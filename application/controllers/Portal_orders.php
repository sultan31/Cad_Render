<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/third_party/PHPExcel.php";

class Portal_orders extends CI_Controller
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
        
    }

    public function index()
    {
        $this->load->view('portal_orders/portal_orders_view');
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
                else if($key == 'from_date')
                {
                	if($value != '')
                	{
                		$conditions[] = 'DATE_FORMAT(order_date, "%Y-%m-%d") >= "'.$value.'"';
                	}                    
                }
                else if($key == 'to_date')
                {
                	if($value != '')
                	{
                		$conditions[] = 'DATE_FORMAT(order_date, "%Y-%m-%d") <= "'.$value.'"';
                	}
                }
            }
        }
        
        $string = !empty($conditions) ? ' AND '.implode(' AND ', $conditions) : '';
        return $string;
    }

    public function copy_portal()
    {
        $this->load->view('portal_orders/portal_orders_view1');
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
            
            $column = array('order_number', 'client_design_no', 'category', 'client_name', 'order_date', 'type', 'remark', 'file_path');/**  set your data base column name here for sorting* */
            $orderColumn = isset($order[0]['column']) ? $column[$order[0]['column']] : 'id';
            $orderDirection = isset($order[0]['dir']) ? $order[0]['dir'] : 'desc';
            // $ordrBy = $orderColumn . " " . $orderDirection;

            $ordrBy = "id DESC";

            $condition = '';

            $filter_array = [];
            $filter_array['order_no'] = isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no']) ? $_REQUEST['order_no'] : '';
            $filter_array['category'] = isset($_REQUEST['category']) && !empty($_REQUEST['category']) ? $_REQUEST['category'] : '';
            $filter_array['client_name'] = isset($_REQUEST['client_name']) && !empty($_REQUEST['client_name']) ? $_REQUEST['client_name'] : '';
            $filter_array['from_date'] = isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']) ? $_REQUEST['from_date'] : '';
            $filter_array['to_date'] = isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']) ? $_REQUEST['to_date'] : '';
            
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
                $sql = "SELECT * FROM website_order WHERE moved_to_production = 0 AND delete_flag = 0 ".$condition." ".$search_string." order by " . $ordrBy . " limit $offset,$limit";
                $sql2 = "SELECT count(*) FROM website_order WHERE moved_to_production = 0 AND delete_flag = 0 ".$condition." ".$search_string." order by " . $ordrBy;
                $result = $this->db->query($sql);
                $result2 = $this->db->query($sql2);
                $count = $result2->num_rows();
            } else {
                /**
                 * If no seach value avaible in datatable
                 */
                $sql = "SELECT * FROM website_order WHERE moved_to_production = 0 AND delete_flag = 0 ".$condition." order by " . $ordrBy . " limit $offset,$limit";
                $sql2 = "SELECT * FROM website_order  WHERE moved_to_production = 0 AND delete_flag = 0 ".$condition." order by " . $ordrBy;
                $result = $this->db->query($sql);
                $result2 = $this->db->query($sql2);
                $count = $result2->num_rows();
            }
            /** create data to display in dataTable as you want **/    

            $data = array();
            if (!empty($result->result_array())) {
                foreach ($result->result_array() as $k => $v) {

                        if(isset($v['file_path']) && $v['file_path'] != '')
                        {
                        
                            $file_path_string = '<button type="button" onclick="file_path('.$v['id'].');" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;"><i class="fe-eye vertical-middle"></i> View</button>';
                        
                        } 
                        else
                        { 
                        	$file_path_string = '<button type="button" onclick="file_path('.$v['id'].');" class="tabledit-edit-button btn btn-success btn-xs active" style="float: none;"><span class="mdi mdi-plus-circle"></span> Add</button>';
                    	}
                        
                    
                    $data[] = array(
                        
                        'check' => '<div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input sub_checks" id="customCheck'.$v['id'].'" value="'.$v['id'].'">
                                    <label class="custom-control-label" for="customCheck'.$v['id'].'"></label>
                                </div>',
                        'order_number' =>  $v['order_number'],
                          'client_design_no' =>  $v['client_design_no'],
                          
                          'category' =>  $v['category'],
                          'client_name' =>  $v['client_name'],
                          'order_date' =>  date('Y-m-d', strtotime($v['order_date'])),
                          
                          'type' =>  $v['type'],
                          'remark' =>  $v['remark'],
                          'file_path' =>  $file_path_string,
                          //'action' =>  $v['id'],


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
                "data" => $data,
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
        if($mode == 'edit')
        {
            $data['edit_data'] = $this->db->get_where('website_order', ['id' => $id])->result_array();
            $this->load->view('portal_orders/form_view', $data);
        }
        else if($mode == 'view')
        {
          $data['edit_data'] = $this->db->get_where('website_order', ['id' => $id])->result_array();
            $this->load->view('portal_orders/info_view', $data);
        }
        else
        {
            $this->load->view('portal_orders/form_view', $data);
        }
        
    }

    //bulk upload for any order on the basis of order no
    public function bulk_media_upload()
    {
        $this->load->view('portal_orders/bulk_media_upload');
        
    }

    public function bulk_media_form_action()
    {
      // pre($_FILES);exit;
        if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))
        {
            $non_uploaded_files = [];
            $image_name = $_FILES['file']['name'];
            if(!empty($image_name))
            {
                $image_size = $_FILES['file']['size'];

                $expbanner=explode('.',$image_name);   
                $atual_name = $expbanner[0];         
                $bannerexptype=$expbanner[1];

               $get_order_no = explode('_', $atual_name);
               $order_no = $get_order_no[0];


               $check_order_no = $this->db->query('SELECT id FROM website_order WHERE delete_flag = 0 AND type="RENDER" AND order_number = "'.$order_no.'"');

               if($check_order_no->num_rows() > 0)
               {
                  $rand=rand(10000,99999);
                  $encname=$atual_name.$rand;
                  $bannername2=$encname.'.'.$bannerexptype;

                  $order_id = $check_order_no->result_array()[0]['id'];

                  if($bannerexptype == 'jpg' || $bannerexptype == 'png' || $bannerexptype == 'jpeg' || $bannerexptype == 'JPG' || $bannerexptype == 'PNG' || $bannerexptype == 'JPEG')
                  {
                    $bannerpath="portal_order_images/".$bannername2;
                    $table = 'portal_order_images';
                  }
                  else
                  {
                    $bannerpath="portal_order_videos/".$bannername2;
                    $table = 'portal_order_videos';
                  }

                 move_uploaded_file($_FILES["file"]["tmp_name"],$bannerpath);
                 $this->db->insert($table, ['order_id' => $order_id, 'file_name' => $bannername2, 'created_by' => $this->session->userdata('user_id')]);

                 echo json_encode(['status' => 1]);

               }

               else
               {
                echo json_encode(['status' => 0, 'image_name' => $image_name]);
                
               }



            }
        }
        
    }

    public function upload_media($id = '')
    {

        $data = [];        
        $data['id'] = $id;
        $this->load->view('portal_orders/bulk_upload', $data);
        
    }

    public function bulk_form_action()
    {
        if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))
        {
            $image_name = $_FILES['file']['name'];
            if(!empty($image_name))
            {
                $image_size = $_FILES['file']['size'];

                $expbanner=explode('.',$image_name);   
                $atual_name = $expbanner[0];         
               $bannerexptype=$expbanner[1];
              
               // date_default_timezone_set('Asia/Kolkata');
               // $date = date('Y-m-d_H-i-s');
               $rand=rand(10000,99999);
               $encname=$atual_name.$rand;
               $bannername2=$encname.'.'.$bannerexptype;
               if($bannerexptype == 'jpg' || $bannerexptype == 'png' || $bannerexptype == 'jpeg' || $bannerexptype == 'JPG' || $bannerexptype == 'PNG' || $bannerexptype == 'JPEG')
               {
                  $bannerpath="portal_order_images/".$bannername2;
                  $table = 'portal_order_images';
               }
               else
               {
                  $bannerpath="portal_order_videos/".$bannername2;
                  $table = 'portal_order_videos';
               }               
               
               move_uploaded_file($_FILES["file"]["tmp_name"],$bannerpath);

               $this->db->insert($table, ['order_id' => $_REQUEST['portal_order_id'], 'file_name' => $bannername2, 'created_by' => $this->session->userdata('user_id')]);
            }
        }
        
    }

    public function media_uploded($id = '')
    {

        $data = [];        
        $data['id'] = $id;
        $this->load->view('portal_orders/media_uploded', $data);
        
    }

    
    public function import($mode = '')
    {
      if(!empty($mode))
      {
          $data['mode'] = $mode;
          $this->load->view('portal_orders/import_view', $data);
      }
    }

    public function move_to_production()
    {

        $flag = $_REQUEST['flag'];
        if($flag == 1)
        {
            $error = 0;
            $moved_orders = [];
            $deadline = $this->db->query('SELECT * FROM `setting` WHERE `type` = "production"')->result_array()[0]['deadline'];

            $portal_order_id = $_REQUEST['ids'];
            $default_status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Pending"')->result_array()[0]['id'];
            $render_default_status = $this->db->query('SELECT id FROM ms_render_status WHERE default_status = 1 AND `department_id` = (SELECT id FROM department WHERE initial_department = 1)')->result_array()[0]['id'];

            $initial_department = $this->db->query('SELECT id FROM `department` WHERE `initial_department` = 1')->result_array()[0]['id'];
            
            $sql = 'SELECT * FROM `website_order` WHERE `id` IN ('.$portal_order_id.')';
            $website_order = $this->db->query($sql);

            if($website_order->num_rows() > 0)
            {
                $website_order = $website_order->result_array();
                foreach($website_order as $w)
                {
                    if($w['file_path'] == '')
                    {
                        $error++;
                    }
                    else
                    {
                        if($w['type'] == 'RENDER' || strtoupper($w['type']) == 'RENDER')
                        {
                            $production_order = array(
                                'portal_order_id' => $w['id'],
                                'client_name' => $w['client_name'],
                                'order_number' => trim($w['order_number']),
                                'client_design_no' => trim($w['client_design_no']),
                                'po_no' => trim($w['po_no']),
                                'category' =>     $w['category'],
                                'order_date' => $w['order_date'],
                                'type' => $w['type'],
                                'remark' => !empty($w['remark']) ? $w['remark'] : '',
                                'file_path' => $w['file_path'],
                                'status'   => $render_default_status,
                                'move_production_by' => $this->session->userdata('user_id'),
                                'deadline'    => date('Y-m-d', strtotime("+".$deadline." days")),
                                'department_id' => $initial_department,
                                'only_RR_order' => $w['only_RR_order']
                            );

                            $this->db->insert('render_production_order', $production_order);
                            $production_order_id = $this->db->insert_id();

                            $order_log = array(
                                'job_id' => $production_order_id,
                                'status'   => $render_default_status,
                                'description' => 'Order moved to production',
                                'created_by' => $this->session->userdata('user_id'),
                            );
                            $this->db->insert('render_order_log', $order_log);

                        }
                        else
                        {
                            $production_order = array(
                                'portal_order_id' => $w['id'],
                                'client_name' => $w['client_name'],
                                'order_number' => trim($w['order_number']),
                                'client_design_no' => trim($w['client_design_no']),
                                'po_no' => trim($w['po_no']),
                                'category' =>     $w['category'],
                                'order_date' => $w['order_date'],
                                'type' => $w['type'],
                                'remark' => $w['remark'],
                                'file_path' => $w['file_path'],
                                'status'   => $default_status,
                                'move_production_by' => $this->session->userdata('user_id'),
                                'deadline'    => date('Y-m-d', strtotime("+".$deadline." days"))
                            );
                            $this->db->insert('production_order', $production_order);
                            $production_order_id = $this->db->insert_id();

                            $order_log = array(
                                'job_id' => $production_order_id,
                                'status'   => $default_status,
                                'description' => 'Order moved to production',
                                'created_by' => $this->session->userdata('user_id'),
                            );
                            $this->db->insert('order_log', $order_log);

                        }
                        

                        
                        array_push($moved_orders, $w['id']);
                    }                    
                }

                if($error == 0)
                {
                    $moved_orders = implode(',', $moved_orders);
                    $sql_update = "UPDATE website_order SET moved_to_production = 1 WHERE id IN (".$moved_orders.")";
                    $res1 = $this->db->query($sql_update);
                    if($res1){
                        $this->session->set_flashdata(['class' => 'success', 'message' => 'Moved To Production Successfully!']);
                    }
                }
                else
                {
                    if($error == count(explode(',', $portal_order_id)))
                    {
                        $this->session->set_flashdata(['class' => 'danger', 'message' => 'File Path missing in all orders']);
                    }
                    else
                    {
                        $moved_orders = implode(',', $moved_orders);
                        $sql_update = "UPDATE website_order SET moved_to_production = 1 WHERE id IN (".$moved_orders.")";
                        $res1 = $this->db->query($sql_update);
                        $this->session->set_flashdata(['class' => 'success', 'message' => 'Moved To Production Successfully, File Path missing in some orders']);
                    }
                }
                redirect('portal_orders');
            }
        }
        else if($flag == 2)
        {
            $portal_order_images = $this->db->query('SELECT id, file_name FROM portal_order_images WHERE order_id IN ('.$_REQUEST['ids'].')');
            if($portal_order_images->num_rows() > 0)
            {
                $portal_order_images = $portal_order_images->result_array();
                foreach ($portal_order_images as $key => $value) 
                {
                    unlink('portal_order_images/'.$value['file_name']);
                    $this->db->query('DELETE FROM portal_order_images WHERE id = '.$value['id']);

                }
            }
            $portal_order_videos = $this->db->query('SELECT id, file_name FROM portal_order_videos WHERE order_id IN ('.$_REQUEST['ids'].')');
            if($portal_order_videos->num_rows() > 0)
            {
                $portal_order_videos = $portal_order_videos->result_array();
                foreach ($portal_order_videos as $key => $value) 
                {
                    unlink('portal_order_videos/'.$value['file_name']);
                    $this->db->query('DELETE FROM portal_order_videos WHERE id = '.$value['id']);
                }
            }

            $success = $this->db->query('UPDATE website_order SET delete_flag = 1 WHERE id IN ('.$_REQUEST['ids'].')');
            if($success){
                $this->session->set_flashdata(['class' => 'success', 'message' => 'Deleted Successfully!']);
            }

            redirect('portal_orders');
        }
    }

    public function uploadData()
     {
        $mode = $_REQUEST['mode'];
        $error = 0;
        $flag = '';
        $table = '<table class="table table-bordered table-hover"><thead class="thead-light"><tr><th>Sr No</th><th>online_order_id</th><th>order_number</th><th>category</th><th>PO No</th><th>type</th><th>remark</th><th>file_path</th></tr></thead><tbody>';
        if(isset($_FILES["excel_file"]["name"]))
        {
          
             $path = $_FILES["excel_file"]["tmp_name"];
             $object = PHPExcel_IOFactory::load($path);
             foreach($object->getWorksheetIterator() as $worksheet)
             {
                  $highestRow = $worksheet->getHighestRow();
                  $highestColumn = $worksheet->getHighestColumn();
                  for($row=2; $row<=$highestRow; $row++)
                  {
                       $sr_no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                       $client_design_no = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                       $order_number = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                       $po_no = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                       $category = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                       $type = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                       $remark = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                       $file_path = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                       if($sr_no != '')
                       {
                            $table .= '<tr><td>'.$sr_no.'</td>';
                            if($client_design_no == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                              $table .= '<td></td>';
                            }
                            if($order_number == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                               
                                  $check_dup = $this->db->get_where('website_order', ['order_number' => $order_number, 'is_cad' => 1, 'delete_flag' => 0]);
                                  if($check_dup->num_rows() > 0)
                                  {
                                      $error++;
                                      $flag = 'error';
                                      $table .= '<td>Duplicate</td>';
                                      
                                  }
                                  else
                                  {
                                    $table .= '<td></td>';
                                  }
                               
                            }

                            

                            if($category == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td><td></td>';
                            }
                            else
                            {
                              $table .= '<td></td><td></td>';
                            }
                          
                            if($type == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td><td></td>';
                            }


                            else
                            {
                              
                              if($type == 'CAD' || $type == 'CAD-RENDER')
                              {
                                $table .= '<td></td><td></td>';
                                
                                  
                              }
                              else
                              {
                                  $error++;
                                  $flag = 'error';
                                  $table .= '<td>Invalid type</td><td></td>';
                              }
                              
                            }
                            

                            if($file_path == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                              $table .= '<td></td>';
                            }

                           if($flag == 0 && $flag == '')
                           {
                                $insert_remark = isset($remark) && !empty($remark) ? $remark : '';

                                $client_name = explode('-', $order_number)[0];
                                $data[] = array(
                                  'client_design_no'  => $client_design_no,
                                  'order_number'   => trim($order_number),
                                  'po_no'   => trim($po_no),
                                  'category'    => $category,
                                  'client_name'  => $client_name,
                                  'type'   => $type,
                                  'remark'  => $insert_remark,
                                  'file_path'  => $file_path,
                                  'is_cad'  => 1
                                 );
                           }

                           $table .= '</tr>';
                       }  
                  }

             }


              
            if($error > 0)
             {
              
                $table .= '</tbody></table>';
                
                $this->session->set_flashdata(['table' => $table, 'msg' => 'Error in following rows', 'mode' => $mode]);
                // echo '<script type="text/javascript">window.open("'.base_url().'portal_orders/error", "_blank");</script>';
                redirect('portal_orders/error');
             }
             else
             {
                $success = $this->db->insert_batch('website_order', $data);
                if($success){
                    $this->session->set_flashdata(['class' => 'success', 'message' => 'Data Imported successfully!']);
                    redirect('portal_orders');
                }
             }
        } 
     }


     
     public function uploadDataRender()
     {
        $mode = $_REQUEST['mode'];
        $error = 0;
        $flag = '';
        $possible_cats = ['Ring', 'Earring', 'Pendant', 'Necklace', 'Bangle', 'Bracelet', 'Tiepin', 'Cufflink', 'Brooch', 'Chain', 'Charm', 'Nose pin', 'Nose ring', 'Other Manual Input'];

        $v_bg_color_array = ['White','Black'];
        $v_duration_array = ['10sec','15sec'];
        $iv_bg_color_array = ['White','Black'];
        $iv_frame_size_array = ['30','36','54','60','OTHR'];

        $table = '<table class="table table-bordered table-hover"><thead class="thead-light"><tr><th>Sr No</th><th>TCC Style No</th><th>Client Design No</th><th>File Type</th><th>Product type</th><th>Findings</th><th>File Path</th><th>Image Resolution</th><th>Image Size</th><th>Video Size</th><th>Order Type</th></tr></thead><tbody>';
        if(isset($_FILES["excel_file"]["name"]))
        {
          
             $path = $_FILES["excel_file"]["tmp_name"];
             // pre($path);
             // exit;
             $object = PHPExcel_IOFactory::load($path);
             foreach($object->getWorksheetIterator() as $worksheet)
             {
                  $highestRow = $worksheet->getHighestRow();
                  $highestColumn = $worksheet->getHighestColumn();
                  for($row=2; $row<=$highestRow; $row++)
                  {

                      $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
                      if($this->isEmptyRow(reset($rowData))) { continue; } // skip empty row
                      // do something usefull

                       $sr_no = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                       $tcc_style_no = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                       $client_design_no = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                       $po_no = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                       $order_description = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                       $file_type = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                       $prod_type = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                       $findings = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                       $rhodium_instructions = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                       $order_type = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                       $file_path = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                       $remark = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                       $center_prong_type = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                       $master_location = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                       $i_gold_tone = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                       $i_angles = $worksheet->getCellByColumnAndRow(15, $row)->getValue();

                       //image data
                       $i_bg_color = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                       $i_shdaow = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                       $i_logo = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                       $i_logo_location = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                       $i_frame_logo = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                       $i_gemstone_details = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                       $i_output = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                       $i_resolution = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
                       $i_size = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
                       $i_remarks = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
                       $image_text_logo = $worksheet->getCellByColumnAndRow(26, $row)->getValue();

                       //video data
                       $v_gold_tone = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
                       $video_type = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
                       $v_rhodium_instruction = $worksheet->getCellByColumnAndRow(29, $row)->getValue();
                       $v_bg_color = $worksheet->getCellByColumnAndRow(30, $row)->getValue();
                       $v_shadow = $worksheet->getCellByColumnAndRow(31, $row)->getValue();
                       $v_logo = $worksheet->getCellByColumnAndRow(32, $row)->getValue();
                       $v_logo_location = $worksheet->getCellByColumnAndRow(33, $row)->getValue();
                       $v_frame_logo_location = $worksheet->getCellByColumnAndRow(34, $row)->getValue();                       
                       $v_gemstone_details = $worksheet->getCellByColumnAndRow(35, $row)->getValue();
                       $v_output = $worksheet->getCellByColumnAndRow(36, $row)->getValue();
                       $v_size = $worksheet->getCellByColumnAndRow(37, $row)->getValue();
                       $v_resolution = $worksheet->getCellByColumnAndRow(38, $row)->getValue();
                       $v_duration = $worksheet->getCellByColumnAndRow(39, $row)->getValue();                       
                       $v_rotation_type = $worksheet->getCellByColumnAndRow(40, $row)->getValue();                       
                       $v_remarks = $worksheet->getCellByColumnAndRow(41, $row)->getValue();
                       $video_text_logo = $worksheet->getCellByColumnAndRow(42, $row)->getValue();

                       
                       //iv data
                       $iv_gold_tone = $worksheet->getCellByColumnAndRow(43, $row)->getValue();
                       $iv_type = $worksheet->getCellByColumnAndRow(44, $row)->getValue();
                       $iv_rhodium_instruction = $worksheet->getCellByColumnAndRow(45, $row)->getValue();
                       $iv_bg_color = $worksheet->getCellByColumnAndRow(46, $row)->getValue();
                       $iv_shadow = $worksheet->getCellByColumnAndRow(47, $row)->getValue();
                       $iv_logo = $worksheet->getCellByColumnAndRow(48, $row)->getValue();
                       $iv_logo_location = $worksheet->getCellByColumnAndRow(49, $row)->getValue();
                       $iv_frame_logo = $worksheet->getCellByColumnAndRow(50, $row)->getValue();
                       $iv_gemstone_details = $worksheet->getCellByColumnAndRow(51, $row)->getValue();
                       $iv_output = $worksheet->getCellByColumnAndRow(52, $row)->getValue();
                       $iv_frame_size = $worksheet->getCellByColumnAndRow(53, $row)->getValue();
                       $iv_rotation = $worksheet->getCellByColumnAndRow(54, $row)->getValue();
                       $iv_remarks = $worksheet->getCellByColumnAndRow(55, $row)->getValue();
                       $iv_size = $worksheet->getCellByColumnAndRow(56, $row)->getValue();
                       $iv_resolution = $worksheet->getCellByColumnAndRow(57, $row)->getValue();
                       $iv_text_logo = $worksheet->getCellByColumnAndRow(58, $row)->getValue();
                       $only_RR_order = $worksheet->getCellByColumnAndRow(59, $row)->getValue();

                       

                       
                       if($sr_no != '')
                       {

                            $table .= '<tr><td>'.$sr_no.'</td>';
                            
                            if($tcc_style_no == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                               
                                  $check_dup = $this->db->get_where('website_order', ['order_number' => $tcc_style_no, 'is_render' => 1, 'delete_flag' => 0]);
                                  if($check_dup->num_rows() > 0)
                                  {
                                      $error++;
                                      $flag = 'error';
                                      $table .= '<td>Duplicate</td>';
                                      
                                  }
                                  else
                                  {
                                    $table .= '<td></td>';
                                  }
                               
                            }

                            if($client_design_no == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                              $table .= '<td></td>';
                            }

                            if($file_type == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                              $table .= '<td></td>';
                            }
                          
                            if($prod_type == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td><td></td>';
                            }
                            else
                            {
                              if(!in_array($prod_type, $possible_cats))
                              {
                                  $table .= '<td>Possible Values: '.implode('<br>', $possible_cats).'</td>';
                              }
                              else
                              {
                                  $table .= '<td></td>';
                              }
                              
                            }
                            

                            if($findings == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                              $table .= '<td></td>';
                            }

                            if($file_path == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                              $table .= '<td></td>';
                            }

                            if($i_resolution == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                              $table .= '<td></td>';
                            }

                            if($i_size == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                              $table .= '<td></td>';
                            }

                            
                            if($v_size == '')
                            {
                                $error++;
                                $flag = 'error';
                                $table .= '<td>Empty</td>';
                            }
                            else
                            {
                              $table .= '<td></td>';
                            }

                            if(!empty($only_RR_order) && $only_RR_order == 'Yes')
                            {
                                 $table .= '<td></td>';
                            }
                            else
                            {
                                $order_type_array = explode(',', $order_type);
                                if(in_array('Image', $order_type_array) || in_array('Video', $order_type_array) || in_array('IV', $order_type_array) || in_array('RR', $order_type_array))
                                {
                                    $table .= '<td></td>';
                                }
                                else
                                {
                                    $error++;
                                    $flag = 'error';
                                    $table .= '<td>Possible Values:Image,Video,IV, RR</td>';
                                }
                            }

                            

                          
                           if($error == 0 && $flag == '')
                           {
                                $client_name = explode('-', trim($tcc_style_no))[0];
                                $data[] = array(
                                'order_number'  => trim($tcc_style_no),
                                'client_design_no'   => $client_design_no,
                                'po_no' => $po_no,
                                'order_description'    => $order_description,
                                'file_type'  => $file_type,
                                'category'   => $prod_type,
                                'client_name' => $client_name,
                                'findings'  => $findings,
                                'rhodium_instructions'  => !empty($rhodium_instructions) ? $rhodium_instructions : 'Yes',
                                'order_type'  => !empty($order_type) ? $order_type : '',
                                'file_path'   => $file_path,
                                'remark'    => $remark,
                                'type' => 'RENDER',
                                'center_prong_type'  => $center_prong_type,
                                'master_location'   => $master_location,
                                'i_gold_tone'  => $i_gold_tone,
                                'i_angles'  => $i_angles,
                                'i_bg_color'  => $i_bg_color,
                                'i_shdaow'   => $i_shdaow,
                                'i_logo'    => $i_logo,
                                'i_logo_location'  => $i_logo_location,
                                'i_frame_logo'   => $i_frame_logo,                                
                                'i_gemstone_details'  => $i_gemstone_details,
                                'i_output'  => $i_output,
                                'i_resolution'  => $i_resolution,
                                'i_size'   => $i_size,
                                'i_remarks'    => $i_remarks,
                                'image_text_logo'    => $image_text_logo,
                                'v_gold_tone'  => $v_gold_tone,
                                'video_type'   => !empty($video_type) ? $video_type : 'TP1',
                                'v_rhodium_instruction'  => !empty($v_rhodium_instruction) ? $v_rhodium_instruction : 'Yes',
                                'v_bg_color'  => !empty($v_bg_color) && in_array($v_bg_color, $v_bg_color_array) ? $v_bg_color : 'MN',
                                'v_bg_color_mn'   => !empty($v_bg_color) && in_array($v_bg_color, $v_bg_color_array) ? '' : $v_bg_color,
                                 'v_shadow' => !empty($v_shadow) ? $v_shadow : 'Shadow',
                                 'v_logo' => !empty($v_logo) ? $v_logo : 'Yes',
                                 'v_logo_location' => $v_logo_location,
                                 'v_frame_logo_location' => $v_frame_logo_location,
                                 'v_gemstone_details' => $v_gemstone_details,
                                 'v_output' => !empty($v_output) ? $v_output : 'MP4',
                                 'v_size' => $v_size,
                                 'v_resolution' => $v_resolution,
                                 'v_duration' => !empty($v_duration) && in_array($v_duration, $v_duration_array) ? $v_duration : 'MN',
                                 'v_duration_mn'  => !empty($v_duration) && in_array($v_duration, $v_duration_array) ? '' : $v_duration,
                                 'v_rotation_type' => !empty($v_rotation_type) ? $v_rotation_type : 'Anticlock',
                                 'v_remarks' => $v_remarks,
                                 'video_text_logo'    => $video_text_logo,
                                 'iv_gold_tone' => $iv_gold_tone,                                
                                 'iv_type' => !empty($iv_type) ? $iv_type : 'Turntable',
                                 'iv_rhodium_instruction' => !empty($iv_rhodium_instruction) ? $iv_rhodium_instruction : 'Yes',
                                 'iv_bg_color' => !empty($iv_bg_color) && in_array($iv_bg_color, $iv_bg_color_array) ? $iv_bg_color : 'MN',
                                 'iv_bg_color_mn' => !empty($iv_bg_color) && in_array($iv_bg_color, $iv_bg_color_array) ? '' : $iv_bg_color,
                                 'iv_shadow' => !empty($iv_shadow) ? $iv_shadow : 'Shadow',
                                 'iv_logo' => !empty($iv_logo) ? $iv_logo : 'Yes',
                                 'iv_logo_location' => $iv_logo_location,
                                 'iv_frame_logo' => $iv_frame_logo,
                                 'iv_gemstone_details' => $iv_gemstone_details,
                                 'iv_output' => !empty($iv_output) ? $iv_output : 'PNG',
                                 'iv_frame_size' => !empty($iv_frame_size) && in_array($iv_frame_size, $iv_frame_size_array) ? $iv_frame_size : 'MN',
                                 'iv_frame_size_mn' => !empty($iv_frame_size) && in_array($iv_frame_size, $iv_frame_size_array) ? '' : $iv_frame_size,
                                 'iv_rotation' => !empty($iv_rotation) ? $iv_rotation : 'Anticlock',
                                 'iv_remarks' => $iv_remarks,
                                 'iv_size' => $iv_size,
                                 'iv_resolution' => $iv_resolution,
                                 'iv_text_logo' => $iv_text_logo,
                                 'only_RR_order'  => !empty($only_RR_order) && $only_RR_order == 'Yes' ? $only_RR_order : 'No',
                                 'is_render'  => 1,
                                 'created_by' => $this->session->userdata('user_id')
                               );    
                           }

                           $table .= '</tr>';
                       }     
                  }

             }

             // pre($error);exit;
              
            if($error > 0)
             {
                
              
                $table .= '</tbody></table>';
                
                $this->session->set_flashdata(['table' => $table, 'msg' => 'Error in following rows', 'mode' => $mode]);
                // echo '<script type="text/javascript">window.open("'.base_url().'portal_orders/error", "_blank");</script>';
                redirect('portal_orders/error');
             }
             else
             {
                // pre($data);exit;
                $success = $this->db->insert_batch('website_order', $data);
                if($success){
                    $this->session->set_flashdata(['class' => 'success', 'message' => 'Data Imported successfully!']);
                    redirect('portal_orders');
                }
             }
        } 
     }


     public function isEmptyRow($row) {
        foreach($row as $cell){
            if (null !== $cell) return false;
        }
        return true;
    }

     public function error()
    {
        $this->load->view('portal_orders/error_view');
    }

    public function view_order()
    {
        $website_order = $this->db->get_where('website_order', ['id' => $_REQUEST['id']])->result_array()[0];
        
        if(!empty($website_order)){
            echo json_encode($website_order);
        }
    }

    public function edit()
    {
    
        $this->db->where('id', $_REQUEST['current_order_id']);
        $sql_update = $this->db->update('website_order', ['file_path' => $_REQUEST['file_path']]);

    
        if($sql_update){
            $this->session->set_flashdata('message', 'Path Updated Successfully!');
        }

        redirect('Portal_orders');
    }


    public function form_action($id='')
    {
        $order_type = isset($_REQUEST['order_type']) ? implode(',', $_REQUEST['order_type']) : '';
        $i_angles = isset($_REQUEST['i_angles']) ? implode(',', $_REQUEST['i_angles']) : '';
        $i_gold_tone = isset($_REQUEST['i_gold_tone']) ? implode(',', $_REQUEST['i_gold_tone']) : '';
        $v_gold_tone = isset($_REQUEST['v_gold_tone']) ? implode(',', $_REQUEST['v_gold_tone']) : ''; 
        $iv_gold_tone = isset($_REQUEST['iv_gold_tone']) ? implode(',', $_REQUEST['iv_gold_tone']) : '';
        
        $bannername = '';
        $bannername1 = '';
        $bannername2 = '';
        // pre($_FILES);
        // pre($_REQUEST);exit;

        $portal_order = array(
                                'type' => 'RENDER',
                                'order_number' => trim($this->input->post('tcc_style_no')),
                                'client_design_no' => $this->input->post('client_design_no'),
                                'po_no' => $this->input->post('po_no'),
                                'order_description' => $this->input->post('order_description'),
                                'file_type' => $this->input->post('file_type'),
                                'category' => $this->input->post('prod_type'),
                                'findings' => $this->input->post('findings'),
                                'rhodium_instructions'  => $this->input->post('rhodium_instructions'),
                                'order_type' => $order_type,
                                'file_path'  => $this->input->post('file_path'),
                                'remark' => $this->input->post('remark'),
                                'center_prong_type' => $this->input->post('center_prong_type'),
                                'master_location' => $this->input->post('master_location'),
                                'i_gold_tone' => $i_gold_tone,
                                'i_angles' => $i_angles,
                                'i_bg_color' => $this->input->post('i_bg_color'),
                                'i_shdaow' => $this->input->post('i_shdaow'),
                                'i_logo' => $this->input->post('i_logo'),
                                'i_logo_location' => $this->input->post('i_logo_location'),
                                'i_frame_logo'  => $this->input->post('i_frame_logo'),
                                'i_gemstone_details' => $this->input->post('i_gemstone_details'),
                                'i_output' => $this->input->post('i_output'),
                                'i_resolution' => $this->input->post('i_resolution'),
                                'i_size' => $this->input->post('i_size'),
                                'i_remarks' => $this->input->post('i_remarks'),
                                'image_text_logo' => $this->input->post('image_text_logo'),
                                'v_gold_tone' => $v_gold_tone,
                                'video_type'  => $this->input->post('video_type'),
                                'v_rhodium_instruction' => $this->input->post('v_rhodium_instruction'),
                                'v_bg_color' => $this->input->post('v_bg_color'),
                                'v_shadow'  => $this->input->post('v_shadow'),
                                'v_logo' => $this->input->post('v_logo'),
                                'v_logo_location'  => $this->input->post('v_logo_location'),
                                'v_frame_logo_location'  => $this->input->post('v_frame_logo_location'),
                                'v_gemstone_details' => $this->input->post('v_gemstone_details'),
                                'v_output'  => $this->input->post('v_output'),
                                'v_size'  => $this->input->post('v_size'),
                                'v_resolution'  => $this->input->post('v_resolution'),
                                'v_duration' => $this->input->post('v_duration'),
                                'v_rotation_type' => $this->input->post('v_rotation_type'),
                                'v_remarks' => $this->input->post('v_remarks'),
                                'video_text_logo' => $this->input->post('video_text_logo'),
                                'iv_gold_tone'  => $iv_gold_tone,
                                'iv_type'  => !empty($this->input->post('iv_type')) ? $this->input->post('iv_type') : 'Turntable',
                                'iv_rhodium_instruction'  => $this->input->post('iv_rhodium_instruction'),
                                'iv_bg_color'  => $this->input->post('iv_bg_color'),
                                'iv_shadow'  => $this->input->post('iv_shadow'),
                                'iv_logo'  => $this->input->post('iv_logo'),
                                'iv_logo_location'  => $this->input->post('iv_logo_location'),
                                'iv_frame_logo' => $this->input->post('iv_frame_logo'),
                                'iv_gemstone_details' => $this->input->post('iv_gemstone_details'),                              
                                'iv_output'  => $this->input->post('iv_output'),
                                'iv_frame_size'  => $this->input->post('iv_frame_size'),
                                'iv_rotation'  => $this->input->post('iv_rotation'),                                
                                'iv_remarks' => $this->input->post('iv_remarks'),
                                'iv_size' => $this->input->post('iv_size'),
                                'iv_resolution' => $this->input->post('iv_resolution'),
                                'iv_text_logo' => $this->input->post('iv_text_logo'),
                                'only_RR_order'  => $this->input->post('only_RR_order'),
                                'is_render' => 1
                            );

          
            // $portal_order['i_angles_mn'] = $this->input->post('i_angles') == 'MN' ? $this->input->post('i_angles_mn') : '';
            $portal_order['v_bg_color_mn'] = $this->input->post('v_bg_color') == 'MN' ? $this->input->post('v_bg_color_mn') : '';
            $portal_order['v_duration_mn'] = $this->input->post('v_duration') == 'MN' ? $this->input->post('v_duration_mn') : '';
            $portal_order['iv_bg_color_mn'] = $this->input->post('iv_bg_color') == 'MN' ? $this->input->post('iv_bg_color_mn') : '';
            $portal_order['iv_frame_size_mn'] = $this->input->post('iv_frame_size') == 'MN' ? $this->input->post('iv_frame_size_mn') : '';
            

            // pre($portal_order);exit;

            if($id)
            {
                $success = $this->db->where('id', $id)->update('website_order', $portal_order);
            }
            else
            {
                $success = $this->db->insert('website_order', $portal_order);
                $id = $this->db->insert_id();
            }


            $this->make_log('website_order_log', $portal_order, $id);

            
            if(isset($_FILES['ref_img']['name']) && !empty($_FILES['ref_img']['name']))
            {
                for($i=0;$i<count($_FILES['ref_img']['name']);$i++)
                {
                    $image_name = $_FILES['ref_img']['name'][$i];
                    if(!empty($image_name))
                    {
                        $image_size = $_FILES['ref_img']['size'][$i];
                        $expbanner=explode('.',$image_name);             
                        $bannerexptype=$expbanner[1];
                    
                         // date_default_timezone_set('Asia/Kolkata');
                         $date = date('Y-m-d_'.$i);
                         $rand=rand(10000,99999);
                         $encname=$date.$rand;
                         $bannername=$encname.'.'.$bannerexptype;
                         $bannerpath="portal_order_images/".$bannername;
                         move_uploaded_file($_FILES["ref_img"]["tmp_name"][$i],$bannerpath);

                         $this->db->insert('portal_order_images', ['order_id' => $id, 'file_name' => $bannername, 'created_by' => $this->session->userdata('user_id')]);
                    }
                    
                }   
            }

            if(isset($_FILES['i_ref_img']['name']) && !empty($_FILES['i_ref_img']['name']))
            {
                for($i=0;$i<count($_FILES['i_ref_img']['name']);$i++)
                {
                    
                    $image_name = $_FILES['i_ref_img']['name'][$i];
                    if(!empty($image_name))
                    {
                       $image_size = $_FILES['i_ref_img']['size'][$i];
                      $expbanner=explode('.',$image_name);             
                       $bannerexptype=$expbanner[1];
                      
                       // date_default_timezone_set('Asia/Kolkata');
                       $date = date('Y-m-d_H-i-s');
                       $rand=rand(10000,99999);
                       $encname=$date.$rand;
                       $bannername1=$encname.'.'.$bannerexptype;
                       $bannerpath="portal_order_images/".$bannername1;
                       move_uploaded_file($_FILES["i_ref_img"]["tmp_name"][$i],$bannerpath);

                       $this->db->insert('portal_order_images', ['order_id' => $id, 'file_name' => $bannername1, 'created_by' => $this->session->userdata('user_id')]); 
                    }
                    
                }    
            }
        

            if(isset($_FILES['ref_video']['name']) && !empty($_FILES['ref_video']['name']))
            {
                for($i=0;$i<count($_FILES['ref_video']['name']);$i++)
                {
                    
                    $image_name = $_FILES['ref_video']['name'][$i];
                    if(!empty($image_name))
                    {
                        $image_size = $_FILES['ref_video']['size'][$i];

                        $expbanner=explode('.',$image_name);             
                       $bannerexptype=$expbanner[1];
                      
                       // date_default_timezone_set('Asia/Kolkata');
                       $date = date('Y-m-d_H-i-s');
                       $rand=rand(10000,99999);
                       $encname=$date.$rand;
                       $bannername2=$encname.'.'.$bannerexptype;
                       $bannerpath="portal_order_videos/".$bannername2;
                       move_uploaded_file($_FILES["ref_video"]["tmp_name"][$i],$bannerpath);

                       $this->db->insert('portal_order_videos', ['order_id' => $id, 'file_name' => $bannername2, 'created_by' => $this->session->userdata('user_id')]);
                    }
                    
                }
            }

            if($success)
            {

                $this->session->set_flashdata(['class' => 'success', 'message' => 'Submitted Successfully!']);
            
                redirect('portal_orders');
            }
    }

    public function make_log($table, $insertArray, $id)
    {
      $insertArray['portal_order_id'] = $id;
      $success = $this->db->insert($table, $insertArray);
    }

    
    public function view_log($id)
    {
      $data['portal_order_id'] = $id;
      $this->load->view('portal_orders/log_view', $data);
    }


    public function remove_file()
    {

        $type = $_REQUEST['type'];
        if($type == 'img')
        {
            $file_name = $this->db->query('SELECT id, file_name FROM portal_order_images WHERE id ='.$_REQUEST['id'])->result_array()[0]['file_name'];
            unlink('portal_order_images/'.$file_name);
            $this->db->query('DELETE FROM portal_order_images WHERE id = '.$_REQUEST['id']);
        }
        else if($type == 'video')
        {
            $file_name = $this->db->query('SELECT id, file_name FROM portal_order_videos WHERE id ='.$_REQUEST['id'])->result_array()[0]['file_name'];
            unlink('portal_order_videos/'.$file_name);
            $this->db->query('DELETE FROM portal_order_videos WHERE id = '.$_REQUEST['id']);
        }

        echo 'Done';
    }

    public function check_duplicate()
    {
        $order_number = trim($_POST['tcc_style_no']);
        if($_POST['portal_order_id'] == 0)
        {
            $q = $this->db->query('SELECT * FROM website_order WHERE order_number = "'.$order_number.'" AND is_render = 1');
        }
        else
        {
            $q = $this->db->query('SELECT * FROM website_order WHERE order_number = "'.$order_number.'" AND id != "'.$_POST['portal_order_id'].'" AND is_render = 1');
        }
        
        
        if($q->num_rows() > 0) { 
            echo json_encode(['status' => 1]);
        }else { 
            echo json_encode(['status' => 0]);
        } 
    }

    
    public function cad_form_action()
    {
        $data = array(
                        'category'  => $_REQUEST['category'],
                        'remark'   => $_REQUEST['remark'],
                        'file_path'  => $_REQUEST['file_path']
                       );
        $this->db->where('id', $_REQUEST['current_order_id']);
        $success = $this->db->update('website_order', $data);

        if($success)
        {
            $this->session->set_flashdata(['class' => 'success', 'message' => 'Order Updated Successfully!']);
            redirect('production_orders/form_view/port/'.$_REQUEST['order_number']);
        }
    }

    public function sync_order()
    {
        $url = "https://vihaainfotech.xyz/api/syncData";

        $curl = curl_init($url);
        $header = array();
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json';
        $header[] = 'Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IlRoZUNhZENvQDIwMjIi.hhdqWPS0U6eQr4e-X-0_GrzRKDMQI71HVhCJPEOYZxM';
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER,$header);

        $resp = curl_exec($curl);
        curl_close($curl);

        $array = json_decode($resp,TRUE);

        // pre($_SERVER['DOCUMENT_ROOT']);exit;

        // pre($array);

        foreach ($array['data'] as $key => $value) 
        {
            $visualization = $value['visualization'];
            $tones = $visualization['tones'];

            $v_gold_tone = [];
            

            foreach ($tones as $key_t => $value_t) 
            {
              if(isset($value_t['tone_type']) && !empty($value_t['tone_type']))
              {
                  switch ($value_t['tone_type']) {
                    case 'White Tone':
                      $v_gold_tone[] = 'WG';
                      break;
                    
                    default:
                      # code...
                      break;
                  }
              }
              
            }

            $v_gold_tone = implode(',', $v_gold_tone);

            $background_color = $visualization['background_color'];
            foreach ($background_color as $key_bg => $value_bg) 
            {
              if(isset($value_bg['background_color']) && !empty($value_bg['background_color']))
              {
                  $bg_color = $value_bg['background_color'];
              }
              
            }

            $website_order = array(

                                'order_number'  => $value['order_id'],
                                'category'   => $value['jewellery_type'],
                                'client_name' => $value['name'],
                                'type' =>  $value['service_type'],
                                'v_rotation_type' => $value['rotation_type'],
                                'iv_rotation' => $value['rotation_type'],
                                'v_duration'  => $visualization['video_duration'],
                                'v_gold_tone' => $v_gold_tone,
                                'iv_gold_tone'  => $v_gold_tone,
                                'v_bg_color' => $bg_color,
                                'iv_bg_color' => $bg_color,
                                'created_by' => $this->session->userdata('user_id')
                            );

            $this->db->insert('website_order', $website_order);

            $portal_order_id = $this->db->insert_id();

            $order_images = $value['order_images'];
            if(!empty($order_images))
            {
                foreach ($order_images as $key1 => $value1) 
                {
                    $url = $value1;
                    $file_name = basename($url);

                    $ext = explode('.', $file_name)[1];

                    $file_name1 = $portal_order_id.date('Y-m-d_His').'.'.$ext;
                    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/process/portal_order_images/'.$file_name1, file_get_contents($url));
                    
                    $portal_order_images = array(
                                'file_name'  => $file_name1,
                                'order_id'   => $portal_order_id,                                
                                'created_by' => $this->session->userdata('user_id')
                            );

                    $this->db->insert('portal_order_images', $portal_order_images);
                    
                }
            }
        }

        echo json_encode(['message' => 'Order Synched Successfully!']);
    }

}
?>
