<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller
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
        $this->load->view('reports/reports_view');
    }

    
    public function status_report()
    {
        $this->load->view('reports/status_report_view');
    }

    public function export_status_report_csv()
    {
        $pdw_sent = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "PDW Sent"')->result_array()[0]['id'];
        $today = date('Y-m-d');
        $completed_status = $this->db->query('SELECT id FROM status WHERE status_name = "Completed"')->result_array()[0]['id'];
        $order_no = $_REQUEST['order_no'];
        $client = $_REQUEST['client'];
        $user_id = $_REQUEST['user_id'];
        $difficulty_name = $_REQUEST['difficulty_name'];
        $status_name = $_REQUEST['status_name'];
        $from_date = $_REQUEST['from_date'];
        $to_date = $_REQUEST['to_date'];
        $po_no = $_REQUEST['po_no'];

        
        $this->db->select('b.id, b.order_number, b.po_no, b.category, b.client_name, b.order_date, b.file_path, b.difficulty_id, b.assigned_to, b.password, b.deadline,b.status AS status, a.status AS log_status,a.created_date');
        $this->db->from('production_order as b');
        $this->db->join('order_log as a', 'a.job_id = b.id', 'LEFT');
            if(isset($status_name) && $status_name != '')
            {
                $this->db->where('a.status', $status_name);
            }
            if(isset($user_id) && $user_id != '')
            {
                $this->db->where('a.assigned_to', $user_id);
            }
            if(isset($_REQUEST['difficulty_name']) && $_REQUEST['difficulty_name'] != '')
            {
                $this->db->where('b.initial_difficulty',$_REQUEST['difficulty_name']);
            }
            if(isset($client) && $client != '')
            {
                $this->db->where('b.client_name', $client);
            }
            if(isset($order_no) && $order_no != '')
            {
                $this->db->where('b.order_number', $order_no);
            }
            if(isset($po_no) && $po_no != '')
            {
                $this->db->where('b.po_no', $po_no);
            }
            
            if(isset($from_date) && $from_date != '')
            {
                $this->db->where('DATE_FORMAT(a.created_date, "%Y-%m-%d") >= ', $from_date);
                
            }
            if(isset($to_date) && $to_date != '')
            {
                $this->db->where('DATE_FORMAT(a.created_date, "%Y-%m-%d") <= ', $to_date);
            }

            if($_REQUEST['status_name'] == $pdw_sent)
            {
                $this->db->group_by('b.order_number');
            }
            $this->db->order_by('a.created_date', 'DESC');
            $res = $this->db->get();
        

        // pre($this->db->last_query());exit;
        
        $mainA = [];
        if($res->num_rows() > 0)
        {
            $result = $res->result_array();
            
            foreach($result as $r)
            {
               
                $status_data = $this->db->get_where('status', ['id' =>  $r['status']])->result_array();
                $status_name = $status_data[0]['status_name'];

                $start_stop_time = $this->db->query('SELECT * FROM `start_stop_time` WHERE job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1');
                if($start_stop_time->num_rows() > 0)
                {
                    $start_stop_time = $start_stop_time->result_array();
                    // pre($start_stop_time);
                    $type = $start_stop_time[0]['type'];
                    if($type == 'Start')
                    {
                        $created_date = $start_stop_time[0]['created_date'];
                        $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($created_date);
                    }
                    else
                    {
                        $diff = 0;
                    }
                    // pre($diff);

                    $start_stop_action = $this->db->query('SELECT * FROM `start_stop_action` WHERE job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1');
                    if($start_stop_action->num_rows() > 0)
                    {
                        $actual_time = $diff + $start_stop_action->result_array()[0]['actual_time'];
                        // pre($actual_time);
                        // $actual_time = date('H:i:s', $actual_time); 
                        
                    }
                    else
                    {
                        $actual_time = $diff;
                        // $actual_time = date('H:i:s', $diff); 
                        
                    }

                    $hours = floor($actual_time / 3600);
                    $min = floor(($actual_time - ($hours * 3600))/60);
                    $sec = $actual_time - (($hours*3600)+($min * 60));
                    $hms = $hours.":".$min.":".$sec;
                    $finalhms = date('H:i:s', strtotime($hms)); 
                }
                else
                {
                    $actual_time = '';
                    $finalhms = '';
                }

                $difficulties = '';

                $difficulty_query = $this->db->query('SELECT difficulty_id FROM `order_log` WHERE `job_id` = '.$r['id'].' AND difficulty_id != 0');
                if($difficulty_query->num_rows() > 0)
                {
                    $difficulties = [];
                    $difficulty_id_column = $difficulty_query->result_array();
                    
                    foreach ($difficulty_id_column as $k1 => $v1) {
                        $difficulty_name = $this->db->query('SELECT difficulty_name FROM difficulty WHERE id = '.$v1['difficulty_id'])->result_array()[0]['difficulty_name'];
                        array_push($difficulties, $difficulty_name);

                    }
                    
                    if(!empty($difficulties))
                    {
                        
                        $difficulties = implode(' / ', $difficulties);
                    }

                }


                
                
                $latest_act = isset($r['created_date']) && !empty($r['created_date']) ? date('d-m-y H:i', strtotime($r['created_date'])) : '';


                $mainA[] = ['Order Number' => $r['order_number'], 'PO No' => $r['po_no'], 'Category' => $r['category'], 'Client' => $r['client_name'], 'Order Date' => date('Y-m-d', strtotime($r['order_date'])), 'Latest ACT' => $latest_act, 'Current Status' => $status_name, 'Current Status' => $status_name, 'Difficulty' => $difficulties, 'Designer' => $this->master_model->get_one_record('users', 'full_name', $r['assigned_to']), 'Total Time' => $finalhms];
            }

            // pre($mainA);

            
            $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
            echo $this->array2csv($mainA);
            die();
           
            
        }
        
    }

    public function export()
    {
        $this->load->view('reports/reports_view');
    }

    public function export_csv()
    {
        $today = date('Y-m-d');
        
        $order_no = urlencode($_REQUEST['order_no']);
        $po_no = urlencode($_REQUEST['po_no']);
        $client = urlencode($_REQUEST['client']);
        $category = urlencode($_REQUEST['category']);
        $user_id = urlencode($_REQUEST['user_id']);
        $difficulty_name = urlencode($_REQUEST['difficulty_name']);
        $status_name = urlencode($_REQUEST['status_name']);
        $from_date = urlencode($_REQUEST['from_date']);
        $to_date = urlencode($_REQUEST['to_date']);

        
            $this->db->select('id, order_number, po_no, category, client_name, order_date, file_path, difficulty_id, assigned_to, password, deadline, status, created_date');
            $this->db->from('production_order');
            
            if(isset($status_name) && $status_name != '')
            {
                $this->db->where('status', $status_name);
            }
            if(isset($user_id) && $user_id != '')
            {
                $this->db->where('assigned_to', $user_id);
            }
            if(isset($client) && $client != '')
            {
                $this->db->where('client_name', $client);
            }
            if(isset($category) && $category != '')
            {
                $this->db->where('category', $category);
            }
            if(isset($difficulty_name) && $difficulty_name != '')
            {
                $this->db->where('initial_difficulty',$difficulty_name);
            }
            
            if(isset($order_no) && $order_no != '')
            {
                $this->db->like('order_number', trim($order_no));
            }

            if(isset($po_no) && $po_no != '')
            {
                $this->db->like('po_no', trim($po_no));
            }
            
            if(isset($from_date) && $from_date != '')
            {
                $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") >= ', $from_date);
                
            }
            if(isset($to_date) && $to_date != '')
            {
                $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") <= ', $to_date);
            }

                
                $this->db->order_by('updated_date', 'DESC');
                $res = $this->db->get();
                 #pre($this->db->last_query());exit;
        
        $mainA = [];
        if($res->num_rows() > 0)
        {
            $result = $res->result_array();
            
            foreach($result as $r)
            {
               
                $status_data = $this->db->get_where('status', ['id' =>  $r['status']])->result_array();
                $status_name = $status_data[0]['status_name'];

                $start_stop_time = $this->db->query('SELECT * FROM `start_stop_time` WHERE job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1');
                if($start_stop_time->num_rows() > 0)
                {
                    $start_stop_time = $start_stop_time->result_array();
                    // pre($start_stop_time);
                    $type = $start_stop_time[0]['type'];
                    if($type == 'Start')
                    {
                        $created_date = $start_stop_time[0]['created_date'];
                        $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($created_date);
                    }
                    else
                    {
                        $diff = 0;
                    }
                    // pre($diff);

                    $start_stop_action = $this->db->query('SELECT * FROM `start_stop_action` WHERE job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1');
                    if($start_stop_action->num_rows() > 0)
                    {
                        $actual_time = $diff + $start_stop_action->result_array()[0]['actual_time'];
                        // pre($actual_time);
                        // $actual_time = date('H:i:s', $actual_time); 
                        
                    }
                    else
                    {
                        $actual_time = $diff;
                        // $actual_time = date('H:i:s', $diff); 
                        
                    }

                    $hours = floor($actual_time / 3600);
                    $min = floor(($actual_time - ($hours * 3600))/60);
                    $sec = $actual_time - (($hours*3600)+($min * 60));
                    $hms = $hours.":".$min.":".$sec;
                    $finalhms = date('H:i:s', strtotime($hms)); 
                }
                else
                {
                    $actual_time = '';
                    $finalhms = '';
                }

                $difficulties = '';

                $difficulty_query = $this->db->query('SELECT difficulty_id FROM `order_log` WHERE `job_id` = '.$r['id'].' AND difficulty_id != 0');
                if($difficulty_query->num_rows() > 0)
                {
                    $difficulties = [];
                    $difficulty_id_column = $difficulty_query->result_array();
                    
                    foreach ($difficulty_id_column as $k1 => $v1) {
                        $difficulty_name = $this->db->query('SELECT difficulty_name FROM difficulty WHERE id = '.$v1['difficulty_id'])->result_array()[0]['difficulty_name'];
                        array_push($difficulties, $difficulty_name);

                    }
                    
                    if(!empty($difficulties))
                    {
                        
                        $difficulties = implode(' / ', $difficulties);
                    }

                }


                $created_date = $this->db->query('SELECT created_date FROM order_log WHERE job_id = '.$r['id'].' ORDER BY id DESC LIMIT 1')->result_array()[0]['created_date'];
                
                $latest_act = isset($created_date) && !empty($created_date) ? date('d-m-y H:i', strtotime($created_date)) : '';


                $mainA[] = ['Order Number' => $r['order_number'], 'PO No' => $r['po_no'], 'Category' => $r['category'], 'Client' => $r['client_name'], 'Order Date' => date('Y-m-d', strtotime($r['order_date'])), 'Latest ACT' => $latest_act, 'Status' => $status_name, 'Difficulty' => $difficulties, 'Designer' => $this->master_model->get_one_record('users', 'full_name', $r['assigned_to']), 'Total Time' => $finalhms];
            }

            // pre($mainA);

            
            $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
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


    public function cad_production()
    {
        $this->load->view('reports/cad_production_view');
    }

     public function export_csv_cad_production()
    { 

        if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])){
            $from_date = $_REQUEST['from_date'];
        }
        else{
            $from_date = date("Y-m-d");
        }


        if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])){
            $to_date = $_REQUEST['to_date'];
        }
        else{
            
            $to_date = date("Y-m-d");
        }

        if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])){
            $filter_user_id = " AND id = ".$_REQUEST['user_id'];
        }
        else{
            $filter_user_id = '';
        }      

        $mainA = [];
        $a = [];

        $status = $this->db->query('SELECT id,status_name FROM `status` WHERE show_in_report = 1  ORDER BY report_position ASC')->result_array();
        

        $users = $this->db->query('SELECT id,full_name FROM `users` WHERE user_role = 2'.$filter_user_id);
        if($users->num_rows() > 0)
        {
            $users = $users->result_array();
            foreach($users as $u)
            {                
                $get_total_time = $this->db->query("SELECT SUM(`diff_time`) AS total_alloc_time FROM `cad_action_time` WHERE `user_id` = ".$u['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59'" );

                if($get_total_time->num_rows() > 0){
                    $get_total_time = $get_total_time->result_array()[0]['total_alloc_time'];

                }
                else{
                    $get_total_time = 0;
                }


                $init = $get_total_time;
                $hours = floor($init / 60);
                $minutes = floor($init % 60);
                $seconds = 0;

                $final_total_time = ( (sprintf("%02d", $hours)).':'.(sprintf("%02d", $minutes)).':'.(sprintf("%02d", $seconds)).' Hrs');
                
                $get_total_work_time = $this->db->query("SELECT SUM(actual_time) AS working_time FROM cad_action_time WHERE user_id = ".$u['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59'");
                if($get_total_work_time->num_rows() > 0)
                {
                    $get_total_work_time = $get_total_work_time->result_array()[0]['working_time'];
                    // $get_total_work_time = round($get_total_work_time / 60);
                } 
                else{
                   $get_total_work_time = 0; 
                }  

                $init1 = $get_total_work_time; 
                $hours1 = floor($init1 / 3660);
                $minutes1 = floor(($init1/60) % 60);
                $seconds1 = $init1 % 60;

                $final_total_work_time = ( (sprintf("%02d", $hours1)).':'.(sprintf("%02d", $minutes1)).':'.(sprintf("%02d", $seconds1)).' Hrs');       

                $a = ['Designer' => $u['full_name'], 'Total Difficulty Time' => $final_total_time, 'Total Time' => $final_total_work_time];

                foreach($status as $d)
                {

                    $get_dept_count = $this->db->query("SELECT COUNT(DISTINCT(job_id)) as dept_ord_count FROM cad_action_time WHERE user_id = ".$u['id']." AND status=".$d['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59'"); 
                    if($get_dept_count->num_rows() > 0)
                    {
                        $a[$d['status_name']] = $get_dept_count->result_array()[0]['dept_ord_count'];
                    }
                    else
                    {
                        $a[$d['status_name']] = 0;
                    }
                    
                }


                $mainA[] = $a;   
            }

            #pre($mainA);die(); 

            $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
            echo $this->array2csv($mainA);
            die();  
        }      
    }

    public function detailed_report($id='',$from_date,$to_date)
    {
        $data['id'] = $id;
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $this->load->view('reports/cad_production_detailed_report', $data);
    }

    
    public function view_detail()
    {
        $data['user_id'] = $_REQUEST['user_id'];
        $data['from_date'] = $_REQUEST['from_date'];
        $data['to_date'] = $_REQUEST['to_date'];
        $this->load->view('reports/cad_production_pivot', $data);
        
        
    }

}
?>
