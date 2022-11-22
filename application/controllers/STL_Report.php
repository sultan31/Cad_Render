<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class STL_Report extends CI_Controller
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
        $this->load->view('stl_report/stl_report_view');
    }

    public function export_csv()
    {
        $today = date('Y-m-d');
        
        $order_no = urlencode($_REQUEST['order_no']);       
        $from_date = urlencode($_REQUEST['from_date']);
        $to_date = urlencode($_REQUEST['to_date']);

        
        $completed_status = $this->db->query('SELECT id FROM `status` WHERE `status_name` = "Completed"')->result_array()[0]['id'];
                                        
        if(isset($_REQUEST['order_no']) && !empty($_REQUEST['order_no']))
        {
            $this->db->where('order_number', $_REQUEST['order_no']);
        }
        if(isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']))
        {
            $this->db->where('order_date >= ', $_REQUEST['from_date']." 00:00:00");
        }
        if(isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']))
        {
            $this->db->where('order_date <= ', $_REQUEST['to_date']." 23:59:59");
        }
        $production_order = $this->db->get('production_order');
        $mainA = [];
        if($production_order->num_rows() > 0)
        {
            $production_order = $production_order->result_array();
            
            foreach($production_order as $r)
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

                $mainA[] = ['Order Number' => $r['order_number'], 'Status' => $status_name, 'Total Time' => $finalhms];
            }

            // pre($mainA);

            
            $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
            echo $this->array2csv($mainA);
            die();
           
            
        }
        
    }

    
    public function export_csv_details()
    {
        $cad_action_time = $this->db->query('SELECT DISTINCT user_id FROM `cad_action_time` WHERE `job_id` = '.$_REQUEST['order_id'].' AND `user_id` IN (SELECT id FROM `users` WHERE `user_role` = (SELECT id FROM `role` WHERE `role_name` = "Cad Designer"))');
                                            
                                            
        #pre($this->db->last_query());

        
        
        $mainA = [];
        if($cad_action_time->num_rows() > 0)
        {
            $cad_action_time = $cad_action_time->result_array();
            
            foreach($cad_action_time as $r)
            {
               
                $users = $this->db->query('SELECT full_name FROM `users` WHERE `id` = '.$r['user_id']);
                if($users->num_rows() > 0)
                {
                    $full_name = strtoupper($users->result_array()[0]['full_name']);
                    
                }
                else
                {
                    $full_name = '';                    
                }

                $get_total_time = $this->db->query("SELECT SUM(`diff_time`) AS total_alloc_time FROM `cad_action_time` WHERE `user_id` = ".$r['user_id']." AND job_id = '".$_REQUEST['order_id']."'");

                if($get_total_time->num_rows() > 0){
                    $get_total_time = $get_total_time->result_array()[0]['total_alloc_time'];

                }
                else{
                    $get_total_time = 0;
                }

                
                $get_total_work_time = $this->db->query("SELECT SUM(actual_time) AS working_time FROM cad_action_time WHERE user_id = ".$r['user_id']." AND job_id = '".$_REQUEST['order_id']."'");
                if($get_total_work_time->num_rows() > 0)
                {
                    $get_total_work_time = $get_total_work_time->result_array()[0]['working_time'];
                    
                } 
                else{
                   $get_total_work_time = 0; 
                }


                $init = $get_total_time;
                        $hours = floor($init / 60);
                        $minutes = floor($init % 60);
                        $seconds = 0;

                $total_d_time = (sprintf("%02d", $hours)).':'.(sprintf("%02d", $minutes)).':'.(sprintf("%02d", $seconds)).' Hrs';

                $init1 = $get_total_work_time; ;
                        $hours1 = floor($init1 / 3660);
                        $minutes1 = floor(($init1/60) % 60);
                        $seconds1 = $init1 % 60;

                $total_time_taken =  (sprintf("%02d", $hours1)).':'.(sprintf("%02d", $minutes1)).':'.(sprintf("%02d", $seconds1)).' Hrs';


                $mainA[] = ['Designer' => $full_name, 'Total Allocated Time' => $total_d_time, 'Total Time Taken' => $total_time_taken];
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

    
    public function get_order_details()
    {
    	
    	$data['order_id'] = isset($_REQUEST['order_id']) && !empty($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '';
        $data['from_date'] = isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']) ? $_REQUEST['from_date'] : '';
        $data['to_date'] = isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date']) ? $_REQUEST['to_date'] : '';
        $this->load->view('stl_report/details_report', $data);
        
        
    }

}
?>
