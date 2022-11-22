<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Render_production_orders extends CI_Controller
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
        $this->render_btn_permissions = $this->master_model->get_render_btn_permissions();
        $this->btn_permissions = $this->master_model->get_btn_permissions();
    }

    public function export_csv()
    {
        $role_name = $this->db->query('SELECT role_name FROM role WHERE id = '.$this->session->userdata('user_role'))->result_array()[0]['role_name'];
        $today = date('Y-m-d');
        $completed_status = $this->db->query('SELECT id FROM status WHERE status_name = "Completed"')->result_array()[0]['id'];
        $order_no = urlencode($_REQUEST['order_no']);
        $po_no = urlencode($_REQUEST['po_no']);
        $category = urlencode($_REQUEST['category']);
        $status_name = urlencode($_REQUEST['status_name']);
        $from_date = urlencode($_REQUEST['from_date']);
        $order_date = urlencode($_REQUEST['order_date']);
        $to_date = urlencode($_REQUEST['to_date']);
        $f_priority = urlencode($_REQUEST['f_priority']);

        if($role_name == 'Admin')
       {
            $department_id_query = $this->db->query('SELECT id FROM department');
            $department_id = array_column($department_id_query->result_array(), 'id');
       }
       else
       {
            $department_id_query = $this->db->query('SELECT dept_id FROM user_departments WHERE user_id = '.$this->session->userdata('user_id'));
           if($department_id_query->num_rows() > 0)
           {
                $department_id = array_column($department_id_query->result_array(), 'dept_id');
           }
           else
           {
            $department_id = [];
           }
       }
        
        $this->db->select('*');
        $this->db->from('render_view');
        if(isset($_REQUEST['status_name']) && $_REQUEST['status_name'] != '')
        {
            if(isset($_REQUEST['department_id']) && $_REQUEST['department_id'] != '')
            {
                $this->db->where('`status` IN (SELECT `id` FROM `ms_render_status` WHERE label = "'.$_REQUEST['status_name'].'" AND department_id = "'.$_REQUEST['department_id'].'")', NULL, FALSE);                                        
            }
            else
            {
                $this->db->where('`status` IN (SELECT `id` FROM `ms_render_status` WHERE label = "'.$_REQUEST['status_name'].'")', NULL, FALSE);
            }
            
        }
        
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
        if(isset($_REQUEST['f_priority']) && $_REQUEST['f_priority'] != '' && $_REQUEST['f_priority'] != 'None')
        {
            
            $this->db->where('priority', $_REQUEST['f_priority']);
        }
        if(isset($from_date) && $from_date != '')
        {
            $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") >= ', $from_date);
            
        }
        if(isset($to_date) && $to_date != '')
        {
            $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") <= ', $to_date);
        }
        if(isset($order_date) && $order_date != '')
        {
            $this->db->where('DATE_FORMAT(order_date, "%Y-%m-%d") = ', $order_date);
            
        }

        if(isset($_REQUEST['department_id']) && $_REQUEST['department_id'] != '')
        {
            if($role_name == 'Render Designer')
            {
                $this->db->where('department_id', $_REQUEST['department_id']);
                $this->db->where('assigned_to', $this->session->userdata('user_id'));
            }
            else
            {
                $this->db->where('department_id', $_REQUEST['department_id']);
            }
            
        }
        else
        {
            if($role_name == 'Render Designer')
            {
                $department_id = implode(',', $department_id);
                $this->db->where('`department_id` IN ('.$department_id.')', NULL, FALSE); 
                // $this->db->where_in('department_id', $department_id);
                $this->db->where('assigned_to', $this->session->userdata('user_id'));
            }                                
            else
            {
                // $this->db->where_in('department_id', $department_id);
                $department_id = implode(',', $department_id);
                $this->db->where('`department_id` IN ('.$department_id.')', NULL, FALSE); 
            }
        }
        

        
        
        $this->db->order_by('updated_date', 'DESC');
        $res = $this->db->get();
        
        $mainA = [];
        $i=0;
        if($res->num_rows() > 0)
        {
            $result = $res->result_array();
            
            foreach($result as $r)
            {               
                $status_name = $this->db->get_where('ms_render_status', ['id' =>  $r['status'], 'department_id' =>  $r['department_id']]); 
                if($status_name->num_rows() > 0)               
                {
                    $status_name = $status_name->result_array()[0]['label'];
                }
                else
                {
                   $status_name = ''; 
                }

                $i++;

                 //$created_date = $this->db->query('SELECT created_date FROM render_order_log WHERE job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['created_date'];

                 $latest_act = isset($created_date) && !empty($created_date) ? date('d-m-y', strtotime($created_date)).' '.date('H:i', strtotime($created_date)) : '';

                $mainA[] = ['Order Number' => $r['order_number'], 'Client Design No' => $r['client_design_no'], 'PO No' => $r['po_no'], 'Priority' => isset($r['priority']) && !empty($r['priority']) ? $r['priority'] : 'None', 'Category' => $r['category'], 'Order Date' => date('Y-m-d', strtotime($r['order_date'])), 'Department' => $this->master_model->get_one_record('department', 'dept_name', $r['department_id']), 'Status' => $status_name, 'File Path' => $r['file_path'], 'Difficulty' => $this->master_model->get_one_record('difficulty', 'difficulty_name', $r['difficulty_id']), 'Designer' => $this->master_model->get_one_record('users', 'full_name', $r['assigned_to'])];
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

    public function index()
    {
        $this->load->view('render_production_orders/render_production_orders_view');
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
                if($key == 'f_priority')
                {
                    if($value != '')
                    {
                        $conditions[] = 'priority = "'.$value.'"';
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
                        $conditions[] = 'current_status = "'.$value.'"';
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
        
        $string = !empty($conditions) ? ' AND '.implode(' AND ', $conditions) : '';
        return $string;
    }

    public function copy_render()
    {
        $this->load->view('render_production_orders/render_production_orders_view1');
    }

    public function fetch_orders() {
       $role_name = $this->db->query('SELECT role_name FROM role WHERE id = '.$this->session->userdata('user_role'))->result_array()[0]['role_name'];
       if($role_name == 'Admin')
       {
            $department_id_query = $this->db->query('SELECT id FROM department');
            $department_id = array_column($department_id_query->result_array(), 'id');
       }
       else
       {
            $department_id_query = $this->db->query('SELECT dept_id FROM user_departments WHERE user_id = '.$this->session->userdata('user_id'));
           if($department_id_query->num_rows() > 0)
           {
                $department_id = array_column($department_id_query->result_array(), 'dept_id');
           }
           else
           {
            $department_id = [];
           }
       }    
        $data = array();
        if ($this->input->is_ajax_request()) {
            /** this will handle datatable js ajax call * */
            /** get all datatable parameters * */
            $search = $this->input->post('search');/** search value for datatable  * */
            $offset = $this->input->post('start');/** offset value * */
            $limit = $this->input->post('length');/** limits for datatable (show entries) * */
            $order = $this->input->post('order');/** order by (column sorted ) * */
            $column = array('order_number', 'client_design_no', 'po_no', 'priority', 'category', 'order_date', 'dept_name', 'current_status', 'color', 'file_path', 'difficulty_name', 'current_designer');/**  set your data base column name here for sorting* */
            $orderColumn = isset($order[0]['column']) ? $column[$order[0]['column']] : 'order_number';
            $orderDirection = isset($order[0]['dir']) ? $order[0]['dir'] : 'asc';
            // $ordrBy = $orderColumn . " " . $orderDirection;

            $ordrBy = "updated_date DESC";

            $condition = '';

            if(isset($_REQUEST['department_id']) && $_REQUEST['department_id'] != '')
            {
                if($role_name == 'Render Designer')
                {
                    $condition .= 'WHERE `department_id` IN ('.$_REQUEST['department_id'].') AND `assigned_to` = "'.$this->session->userdata('user_id').'"'; 
                }
                else
                {
                    
                    $condition .= 'WHERE `department_id` IN ('.$_REQUEST['department_id'].')'; 
                }
                
            }
            else
            {

                if($role_name == 'Render Designer')
                {
                    $department_id = implode(',', $department_id);
                    $condition .= 'WHERE `department_id` IN ('.$department_id.') AND `assigned_to` = "'.$this->session->userdata('user_id').'"'; 
                }                                
                else
                {
                    
                    $department_id = implode(',', $department_id);
                    $condition .= 'WHERE `department_id` IN ('.$department_id.')'; 
                }
            }

            $filter_array = [];
            $filter_array['order_no'] = isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no']) ? $_REQUEST['order_no'] : '';
            $filter_array['category'] = isset($_REQUEST['category']) && !empty($_REQUEST['category']) ? $_REQUEST['category'] : '';
            $filter_array['client_name'] = isset($_REQUEST['client_name']) && !empty($_REQUEST['client_name']) ? $_REQUEST['client_name'] : '';
            $filter_array['from_date'] = isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']) ? $_REQUEST['from_date'] : '';
            $filter_array['to_date'] = isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']) ? $_REQUEST['to_date'] : '';
            $filter_array['order_date'] = isset($_REQUEST['order_date']) && !empty($_REQUEST['order_date']) ? $_REQUEST['order_date'] : '';
            $filter_array['status_name'] = isset($_REQUEST['status_name']) && !empty($_REQUEST['status_name']) ? $_REQUEST['status_name'] : '';
            $filter_array['po_no'] = isset($_REQUEST['po_no']) && !empty($_REQUEST['po_no']) ? $_REQUEST['po_no'] : '';
            $filter_array['f_priority'] = isset($_REQUEST['f_priority']) && !empty($_REQUEST['f_priority']) ? $_REQUEST['f_priority'] : '';
            
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
                /** creat sql or call Model * */
                /**   $this->load->model('Parameter_model');
                  $this->Parameter_model->get_parameter('tbl_parameter'); * */
                /** I am calling sql directly in controller for your answer 
                 * Please change your sql according to your table name
                 * */
                $sql = "SELECT * FROM render_view ".$condition." ".$search_string." order by " . $ordrBy . " limit $offset,$limit";
                $sql2 = "SELECT count(id) AS count FROM render_view ".$condition." ".$search_string." order by " . $ordrBy;
                $result = $this->db->query($sql);
                $result2 = $this->db->query($sql2);
                $count = $result2->result_array()[0]['count'];
            } else {
                /**
                 * If no seach value avaible in datatable
                 */
                $sql = "SELECT * FROM render_view ".$condition." order by " . $ordrBy . " limit $offset,$limit";
                $sql2 = "SELECT count(id) AS count FROM render_view ".$condition." order by " . $ordrBy;
                $result = $this->db->query($sql);
                $result2 = $this->db->query($sql2);
                $count = $result2->result_array()[0]['count'];
            }
            /** create data to display in dataTable as you want **/    

            $data = array();
            if (!empty($result->result_array())) {
                foreach ($result->result_array() as $k => $v) {

                                                                   
                        $status_name = $v['current_status'];
                        $color = $v['color'];

                        $status_string = '<span class="badge badge-outline-success" style="color:#fff;background-color:'.$color.';border:1px solid '.$color.';">'.$status_name.'</span>';
                        
                        if(isset($v['rejected_flag']) && $v['rejected_flag'] != 0)
                        {
                           $rejected_by = $this->master_model->get_one_record('users', 'full_name', $v['rejected_flag']); 
                    
                            $status_string .= '<br><a href="javascript:void(0);" onclick="check_rejected(\''.$v['remark'].'\', \''.$rejected_by.'\');">Rejected Order</a>';
                    
                        }


                        if(isset($v['prev_dept_flag']) && $v['prev_dept_flag'] != 0)
                            {
                                $prev_dept = $this->master_model->get_one_record('department', 'dept_name', $v['prev_dept_flag']);
                        
                                $status_string .= '<br><a href="javascript:void(0);" style="color:red;" onclick="check_go_back(\''.$prev_dept.'\', \''.$v['remark'].'\');">Returned Order</a>';
                        
                            } 

                        if($status_name == 'QC Reject') 
                        {
                            $status_string .= '<br><strong>'.$v['remark'].'</strong>';
                        }

                        if(isset($v['file_path']) && $v['file_path'] != '')
                        {
                        	$id = 'file_path_span'.$v['id'];
                        
                            $file_path_string = '<div><span id="'.$id.'" style="display:none;">'.$v['file_path'].'</span>
                            <button type="button" onclick="copyToClipboard(\''.$id.'\')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">IMG Path</button> </div>';
                        
                        } else{ $file_path_string = '';}


                        if(isset($v['video_file_path']) && $v['video_file_path'] != '')
                        {
                        	$id1 = 'video_file_path_span'.$v['id'];
                        
                            $file_path_string .= '<div style="margin-top:27px;"><span id="'.$id1.'" style="display:none;">'.$v['video_file_path'].'</span>
                            <button type="button" onclick="copyToClipboard(\''.$id1.'\')" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;">Video Path</button> </div>';  
                        
                        } else{ $file_path_string .= '';}


                        $portal_order_id = $this->db->query('SELECT portal_order_id FROM render_production_order WHERE id = '.$v['id'])->result_array()[0]['portal_order_id'];
                    
                    $data[] = array(

                        
                        
                        'check' => '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input dt-checkboxes chk_order" id="customCheck'.$v['id'].'" value="'.$v['id'].'"><label class="custom-control-label">&nbsp;</label></div>',
                        'order_number' =>  '<a target="_blank" href="'.base_url().'portal_orders/form_view/view/'.$portal_order_id.'">'.$v['order_number'].'</a>',
                        
                          'client_design_no' =>  $v['client_design_no'],
                          'po_no' =>  $v['po_no'],
                          'priority' =>  $v['priority'],
                          'category' =>  $v['category'],
                          'order_date' =>  date('d-m-y', strtotime($v['order_date'])),
                          'dept_name' =>  $v['dept_name'],
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

    public function media_uploded($id = '')
    {
        $data = [];        
        $data['id'] = $this->db->query('SELECT id FROM website_order WHERE id = (SELECT portal_order_id FROM render_production_order WHERE id = "'.$id.'" AND delete_flag = 0)')->result_array()[0]['id'];
        $this->load->view('portal_orders/media_uploded', $data);
        
    }

    public function form_view($id = '')
    {
        $data = [];
        if($id)
        {
            $data['edit_data'] = $this->db->query('SELECT * FROM website_order WHERE delete_flag = 0 AND id = (SELECT portal_order_id FROM render_production_order WHERE delete_flag = 0 AND id = "'.$id.'")')->result_array();
            
            $this->load->view('portal_orders/info_view', $data);
        }
    }

    
    public function get_this_designers()
    {
        $order_id = $_REQUEST['order_id'];
        $department_id = $_REQUEST['department_id'];
        
        $html = '';
        $html .= '<label for="user_id">Designer</label><select  data-parsley-errors-container="#des-errors" class="form-control" name="user_id" id="user_id" data-toggle="select2" required>
                                <option value="">Select</option>';
        
        $check_designers = $this->db->query('SELECT * FROM `users` WHERE user_role IN (SELECT associated FROM dropdown_options WHERE role_id = '.$this->session->userdata('user_role').' AND type = "RENDER") AND id IN (SELECT user_id FROM user_departments WHERE dept_id IN ('.$department_id.'))');
            // pre($this->db->last_query());exit;
        
        if($check_designers->num_rows() > 0)
        {
            $check_designers = $check_designers->result_array();
            foreach($check_designers as $key => $value) 
            {
                $html .= '<option value="'.$value['id'].'">'.$value['full_name'].'</option>';
            }
        }
        $html .= '</select><div id="des-errors"></div>';
        
        echo $html;
    }
    

    public function assign()
    {

        $department_id = $this->db->query('SELECT department_id FROM render_production_order WHERE id = '.$_REQUEST['order_id'])->result_array()[0]['department_id'];
        $difficulty_name = $this->master_model->get_one_record('difficulty', 'difficulty_name', $_REQUEST['difficulty_id']); 

        $password = str_pad(rand(0, pow(10, 6)-1), 6, '0', STR_PAD_LEFT);
        $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `name` = "Allocated" AND department_id = '.$department_id)->result_array()[0]['id'];

        $this->db->where('id', $_REQUEST['order_id']);       

        $sql_update = $this->db->update('render_production_order', ['assigned_to' => $_REQUEST['user_id'], 'password' => $password, 'difficulty_id' => $_REQUEST['difficulty_id'], 'initial_difficulty' => $difficulty_name,'status' => $status, 'file_path' => $_REQUEST['assign_file_path'], 'remark' => '', 'rejected_flag' => 0, 'prev_dept_flag' => 0, 'is_started' => 0]);

        $render_order_log = array(
            'job_id' => $_REQUEST['order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['user_id'],
            'description' => 'Order allocated to', 
            'department_id' => $department_id,
            'file_path' => $_REQUEST['assign_file_path'],
            'remark' => '',
            'rejected_flag' => 0,
            'prev_dept_flag' => 0,
            'difficulty_id' => $_REQUEST['difficulty_id']

        );
        $this->db->insert('render_order_log', $render_order_log);
        if($sql_update){
            $this->session->set_flashdata('message', 'Allocated Successfully!');
        }

        if(isset($_REQUEST['custom_department_id']) && !empty($_REQUEST['custom_department_id']))
        {
            redirect('render_production_orders?department_id='.$_REQUEST['custom_department_id']);
        }
        else{
            redirect('render_production_orders');
        }

        
    }

    public function start_timer()
    {
        $order_id = $_REQUEST['order_id'];
        $user_id = $_REQUEST['user_id'];
        $department_id = $this->db->query('SELECT department_id FROM render_production_order WHERE id = '.$order_id)->result_array()[0]['department_id']; 

        $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `name` = "Start" AND department_id = '.$department_id)->result_array()[0]['id'];

        $this->db->where('id', $order_id);
        $sql_update = $this->db->update('render_production_order', ['status' => $status, 'is_started' => 1]);

        $render_order_log = $this->db->insert('render_order_log', ['job_id' => $order_id, 'status' => $status, 'assigned_to' => $user_id, 'created_by' => $this->session->userdata('user_id'), 'description' => 'Designing started', 'department_id' => $department_id]);

        $start_stop_time = $this->db->insert('render_start_stop_time', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'time' => time(), 'type' => 'Start', 'department_id' => $department_id]);

        if($start_stop_time){
            echo json_encode(['class' => 'success', 'message' => 'Started Successfully!']);
        }

    }

    public function pause_timer()
    {

        $order_id = $_REQUEST['pause_order_id'];
        
        $department_id = $this->db->query('SELECT department_id FROM render_production_order WHERE id = '.$order_id)->result_array()[0]['department_id']; 

        $verify = $this->db->get_where('render_production_order', ['id' => $order_id, 'password' => $_REQUEST['password']]);
        if($verify->num_rows() == 0)
        {
            $this->session->set_flashdata(['class' => 'danger', 'message' => 'Invalid Password!']);
        }
        else{


        	$verified = $verify->result_array();
        	$client_name = $verified[0]['client_name'];

        	$assigned_to = $verified[0]['assigned_to'];

        	$name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `render_production_order` WHERE `id` = '.$order_id.')')->result_array();

        	$diff_name = $name_time[0]['difficulty_name'];
        	$diff_time = $name_time[0]['total_time'];

            $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `name` = "Pause" AND department_id = '.$department_id)->result_array()[0]['id'];
            $this->db->where('id', $order_id);
            $sql_update = $this->db->update('render_production_order', ['status' => $status]);

            $user_id = $this->session->userdata('user_id') != $assigned_to ? $assigned_to  : $this->session->userdata('user_id');

            $render_order_log = $this->db->insert('render_order_log', ['job_id' => $order_id, 'assigned_to' => $user_id, 'reason' => $_REQUEST['reason'], 'status' => $status, 'description' => 'Order paused', 'created_by' => $this->session->userdata('user_id'), 'department_id' => $department_id]);

            

            $is_started = $this->db->query('SELECT is_started FROM render_production_order WHERE id = '.$order_id)->result_array()[0]['is_started'];
            
            if($is_started == 1)
            {
            	$render_start_stop_time = $this->db->insert('render_start_stop_time', ['job_id' => $order_id, 'user_id' => $user_id, 'time' => time(), 'type' => 'Stop', 'department_id' => $department_id]);

            	
            }


           $this->db->where('id', $order_id);
           $this->db->update('render_production_order', ['is_started' => 0]);
            

            $this->db->where(['type' => 'Start', 'job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $start_time_query = $this->db->get('render_start_stop_time');
            $start_time = $start_time_query->result_array()[0]['time'];
            


            $this->db->where(['type' => 'Stop', 'job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $stop_time_query = $this->db->get('render_start_stop_time');
            $stop_time = $stop_time_query->result_array()[0]['time'];


            $time_taken = $stop_time - $start_time;

            $this->db->where(['job_id' => $order_id, 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $last_time_taken = $this->db->get('render_start_stop_action');
            
            if($last_time_taken->num_rows() > 0)
            {
                $last_time_taken = $last_time_taken->result_array()[0]['actual_time'];
                
                $final_time_taken = $time_taken + $last_time_taken;
            }
            else
            {
                $final_time_taken = $time_taken;
            }

            $this->db->insert('render_start_stop_action', ['job_id' => $order_id, 'user_id' => $user_id, 'actual_time' => $final_time_taken, 'department_id' => $department_id]);

            $this->db->insert('render_action_time', ['job_id' => $order_id, 'user_id' => $user_id, 'actual_time' => $time_taken, 'department_id' => $department_id,'diff_name' => $diff_name, 'diff_time' => $diff_time]);


            if($render_start_stop_time){
                $this->session->set_flashdata(['class' => 'success', 'message' => 'Paused Successfully!']);
            }
        }

        if(isset($_REQUEST['pause_department_id']) && !empty($_REQUEST['pause_department_id']))
        {
            redirect('render_production_orders?department_id='.$_REQUEST['pause_department_id']);
        }
        else{
            redirect('render_production_orders');
        }

        

    }

    public function qc_check()
    {
        $order_id = $_REQUEST['order_id'];
        $verified = $this->db->get_where('render_production_order',['id' => $order_id])->result_array();

        $client_name = $verified[0]['client_name'];

        $name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `render_production_order` WHERE `id` = '.$order_id.')')->result_array();

    	$diff_name = $name_time[0]['difficulty_name'];
    	$diff_time = $name_time[0]['total_time'];
        
        $department_id = $this->db->query('SELECT department_id FROM render_production_order WHERE id = '.$order_id)->result_array()[0]['department_id']; 
        $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `name` = "Send to QC" AND department_id = '.$department_id)->result_array()[0]['id'];
        
        $this->db->where('id', $order_id);
        $sql_update = $this->db->update('render_production_order', ['status' => $status, 'qc_by' => $this->session->userdata('user_id'), 'file_path' => $_REQUEST['assign_file_path']]);
        $render_order_log = array(
            'job_id' => $order_id,
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'description' => 'Order sent for quality check',
            'assigned_to' => $_REQUEST['assigned_user_id'],
            'file_path' => $_REQUEST['assign_file_path'],
            'department_id' => $department_id
        );

        $this->db->insert('render_order_log', $render_order_log);

        $is_started = $this->db->query('SELECT is_started FROM render_production_order WHERE id = '.$order_id)->result_array()[0]['is_started'];
        if($is_started == 1)
        {
        	$render_start_stop_time = $this->db->insert('render_start_stop_time', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'time' => time(), 'type' => 'Stop', 'department_id' => $department_id]);
        }

        $this->db->where('id', $order_id);
        $sql_update = $this->db->update('render_production_order', ['is_started' => 0]);
        

        $this->db->where(['type' => 'Start', 'job_id' => $order_id, 'user_id' => $this->session->userdata('user_id')]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $start_time_query = $this->db->get('render_start_stop_time');
        $start_time = $start_time_query->result_array()[0]['time'];          


        $this->db->where(['type' => 'Stop', 'job_id' => $order_id, 'user_id' => $this->session->userdata('user_id')]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $stop_time_query = $this->db->get('render_start_stop_time');
        $stop_time = $stop_time_query->result_array()[0]['time'];


        $time_taken = $stop_time - $start_time;

        $this->db->where(['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id')]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $last_time_taken = $this->db->get('render_start_stop_action');
        if($last_time_taken->num_rows() > 0)
        {
            $last_time_taken = $last_time_taken->result_array()[0]['actual_time'];
            
            $final_time_taken = $time_taken + $last_time_taken;
        }
        else
        {
            $final_time_taken = $time_taken;
        }

        $this->db->insert('render_start_stop_action', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'actual_time' => $final_time_taken, 'department_id' => $department_id]);

        $this->db->insert('render_action_time', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'actual_time' => $time_taken, 'department_id' => $department_id,'diff_name' => $diff_name, 'diff_time' => $diff_time]);

        if($sql_update){
            $this->session->set_flashdata('message', 'Order sent for quality check!');
        }

        if(isset($_REQUEST['custom_department_id']) && !empty($_REQUEST['custom_department_id']))
        {
            redirect('render_production_orders?department_id='.$_REQUEST['custom_department_id']);
        }
        else{
            redirect('render_production_orders');
        }
        
        
    }

    public function qc_accept()
    {
        $department_id = $this->db->query('SELECT department_id FROM render_production_order WHERE id = '.$_REQUEST['order_id'])->result_array()[0]['department_id']; 

        $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `name` = "QC Accept" AND department_id = '.$department_id)->result_array()[0]['id'];

        
        $this->db->where('id', $_REQUEST['order_id']);
        $sql_update = $this->db->update('render_production_order', ['status' => $status]);

        $render_order_log = array(
            'job_id' => $_REQUEST['order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['user_id'],
            'department_id' => $department_id
        );
        $this->db->insert('render_order_log', $render_order_log);
        if($sql_update){
            echo json_encode(array('message' => 'QC Accepted Successfully!'));
        }
    }

    public function complete()
    {
        $department_id = $this->db->query('SELECT department_id FROM render_production_order WHERE id = '.$_REQUEST['complete_order_id'])->result_array()[0]['department_id'];
        $final_qc_dept_id = $this->db->query('SELECT id FROM department WHERE dept_name = "Final QC"')->result_array()[0]['id'];
        $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `name` = "Completed" AND department_id = '.$department_id)->result_array()[0]['id'];

        $update_array = ['status' => $status, 'complet_file_path' => $_REQUEST['complet_file_path']];
        if(isset($_REQUEST['video_file_path']) && !empty($_REQUEST['video_file_path']))
        {
            $update_array['video_file_path'] = $_REQUEST['video_file_path'];
        }

        if(isset($_REQUEST['img_file_path']) && !empty($_REQUEST['img_file_path']))
        {
            $update_array['file_path'] = $_REQUEST['img_file_path'];
        }
        
        $this->db->where('id', $_REQUEST['complete_order_id']);
        $sql_update = $this->db->update('render_production_order', $update_array);

        $render_order_log = array(
            'job_id' => $_REQUEST['complete_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['complete_assigned_to'],
            'department_id' => $department_id
        );

        $this->db->insert('render_order_log', $render_order_log);

        if($sql_update){
                
                $this->session->set_flashdata('message', 'Completed Successfully!');
        }


        /*stop entry in final qc*/
        if($department_id == $final_qc_dept_id)
        {
            $verified = $this->db->get_where('render_production_order', ['id' => $_REQUEST['complete_order_id']])->result_array();
            $assigned_to = $verified[0]['assigned_to'];
            $name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `render_production_order` WHERE `id` = '.$_REQUEST['complete_order_id'].')')->result_array();

            $diff_name = $name_time[0]['difficulty_name'];
            $diff_time = $name_time[0]['total_time'];
            $user_id = $this->session->userdata('user_id') != $assigned_to ? $assigned_to  : $this->session->userdata('user_id');
            $is_started = $this->db->query('SELECT is_started FROM render_production_order WHERE id = '.$_REQUEST['complete_order_id'])->result_array()[0]['is_started'];
                
            if($is_started == 1)
            {
                $render_start_stop_time = $this->db->insert('render_start_stop_time', ['job_id' => $_REQUEST['complete_order_id'], 'user_id' => $user_id, 'time' => time(), 'type' => 'Stop', 'department_id' => $department_id]);

                $this->db->where('id', $_REQUEST['complete_order_id']);
                $this->db->update('render_production_order', ['is_started' => 0]);
            }


            $this->db->where(['type' => 'Start', 'job_id' => $_REQUEST['complete_order_id'], 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $start_time_query = $this->db->get('render_start_stop_time');
            $start_time = $start_time_query->result_array()[0]['time'];
            


            $this->db->where(['type' => 'Stop', 'job_id' => $_REQUEST['complete_order_id'], 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $stop_time_query = $this->db->get('render_start_stop_time');
            $stop_time = $stop_time_query->result_array()[0]['time'];


            $time_taken = $stop_time - $start_time;

            $this->db->where(['job_id' => $_REQUEST['complete_order_id'], 'user_id' => $user_id]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $last_time_taken = $this->db->get('render_start_stop_action');
            
            if($last_time_taken->num_rows() > 0)
            {
                $last_time_taken = $last_time_taken->result_array()[0]['actual_time'];
                
                $final_time_taken = $time_taken + $last_time_taken;
            }
            else
            {
                $final_time_taken = $time_taken;
            }

            $this->db->insert('render_start_stop_action', ['job_id' => $_REQUEST['complete_order_id'], 'user_id' => $user_id, 'actual_time' => $final_time_taken, 'department_id' => $department_id]);

            $this->db->insert('render_action_time', ['job_id' => $_REQUEST['complete_order_id'], 'user_id' => $user_id, 'actual_time' => $time_taken, 'department_id' => $department_id,'diff_name' => $diff_name, 'diff_time' => $diff_time]);
        }
        
        /*final qc stop ends*/

        if(isset($_REQUEST['move_to_dept']) && !empty($_REQUEST['move_to_dept']))
        {
            //move to
            $target_department_id = $_REQUEST['move_to_dept'];
            $default_status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `department_id` IN ('.$target_department_id.') AND default_status = 1')->result_array()[0]['id']; 

            
            $this->db->where('id', $_REQUEST['complete_order_id']);       

            $sql_update = $this->db->update('render_production_order', ['status' => $default_status, 'department_id' => $target_department_id, 'assigned_to' => 0, 'difficulty_id' => 0]);

            $render_order_log1 = array(
                'job_id' => $_REQUEST['complete_order_id'],
                'status'   => $default_status,
                'created_by' => $this->session->userdata('user_id'),
                'assigned_to' => 0,
                'description' => 'Order moved to', 
                'department_id' => $target_department_id
            );
            $target_name = $this->master_model->get_one_record('department', 'label', $target_department_id);
            $this->db->insert('render_order_log', $render_order_log1);
            if($sql_update){
                
                $this->session->set_flashdata('message', 'Completed And Moved To '.$target_name.' Successfully!');
            }
        }
        
        if(isset($_REQUEST['complete_department_id']) && !empty($_REQUEST['complete_department_id']))
        {
            redirect('render_production_orders?department_id='.$_REQUEST['complete_department_id']);
        }
        else{
            redirect('render_production_orders');
        } 
        
    }

    public function move_to_RR()
    {
        #pre($_REQUEST);exit;
        $department_id = $this->db->query('SELECT id FROM department WHERE dept_name = "'.$_REQUEST['target_department'].'"')->result_array()[0]['id'];
        $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `name` = "Pending" AND department_id = '.$department_id)->result_array()[0]['id'];
        
        $this->db->where('id', $_REQUEST['order_id']);
        $sql_update = $this->db->update('render_production_order', ['status' => $status, 'department_id' => $department_id, 'is_started' => 0]);

        $render_order_log = array(
            'job_id' => $_REQUEST['order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['user_id'],
            'department_id' => $department_id
        );

        $this->db->insert('render_order_log', $render_order_log);
        if($sql_update){
            echo json_encode(array('message' => 'Moved To RR Successfully!'));
        }        
    }


    
    public function qc_reject()
    {
        $department_id = $this->db->query('SELECT department_id FROM render_production_order WHERE id = '.$_REQUEST['rej_order_id'])->result_array()[0]['department_id'];

        $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `name` = "QC Reject" AND department_id = '.$department_id)->result_array()[0]['id'];
        
        
        $this->db->where('id', $_REQUEST['rej_order_id']);
        $sql_update = $this->db->update('render_production_order', ['status' => $status, 'remark' => $_REQUEST['remark'], 'is_started' => 0]);

        $render_order_log = array(
        	'status' => $status,
            'job_id' => $_REQUEST['rej_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['assigned_to'],
            'remark' => $_REQUEST['remark'],
            'description' => 'Quality check reject',
            'department_id' => $department_id
        );
        $this->db->insert('render_order_log', $render_order_log);
        if($sql_update){
            $this->session->set_flashdata('message', 'Rejected Successfully!');
        }


        if(isset($_REQUEST['rej_department_id']) && !empty($_REQUEST['rej_department_id']))
        {
            redirect('render_production_orders?department_id='.$_REQUEST['rej_department_id']);
        }
        else{
            redirect('render_production_orders');
        }        

        
    }

    public function view_order()
    {
        $html = '';
        $designer = $this->db->query('SELECT id, full_name FROM `users` WHERE id IN (SELECT user_id FROM `user_departments` WHERE dept_id IN (SELECT department_id FROM render_production_order WHERE id = '.$_REQUEST['order_id'].')) AND active = 1');
        if($designer->num_rows() > 0)
        {
            $designer = $designer->result_array();
            foreach($designer as $d)
            {
                $html.= '<option value="'.$d['id'].'">'.$d['full_name'].'</option>';
            }
        }

        $production_order = $this->db->get_where('render_production_order', ['id' => $_REQUEST['order_id']])->result_array()[0];
        
        $production_order['html'] = $html;
        if(!empty($production_order)){
            echo json_encode($production_order);
        }
    } 

    public function deallocate_order()
    {
        
        
        $department_id = $_REQUEST['department_id'];
        $default_status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `department_id` IN ('.$department_id.') AND default_status = 1')->result_array()[0]['id']; 

        
        $this->db->where('id', $_REQUEST['order_id']);       

        $sql_update = $this->db->update('render_production_order', ['status' => $default_status, 'department_id' => $department_id, 'assigned_to' => 0, 'difficulty_id' => 0, 'is_started' => 0]);

        $render_order_log = array(
            'job_id' => $_REQUEST['order_id'],
            'status'   => $default_status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => 0,
            'is_dealocated' => 1,
            'description' => 'Order Deallocated', 
            'department_id' => $department_id
        );
        $this->db->insert('render_order_log', $render_order_log);
        if($sql_update){
            echo json_encode(array('message' => 'Rejected Successfully!'));
        }

        
    }   

    public function edit()
    {
       
        $this->db->where('id', $_REQUEST['current_order_id']);
        $department_id = $this->db->query('SELECT department_id FROM render_production_order WHERE id = '.$_REQUEST['current_order_id'])->result_array()[0]['department_id'];
        $sql_update = $this->db->update('render_production_order', ['difficulty_id' => $_REQUEST['current_difficulty_id'], 'assigned_to' => $_REQUEST['current_user_id'], 'file_path' => $_REQUEST['file_path']]);

        $last_log_id = $this->db->query('SELECT id FROM render_order_log WHERE job_id = '.$_REQUEST['current_order_id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['id'];

        $this->db->where('id', $last_log_id)->update('render_order_log', ['is_dealocated' => 1]);

        $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `label` = "Pending" AND department_id IN ('.$department_id.')')->result_array()[0]['id'];
        $order_log = array(
            'job_id' => $_REQUEST['current_order_id'],
            'department_id' => $department_id,
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => 0,
            'is_dealocated' => 1,
            'description' => 'Order Deallocated'
        );
        $this->db->insert('render_order_log', $order_log);


        $order_log = array(
            'job_id' => $_REQUEST['current_order_id'],
            'department_id' => $department_id,
            'status'   => $_REQUEST['current_status'],
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['current_user_id'],
            'difficulty_id' => $_REQUEST['current_difficulty_id'],
            'description' => 'Order allocated to'
        );
        $this->db->insert('render_order_log', $order_log);

    
        if($sql_update){
            $this->session->set_flashdata('message', 'Submitted Successfully!');
        }

        redirect('render_production_orders');
    }

    public function remove()
    {
        $portal_order_id = $this->db->query('SELECT portal_order_id FROM render_production_order WHERE id IN ('.$_REQUEST['order_ids'].')');
        if($portal_order_id->num_rows() > 0)
        {
            $portal_order_id = array_column($portal_order_id->result_array(), 'portal_order_id');
            $portal_order_id = implode(',', $portal_order_id);
        }
        $this->db->query('UPDATE website_order SET delete_flag = 1 WHERE id IN ('.$portal_order_id.')');
        
        $success = $this->db->query('UPDATE render_production_order SET delete_flag = 1 WHERE id IN ('.$_REQUEST['order_ids'].')');
        if($success){
            $this->session->set_flashdata('message', 'Deleted Successfully!');
        }

        if(isset($_REQUEST['filtered_department_id']) && !empty($_REQUEST['filtered_department_id']))
        {
            redirect('render_production_orders?department_id='.$_REQUEST['filtered_department_id']);
        }
        else
        {
            redirect('render_production_orders');
        }

        
    }

    public function set_priority()
    {
        $priority = $_REQUEST['priority'];
        $success = $this->db->query('UPDATE render_production_order SET priority = "'.$priority.'" WHERE id IN ('.$_REQUEST['priority_order_ids'].')');
        
        if($success){
            $this->session->set_flashdata('message', 'Priority Set Successfully!');
        }

        redirect('render_production_orders');
    }
    
    


    public function reject_order()
    {
        $order_id = $_REQUEST['rej_order_id'];
        $department_id = $this->db->query('SELECT department_id FROM render_production_order WHERE id = '.$order_id)->result_array()[0]['department_id'];
        $default_status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `department_id` IN ('.$department_id.') AND default_status = 1')->result_array()[0]['id']; 

        $verified = $this->db->get_where('render_production_order',['id' => $order_id])->result_array();        

        $client_name = $verified[0]['client_name'];

        $name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `render_production_order` WHERE `id` = '.$order_id.')')->result_array();

        $diff_name = $name_time[0]['difficulty_name'];
        $diff_time = $name_time[0]['total_time'];

        
        $this->db->where('id', $order_id);    
        $sql_update = $this->db->update('render_production_order', ['status' => $default_status, 'department_id' => $department_id, 'assigned_to' => 0, 'difficulty_id' => 0, 'rejected_flag' => $this->session->userdata('user_id'), 'remark' => $_REQUEST['remark']]);

        $render_order_log = array(
            'job_id' => $order_id,
            'status'   => $default_status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => 0,
            'description' => 'Order moved to', 
            'department_id' => $department_id,
            'rejected_flag' => $this->session->userdata('user_id'),
            'remark' => $_REQUEST['remark']
        );
        $this->db->insert('render_order_log', $render_order_log);

        /*start stop action*/

        $is_started = $this->db->query('SELECT is_started FROM render_production_order WHERE id = '.$order_id)->result_array()[0]['is_started'];
        if($is_started == 1)
        {
        	$render_start_stop_time = $this->db->insert('render_start_stop_time', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'time' => time(), 'type' => 'Stop', 'department_id' => $department_id]);        	
        }
        
        $this->db->where('id', $order_id); 
        $this->db->update('render_production_order', ['is_started' => 0]);

        $this->db->where(['type' => 'Start', 'job_id' => $order_id, 'user_id' => $this->session->userdata('user_id')]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $start_time_query = $this->db->get('render_start_stop_time');
        if($start_time_query->num_rows() > 0)
        {
            $start_time = $start_time_query->result_array()[0]['time'];
            $this->db->where(['type' => 'Stop', 'job_id' => $order_id, 'user_id' => $this->session->userdata('user_id')]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $stop_time_query = $this->db->get('render_start_stop_time');
            $stop_time = $stop_time_query->result_array()[0]['time'];

            $time_taken = $stop_time - $start_time;

            $this->db->where(['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id')]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $last_time_taken = $this->db->get('render_start_stop_action');

            if($last_time_taken->num_rows() > 0)
            {
                $last_time_taken = $last_time_taken->result_array()[0]['actual_time'];
                
                $final_time_taken = $time_taken + $last_time_taken;
            }
            else
            {
                $final_time_taken = $time_taken;
            }

            $this->db->insert('render_start_stop_action', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'actual_time' => $final_time_taken, 'department_id' => $department_id]);

            $this->db->insert('render_action_time', ['job_id' => $order_id, 'user_id' => $this->session->userdata('user_id'), 'actual_time' => $time_taken, 'department_id' => $department_id,'diff_name' => $diff_name, 'diff_time' => $diff_time]);
        }    
        
        /*time ends here*/

        if($sql_update){
            
            $this->session->set_flashdata(['class' => 'success', 'message' => 'Order rejected successfully!']);
        }


        if(isset($_REQUEST['rej_department_id']) && !empty($_REQUEST['rej_department_id']))
        {
            redirect('render_production_orders?department_id='.$_REQUEST['rej_department_id']);
        }
        else{
            redirect('render_production_orders');
        }           
        
        
    }



    public function get_related_depts()
    {
        $department_association = $this->db->query('SELECT * FROM `department_association` WHERE `dept_id` = (SELECT department_id FROM render_production_order WHERE id = '.$_REQUEST['order_id'].')');

        $html = '';

        if($department_association->num_rows() > 0)
        {
            $related_dept_id = array_column($department_association->result_array(), 'related_dept_id');
            
            foreach ($related_dept_id as $key1 => $value1) 
            {
                $html .= '<div class="checkbox checkbox-primary mb-2">
                                <input id="checkbox'.$key1.'" type="checkbox" name="related_dept_id[]" value="'.$value1.'">
                                <label for="checkbox'.$key1.'">
                                                    '.$this->master_model->get_one_record('department', 'label', $value1).'
                                </label>
                        </div>';
            }

            echo $html;
            
        }   
    } 

    public function get_back_depts()
    {
        #$department_association = $this->db->query('SELECT id, dept_name FROM `department` WHERE id IN (SELECT related_dept_id FROM `department_association` WHERE `type` = 2 AND `dept_id` = '.$_REQUEST['department_id'].')');
        $department_association = $this->db->query('SELECT * FROM `department` WHERE `go_back_visible` = 1 AND `id` != '.$_REQUEST['department_id']);

        // pre($this->db->last_query());exit;

        $html = '<option value="">Select</option>';

        if($department_association->num_rows() > 0)
        {
            $department_association = $department_association->result_array();
            foreach ($department_association as $key1 => $value1) 
            {
                $html .= '<option value="'.$value1['id'].'">'.$value1['dept_name'].'</option>';
            }
            echo $html;
            
        }   
    } 

    public function go_back()
    {
        $from_department_id = $_REQUEST['from_department_id'];
        $target_department_id = $_REQUEST['back_department_id'];
        $final_qc_dept_id = $this->db->query('SELECT id FROM department WHERE dept_name = "Final QC"')->result_array()[0]['id'];

        if($from_department_id != $final_qc_dept_id)
        {
            $verified = $this->db->get_where('render_production_order',['id' => $_REQUEST['back_order_id']])->result_array();
            $client_name = $verified[0]['client_name'];

            $name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `render_production_order` WHERE `id` = '.$_REQUEST['back_order_id'].')')->result_array();
            
            $diff_name = isset($name_time[0]['difficulty_name']) ? $name_time[0]['difficulty_name'] : '';
            $diff_time = isset($name_time[0]['total_time']) ? $name_time[0]['total_time'] : '';

        }         

        $default_status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `department_id` IN ('.$target_department_id.') AND default_status = 1')->result_array()[0]['id'];

        $this->db->where('id', $_REQUEST['back_order_id']); 
        $sql_update = $this->db->update('render_production_order', ['status' => $default_status, 'department_id' => $target_department_id, 'assigned_to' => 0, 'difficulty_id' => 0, 'remark' => $_REQUEST['back_remark'], 'prev_dept_flag' => $_REQUEST['from_department_id']]);

        $render_order_log = array(
            'job_id' => $_REQUEST['back_order_id'],
            'status'   => $default_status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => 0,
            'remark' => $_REQUEST['back_remark'],
            'description' => 'Order moved to', 
            'department_id' => $target_department_id,
            'prev_dept_flag'    => $_REQUEST['from_department_id']
        );
        $this->db->insert('render_order_log', $render_order_log);          


        /*start stop action*/
        if($from_department_id != $final_qc_dept_id)
        {
        	 $is_started = $this->db->query('SELECT is_started FROM render_production_order WHERE id = '.$_REQUEST['back_order_id'])->result_array()[0]['is_started'];
	        if($is_started == 1)
	        {
	        	$render_start_stop_time = $this->db->insert('render_start_stop_time', ['job_id' => $_REQUEST['back_order_id'], 'user_id' => $this->session->userdata('user_id'), 'time' => time(), 'type' => 'Stop', 'department_id' => $target_department_id]);
	        }

            $this->db->where('id', $_REQUEST['back_order_id']);
            $this->db->update('render_production_order', ['is_started' => 0]);
            

            $this->db->where(['type' => 'Start', 'job_id' => $_REQUEST['back_order_id'], 'user_id' => $this->session->userdata('user_id')]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $start_time_query = $this->db->get('render_start_stop_time');
            if($start_time_query->num_rows() > 0)
            {
                $start_time = $start_time_query->result_array()[0]['time'];
                $this->db->where(['type' => 'Stop', 'job_id' => $_REQUEST['back_order_id'], 'user_id' => $this->session->userdata('user_id')]);
                $this->db->order_by('id', 'DESC');
                $this->db->limit(1);
                $stop_time_query = $this->db->get('render_start_stop_time');
                $stop_time = $stop_time_query->result_array()[0]['time'];

                $time_taken = $stop_time - $start_time;

                $this->db->where(['job_id' => $_REQUEST['back_order_id'], 'user_id' => $this->session->userdata('user_id')]);
                $this->db->order_by('id', 'DESC');
                $this->db->limit(1);
                $last_time_taken = $this->db->get('render_start_stop_action');
                if($last_time_taken->num_rows() > 0)
                {
                    $last_time_taken = $last_time_taken->result_array()[0]['actual_time'];
                    
                    $final_time_taken = $time_taken + $last_time_taken;
                }
                else
                {
                    $final_time_taken = $time_taken;
                }

                $this->db->insert('render_start_stop_action', ['job_id' => $_REQUEST['back_order_id'], 'user_id' => $this->session->userdata('user_id'), 'actual_time' => $final_time_taken, 'department_id' => $target_department_id]);

                $this->db->insert('render_action_time', ['job_id' => $_REQUEST['back_order_id'], 'user_id' => $this->session->userdata('user_id'), 'actual_time' => $time_taken, 'department_id' => $target_department_id,'diff_name' => $diff_name, 'diff_time' => $diff_time]);
            }    
        }
        
        /*time ends here*/

        if($sql_update){
            $this->session->set_flashdata('message', 'Moved Successfully!');
        }


        if(isset($_REQUEST['gobk_department_id']) && !empty($_REQUEST['gobk_department_id']))
        {
            redirect('render_production_orders?department_id='.$_REQUEST['gobk_department_id']);
        }
        else{
            redirect('render_production_orders');
        }        

             
    }

    public function send_to_manager()
    {

        $verified = $this->db->get_where('render_production_order',['id' => $_REQUEST['send_order_id']])->result_array();        

        $client_name = $verified[0]['client_name'];

        $name_time = $this->db->query('SELECT difficulty_name,total_time FROM `difficulty` WHERE `id` = (SELECT difficulty_id FROM `render_production_order` WHERE `id` = '.$_REQUEST['send_order_id'].')')->result_array();

        $diff_name = $name_time[0]['difficulty_name'];
        $diff_time = $name_time[0]['total_time'];
        
        $target_department_id = $_REQUEST['same_department_id'];

        $default_status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `department_id` IN ('.$target_department_id.') AND default_status = 1')->result_array()[0]['id']; 
        
        $this->db->where('id', $_REQUEST['send_order_id']); 
        $sql_update = $this->db->update('render_production_order', ['status' => $default_status, 'department_id' => $target_department_id, 'assigned_to' => 0, 'difficulty_id' => 0, 'remark' => $_REQUEST['send_remark'], 'prev_dept_flag' => $_REQUEST['same_department_id']]);

        $render_order_log = array(
            'job_id' => $_REQUEST['send_order_id'],
            'status'   => $default_status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => 0,
            'remark' => $_REQUEST['send_remark'],
            'description' => 'Order moved to', 
            'department_id' => $target_department_id,
            'prev_dept_flag'    => $_REQUEST['same_department_id']
        );
        $this->db->insert('render_order_log', $render_order_log);


        /*start stop action*/
        $is_started = $this->db->query('SELECT is_started FROM render_production_order WHERE id = '.$_REQUEST['send_order_id'])->result_array()[0]['is_started'];
        if($is_started == 1)
        {
        	$render_start_stop_time = $this->db->insert('render_start_stop_time', ['job_id' => $_REQUEST['send_order_id'], 'user_id' => $this->session->userdata('user_id'), 'time' => time(), 'type' => 'Stop', 'department_id' => $target_department_id]);
        }

        $this->db->where('id', $_REQUEST['send_order_id']);
        $this->db->update('render_production_order', ['is_started' => 0]);
        

        $this->db->where(['type' => 'Start', 'job_id' => $_REQUEST['send_order_id'], 'user_id' => $this->session->userdata('user_id')]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $start_time_query = $this->db->get('render_start_stop_time');
        if($start_time_query->num_rows() > 0)
        {
            $start_time = $start_time_query->result_array()[0]['time'];
            $this->db->where(['type' => 'Stop', 'job_id' => $_REQUEST['send_order_id'], 'user_id' => $this->session->userdata('user_id')]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $stop_time_query = $this->db->get('render_start_stop_time');
            $stop_time = $stop_time_query->result_array()[0]['time'];

            $time_taken = $stop_time - $start_time;

            $this->db->where(['job_id' => $_REQUEST['send_order_id'], 'user_id' => $this->session->userdata('user_id')]);
            $this->db->order_by('id', 'DESC');
            $this->db->limit(1);
            $last_time_taken = $this->db->get('render_start_stop_action');

            if($last_time_taken->num_rows() > 0)
            {
                $last_time_taken = $last_time_taken->result_array()[0]['actual_time'];
                
                $final_time_taken = $time_taken + $last_time_taken;
            }
            else
            {
                $final_time_taken = $time_taken;
            }

            $this->db->insert('render_start_stop_action', ['job_id' => $_REQUEST['send_order_id'], 'user_id' => $this->session->userdata('user_id'), 'actual_time' => $final_time_taken, 'department_id' => $target_department_id]);

            $this->db->insert('render_action_time', ['job_id' => $_REQUEST['send_order_id'], 'user_id' => $this->session->userdata('user_id'), 'actual_time' => $time_taken, 'department_id' => $target_department_id,'diff_name' => $diff_name, 'diff_time' => $diff_time]);
        }    
        
        /*time ends here*/


        if($sql_update){
            $this->session->set_flashdata('message', 'Sent To Manager Successfully!');
        }

        if(isset($_REQUEST['send_department_id']) && !empty($_REQUEST['send_department_id']))
        {
            redirect('render_production_orders?department_id='.$_REQUEST['send_department_id']);
        }
        else{
            redirect('render_production_orders');
        }      
    }
    
    public function send_to_dept()
    {
        if(isset($_REQUEST['which_dept']) && !empty($_REQUEST['which_dept']))
        {
            //move to
            $target_department_id = $_REQUEST['which_dept'];
            $default_status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `department_id` IN ('.$target_department_id.') AND default_status = 1')->result_array()[0]['id']; 

            
            $this->db->where('id', $_REQUEST['which_order_id']);       

            $sql_update = $this->db->update('render_production_order', ['status' => $default_status, 'department_id' => $target_department_id, 'assigned_to' => 0, 'difficulty_id' => 0]);

            $render_order_log1 = array(
                'job_id' => $_REQUEST['which_order_id'],
                'status'   => $default_status,
                'created_by' => $this->session->userdata('user_id'),
                'assigned_to' => 0,
                'description' => 'Order moved to', 
                'department_id' => $target_department_id
            );
            $target_name = $this->master_model->get_one_record('department', 'label', $target_department_id);
            $this->db->insert('render_order_log', $render_order_log1);
            if($sql_update){
                
                $this->session->set_flashdata('message', 'Order Moved To '.$target_name.' Successfully!');

                // if(isset($_REQUEST['send_department_id']) && !empty($_REQUEST['send_department_id']))
                // {
                //     redirect('render_production_orders?department_id='.$_REQUEST['send_department_id']);
                // }
                // else{
                    redirect('render_production_orders');
                // }  
            }
        }
    }

    public function update_last()
    {
        $this->db->where('id', $_REQUEST['user_id']);
        $success = $this->db->update('users', ['notify_last_seen' => date('Y-m-d H:i:s')]);
        if($success){
            echo 'Updated';
        }
    }


    public function get_move_to_dropdown()
    {
        #$department_association = $this->db->query('SELECT * FROM `department_association` WHERE `dept_id` = '.$_REQUEST['department_id'].' AND type = 1');

        $order = $this->db->query('SELECT file_path, complet_file_path, video_file_path FROM render_production_order WHERE id = '.$_REQUEST['order_id'])->result_array();

        $department_association = $this->db->query('SELECT id,dept_name FROM `department` WHERE `move_to_visible` = 1 AND `id` != '.$_REQUEST['department_id']);
        
        $move_multiple = $this->db->query('SELECT move_multiple FROM `department` WHERE `id` = '.$_REQUEST['department_id'])->result_array()[0]['move_multiple'];


        $html = '<option value="">Select</option>';                                                            
        
        if($department_association->num_rows() > 0)
        {
            $related_dept_id = $department_association->result_array();
            if($move_multiple == 'single')
            {
                foreach ($related_dept_id as $key1 => $value1) 
                {

                    $html .= '<option value="'.$value1['id'].'">Move To '.$value1['dept_name'].'</option>';
                }
            }
            
        }

        echo json_encode(['html' => $html, 'file_path' => $order[0]['file_path'], 'complet_file_path' => $order[0]['complet_file_path'], 'video_file_path' => $order[0]['video_file_path']]);
        
    }


    public function delivered()
    {
        $department_id = $_REQUEST['department_id'];
        $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `department_id` IN ('.$department_id.') AND name = "Delivered"')->result_array()[0]['id']; 
        
        $this->db->where('id', $_REQUEST['order_id']);       

        $sql_update = $this->db->update('render_production_order', ['status' => $status, 'department_id' => $department_id, 'rejected_flag' => 0, 'prev_dept_flag' => 0, 'is_started' => 0]);

        $render_order_log = array(
            'job_id' => $_REQUEST['order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => 0,
            'description' => 'Order Delivered', 
            'department_id' => $department_id,
            'rejected_flag' => 0, 
            'prev_dept_flag' => 0
        );
        $this->db->insert('render_order_log', $render_order_log);
        if($sql_update){
            echo json_encode(array('message' => 'Delivered Successfully!'));
        }

        
    }


    public function cancel_order()
    {
        $department_id = $this->db->query('SELECT id FROM `department` WHERE `dept_name` = "Canceled"')->result_array()[0]['id'];
        $status = $this->db->query('SELECT id FROM `ms_render_status` WHERE `name` = "Canceled" AND `department_id` = '.$department_id)->result_array()[0]['id'];
        $this->db->where('id', $_REQUEST['cancel_order_id']);
        $sql_update = $this->db->update('render_production_order', ['department_id' => $department_id, 'status' => $status, 'is_started' => 0]);

        $render_order_log = array(
            'job_id' => $_REQUEST['cancel_order_id'],
            'status'   => $status,
            'created_by' => $this->session->userdata('user_id'),
            'assigned_to' => $_REQUEST['cancel_assigned_to'],
            'remark' => $_REQUEST['cancecl_remark'],
            'description' => 'Order Canceled'
        );
        $this->db->insert('render_order_log', $render_order_log);
        if($sql_update){
            $this->session->set_flashdata('message', 'Order Canceled Successfully!');
        }

        redirect('render_production_orders');
    }


    public function action_buttons()
    {
    	$edit_dept_id = $this->db->query('SELECT id FROM department WHERE dept_name = "Edit"')->result_array()[0]['id'];
        $final_qc_dept_id = $this->db->query('SELECT id FROM department WHERE dept_name = "Final QC"')->result_array()[0]['id'];
        $RR_dept_id = $this->db->query('SELECT id FROM department WHERE dept_name = "RR"')->result_array()[0]['id'];

        $cs_dept = $this->db->query('SELECT id FROM `department` WHERE `dept_name` = "Customer Service"')->result_array()[0]['id'];

        $order_data = $this->db->query('SELECT assigned_to, status, department_id, video_file_path, only_RR_order, file_path FROM render_production_order WHERE id = '.$_REQUEST['order_id'])->result_array();
        $status = $order_data[0]['status'];
        $assigned_to = $order_data[0]['assigned_to'];
        $department_id = $order_data[0]['department_id'];
        $video_file_path = $order_data[0]['video_file_path'];
        $file_path = $order_data[0]['file_path'];
        $only_RR_order = $order_data[0]['only_RR_order'];
        $status_name = $this->db->query('SELECT label FROM ms_render_status WHERE id = '.$status)->result_array()[0]['label'];
        $html = '';
        
        if(($status_name == 'Allocated' || $status_name == 'Pause' || $status_name == 'QC Reject') && $assigned_to == $this->session->userdata('user_id'))
        {
            if(array_key_exists('Start', $this->render_btn_permissions) && $this->render_btn_permissions['Start']['view_perm'] == 1)
            {
                
                $html .= '<a class="dropdown-item" href="javascript:start_timer(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Start</a>';
                 
            }
            if($status_name == 'Allocated')
            {
                if($this->session->userdata('user_id') == $assigned_to)
                {
                    if(array_key_exists('Reject Order', $this->render_btn_permissions) && $this->render_btn_permissions['Reject Order']['view_perm'] == 1)
                    {
        
                    $html .= '<a class="dropdown-item" href="javascript:reject_order(\''.$_REQUEST['order_id'].'\', \''.$department_id.'\');"><i class="fe-x-circle mr-2 text-muted font-18 vertical-middle"></i>Reject Order</a>';
        
                    }
                }
            }
        }                                                        

        if($status_name == 'Pending' && $department_id != $cs_dept)
        {
            if(array_key_exists('Assign', $this->render_btn_permissions) && $this->render_btn_permissions['Assign']['view_perm'] == 1)
            {
        
                $html .= '<a class="dropdown-item" href="javascript:assign_order(\''.$_REQUEST['order_id'].'\', \''.$department_id.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Assign</a>';
        
            }
        }
        if($status_name == 'Allocated')
        {
            if($this->session->userdata('user_id') != $assigned_to)
            {
                if(array_key_exists('De-allocate', $this->render_btn_permissions) && $this->render_btn_permissions['De-allocate']['view_perm'] == 1)
                {
                    $html .= '<a class="dropdown-item" href="javascript:deallocate_order(\''.$_REQUEST['order_id'].'\', \''.$department_id.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>De-allocate</a>'; 
                }
            }
        }
        if($status_name == 'In Process')
        {
            if($department_id != $final_qc_dept_id)
            {
                if(array_key_exists('Pause', $this->render_btn_permissions) && $this->render_btn_permissions['Pause']['view_perm'] == 1)
                {
                
                    $html .= '<a class="dropdown-item" href="javascript:pause_timer(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Pause</a>';
                
                }
                if(array_key_exists('QC', $this->render_btn_permissions) && $this->render_btn_permissions['QC']['view_perm'] == 1)
                {
           
                    $html .= '<a class="dropdown-item" href="javascript:qc_check(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>QC</a>';
            
                }
            }
            
        }
        else if($status_name == 'Send to QC')
        {
            if(array_key_exists('QC Accept', $this->render_btn_permissions) && $this->render_btn_permissions['QC Accept']['view_perm'] == 1)
            {
        
                $html .= '<a class="dropdown-item" href="javascript:qc_accept(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>QC Accept</a>';
        
            }
            if(array_key_exists('QC Reject', $this->render_btn_permissions) && $this->render_btn_permissions['QC Reject']['view_perm'] == 1)
            {
        
                $html .= '<a class="dropdown-item" href="javascript:qc_reject(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>QC Reject</a>';
        
            }
        }
                                                    
        else if($status_name == 'QC Accept')
        {   
           
           
           if(array_key_exists('Complete', $this->render_btn_permissions) && $this->render_btn_permissions['Complete']['view_perm'] == 1)
            {
                if($only_RR_order == 'Yes')
                {
                    if($department_id == $RR_dept_id)
                    {
            
                        $html .= '<a class="dropdown-item" href="javascript:complete(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \''.$department_id.'\', \'Yes\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Complete</a>';
            

                    }
                    else
                   {
            
                        $html .= '<a class="dropdown-item" href="javascript:complete(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \''.$department_id.'\', \'Yes\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Complete</a>';            
            
                    }
   
                }
                else
                {
    
                    $html .= '<a class="dropdown-item" href="javascript:complete(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \''.$department_id.'\', \'Yes\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Complete</a>';           
    
                }      
            
            } 
            
        }
                                                  
        if(array_key_exists('Timeline', $this->render_btn_permissions) && $this->render_btn_permissions['Timeline']['view_perm'] == 1)
        {
       
            $html .= '<a class="dropdown-item" href="'.base_url().'render_timeline/index/'.$_REQUEST['order_id'].'"><i class="fe-clock font-18 text-muted mr-2 vertical-middle"></i>Timeline</a>';
        
        }
        if(array_key_exists('Cancel', $this->render_btn_permissions) && $this->render_btn_permissions['Cancel']['view_perm'] == 1 && $status_name != 'Canceled' && $status_name != 'Completed' && $status_name != 'Delivered')
            {
        
                $html .= '<a class="dropdown-item" href="javascript:cancel_order(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="mdi mdi-close-circle mr-2 text-muted font-18 vertical-middle"></i>Cancel</a>';       
            }
        if(array_key_exists('View', $this->render_btn_permissions) && $this->render_btn_permissions['View']['view_perm'] == 1 && $status_name != 'Canceled')
        {
        
            $html .= '<a class="dropdown-item" href="javascript:void(0);" onclick="view_order(\''.$_REQUEST['order_id'].'\', \''.$status.'\');"><i class="fe-eye font-18 text-muted mr-2 vertical-middle"></i>View</a>';
        }
        if($department_id != $edit_dept_id && $department_id != $cs_dept)
        {
            if(array_key_exists('Go Back To', $this->render_btn_permissions) && $this->render_btn_permissions['Go Back To']['view_perm'] == 1 && $status_name != 'Canceled')
            {
    
            $html .= '<a class="dropdown-item" href="javascript:go_back(\''.$department_id.'\', \''.$_REQUEST['order_id'].'\');"><i class="fe-arrow-left font-18 text-muted mr-2 vertical-middle"></i>Go Back To</a>';     
            }

            if(array_key_exists('Send To Manager', $this->render_btn_permissions) && $this->render_btn_permissions['Send To Manager']['view_perm'] == 1 && $status_name != 'Canceled' && $status_name != 'Pending')
            {
            	$html .= '<a class="dropdown-item" href="javascript:send_to_manager(\''.$department_id.'\', \''.$_REQUEST['order_id'].'\');"><i class="fe-arrow-right font-18 text-muted mr-2 vertical-middle"></i>Send To Manager</a>';     
            }
        }

                                                    
    	if($department_id == $final_qc_dept_id)
    	{
    		if($status_name == 'Pending')
			{
                if(array_key_exists('Start', $this->render_btn_permissions) && $this->render_btn_permissions['Start']['view_perm'] == 1 && $assigned_to == $this->session->userdata('user_id'))
                {
                    
                    $html .= '<a class="dropdown-item" href="javascript:start_timer(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\');"><i class="fe-clock mr-2 text-muted font-18 vertical-middle"></i>Start</a>';
                     
                }
    		}
			if($status_name == 'In Process')
			{
                if(array_key_exists('Complete', $this->render_btn_permissions) && $this->render_btn_permissions['Complete']['view_perm'] == 1)
                {
   
    				$html .= '<a class="dropdown-item" href="javascript:complete(\''.$_REQUEST['order_id'].'\', \''.$assigned_to.'\', \''.$department_id.'\', \'No\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Complete</a>';
    
                }
    		}
			if($status_name == 'Completed')
			{
                if(array_key_exists('Delivered', $this->render_btn_permissions) && $this->render_btn_permissions['Delivered']['view_perm'] == 1)
                {
   
    				$html .= '<a class="dropdown-item" href="javascript:delivered(\''.$department_id.'\', \''.$_REQUEST['order_id'].'\');"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Delivered</a>';
   
                }
    		}                                                    		
    	}

        if($department_id == $cs_dept)
        {            
            
            $html .= '<a class="dropdown-item" href="javascript:send_to(\''.$department_id.'\', \''.$_REQUEST['order_id'].'\');"><i class="fe-arrow-left font-18 text-muted mr-2 vertical-middle"></i>Send To</a>';    
            
                                                                       
        }
                                                    
        echo json_encode(['html' => $html]);
    }

    
}
?>
