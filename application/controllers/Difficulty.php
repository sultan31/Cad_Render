<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Difficulty extends CI_Controller
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
        $this->load->view('difficulty/difficulty_view');
    }

    public function form_action()
    {
        $id = $this->input->post('difficulty_id');
        $postdata['difficulty_name'] = $this->input->post('difficulty_name');
        $postdata['total_time'] = $this->input->post('total_time');
        if($id != '' && $id != 0)
        {
            $postdata['updated_by'] = $this->session->userdata('user_id');
            $this->db->where('id', $id);
            $this->db->update('difficulty', $postdata);
            $this->session->set_flashdata('message', 'Difficulty Updated Successfully!');
        }
        else{
            $postdata['created_by'] = $this->session->userdata('user_id');
            $this->db->insert('difficulty', $postdata);
            $this->session->set_flashdata('message', 'Difficulty Added Successfully!');
        }

        redirect('difficulty');
    }

    public function fetch_record(){
        $result = array();
        $id = $_GET['id'];
        $sql_select = "SELECT * from difficulty WHERE id =".$id;
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
            $success = $this->db->delete('difficulty');
            if($success)
            {
                $array['status'] = 'Success';
                echo json_encode($array);
            }
        }
    }

}
?>
