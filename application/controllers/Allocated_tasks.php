<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Allocated_tasks extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
        if($this->session->userdata('user_id') == '')
        {
            redirect('login');
        }

        $this->role_permissions = $this->master_model->get_role_permissions();
        $this->btn_permissions = $this->master_model->get_btn_permissions();
    }

    public function index()
    {
        $this->load->view('allocated_tasks/allocated_tasks_view');
    }

    public function make_filter_string($filter_array)
    {
      $conditions = [];
      
        if(!empty($filter_array))
        {
            foreach ($filter_array as $key => $value) 
            {
                if($key == 'status_name')
                {
                    if($value != '')
                    {
                        $conditions[] = 'status = "'.$value.'"';
                    }                    
                }
            }
        }
        
        $string = !empty($conditions) ? ' AND '.implode(' AND ', $conditions) : '';
        return $string;
    }

    public function fetch_orders() {
        $data = array();
        if ($this->input->is_ajax_request()) {
            /** this will handle datatable js ajax call * */
            /** get all datatable parameters * */
            $search = $this->input->post('search');/** search value for datatable  * */
            $offset = $this->input->post('start');/** offset value * */
            $limit = $this->input->post('length');/** limits for datatable (show entries) * */
            $order = $this->input->post('order');/** order by (column sorted ) * */
            $column = array('order_number', 'category', 'type', 'current_status', 'color', 'file_path', 'difficulty_name', 'remark');/**  set your data base column name here for sorting* */
            //$orderColumn = isset($order[0]['column']) ? $column[$order[0]['column']] : 'order_number';
            //$orderDirection = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';
            //$ordrBy = $orderColumn . " " . $orderDirection;

            $ordrBy = "updated_date DESC";

            $condition = ' WHERE assigned_to = "'.$this->session->userdata('user_id').'"';
            // if(isset($_REQUEST['status_name']) && $_REQUEST['status_name'] == 0)
            // {
            //     $this->db->where_in("(SELECT id FROM status WHERE status_name != 'Completed')");
            //     $this->db->where('deadline < ', $today);
                
            // }

            $filter_array = [];
            
            $filter_array['status_name'] = isset($_REQUEST['status_name']) && !empty($_REQUEST['status_name']) ? $_REQUEST['status_name'] : '';
            
            $condition .= $this->make_filter_string($filter_array);

            if (isset($search['value']) && !empty($search['value'])) {
                $search_string = [];
                foreach ($column as $c_key => $c_value) 
                {
                    $search_string[] = $c_value.' LIKE "%'.$search['value'].'%"';
                }

                if(!empty($search_string))
                {
                    $search_string = implode(' OR ', $search_string);
                    $search_string = !empty($condition) ? 'AND ('.$search_string.')' : 'AND ('.$search_string.')';
                }
                
                $sql = "SELECT * FROM cad_view ".$condition." ".$search_string." order by " . $ordrBy . " limit $offset,$limit";
                $sql2 = "SELECT count(id) AS count FROM cad_view ".$condition." ".$search_string." order by " . $ordrBy;
                $result = $this->db->query($sql);
                $result2 = $this->db->query($sql2);
                $count = $result2->result_array()[0]['count'];
            } else {
                
                $sql = "SELECT * FROM cad_view ".$condition." order by " . $ordrBy . " limit $offset,$limit";
                $sql2 = "SELECT count(id) AS count FROM cad_view ".$condition." order by " . $ordrBy;
                
                $result = $this->db->query($sql);
                $result2 = $this->db->query($sql2);
                $count = $result2->result_array()[0]['count'];
                
            }
             

            $data = array();

            if (!empty($result->result_array())) {
                $i = 0;
                foreach ($result->result_array() as $k => $v) {

                    $i++;
                    
                                                                             
                        $status_name = $v['current_status'];
                        $color = $v['color'];

                        $status_string = '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$status_name.'</span>';

                        

                        if(isset($v['file_path']) && $v['file_path'] != '')
                        {

                            $id = 'file_path_span'.$v['id'];
                        
                            $file_path_string = '<div><span id="'.$id.'" style="display:none;">'.$v['file_path'].'</span>
                            <button type="button" onclick="copyToClipboard(\''.$id.'\')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">File Path</button> </div>';
                        
                        } else{ $file_path_string = '';}


                     $order_log_query = $this->db->query('SELECT created_date FROM `order_log` WHERE status = (SELECT id FROM `status` WHERE `status_name` = "In Process") AND job_id = '.$v['id'].' ORDER BY id ASC');
                    if($order_log_query->num_rows() > 0)
                    {
                        $start_date_time = date('Y-m-d, h:i A', strtotime($order_log_query->result_array()[0]['created_date']));
                    }
                    else
                    {
                        $start_date_time = '';
                    }   

                     $latest_activity = $this->db->query('SELECT created_date FROM order_log WHERE job_id = '.$v['id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['created_date'];  
                    
                    $data[] = array(

                        
                        'check' => $i,
                        'order_number' =>  '<strong>'.$v['order_number'].'</strong>',
                          'category' =>  $v['category'],
                          'start_date' =>  $start_date_time,
                          'type' =>  $v['type'],                          
                          'latest_activity' =>  date('Y-m-d', strtotime($latest_activity)).'<br>'.date('H:i', strtotime($latest_activity)),
                          'remark' =>  $v['remark'],
                          'difficulty_name' => $v['difficulty_name'],
                          'status' =>  $status_string,                         
                          'file_path' =>  $file_path_string,
                          'action' =>  '<a class="tabledit-edit-button btn btn-info btn-xs active" onclick="action_buttons('.$v['id'].');">Action</a>'

                    );
                }
            }
            
            $results = array(
                "last_query" => $sql,
                "draw" => $this->input->get('draw'),
                "recordsTotal" => count($data),
                "recordsFiltered" => $count,
                "data" => $data 
            );

           // pre($results);
            echo json_encode($results);
        } else {
            /** this will load by default with no data for datatable
             *  we will load data in table through datatable ajax call
             */
            $this->site->view('parameter', $data);
        }
    }

    public function start_timer()
    {
        $order_id = $_REQUEST['order_id'];
        $user_id = $_REQUEST['user_id'];

        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "In Process"')->result_array()[0]['id'];

        $this->db->where('id', $order_id);
        $sql_update = $this->db->update('production_order', ['status' => $status, 'is_started' => 1]);

        $order_log = $this->db->insert('order_log', ['job_id' => $order_id, 'status' => $status, 'assigned_to' => $user_id, 'created_by' => $this->session->userdata('user_id'), 'description' => 'Designing started']);

        $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'time' => time(), 'type' => 'Start']);

        if($start_stop_time){
            echo json_encode(['class' => 'success', 'message' => 'Started Successfully!']);
        }

    }

    public function stl_process()
    {
        $order_id = $_REQUEST['order_id'];
        $user_id = $_REQUEST['user_id'];

        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "STL Process"')->result_array()[0]['id'];

        $this->db->where('id', $order_id);
        $sql_update = $this->db->update('production_order', ['status' => $status, 'stl_process' => 1, 'is_started' => 1]);

        $order_log = $this->db->insert('order_log', ['job_id' => $order_id, 'status' => $status, 'assigned_to' => $user_id, 'created_by' => $this->session->userdata('user_id'), 'description' => 'Designing started']);

        $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'time' => time(), 'type' => 'Start']);

        if($start_stop_time){
            echo json_encode(['class' => 'success', 'message' => 'Started Successfully!']);
        }

    }

    public function stl()
    {
        $order_id = $_REQUEST['order_id'];
        $user_id = $_REQUEST['user_id'];
        $type = $_REQUEST['type'];

        if($type == 'Start')
        {
            $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'time' => time(), 'type' => 'Start']);
            if($start_stop_time){
                echo json_encode(['class' => 'success', 'message' => 'Started Successfully!']);
            }
        }
        elseif($type == 'Stop')
        {
            $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'time' => time(), 'type' => 'Stop']);
            if($start_stop_time){
                echo json_encode(['class' => 'success', 'message' => 'Started Successfully!']);
            }
        } 
        elseif($type == 'STL QC')
        {
            $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "STL QC"')->result_array()[0]['id'];
            $this->db->where('id', $order_id);
            $sql_update = $this->db->update('production_order', ['status' => $status]);
            $order_log = $this->db->insert('order_log', ['job_id' => $order_id, 'status' => $status, 'assigned_to' => $user_id, 'created_by' => $this->session->userdata('user_id'), 'description' => 'STL QC']);

            $verified = $this->db->query('SELECT assigned_to,is_started,client_name FROM production_order WHERE id = '.$order_id)->result_array();
            $assigned_to = $verified[0]['assigned_to'];
            $is_started = $verified[0]['is_started'];

            $client_name = $verified[0]['client_name'];
            $name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `production_order` WHERE `id` = '.$order_id.')')->result_array();

            $diff_name = $name_time[0]['difficulty_name'];
            $diff_time = $name_time[0]['total_time'];

            $user_id = $this->session->userdata('user_id') != $assigned_to ? $assigned_to  : $this->session->userdata('user_id');

            if($is_started == 1)
            {
                $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $order_id, 'user_id' => $user_id, 'time' => time(), 'type' => 'Stop']);
                $this->db->where('id', $order_id);
                $this->db->update('production_order', ['is_started' => 0]);                
            }

            

            $this->db->where(['type' => 'Start', 'job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $start_time_query = $this->db->get('start_stop_time');
            $start_time = $start_time_query->result_array()[0]['time'];
            


            $this->db->where(['type' => 'Stop', 'job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $stop_time_query = $this->db->get('start_stop_time');
            $stop_time = $stop_time_query->result_array()[0]['time'];


            $time_taken = $stop_time - $start_time;

            $this->db->where(['job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $last_time_taken = $this->db->get('start_stop_action');
            if($last_time_taken->num_rows() > 0)
            {
                $last_time_taken = $last_time_taken->result_array()[0]['actual_time'];
                
                $final_time_taken = $time_taken + $last_time_taken;
            }
            else
            {
                $final_time_taken = $time_taken;
            }

            $this->db->insert('start_stop_action', ['job_id' => $order_id, 'user_id' => $user_id, 'actual_time' => $final_time_taken]);
            $this->db->insert('cad_action_time', ['job_id' => $order_id, 'user_id' => $user_id, 'actual_time' => $time_taken, 'status' => $status,'diff_name' => $diff_name, 'diff_time' => $diff_time,]);

            if($order_log){
                echo json_encode(['class' => 'success', 'message' => 'Sent For STL QC Successfully!']);
            }
            
        } 


        

    }

    public function pause_timer()
    {

        $order_id = $_REQUEST['order_id'];
        $user_id = $this->session->userdata('user_id');

        $verify = $this->db->get_where('production_order', ['id' => $order_id, 'password' => $_REQUEST['password']]);
        if($verify->num_rows() == 0)
        {
            $this->session->set_flashdata(['class' => 'danger', 'message' => 'Invalid Password!']);
        }
        else{

            $verified = $verify->result_array();
            $assigned_to = $verified[0]['assigned_to'];
            $client_name = $verified[0]['client_name'];
            $name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `production_order` WHERE `id` = '.$order_id.')')->result_array();

            $diff_name = $name_time[0]['difficulty_name'];
            $diff_time = $name_time[0]['total_time'];


            $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Paused"')->result_array()[0]['id'];
            $this->db->where('id', $order_id);
            $sql_update = $this->db->update('production_order', ['status' => $status]);

            $user_id = $this->session->userdata('user_id') != $assigned_to ? $assigned_to  : $this->session->userdata('user_id');

            $order_log = $this->db->insert('order_log', ['job_id' => $order_id, 'assigned_to' => $user_id, 'reason' => $_REQUEST['reason'], 'status' => $status, 'description' => 'Order paused', 'created_by' => $this->session->userdata('user_id')]);

            $is_started = $this->db->query('SELECT is_started FROM production_order WHERE id = '.$order_id)->result_array()[0]['is_started'];
            
            if($is_started == 1)
            {
                $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'time' => time(), 'type' => 'Stop']);                
            }

            $this->db->where('id', $order_id);
           $this->db->update('production_order', ['is_started' => 0]);

            

            $this->db->where(['type' => 'Start', 'job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $start_time_query = $this->db->get('start_stop_time');
            $start_time = $start_time_query->result_array()[0]['time'];
            


            $this->db->where(['type' => 'Stop', 'job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $stop_time_query = $this->db->get('start_stop_time');
            $stop_time = $stop_time_query->result_array()[0]['time'];


            $time_taken = $stop_time - $start_time;

            $this->db->where(['job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $last_time_taken = $this->db->get('start_stop_action');
            if($last_time_taken->num_rows() > 0)
            {
                $last_time_taken = $last_time_taken->result_array()[0]['actual_time'];
                
                $final_time_taken = $time_taken + $last_time_taken;
            }
            else
            {
                $final_time_taken = $time_taken;
            }

            $this->db->insert('start_stop_action', ['job_id' => $order_id, 'user_id' => $user_id, 'actual_time' => $final_time_taken]);
            $this->db->insert('cad_action_time', ['job_id' => $order_id, 'user_id' => $user_id, 'actual_time' => $time_taken, 'status' => $status,'diff_name' => $diff_name, 'diff_time' => $diff_time,]);

            if($start_stop_time){
                $this->session->set_flashdata(['class' => 'success', 'message' => 'Paused Successfully!']);
            }
        }

        redirect('allocated_tasks');

    }

    public function qc_check()
    {
        $order_id = $_REQUEST['order_id'];
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "QC Pending"')->result_array()[0]['id'];
        $this->db->where('id', $order_id);
        $sql_update = $this->db->update('production_order', ['status' => $status, 'qc_by' => $this->session->userdata('user_id')]);
        $order_log = array(
            'job_id' => $order_id,
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'description' => 'Order sent for quality check',
            'assigned_to' => $_REQUEST['user_id']
        );

        $this->db->insert('order_log', $order_log);

        $verified = $this->db->query('SELECT assigned_to,is_started, client_name FROM production_order WHERE id = '.$_REQUEST['order_id'])->result_array();
        $assigned_to = $verified[0]['assigned_to'];
        $client_name = $verified[0]['client_name'];
        $is_started = $verified[0]['is_started'];

        $name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `production_order` WHERE `id` = '.$order_id.')')->result_array();

        $diff_name = $name_time[0]['difficulty_name'];
        $diff_time = $name_time[0]['total_time'];

        $user_id = $this->session->userdata('user_id') != $assigned_to ? $assigned_to  : $this->session->userdata('user_id');

        if($is_started == 1)
        {
            $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $order_id, 'user_id' => $user_id, 'time' => time(), 'type' => 'Stop']);
            $this->db->where('id', $_REQUEST['order_id']);
            $this->db->update('production_order', ['is_started' => 0]);                
        }

        

            $this->db->where(['type' => 'Start', 'job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $start_time_query = $this->db->get('start_stop_time');
            $start_time = $start_time_query->result_array()[0]['time'];
            


            $this->db->where(['type' => 'Stop', 'job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $stop_time_query = $this->db->get('start_stop_time');
            $stop_time = $stop_time_query->result_array()[0]['time'];


            $time_taken = $stop_time - $start_time;

            $this->db->where(['job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $last_time_taken = $this->db->get('start_stop_action');
            if($last_time_taken->num_rows() > 0)
            {
                $last_time_taken = $last_time_taken->result_array()[0]['actual_time'];
                
                $final_time_taken = $time_taken + $last_time_taken;
            }
            else
            {
                $final_time_taken = $time_taken;
            }

            $this->db->insert('start_stop_action', ['job_id' => $order_id, 'user_id' => $user_id, 'actual_time' => $final_time_taken]);

            $this->db->insert('cad_action_time', ['job_id' => $order_id, 'user_id' => $user_id, 'actual_time' => $time_taken, 'status' => $status,'diff_name' => $diff_name, 'diff_time' => $diff_time,]);
        if($sql_update){
            echo json_encode(array('message' => 'Order sent for quality check!'));
        }
    }

    public function change_status()
    {
        $status_name = $_REQUEST['status'];
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = '.$status_name)->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['order_id']);
        $sql_update = $this->db->update('production_order', ['status' => $status]);

        $order_log = array(
            'job_id' => $_REQUEST['order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['user_id']
        );
        $this->db->insert('order_log', $order_log);
        if($sql_update){
            echo json_encode(array('message' => $status_name.' Successfully!'));
        }
    }


    public function reject_order()
    {
        $reject_order_id = $_REQUEST['reject_order_id'];
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Pending"')->result_array()[0]['id'];
        $this->db->where('id', $reject_order_id);
        $sql_update = $this->db->update('production_order', ['status' => $status, 'qc_by' => 0, 'assigned_to' => 0, 'difficulty_id' => 0, 'password' => 0, 'rejected_flag' => 1,]);
        $order_log = array(
            'job_id' => $reject_order_id,
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'reason' => $_REQUEST['reason'],
            'description' => 'Order rejected',
            'rejected_flag' => 1,
            'assigned_to' => 0
        );

        $this->db->insert('order_log', $order_log);
        if($sql_update){
            $this->session->set_flashdata(['class' => 'success', 'message' => 'Order rejected successfully!']);
            
        }
        redirect('allocated_tasks');
    }

    public function cancel_order()
    {
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Canceled"')->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['cancel_order_id']);
        $sql_update = $this->db->update('production_order', ['status' => $status]);

        $order_log = array(
            'job_id' => $_REQUEST['cancel_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['cancel_assigned_to'],
            'remark' => $_REQUEST['cancecl_remark'],
            'description' => 'Order Canceled'
        );
        $this->db->insert('order_log', $order_log);
        if($sql_update){
            $this->session->set_flashdata('message', 'Order Canceled Successfully!');
        }

        redirect('allocated_tasks');
    }



    public function action_buttons()
    {
        $start_stop_time = $this->db->query('SELECT * FROM `start_stop_time` WHERE job_id = '.$_REQUEST['order_id']);

        $order_data = $this->db->query('SELECT assigned_to, status, move_to_render FROM production_order WHERE id = '.$_REQUEST['order_id'])->result_array();
        $status = $order_data[0]['status'];
        $assigned_to = $order_data[0]['assigned_to'];
        $move_to_render = $order_data[0]['move_to_render'];
        $status_name = $this->db->query('SELECT status_name FROM status WHERE id = '.$status)->result_array()[0]['status_name'];
        $html = '';
        
        $start_stop_time = $this->db->query('SELECT * FROM `start_stop_time` WHERE job_id = '.$_REQUEST['order_id']);

        if($start_stop_time->num_rows() == 0)
        {
            if(array_key_exists('Start', $this->btn_permissions) && $this->btn_permissions['Start']['view_perm'] == 1 && $status_name != 'Canceled')
            {
            
                $html .= '<a class="dropdown-item" href="javascript:start_timer(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Start</a>';            
            }
            if($status_name == 'Allocated')
            {
                if(array_key_exists('Reject Order', $this->btn_permissions) && $this->btn_permissions['Reject Order']['view_perm'] == 1 && $status_name != 'Canceled')
                {            
                    $html .= '<a class="dropdown-item" href="javascript:reject_order(\''.$_REQUEST['order_id'].'\');"><i class="fe-x-circle mr-2 text-muted font-18 vertical-middle"></i>Reject Order</a>';            
                }
            }
        }
        elseif($status_name == 'In Process')
        {
            $type = $this->db->query('SELECT * FROM `start_stop_time` WHERE job_id = '.$_REQUEST['order_id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['type'];
            if($type == 'Stop')
            {
                if(array_key_exists('Start', $this->btn_permissions) && $this->btn_permissions['Start']['view_perm'] == 1 && $status_name != 'Canceled')
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:start_timer(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Start</a>';                
                }
                if(array_key_exists('Reject Order', $this->btn_permissions) && $this->btn_permissions['Reject Order']['view_perm'] == 1 && $status_name != 'Canceled')
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:reject_order(\''.$_REQUEST['order_id'].'\');"><i class="fe-x-circle mr-2 text-muted font-18 vertical-middle"></i>Reject Order</a>';               
                }
            }
            else if($type == 'Start')
            {
                if(array_key_exists('Pause', $this->btn_permissions) && $this->btn_permissions['Pause']['view_perm'] == 1 && $status_name != 'Canceled')
                {
                    $html .= '<a class="dropdown-item" href="javascript:pause_timer(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Pause</a>';
                
                }
                if(array_key_exists('QC', $this->btn_permissions) && $this->btn_permissions['QC']['view_perm'] == 1 && $status_name != 'Canceled')
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:qc_check(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>QC</a>';                
                }
            }
        }
        elseif($status_name == 'Paused' || $status_name == 'QC Reject' || $status_name == 'Modification' || $status_name == 'Repair')
        {
            if(array_key_exists('Start', $this->btn_permissions) && $this->btn_permissions['Start']['view_perm'] == 1 && $status_name != 'Canceled')
                {
              
                    $html .= '<a class="dropdown-item" href="javascript:start_timer(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Start</a>';
                
                }
                if($status_name == 'Paused')
                {
                    if(array_key_exists('Reject Order', $this->btn_permissions) && $this->btn_permissions['Reject Order']['view_perm'] == 1 && $status_name != 'Canceled')
                    {
            
                    $html .= '<a class="dropdown-item" href="javascript:reject_order(\''.$_REQUEST['order_id'].'\');"><i class="fe-x-circle mr-2 text-muted font-18 vertical-middle"></i>Reject Order</a>';        
            
                    }
                }
          
        }                                                        
        elseif($status_name == 'STL Requested' || $status_name == 'STL Reject')
        {
            if(array_key_exists('Start', $this->btn_permissions) && $this->btn_permissions['Start']['view_perm'] == 1 && $status_name != 'Canceled')
            {
              
                $html .= '<a class="dropdown-item" href="javascript:stl_process(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Start</a>';
            }
        }
        elseif($status_name == 'STL Process')
        {
            $type = $this->db->query('SELECT * FROM `start_stop_time` WHERE job_id = '.$_REQUEST['order_id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['type'];
            if($type == 'Stop')
            {
                if(array_key_exists('Start', $this->btn_permissions) && $this->btn_permissions['Start']['view_perm'] == 1 && $status_name != 'Canceled')
                    {
                
                        $html .= '<a class="dropdown-item" href="javascript:stl(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \'Start\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Start</a>';
                
                
                    }
            }
            else if($type == 'Start')
            {
                if(array_key_exists('Pause', $this->btn_permissions) && $this->btn_permissions['Pause']['view_perm'] == 1 && $status_name != 'Canceled')
                    {
                
                    $html .= '<a class="dropdown-item" href="javascript:pause_timer(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Pause</a>';
                
                    }
                    if(array_key_exists('STL QC', $this->btn_permissions) && $this->btn_permissions['STL QC']['view_perm'] == 1 && $status_name != 'Canceled')
                    {
                
                        $html .= '<a class="dropdown-item" href="javascript:stl(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \'STL QC\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>STL QC</a>';                
                
                    }
            }
        }
                                                    
        if(array_key_exists('Timeline', $this->btn_permissions) && $this->btn_permissions['Timeline']['view_perm'] == 1)
        {
    
            $html .= '<a class="dropdown-item" href="'.base_url().'timeline/index/'.$_REQUEST['order_id'].'"><i class="fe-clock font-18 text-muted mr-2 vertical-middle"></i>Timeline</a>';
    

    
        }
        if(array_key_exists('Cancel', $this->btn_permissions) && $this->btn_permissions['Cancel']['view_perm'] == 1 && $status_name != 'Canceled' && $status_name != 'Completed')
        {
    
            $html .= '<a class="dropdown-item" href="javascript:cancel_order(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-close-circle mr-2 text-muted font-18 vertical-middle"></i>Cancel</a>';
    

    
        }
        if($status_name != 'Pending')
        {
            if(array_key_exists('View', $this->btn_permissions) && $this->btn_permissions['View']['view_perm'] == 1 && $status_name != 'Canceled')
            {
    
                $html .= '<a class="dropdown-item" href="javascript:void(0);" onclick="view_order(\''.$_REQUEST['order_id'].'\', \''.$status.'\');"><i class="fe-eye font-18 text-muted mr-2 vertical-middle"></i>View</a>';
    
            }
        }
        
        echo json_encode(['html' => $html]);
    }




}
?>
