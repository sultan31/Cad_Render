<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production_orders extends CI_Controller
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
        $this->load->view('production_orders/production_orders_view');
    }

    public function make_filter_string($filter_array)
    {
      $conditions = [];
      
        if(!empty($filter_array))
        {
            foreach ($filter_array as $key => $value) 
            {
                if($key == 'order_no')
                {
                    if($value != '')
                    {
                        $conditions[] = 'order_number = "'.$value.'"';
                    }
                }
                else if($key == 'category')
                {
                    if($value != '')
                    {
                        $conditions[] = 'category = "'.$value.'"';
                    }                    
                }
                else if($key == 'client_name')
                {
                    if($value != '')
                    {
                        $conditions[] = 'client_name = "'.$value.'"';
                    }                    
                }
                else if($key == 'po_no')
                {
                    if($value != '')
                    {
                        $conditions[] = 'po_no = "'.$value.'"';
                    }                    
                }
                else if($key == 'status_name')
                {
                    if($value != '')
                    {
                        $conditions[] = 'status = "'.$value.'"';
                    }                    
                }
                else if($key == 'from_date')
                {
                    if($value != '')
                    {
                        $conditions[] = 'DATE_FORMAT(updated_date, "%Y-%m-%d") >= "'.$value.'"';
                    }                    
                }
                else if($key == 'to_date')
                {
                    if($value != '')
                    {
                        $conditions[] = 'DATE_FORMAT(updated_date, "%Y-%m-%d") <= "'.$value.'"';
                    }
                }
                else if($key == 'order_date')
                {
                    if($value != '')
                    {
                        $conditions[] = 'order_date = "'.date('d-m-y', strtotime($value)).'"';
                    }
                }
            }
        }
        
        $string = !empty($conditions) ? ' WHERE '.implode(' AND ', $conditions) : '';
        return $string;
    }

    public function copy_cad()
    {
        $this->load->view('production_orders/production_orders_view1');
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
            $column = array('order_number', 'client_design_no', 'po_no', 'category', 'order_date', 'current_status', 'color', 'file_path', 'difficulty_name', 'current_designer');/**  set your data base column name here for sorting* */
            $orderColumn = isset($order[0]['column']) ? $column[$order[0]['column']] : 'order_number';
            $orderDirection = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';
            //$ordrBy = $orderColumn . " " . $orderDirection;

            $ordrBy = "updated_date DESC";

            $condition = '';

            $filter_array = [];
            $filter_array['order_no'] = isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no']) ? $_REQUEST['order_no'] : '';
            $filter_array['category'] = isset($_REQUEST['category']) && !empty($_REQUEST['category']) ? $_REQUEST['category'] : '';
            $filter_array['client_name'] = isset($_REQUEST['client_name']) && !empty($_REQUEST['client_name']) ? $_REQUEST['client_name'] : '';
            $filter_array['from_date'] = isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']) ? $_REQUEST['from_date'] : '';
            $filter_array['to_date'] = isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']) ? $_REQUEST['to_date'] : '';
            $filter_array['order_date'] = isset($_REQUEST['order_date']) && !empty($_REQUEST['order_date']) ? $_REQUEST['order_date'] : '';
            $filter_array['status_name'] = isset($_REQUEST['status_name']) && !empty($_REQUEST['status_name']) ? $_REQUEST['status_name'] : '';
            $filter_array['po_no'] = isset($_REQUEST['po_no']) && !empty($_REQUEST['po_no']) ? $_REQUEST['po_no'] : '';
            
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
                    $search_string = !empty($condition) ? 'AND ('.$search_string.')' : 'WHERE ('.$search_string.')';
                }
                /** creat sql or call Model * */
                /**   $this->load->model('Parameter_model');
                  $this->Parameter_model->get_parameter('tbl_parameter'); * */
                /** I am calling sql directly in controller for your answer 
                 * Please change your sql according to your table name
                 * */
                $sql = "SELECT * FROM cad_view ".$condition." ".$search_string." order by " . $ordrBy . " limit $offset,$limit";
                $sql2 = "SELECT count(id) AS count FROM cad_view ".$condition." ".$search_string." order by " . $ordrBy;
                $result = $this->db->query($sql);
                $result2 = $this->db->query($sql2);
                $count = $result2->result_array()[0]['count'];
            } else {
                /**
                 * If no seach value avaible in datatable
                 */
                $sql = "SELECT * FROM cad_view ".$condition." order by " . $ordrBy . " limit $offset,$limit";
                $sql2 = "SELECT count(id) AS count FROM cad_view ".$condition." order by " . $ordrBy;
                
                $result = $this->db->query($sql);
                $result2 = $this->db->query($sql2);
                $count = $result2->result_array()[0]['count'];
                
            }
            /** create data to display in dataTable as you want **/    

            $data = array();
            if (!empty($result->result_array())) {
                foreach ($result->result_array() as $k => $v) {
                    
                                                                             
                        $current_status = $v['current_status'];
                        $color = $v['color'];

                        $status_string = '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$current_status.'</span>';

                        if(isset($v['rejected_flag']) && $v['rejected_flag'] != 0)
                        {
                           $rejected_by = $this->master_model->get_one_record('users', 'full_name', $v['rejected_flag']); 
                            $reason = $this->db->query('SELECT reason FROM order_log WHERE rejected_flag = 1 AND job_id = '.$v['id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['reason'];
                            $status_string .= '<a href="javascript:void(0);">Rejected Order</a>';
                    
                        }

                        if($current_status == 'QC Reject' || $current_status == 'Pending-MR') 
                        {
                            $status_string .= '<br><strong style="color:red;">'.$v['remark'].'</strong>';
                        }

                        if(isset($v['file_path']) && $v['file_path'] != '')
                        {

                            $id = 'file_path_span'.$v['id'];
                        
                            $file_path_string = '<div><span id="'.$id.'" style="display:none;">'.$v['file_path'].'</span>
                            <button type="button" onclick="copyToClipboard(\''.$id.'\')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">File Path</button> </div>';
                        
                        } else{ $file_path_string = '';}


                     $created_date = $this->db->query('SELECT created_date FROM order_log WHERE job_id = '.$v['id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['created_date'];   
                    
                    $data[] = array(

                        
                        
                        'check' => '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input dt-checkboxes chk_order" id="customCheck'.$v['id'].'" value="'.$v['id'].'"><label class="custom-control-label">&nbsp;</label></div>',
                        'order_number' =>  '<a target="_blank" href="'.base_url().'production_orders/form_view/prod/'.$v['id'].'">'.$v['order_number'].'</a>',
                        
                          'client_design_no' =>  $v['client_design_no'],
                          'po_no' =>  $v['po_no'],
                          
                          'category' =>  $v['category'],
                          'client_name' =>  $v['client_name'],
                          'order_date' =>  date('d-m-Y', strtotime($v['order_date'])),
                          'created_date' =>  date('d-m-y', strtotime($created_date)).'<br>'.date('H:i', strtotime($created_date)),
                          'status' =>  $status_string,                        
                          
                          'file_path' =>  $file_path_string,
                          'difficulty_name' => $v['difficulty_name'],
                          'designer' => $v['current_designer'],
                          'action' =>  '<a class="tabledit-edit-button btn btn-info btn-xs active" onclick="action_buttons('.$v['id'].');">Action</a>'

                    );
                }
            }
            /**
             * draw,recordTotal,recordsFiltered is required for pagination and info.
             */
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

    public function form_view($mode = '', $id = '')
    {
        $data = [];
        $data['mode'] = $mode;
        if($mode == 'prod')
        {
            $data['edit_data'] = $this->db->get_where('production_order', ['id' => $id])->result_array();
            $data['show_edit'] = 'No';
            $this->load->view('production_orders/info_view', $data);
        } 
        if($mode == 'port')
        {
            $data['edit_data'] = $this->db->get_where('website_order', ['order_number' => $id, 'moved_to_production' => 0])->result_array();
            $data['show_edit'] = 'Yes';
            $this->load->view('production_orders/info_view', $data);
        }
        if($mode == 'edit')
        {
            $data['edit_data'] = $this->db->get_where('production_order', ['id' => $id])->result_array();
            $this->load->view('production_orders/form_view', $data);
        }        
    }

    public function form_action($id = '')
    {
        if($id)
        {
            $postdata = array(
                'order_number'  => $this->input->post('order_number'),
                'client_design_no'  => $this->input->post('client_design_no'),
                'po_no'  => $this->input->post('po_no'),
                'category'  => $this->input->post('category'),
                'remark'  => $this->input->post('remark'),
                'file_path'  => $this->input->post('file_path')
            );

            $sql_update = $this->db->where('id', $id)->update('production_order', $postdata);
            
            if($sql_update){
                $this->session->set_flashdata('message', 'Submitted Successfully!');
            }

            redirect('production_orders');
        }     
    }

    public function assign()
    {
    	// pre($_REQUEST);exit;
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Allocated"')->result_array()[0]['id'];
        $difficulty_name = $this->master_model->get_one_record('difficulty', 'difficulty_name', $_REQUEST['difficulty_id']);

        $password = str_pad(rand(0, pow(10, 6)-1), 6, '0', STR_PAD_LEFT);

        $this->db->where('id', $_REQUEST['order_id']);
        $sql_update = $this->db->update('production_order', ['assigned_to' => $_REQUEST['user_id'], 'password' => $password, 'difficulty_id' => $_REQUEST['difficulty_id'], 'initial_difficulty' => $difficulty_name, 'status' => $status]);

        $order_log = array(
            'job_id' => $_REQUEST['order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['user_id'],
            'description' => 'Order allocated to',
            'difficulty_id' => $_REQUEST['difficulty_id']
        );
        $this->db->insert('order_log', $order_log);

        
        if($sql_update){
            $this->session->set_flashdata('message', 'Allocated Successfully!');
        }

        redirect('production_orders');
    }

    //reject by admin
    public function reject()
    {
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "QC Reject"')->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['rej_order_id']);
        $sql_update = $this->db->update('production_order', ['status' => $status, 'remark' => $_REQUEST['remark']]);

        $order_log = array(
            'job_id' => $_REQUEST['rej_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['assigned_to'],
            'remark' => $_REQUEST['remark'],
            'description' => 'Quality check reject'
        );
        $this->db->insert('order_log', $order_log);
        if($sql_update){
            $this->session->set_flashdata('message', 'Rejected Successfully!');
        }

        redirect('production_orders');
    }

    //reject by admin
    public function stl_reject()
    {
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "STL Reject"')->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['rej_order_id']);
        $sql_update = $this->db->update('production_order', ['status' => $status, 'remark' => $_REQUEST['remark']]);

        $order_log = array(
            'job_id' => $_REQUEST['rej_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['assigned_to'],
            'remark' => $_REQUEST['remark'],
            'description' => 'STL reject'
        );
        $this->db->insert('order_log', $order_log);
        if($sql_update){
            $this->session->set_flashdata('message', 'STL Rejected Successfully!');
        }

        redirect('production_orders');
    }

    public function view_order()
    {
        $production_order = $this->db->get_where('production_order', ['id' => $_REQUEST['order_id']])->result_array()[0];
        
        if(!empty($production_order)){
            echo json_encode($production_order);
        }
    }

    
    public function client_fb()
    {
        
        
        $status_val = $_REQUEST['status_val'];
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "'.$status_val.'"')->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['rej_order_id']);
        $sql_update = $this->db->update('production_order', ['difficulty_id' => $_REQUEST['modi_rep_difficulty_id'], 'status' => $status, 'remark' => $_REQUEST['remark'], 'assigned_to' => $_REQUEST['modi_rep_user_id']]);

        $verified = $this->db->get_where('production_order', ['id' => $_REQUEST['rej_order_id']])->result_array();
        $assigned_to = $verified[0]['assigned_to'];
        $client_name = $verified[0]['client_name'];
        
        $name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `production_order` WHERE `id` = '.$_REQUEST['rej_order_id'].')')->result_array();

        $diff_name = $name_time[0]['difficulty_name'];
        $diff_time = $name_time[0]['total_time'];

        $user_id = $this->session->userdata('user_id') != $assigned_to ? $assigned_to  : $this->session->userdata('user_id');

        $description = $status_val == 'Modification' ? 'Sent for Modification' : 'Sent for Repair';

        $cad_dept_flag = $status_val == 'Modification' ? 2 : 3;

        $column_name = $status_val == 'Modification' ? 'modification' : 'repair';

        $order_log = array(
            'job_id' => $_REQUEST['rej_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['modi_rep_user_id'],
            'remark' => $_REQUEST['remark'],
            'difficulty_id' => $_REQUEST['modi_rep_difficulty_id'],
            'description' => $description
        );
        $this->db->insert('order_log', $order_log);


        $this->db->where(['type' => 'Start', 'job_id' => $_REQUEST['rej_order_id'], 'user_id' => $user_id]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $start_time_query = $this->db->get('start_stop_time');
        $start_time = $start_time_query->result_array()[0]['time'];
        


        $this->db->where(['type' => 'Stop', 'job_id' => $_REQUEST['rej_order_id'], 'user_id' => $user_id]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $stop_time_query = $this->db->get('start_stop_time');
        $stop_time = $stop_time_query->result_array()[0]['time'];


        $time_taken = $stop_time - $start_time;

        $this->db->where(['job_id' => $_REQUEST['rej_order_id'], 'user_id' => $user_id]);
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

        $this->db->insert('start_stop_action', ['job_id' => $_REQUEST['rej_order_id'], 'user_id' => $user_id, 'actual_time' => $final_time_taken]);
        $this->db->insert('cad_action_time', ['job_id' => $_REQUEST['rej_order_id'], 'user_id' => $user_id, 'actual_time' => $time_taken, 'status' => $status,'diff_name' => $diff_name, 'diff_time' => $diff_time, $column_name => 1]);

        
        $this->db->where('id', $_REQUEST['rej_order_id']);
        $sql_update = $this->db->update('production_order', ['cad_dept_flag' => $cad_dept_flag]);



        if($sql_update){
            $this->session->set_flashdata('message', 'Submitted Successfully!');
        }

        redirect('production_orders');
    }

    public function qc_accept()
    {
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Ready To Deliver"')->result_array()[0]['id'];
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
            echo json_encode(array('message' => 'QC Accepted Successfully!'));
        }
    }

    public function edit()
    {
    
        $this->db->where('id', $_REQUEST['current_order_id']);
        $sql_update = $this->db->update('production_order', ['difficulty_id' => $_REQUEST['current_difficulty_id'], 'assigned_to' => $_REQUEST['current_user_id'], 'file_path' => $_REQUEST['file_path']]);

        $last_log_id = $this->db->query('SELECT id FROM order_log WHERE job_id = '.$_REQUEST['current_order_id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['id'];

        $this->db->where('id', $last_log_id)->update('order_log', ['is_dealocated' => 1]);

        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Pending"')->result_array()[0]['id'];
        $order_log = array(
            'job_id' => $_REQUEST['current_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => 0,
            'is_dealocated' => 1,
            'description' => 'Order Deallocated'
        );
        $this->db->insert('order_log', $order_log);


        $order_log = array(
            'job_id' => $_REQUEST['current_order_id'],
            'status'   => $_REQUEST['current_status'],
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['current_user_id'],
            'difficulty_id' => $_REQUEST['current_difficulty_id'],
            'description' => 'Order allocated to'
        );
        $this->db->insert('order_log', $order_log);

        if($sql_update){
            $this->session->set_flashdata('message', 'Submitted Successfully!');
        }

        redirect('production_orders');
    }

    public function stl_accept()
    {
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "STL Accept"')->result_array()[0]['id'];
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
            echo json_encode(array('message' => 'STL Accepted Successfully!'));
        }
    }

    public function complete()
    {

        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Completed"')->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['complete_order_id']);
        $sql_update = $this->db->update('production_order', ['status' => $status, 'complet_file_path' => $_REQUEST['complet_file_path']]);

        $order_log = array(
            'job_id' => $_REQUEST['complete_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['complete_assigned_to']
        );
        $this->db->insert('order_log', $order_log);

        if($sql_update){
            $this->session->set_flashdata('message', 'Completed Successfully!');
        }

        redirect('production_orders');
        
    }

    public function change_status()
    {
        $status_name = $_REQUEST['stl_status'];
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "'.$status_name.'"')->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['stl_order_id']);
        $sql_update = $this->db->update('production_order', ['status' => $status]);

        $order_log = array(
            'job_id' => $_REQUEST['stl_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['stl_user_id']
        );
        $this->db->insert('order_log', $order_log);
        if($sql_update){
            
            $this->session->set_flashdata('message', $status_name.' Successfully!');
        }
        redirect('production_orders');
    }

    
    public function pdw_sent()
    {
       
        $status_name = $_REQUEST['status'];
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "'.$status_name.'"')->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['order_id']);
        $sql_update = $this->db->update('production_order', ['status' => $status]);

        $verified = $this->db->get_where('production_order', ['id' => $_REQUEST['order_id']])->result_array();
        $assigned_to = $verified[0]['assigned_to'];
        $client_name = $verified[0]['client_name'];
        $name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `production_order` WHERE `id` = '.$_REQUEST['order_id'].')')->result_array();

        $diff_name = $name_time[0]['difficulty_name'];
        $diff_time = $name_time[0]['total_time'];

        $user_id = $this->session->userdata('user_id') != $assigned_to ? $assigned_to  : $this->session->userdata('user_id');

        

        $order_log = array(
            'job_id' => $_REQUEST['order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['user_id']
        );
        $this->db->insert('order_log', $order_log);


        $time = time();

        $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $_REQUEST['order_id'], 'user_id' => $this->session->userdata('user_id'), 'time' => $time, 'type' => 'Start']);

        $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $_REQUEST['order_id'], 'user_id' => $this->session->userdata('user_id'), 'time' => $time, 'type' => 'Stop']);

        $this->db->where(['type' => 'Start', 'job_id' => $_REQUEST['order_id'], 'user_id' => $user_id]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $start_time_query = $this->db->get('start_stop_time');
        $start_time = $start_time_query->result_array()[0]['time'];
        


        $this->db->where(['type' => 'Stop', 'job_id' => $_REQUEST['order_id'], 'user_id' => $user_id]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $stop_time_query = $this->db->get('start_stop_time');
        $stop_time = $stop_time_query->result_array()[0]['time'];


        $time_taken = $stop_time - $start_time;

        $this->db->where(['job_id' => $_REQUEST['order_id'], 'user_id' => $user_id]);
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

        $this->db->insert('start_stop_action', ['job_id' => $_REQUEST['order_id'], 'user_id' => $user_id, 'actual_time' => $final_time_taken]);
        $this->db->insert('cad_action_time', ['job_id' => $_REQUEST['order_id'], 'user_id' => $user_id, 'actual_time' => $time_taken, 'status' => $status,'diff_name' => $diff_name, 'diff_time' => $diff_time, 'pdw_sent' => 1]);

        $this->db->where('id', $_REQUEST['order_id']);
        $sql_update = $this->db->update('production_order', ['cad_dept_flag' => 1]);


        if($sql_update){
            
            echo json_encode(array('message' => $status_name.' Successfully!'));
        }
        
    }

    
    public function de_allocate()
    {
        
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Pending"')->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['order_id']);
        $sql_update = $this->db->update('production_order', ['status' => $status, 'assigned_to' => 0, 'difficulty_id' => 0, 'password' => 0]);

        $last_log_id = $this->db->query('SELECT id FROM order_log WHERE job_id = '.$_REQUEST['order_id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['id'];

        $this->db->where('id', $last_log_id)->update('order_log', ['is_dealocated' => 1]);

        $order_log = array(
            'job_id' => $_REQUEST['order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => 0,
            'is_dealocated' => 1,
            'description' => 'Order Deallocated'
        );
        $this->db->insert('order_log', $order_log);

        if($sql_update){
            echo json_encode(array('message' => 'De allocated Successfully!'));
        }
    }

    public function remove()
    {
        $portal_order_id = $this->db->query('SELECT portal_order_id FROM production_order WHERE id IN ('.$_REQUEST['order_ids'].')');
        if($portal_order_id->num_rows() > 0)
        {
            $portal_order_id = array_column($portal_order_id->result_array(), 'portal_order_id');
            $portal_order_id = implode(',', $portal_order_id);
        }
        $this->db->query('UPDATE website_order SET delete_flag = 1 WHERE id IN ('.$portal_order_id.')');
        $success = $this->db->query('UPDATE production_order SET delete_flag = 1 WHERE id IN ('.$_REQUEST['order_ids'].')');
        if($success){
            $this->session->set_flashdata('message', 'Deleted Successfully!');
        }

        redirect('production_orders');
    }

    
    public function update_last()
    {
        $this->db->where('id', $_REQUEST['user_id']);
        $success = $this->db->update('users', ['notify_last_seen' => date('Y-m-d H:i:s')]);
        if($success){
            echo 'Updated';
        }
    }

    public function pause_timer()
    {

        $order_id = $_REQUEST['pause_order_id'];
        $user_id = $this->session->userdata('user_id');

        $role_name = $this->db->query('SELECT role_name FROM `role` WHERE `id` = (SELECT user_role FROM users WHERE id = '.$user_id.')')->result_array()[0]['role_name'];

        $verify = $this->db->get_where('production_order', ['id' => $order_id, 'password' => $_REQUEST['password']]);
        if($verify->num_rows() == 0)
        {
            $this->session->set_flashdata(['class' => 'danger', 'message' => 'Invalid Password!']);
        }
        else
        {
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

            $order_log_array = ['job_id' => $order_id, 'reason' => $_REQUEST['reason'], 'status' => $status, 'description' => 'Order paused', 'assigned_to' => $user_id, 'created_by' => $this->session->userdata('user_id')];

            $order_log = $this->db->insert('order_log', $order_log_array);

            $is_started = $this->db->query('SELECT is_started FROM production_order WHERE id = '.$order_id)->result_array()[0]['is_started'];
            
            if($is_started == 1)
            {
                $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $order_id, 'user_id' => $user_id, 'time' => time(), 'type' => 'Stop']);                
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

        redirect('production_orders');

    }

    public function cancel_order()
    {
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Canceled"')->result_array()[0]['id'];       

        $verified = $this->db->query('SELECT assigned_to,is_started FROM production_order WHERE id = '.$_REQUEST['cancel_order_id'])->result_array();
        $assigned_to = $verified[0]['assigned_to'];
        $is_started = $verified[0]['is_started'];
            
        $this->db->where('id', $_REQUEST['cancel_order_id']);
        $sql_update = $this->db->update('production_order', ['status' => $status]);

        $user_id = $this->session->userdata('user_id') != $assigned_to ? $assigned_to  : $this->session->userdata('user_id');

        $order_log = array(
            'job_id' => $_REQUEST['cancel_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['cancel_assigned_to'],
            'remark' => $_REQUEST['cancecl_remark'],
            'description' => 'Order Canceled'
        );
         $this->db->insert('order_log', $order_log);
            
        if($is_started == 1)
        {
            $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $_REQUEST['cancel_order_id'], 'user_id' => $user_id, 'time' => time(), 'type' => 'Stop']);  
            $this->db->where('id', $_REQUEST['cancel_order_id']);
           $this->db->update('production_order', ['is_started' => 0]);              
        }

            
       
        if($sql_update){
            $this->session->set_flashdata('message', 'Order Canceled Successfully!');
        }

        redirect('production_orders');
    }

    public function delivered()
    {
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Delivered"')->result_array()[0]['id']; 
        
        $this->db->where('id', $_REQUEST['order_id']);       

        $sql_update = $this->db->update('production_order', ['status' => $status, 'rejected_flag' => 0]);

        $order_log = array(
            'job_id' => $_REQUEST['order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => 0,
            'description' => 'Order Delivered', 
            'rejected_flag' => 0, 
        );
        $this->db->insert('order_log', $order_log);
        if($sql_update){
            echo json_encode(array('message' => 'Delivered Successfully!'));
        }

        
    }

    public function export_csv()
    {
        $today = date('Y-m-d');
        $completed_status = $this->db->query('SELECT id FROM status WHERE status_name = "Completed"')->result_array()[0]['id'];
        $order_no = urlencode($_REQUEST['order_no']);
        $category = urlencode($_REQUEST['category']);
        $status_name = urlencode($_REQUEST['status_name']);
        $from_date = urlencode($_REQUEST['from_date']);
        $to_date = urlencode($_REQUEST['to_date']);
        $order_date = urlencode($_REQUEST['order_date']);

        
        $this->db->select('*');
        $this->db->from('production_order');
        if(isset($_REQUEST['status_name']) && $_REQUEST['status_name'] != '')
        {
            $this->db->where('status', $_REQUEST['status_name']);
        }
        // if(isset($_REQUEST['status_name']) && $_REQUEST['status_name'] == '')
        // {
        //     $this->db->where("status !=", $completed_status);
        //     $this->db->where('deadline < ', $today);
        // }
        if(isset($_REQUEST['order_no']) && $_REQUEST['order_no'] != '')
        {
            $this->db->where('order_number', $_REQUEST['order_no']);
        }
        if(isset($_REQUEST['po_no']) && $_REQUEST['po_no'] != '')
        {
            $this->db->where('po_no', $_REQUEST['po_no']);
        }
        if(isset($_REQUEST['category']) && $_REQUEST['category'] != '')
        {
            $this->db->where('category', $_REQUEST['category']);
        }
        if(isset($_REQUEST['client_name']) && $_REQUEST['client_name'] != '')
        {
            $this->db->where('client_name', $_REQUEST['client_name']);
        }
        if(isset($_REQUEST['from_date']) && $_REQUEST['from_date'] != '')
        {
            $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") >= ', $_REQUEST['from_date']);
            
        }
        if(isset($_REQUEST['to_date']) && $_REQUEST['to_date'] != '')
        {
            $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") <= ', $_REQUEST['to_date']);
        }
        if(isset($_REQUEST['order_date']) && $_REQUEST['order_date'] != '')
        {
            $this->db->where('DATE_FORMAT(order_date, "%Y-%m-%d") = ', $_REQUEST['order_date']);
            
        }
        $this->db->order_by('updated_date', 'DESC');
        $this->db->where('delete_flag', 0);
        $res = $this->db->get();
                 #pre($this->db->last_query());exit;
        
        $mainA = [];
        $i=0;
        if($res->num_rows() > 0)
        {
            $result = $res->result_array();
            
            foreach($result as $r)
            {                
                $status_name = $this->db->get_where('status', ['id' =>  $r['status']])->result_array()[0]['status_name'];                
                $i++;

                 $created_date = $this->db->query('SELECT created_date FROM order_log WHERE job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['created_date'];

                 $latest_act = isset($created_date) && !empty($created_date) ? date('d-m-y', strtotime($created_date)).' '.date('H:i', strtotime($created_date)) : '';

                $mainA[] = ['Order Number' => $r['order_number'], 'Client Design No' => $r['client_design_no'], 'PO No' => $r['po_no'], 'Category' => $r['category'], 'Client' => $r['client_name'], 'Order Date' => date('Y-m-d', strtotime($r['order_date'])), 'Latest ACT' => $latest_act, 'Status' => $status_name, 'File Path' => $r['file_path'], 'Difficulty' => $this->master_model->get_one_record('difficulty', 'difficulty_name', $r['difficulty_id']), 'Current Designer' => $this->master_model->get_one_record('users', 'full_name', $r['assigned_to'])];
            }

            $this->download_send_headers("production_orders" . date("Y-m-d") . ".csv");
            echo $this->array2csv($mainA);
            die();          
            
        }
        
    }

    public function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }


    public function array2csv(array &$array)
    {
       if (count($array) == 0) {
         return null;
       }
       ob_start();
       $df = fopen("php://output", 'w');
       fputcsv($df, array_keys(reset($array)));
       foreach ($array as $row) {
          fputcsv($df, $row);
       }
       fclose($df);
       return ob_get_clean();
    }

    
    public function send_to_manager()
    {
       
        $status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Pending-MR"')->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['send_to_order_id']);
        $sql_update = $this->db->update('production_order', ['status' => $status, 'remark' => $_REQUEST['send_to_manager_remark'].'-'.$_REQUEST['stage']]);

        $order_log = array(
            'job_id' => $_REQUEST['send_to_order_id'],
            'status'   => $status,
            'remark' => $_REQUEST['send_to_manager_remark'].'-'.$_REQUEST['stage'],
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['send_to_assigned_id']
        );
        $this->db->insert('order_log', $order_log);
        if($sql_update){
            
            $this->session->set_flashdata('message', 'Pending-MR Successfully!');
        }
        redirect('production_orders');
        
        
    }



    public function move_to_render()
    {
        $website_order = $this->db->query('SELECT * FROM `website_order` WHERE `id` = (SELECT portal_order_id FROM production_order WHERE id = '.$_REQUEST['order_id'].')')->result_array()[0];

        $complete_file_path = $this->db->query('SELECT complet_file_path FROM production_order WHERE id = '.$_REQUEST['order_id'])->result_array()[0]['complet_file_path'];

        $new_website_order = array(
            'cad_web_order_id'  => $website_order['id'],
            'online_order_id'  => $website_order['online_order_id'],
            'order_number'  => $website_order['order_number'],
            'category'  => $website_order['category'],
            'client_name'  => $website_order['client_name'],
            'file_path'  => $complete_file_path,
            'type'  => 'RENDER',
            'is_render' => 1
        );

        $success = $this->db->insert('website_order', $new_website_order);
        $portal_order_id = $this->db->insert_id();
        // pre($this->db->last_query());exit;

        // $production_order = $this->db->query('SELECT * FROM `production_order` WHERE `id` = '.$_REQUEST['order_id'])->result_array()[0];

        // $render_default_status = $this->db->query('SELECT id FROM ms_render_status WHERE default_status = 1 AND `department_id` = (SELECT id FROM department WHERE initial_department = 1)')->result_array()[0]['id'];

        // $initial_department = $this->db->query('SELECT id FROM `department` WHERE `initial_department` = 1')->result_array()[0]['id'];

        // $production_order = array(
        //     'portal_order_id'   => $portal_order_id,
        //     'order_number'  => $production_order['order_number'],
        //     'category'  => $production_order['category'],
        //     'client_name'  => $production_order['client_name'],
        //     'type'  => 'RENDER',
        //     'status'  => $render_default_status,
        //     'department_id'  => $initial_department,
        //     'created_by' => $this->session->userdata('user_id'),
        // );

        // $success = $this->db->insert('production_order', $production_order);
        // $production_order_id = $this->db->insert_id();

        // $render_order_log = array(
        //     'job_id' => $production_order_id,
        //     'status'   => $render_default_status,
        //     'created_by' => $this->session->userdata('user_id'),
        //     'description' => 'Order moved to production',
        //     'department_id' => $initial_department
        // );

        // $this->db->insert('render_order_log', $render_order_log);

        $this->db->query('UPDATE `production_order` SET `move_to_render` = 1 WHERE `id` = '.$_REQUEST['order_id']);

        if($success)
        {
            echo json_encode(['status' => 1]);
        }
        
    }

    public function action_buttons()
    {
        $order_data = $this->db->query('SELECT assigned_to, status, move_to_render FROM production_order WHERE id = '.$_REQUEST['order_id'])->result_array();
        $status = $order_data[0]['status'];
        $assigned_to = $order_data[0]['assigned_to'];
        $move_to_render = $order_data[0]['move_to_render'];
        $status_name = $this->db->query('SELECT status_name FROM status WHERE id = '.$status)->result_array()[0]['status_name'];
        $html = '';
        
            if($status_name == 'Pending')
            {
                if(array_key_exists('Assign', $this->btn_permissions) && $this->btn_permissions['Assign']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:assign_order(\''.$_REQUEST['order_id'].'\', \'A\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Assign</a>';   



                    //echo('<button type="button" id="button'.$ctr.'" onClick="showMapsInfo(\''.str_replace("'", "\\'", $maps_name).'\', \''.str_replace("'", "\\'", $ctr).'\');"><img src="img/maps_logo.gif"></button><br/>');
       
                }
            }
            if($status_name == 'Pending-MR')
            {
                if(array_key_exists('Modification', $this->btn_permissions) && $this->btn_permissions['Modification']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:client_fb(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \'Modification\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Modification</a>';
                
                }
                if(array_key_exists('Repair', $this->btn_permissions) && $this->btn_permissions['Repair']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:client_fb(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \'Repair\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Repair</a>';
                
                }
            }
            if($status_name == 'Allocated')
            {
                if(array_key_exists('De-allocate', $this->btn_permissions) && $this->btn_permissions['De-allocate']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:assign_order(\''.$_REQUEST['order_id'].'\', \'D\');"><i class="mdi mdi-close-circle mr-2 text-muted font-18 vertical-middle"></i>De-allocate</a>';            
                }
            }
            if($status_name == 'In Process')
            {
                if(array_key_exists('Pause', $this->btn_permissions) && $this->btn_permissions['Pause']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:pause_timer(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Pause</a>';

            
                }
            }
            else if($status_name == 'QC Pending')
            {
                if(array_key_exists('QC Accept', $this->btn_permissions) && $this->btn_permissions['QC Accept']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:qc_accept(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>QC Accept</a>';
                
                }
                if(array_key_exists('QC Reject', $this->btn_permissions) && $this->btn_permissions['QC Reject']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:qc_reject(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>QC Reject</a>';
                
                }
            }
            else if($status_name == 'Ready To Deliver')
            {
                if(array_key_exists('PDW Sent', $this->btn_permissions) && $this->btn_permissions['PDW Sent']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:pdw_sent(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \'PDW Sent\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>PDW Sent</a>';
                
                }
            }
            else if($status_name == 'PDW Sent')
            {
                if(array_key_exists('Modification', $this->btn_permissions) && $this->btn_permissions['Modification']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:client_fb(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \'Modification\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Modification</a>';
                
                }
                if(array_key_exists('Repair', $this->btn_permissions) && $this->btn_permissions['Repair']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:client_fb(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \'Repair\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Repair</a>';
                
                }
                if(array_key_exists('STL Requested', $this->btn_permissions) && $this->btn_permissions['STL Requested']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:change_status(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \'STL Requested\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>STL Requested</a>';
                
                }
            }
            else if($status_name == 'Modification' || $status_name == 'Repair')
            {
                if(array_key_exists('Complete', $this->btn_permissions) && $this->btn_permissions['Complete']['view_perm'] == 1)
                {
                
                
                    $html .= '<a class="dropdown-item" href="javascript:complete(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Complete</a>';
                
                }
            }
            else if($status_name == 'STL QC')
            {
                if(array_key_exists('STL Accept', $this->btn_permissions) && $this->btn_permissions['STL Accept']['view_perm'] == 1)
                {
                
                
                    $html .= '<a class="dropdown-item" href="javascript:stl_accept(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \'Modification\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>STL Accept</a>';
                
                }
                if(array_key_exists('STL Reject', $this->btn_permissions) && $this->btn_permissions['STL Reject']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:stl_reject(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \'Repair\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>STL Reject</a>';

                
                }
            }
            else if($status_name == 'STL Accept')
            {
                if(array_key_exists('Complete', $this->btn_permissions) && $this->btn_permissions['Complete']['view_perm'] == 1)
                {
                
                
                    $html .= '<a class="dropdown-item" href="javascript:complete(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Complete</a>';                                                      
                
                }
            }    
            
            if(array_key_exists('Timeline', $this->btn_permissions) && $this->btn_permissions['Timeline']['view_perm'] == 1)
            {
        
                $html .= '<a class="dropdown-item" href="'.base_url().'timeline/index/'.$_REQUEST['order_id'].'"><i class="fe-clock font-18 text-muted mr-2 vertical-middle"></i>Timeline</a>';                      
            }

            if(array_key_exists('Cancel', $this->btn_permissions) && $this->btn_permissions['Cancel']['view_perm'] == 1 && $status_name != 'Canceled' && $status_name != 'Completed')
            {
        
                $html .= '<a class="dropdown-item" href="javascript:cancel_order(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', );"><i class="mdi mdi-close-circle mr-2 text-muted font-18 vertical-middle"></i>Cancel</a>';
        

        
            }
            if(array_key_exists('Edit', $this->btn_permissions) && $this->btn_permissions['Edit']['view_perm'] == 1 && $status_name != 'Canceled')
            {
        
                $html .= '<a class="dropdown-item" href="'.base_url().'production_orders/form_view/edit/'.$_REQUEST['order_id'].'"><i class="fe-edit font-18 text-muted mr-2 vertical-middle"></i>Edit</a>';
        
            }
            if($status_name != 'Pending')
            {
                if(array_key_exists('View', $this->btn_permissions) && $this->btn_permissions['View']['view_perm'] == 1 && $status_name != 'Canceled')
                {
        
                    $html .= '<a class="dropdown-item" href="javascript:void(0);" onclick="view_order(\''.$_REQUEST['order_id'].'\', \''.$status.'\', );"><i class="fe-eye font-18 text-muted mr-2 vertical-middle"></i>View</a>';
        
                }
            }
            if($status_name == 'Completed')
            {
                if(array_key_exists('Modification', $this->btn_permissions) && $this->btn_permissions['Modification']['view_perm'] == 1)
                {
        
                    $html .= '<a class="dropdown-item" href="javascript:client_fb(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\',  \'Modification\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Modification</a>';
        
                }

                if(array_key_exists('Move To Render', $this->btn_permissions) && $this->btn_permissions['Move To Render']['view_perm'] == 1 && $move_to_render == 0)
                {
        
                    $html .= '<a class="dropdown-item" href="javascript:void(0);" onclick="move_to_render('.$_REQUEST['order_id'].');"><i class="fe-arrow-right font-18 text-muted mr-2 vertical-middle"></i>Move To Render</a>';
        
                }

                if(array_key_exists('Delivered', $this->btn_permissions) && $this->btn_permissions['Delivered']['view_perm'] == 1)
                    {
        
                        $html .= '<a class="dropdown-item" href="javascript:delivered('.$_REQUEST['order_id'].');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Delivered</a>';
        
                    }
            }
            if($status_name == 'Delivered')
            {
                if(array_key_exists('Move To Render', $this->btn_permissions) && $this->btn_permissions['Move To Render']['view_perm'] == 1 && $move_to_render == 0)
                {
        
                    $html .= '<a class="dropdown-item" href="javascript:void(0);" onclick="move_to_render('.$_REQUEST['order_id'].');"><i class="fe-arrow-right font-18 text-muted mr-2 vertical-middle"></i>Move To Render</a>';
        
                }
            }

            if(array_key_exists('Send To Manager', $this->btn_permissions) && $this->btn_permissions['Send To Manager']['view_perm'] == 1)
            {
        
                $html .= '<a class="dropdown-item" href="javascript:send_to_manager(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Send To Manager</a>';                     
            }
        
        echo json_encode(['html' => $html]);
    }

}
?>
