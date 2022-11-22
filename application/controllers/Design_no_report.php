<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Design_no_report extends CI_Controller
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
        $this->load->view('reports/design_no_report');
    }

    
    public function view_record()
    {
        $html = '<table class="table table-hover table-bordered m-0 table-centered nowrap w-100">';
        $order_id = $_REQUEST['order_id'];
        $mod_status = $this->db->query('SELECT id FROM status WHERE status_name = "Modification"')->result_array()[0]['id'];
        $rep_status = $this->db->query('SELECT id FROM status WHERE status_name = "Repair"')->result_array()[0]['id'];
        $Modification = $this->db->get_where('order_log', ['job_id' => $order_id, 'status' => $mod_status]);
        if($Modification->num_rows() > 0)
        {
            $Modification = $Modification->result_array();
            $html .= '<thead>
                        <tr>
                            <th colspan="2" style="font-size:16px;text-align:center;background-color:#efefef;">
                                Modification
                            </th>
                        </tr>
                        <thead>
                            <tr>
                                <th>
                                    Sr No
                                </th>
                                <th>
                                    Date
                                </th>
                                
                            </tr>
                        </thead><tbody>';
                        $i = 0;
            foreach ($Modification as $key => $value) 
            {
                $i++;
                $html .= '<tr>
                            <td>'.$i.'</td>
                            <td>'.date('Y-m-d h:i A', strtotime($value['created_date'])).'</td>
                        </tr>';
            }

            $html .= '</tbody>';
        }


        $Repair = $this->db->get_where('order_log', ['job_id' => $order_id, 'status' => $rep_status]);
        if($Repair->num_rows() > 0)
        {
            $Repair = $Repair->result_array();
            $html .= '<thead>
                        <tr>
                            <th colspan="2" style="font-size:16px;text-align:center;background-color:#efefef;">
                                Repair
                            </th>
                        </tr>
                        <thead>
                            <tr>
                                <th>
                                    Sr No
                                </th>
                                <th>
                                    Date
                                </th>
                                
                            </tr>
                        </thead><tbody>';
                        $j = 0;
            foreach ($Repair as $key1 => $value1) 
            {
                $j++;
                $html .= '<tr>
                            <td>'.$j.'</td>
                            <td>'.date('Y-m-d h:i A', strtotime($value1['created_date'])).'</td>
                        </tr>';
            }

            $html .= '</tbody>';
        }

        $html .= '</table>';

        echo $html;
    }


    public function export_csv()
    {
        $mod_status = $this->db->query('SELECT id FROM status WHERE status_name = "Modification"')->result_array()[0]['id'];
        $rep_status = $this->db->query('SELECT id FROM status WHERE status_name = "Repair"')->result_array()[0]['id'];
        $order_no = $_REQUEST['order_no'];
        $po_no = $_REQUEST['po_no'];
        $client = $_REQUEST['client'];
        $from_date = $_REQUEST['from_date'];
        $to_date = $_REQUEST['to_date'];


        $today = date('Y-m-d');
        $conditions = [];
        $this->db->select('order_number, po_no, client_name, (SELECT COUNT(id) FROM order_log WHERE production_order.id = order_log.job_id AND status = '.$mod_status.') AS modification, (SELECT COUNT(id) FROM order_log WHERE production_order.id = order_log.job_id AND status = '.$rep_status.') AS repair');
       
        if(isset($order_no) && $order_no != '')
        {
            $this->db->where('order_number', $order_no);
        }
        if(isset($po_no) && $po_no != '')
        {
            $this->db->where('po_no', $po_no);
        }
        if(isset($client) && $client != '')
        {
            $this->db->where('client_name', $client);
        }
        
        if(isset($from_date) && $from_date != '')
        {
            $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") >= ', $from_date);
            
        }
        if(isset($to_date) && $to_date != '')
        {
            $this->db->where('DATE_FORMAT(updated_date, "%Y-%m-%d") <= ', $to_date);
        }
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get('production_order');
        // pre($this->db->last_query());exit;
        $mainA = [];
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            $i = 1;
            foreach($result as $r)
            {
                if($r['modification'] > 0 || $r['repair'] > 0)
                {
                    $mainA[] = ['Sr No' => $i, 'Design Number' => $r['order_number'], 'PO No' => $r['po_no'], 'Client' => $r['client_name'], 'Modification' => $r['modification'], 'Repair' => $r['repair']];
                    $i++;
                }


                
            }

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
