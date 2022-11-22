<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller
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
        $this->load->view('status/status_view');
    }

    public function form_action($id = '')
    {
        $id = $this->input->post('status_id');
        $postdata['status_name'] = $this->input->post('status_name');
        if($id != '' && $id != 0)
        {
            $postdata['updated_by'] = $this->session->userdata('user_id');
            $this->db->where('id', $id);
            $this->db->update('status', $postdata);
            $this->session->set_flashdata('message', 'Status Updated Successfully!');
        }
        else{
            $insertArray['created_by'] = $this->session->userdata('user_id');
            $this->db->insert('status', $postdata);
            $this->session->set_flashdata('message', 'Status Added Successfully!');
        }

        redirect('status');
    }

    public function fetch_record(){
        $result = array();
        $id = $_GET['id'];
        $sql_select = "SELECT * from status WHERE id =".$id;
        $res1 = $this->db->query($sql_select);
        if($res1){
            $row = $res1->result_array();
            $result['status'] = true;
            $result['message'] = 'Successfully fetch';
            $result['data'] = $row[0];

            echo json_encode($result);
        }
    }

    public function remove()
    {
        $array = [];
        $id = $this->input->post('id');
        if($id != '' && $id != 0)
        {
            $this->db->where('id', $id);
            $success = $this->db->delete('status');
            if($success)
            {
                $array['status'] = 'Success';
                echo json_encode($array);
            }
        }
    }

}
?>
