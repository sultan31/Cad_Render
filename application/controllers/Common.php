<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
        {
            redirect('login');
        }
    }

    public function form_action()
    {

        $this->db->where('id', $_REQUEST['user_id']);
        $success = $this->db->update('users', ['password' => $_REQUEST['c_new_passsword']]);
        if($success)
        {
            $this->session->set_flashdata('message', 'Password Changed Successfully!');
        }

        redirect($_REQUEST['redirect']);
    }

    public function update_complete_Order_stopTime()
    {
        $order_log = $this->db->query('SELECT * FROM order_log WHERE status = (SELECT id FROM status WHERE status_name = "Completed")');
        if($order_log->num_rows() > 0)
        {
            $order_log = $order_log->result_array();
            foreach ($order_log as $key => $value) 
            {
                $start_stop_time = $this->db->insert('start_stop_time', ['job_id' => $value['job_id'], 'user_id' => $value['assigned_to'], 'time' => strtotime($value['created_date']), 'type' => 'Stop']);
                
                $this->db->where(['type' => 'Start', 'job_id' => $value['job_id']]);
                $this->db->order_by('id', 'DESC');
                $this->db->limit(1);
                $start_time_query = $this->db->get('start_stop_time');
                $start_time = $start_time_query->result_array()[0]['time'];

                $this->db->where(['type' => 'Stop', 'job_id' => $value['job_id']]);
                $this->db->order_by('id', 'DESC');
                $this->db->limit(1);
                $stop_time_query = $this->db->get('start_stop_time');
                $stop_time = $stop_time_query->result_array()[0]['time'];

                $time_taken = $stop_time - $start_time;

                $this->db->where(['job_id' => $value['job_id']]);
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

                $this->db->insert('start_stop_action', ['job_id' => $value['job_id'], 'user_id' => $value['assigned_to'], 'actual_time' => $final_time_taken]);
            }

            echo 'Done';
        }

    }

    public function update_client_name_portal()
    {
        $website_order = $this->db->get('website_order');
        if($website_order->num_rows() > 0)
        {
            $website_order = $website_order->result_array();
            foreach ($website_order as $key => $value) 
            {
                $order_number = $value['order_number'];
                $client_name = explode('-', $value['order_number'])[0];

                $this->db->where('id', $value['id']);
                $this->db->update('website_order', ['client_name' => $client_name]);
            }

            echo 'Done';
        }

    }

    public function update_client_name()
    {
        $production_order = $this->db->get('production_order');
        if($production_order->num_rows() > 0)
        {
            $production_order = $production_order->result_array();
            foreach ($production_order as $key => $value) 
            {
                $order_number = $value['order_number'];
                $client_name = explode('-', $value['order_number'])[0];

                $this->db->where('id', $value['id']);
                $this->db->update('production_order', ['client_name' => $client_name]);
            }

            echo 'Done';
        }

    }

    public function update_client_name1()
    {
        $render_production_order = $this->db->get('render_production_order');
        if($render_production_order->num_rows() > 0)
        {
            $render_production_order = $render_production_order->result_array();
            foreach ($render_production_order as $key => $value) 
            {
                $order_number = $value['order_number'];
                $client_name = explode('-', $value['order_number'])[0];

                $this->db->where('id', $value['id']);
                $this->db->update('render_production_order', ['client_name' => $client_name]);
            }

            echo 'Done';
        }

    }

    public function update_po_no_render()
    {
        $render_production_order = $this->db->query('SELECT id, portal_order_id FROM render_production_order WHERE delete_flag = 0');
        if($render_production_order->num_rows() > 0)
        {
            $render_production_order = $render_production_order->result_array();
            foreach ($render_production_order as $key => $value) 
            {
                $website_order = $this->db->query('SELECT po_no FROM website_order WHERE id = '.$value['portal_order_id']);
                if($website_order->num_rows() > 0)
                {
                    $po_no = $website_order->result_array()[0]['po_no'];
                    $this->db->where('id', $value['id']);
                    $this->db->update('render_production_order', ['po_no' => $po_no]);
                }
            }

            echo 'Done';
        }

    }

    public function update_first_difficulty()
    {
        
        $order_log = $this->db->query('SELECT * FROM `order_log` WHERE `status` = (SELECT id FROM `status` WHERE `status_name` = "Allocated")');
        if($order_log->num_rows() > 0)
        {
            $order_log = $order_log->result_array();
            foreach ($order_log as $key => $value) 
            {
                $difficulty_name = $this->master_model->get_one_record('difficulty', 'difficulty_name', $value['difficulty_id']);
                $this->db->where('id', $value['job_id']);
                $this->db->update('production_order', ['initial_difficulty' => $difficulty_name]);
                pre($this->db->last_query());
            }

            echo 'Done';
        }

    }

    public function update_client_design_no()
    {
        $render_production_order = $this->db->query('SELECT id, portal_order_id FROM render_production_order WHERE delete_flag = 0');
        if($render_production_order->num_rows() > 0)
        {
            $render_production_order = $render_production_order->result_array();
            foreach ($render_production_order as $key => $value) 
            {
                $portal_order_id = $value['portal_order_id'];
                $website_order = $this->db->query('SELECT client_design_no FROM website_order WHERE id = '.$portal_order_id);
                if($website_order->num_rows() > 0)
                {
                    $client_design_no = $website_order->result_array()[0]['client_design_no'];
                    $this->db->where('id', $value['id']);
                    $this->db->update('render_production_order', ['client_design_no' => $client_design_no]);
                }
                
            }

            echo 'Done';
        }

    }


    public function update_client_design_no1()
    {
        $production_order = $this->db->query('SELECT id, portal_order_id FROM production_order WHERE delete_flag = 0');
        if($production_order->num_rows() > 0)
        {
            $production_order = $production_order->result_array();
            foreach ($production_order as $key => $value) 
            {
                $portal_order_id = $value['portal_order_id'];
                $website_order = $this->db->query('SELECT client_design_no FROM website_order WHERE id = '.$portal_order_id);
                if($website_order->num_rows() > 0)
                {
                    $client_design_no = $website_order->result_array()[0]['client_design_no'];
                    $this->db->where('id', $value['id']);
                    $this->db->update('production_order', ['client_design_no' => $client_design_no]);
                }
                
            }

            echo 'Done';
        }

    }


    public function update_render_production_po_no()
    {
        $temp = $this->db->query('SELECT * FROM temp');
        if($temp->num_rows() > 0)
        {
            $temp = $temp->result_array();
            foreach ($temp as $key => $value) 
            {
                
                $this->db->where('id', $value['id']);
                $this->db->update('render_production_order', ['po_no' => $value['po_no']]);
            }

            echo 'Done';
        }

    }


    public function update_production_po_no()
    {
        $cad_temp = $this->db->query('SELECT * FROM cad_temp');
        if($cad_temp->num_rows() > 0)
        {
            $cad_temp = $cad_temp->result_array();
            foreach ($cad_temp as $key => $value) 
            {
                
                $this->db->where('id', $value['id']);
                $this->db->update('production_order', ['po_no' => $value['po_no']]);
            }

            echo 'Done';
        }

    }

}
?>
