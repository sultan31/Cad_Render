<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Style_dep_comp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
        {
            redirect('login');
        }
    }

    public function index()
    {
        $this->load->view('reports/style_dept_comp_view');
    }
    
    public function export_csv()
    {
        $user_id = $_REQUEST['user_id'];
        $basic_datepicker = $_REQUEST['basic_datepicker'];
        $basic_datepicker1 = $_REQUEST['basic_datepicker1'];


        $today = date('Y-m-d');
        $conditions = [];
        $this->db->select('*');
        $this->db->from('production_order');
        
        if(isset($user_id) && $user_id != '' && $user_id != 'Select')
        {
            $this->db->where('assigned_to', $user_id);
        }
        
        if(isset($basic_datepicker) && $basic_datepicker != '')
        {
            $this->db->where('DATE_FORMAT(order_date, "%Y-%m-%d") >= ', $basic_datepicker);
            
        }
        if(isset($basic_datepicker1) && $basic_datepicker1 != '')
        {
            $this->db->where('DATE_FORMAT(order_date, "%Y-%m-%d") <= ', $basic_datepicker1);
        }
        $this->db->order_by('id', 'DESC');
        $res = $this->db->get();
        $mainA = [];
        if($res->num_rows() > 0)
        {
            $result = $res->result_array();
            
            foreach($result as $r)
            {
                $full_name = $this->master_model->get_one_record('users', 'full_name', $r['assigned_to']);
                $difficulty_name = $this->master_model->get_one_record('difficulty', 'difficulty_name', $r['difficulty_id']);
                $total_time = $this->master_model->get_one_record('difficulty', 'total_time', $r['difficulty_id']);
                $start_time = '';
                $start_time_query = $this->db->query('SELECT time FROM `start_stop_time` WHERE `job_id` = '.$r['id'].' AND  `type` = "Start" ORDER BY `id` ASC LIMIT 1');
                
                if($start_time_query->num_rows() > 0)
                {
                    $start_time = date('H:i', strtotime($start_time_query->result_array()[0]['time']));
                }

                $stop_time = '';
                $stop_time_query = $this->db->query('SELECT time FROM `start_stop_time` WHERE `job_id` = '.$r['id'].' AND  `type` = "Stop" ORDER BY `id` DESC LIMIT 1');
                
                if($stop_time_query->num_rows() > 0)
                {
                    $stop_time = date('H:i', strtotime($stop_time_query->result_array()[0]['time']));
                }

                $actual_time_query = $this->db->query('SELECT actual_time FROM `start_stop_action` WHERE `job_id` = '.$r['id'].' ORDER BY `id` DESC LIMIT 1');
                                            
                if($actual_time_query->num_rows() > 0)
                {
                    $actual_time = $actual_time_query->result_array()[0]['actual_time'];
                }

                $mainA[] = ['Order ID' => $r['order_number'], 'Designer' => $full_name, 'Diffculty' => $difficulty_name, 'Allocated Time (as per diffculty level)' => $total_time, 'Start Time' => $start_time, 'End Time' => $stop_time, 'Total Time Taken' => $actual_time];
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
}
?>
