<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cad_production_report extends CI_Controller
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


    public function export()
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
            // $from_date = date(Y-m-d);
            $to_date = date("Y-m-d");
        }

        if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])){
            $filter_user_id = " AND id = ".$_REQUEST['user_id'];
            // pre($filter_user_id);exit();
        }
        else{
            // $from_date = date(Y-m-d);
            $filter_user_id = '';
        }       

        // pre($this->db->last_query());exit;
        
        $mainA = [];
        $users = $this->db->query('SELECT id,full_name FROM `users` WHERE user_role = 2'.$filter_user_id.'');
        if($users->num_rows() > 0)
        {
            $users = $users->result_array();
            foreach($users as $u)
            {
                $get_total_time = $this->db->query("SELECT SUM(`diff_time`) AS total_alloc_time FROM `cad_action_time` WHERE `user_id` = ".$u['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59'" );

                 //pre($this->db->last_query());exit;

                if($get_total_time->num_rows() > 0){
                    $get_total_time = $get_total_time->result_array()[0]['total_alloc_time'];

                }
                else{
                    $get_total_time = 0;
                }

                
                $get_total_work_time = $this->db->query("SELECT SUM(actual_time) AS working_time FROM cad_action_time WHERE user_id = ".$u['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59'");
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

                        $Total_Difficulty_Time = ( (sprintf("%02d", $hours)).':'.(sprintf("%02d", $minutes)).':'.(sprintf("%02d", $seconds)).' Hrs');
                 
                 
                        $init1 = $get_total_work_time; ;
                        $hours1 = floor($init1 / 3660);
                        $minutes1 = floor(($init1/60) % 60);
                        $seconds1 = $init1 % 60;

                        $Total_Time = ( (sprintf("%02d", $hours1)).':'.(sprintf("%02d", $minutes1)).':'.(sprintf("%02d", $seconds1)).' Hrs');                                                  

                                                                           
                        $modification_count = $this->db->query("SELECT COUNT(DISTINCT(job_id)) as modification_count FROM cad_action_time WHERE user_id = ".$u['id']." AND modification = 1 AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59'"); 
                        
                        if($modification_count->num_rows() > 0)
                        {
                            $modification_count = $modification_count->result_array()[0]['modification_count'];
                        }
                        else
                        {
                            $modification_count = 0;
                        }

                        

                        $repair_count = $this->db->query("SELECT COUNT(DISTINCT(job_id)) as repair_count FROM cad_action_time WHERE user_id = ".$u['id']." AND repair = 1 AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59'"); 
                        
                        if($repair_count->num_rows() > 0)
                        {
                            $repair_count = $repair_count->result_array()[0]['repair_count'];
                        }
                        else
                        {
                            $repair_count = 0;
                        }

                        

                        
                        $pdw_sent_count = $this->db->query("SELECT COUNT(DISTINCT(job_id)) as pdw_sent_count FROM cad_action_time WHERE user_id = ".$u['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59' AND job_id IN (SELECT id FROM production_order WHERE cad_dept_flag = 1)")->result_array()[0]['pdw_sent_count']; 
                        // pre($this->db->last_query());
                        
                    
                        $pending_count = $this->db->query("SELECT COUNT(DISTINCT(job_id)) as pending_count FROM cad_action_time WHERE user_id = ".$u['id']." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59' AND job_id IN (SELECT id FROM production_order WHERE cad_dept_flag = 0)")->result_array()[0]['pending_count']; 
                        
                        $mainA[] = ['Designer' => $u['full_name'], 'Total Difficulty Time' => $Total_Difficulty_Time, 'Total Time' => $Total_Time, 'Modification' => $modification_count, 'Repair' => $repair_count, 'PDW Sent' => $pdw_sent_count, 'Pending' => $pending_count];

            }


            

            $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
            echo $this->array2csv($mainA);
            die();
        }
        
        
    }

    public function export_csv_details()
    {
        $dept_filter = '';
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
            // $from_date = date(Y-m-d);
            $to_date = date("Y-m-d");
        }

        if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])){
            $user_id = $_REQUEST['user_id'];
            // pre($filter_user_id);exit();
        }
        else{
            // $from_date = date(Y-m-d);
            $filter_user_id = '';
        }       

        // pre($this->db->last_query());exit;
        
        $mainA = [];
        $jobs_data =  $this->db->query("SELECT id, SUM(`diff_time`) as t_diff_time, SUM(`actual_time`) as t_actual_time, job_id, status, diff_name  FROM `cad_action_time` WHERE `user_id` = ".$user_id." AND `created_date` >= '".$from_date." 00:00:00' AND `created_date` <= '".$to_date." 23:59:59' ".$dept_filter." GROUP BY `status`, `job_id` ORDER BY job_id ASC");
        if($jobs_data->num_rows() > 0)
        {
            $jobs_data = $jobs_data->result_array();
            foreach($jobs_data as $key => $value)
            {
                $order_number = $this->master_model->get_one_record('production_order', 'order_number', $value['job_id']); 
                $init = $value['t_diff_time'];
                $hours = floor($init / 60);
                $minutes = floor($init % 60);
                $seconds = 0;

                $Total_Difficulty_Time =  (sprintf("%02d", $hours)).':'.(sprintf("%02d", $minutes)).':'.(sprintf("%02d", $seconds)).' Hrs';

                $diff_name =  $value['diff_name'];
                                                        
                $init1 = $value['t_actual_time'];
                $hours1 = floor($init1 / 3660);
                $minutes1 = floor(($init1/60) % 60);
                $seconds1 = $init1 % 60;

                $Total_Time = (sprintf("%02d", $hours1)).':'.(sprintf("%02d", $minutes1)).':'.(sprintf("%02d", $seconds1)).' Hrs';
                
                $CAD = $this->master_model->get_one_record('status', 'status_name', $value['status']);
                                                                                                        
                                                    
                        
                $mainA[] = ['Order Number' => $order_number, 'Total Difficulty Time' => $Total_Difficulty_Time, 'Difficulty Type' => $diff_name, 'Total Time' => $Total_Time, 'CAD' => $CAD];

            }


            

            $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
            echo $this->array2csv($mainA);
            die();
        }
        
        
    }

     public function export_cad_production_pivot()
    {
        $dept_filter = '';
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
            // $from_date = date(Y-m-d);
            $to_date = date("Y-m-d");
        }

        if(isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])){
            $user_id = $_REQUEST['user_id'];
            // pre($filter_user_id);exit();
        }
        else{
            // $from_date = date(Y-m-d);
            $filter_user_id = '';
        }       

        // pre($this->db->last_query());exit;
        
        $mainA = [];
        $diff_name =  $this->db->query("SELECT DISTINCT `diff_name` FROM `cad_action_time` WHERE `user_id` = ".$user_id);
        if($diff_name->num_rows() > 0)
        {
            $diff_name = $diff_name->result_array();
            foreach($diff_name as $key => $value)
            {
                $diff_name = $value['diff_name']; 

                $pdw_sent_count = $this->db->query('SELECT COUNT(id) AS pdw_sent_count FROM `cad_action_time` WHERE `user_id` = "'.$user_id.'" AND diff_name = "'.$value['diff_name'].'" AND job_id IN (SELECT id FROM production_order WHERE cad_dept_flag = 1)')->result_array()[0]['pdw_sent_count'];  

                $modification_count = $this->db->query('SELECT COUNT(id) AS modification_count FROM `cad_action_time` WHERE `user_id` = "'.$user_id.'" AND `modification` = 1 AND diff_name = "'.$value['diff_name'].'"')->result_array()[0]['modification_count'];   

                $repair_count = $this->db->query('SELECT COUNT(id) AS repair_count FROM `cad_action_time` WHERE `user_id` = "'.$user_id.'" AND `repair` = 1 AND diff_name = "'.$value['diff_name'].'"')->result_array()[0]['repair_count'];                  
                        
                $mainA[] = ['DIFF' => $diff_name, 'CAD' => $pdw_sent_count, 'MOD' => $modification_count, 'REP' => $repair_count];

            }


            

            $this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
            echo $this->array2csv($mainA);
            die();
        }
        
        
    }
}
?>