<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
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
        $this->load->view('users/users_view');
    }

    
    public function available()
    {
        $this->load->view('users/available_designers');
    }

    public function form_view($mode, $id='')
    {
        if($mode == 'add')
        {
            $this->load->view('users/users_form');
        }
        else if($mode == 'edit')
        {
            $data['edit_data'] = $this->db->get_where('users', ['id' => $id])->result_array();
            $this->load->view('users/users_form', $data);
        }

    }

    public function form_action($id='')
    {
        $postdata['user_role'] = $this->input->post('user_role');
        $postdata['full_name'] = $this->input->post('full_name');
        $postdata['mobile_no'] = $this->input->post('mobile_no');
        $postdata['email_id'] = $this->input->post('email_id');

        
        $dept_id = isset($_REQUEST['dept_id']) && !empty($_REQUEST['dept_id']) ? $_REQUEST['dept_id'] : [];
        
        if($id)
        {
            $postdata['password'] = $this->input->post('password');
            $postdata['updated_by'] = $this->session->userdata('user_id');
            $this->db->where('id', $id);
            $this->db->update('users', $postdata);
            $this->session->set_flashdata('message', 'User Updated Successfully!');
        }
        else{
            $postdata['password'] = $this->input->post('c_password');
            $postdata['created_by'] = $this->session->userdata('user_id');
            $this->db->insert('users', $postdata);
            $last_insert_id = $this->db->insert_id();
            $this->session->set_flashdata('message', 'User Added Successfully!');
        }

        $user_id = isset($id) && !empty($id) ? $id : $last_insert_id;

        $this->db->where('user_id', $user_id);
        $this->db->delete('user_departments');


        if(!empty($dept_id))
        {
            for ($i=0; $i < count($dept_id); $i++) 
            { 
                $user_departments[] = ['user_id' => $user_id, 'dept_id' => $dept_id[$i], 'created_by' => $this->session->userdata('user_id')];
            }
            $this->db->insert_batch('user_departments', $user_departments);
        }
        

        

        redirect('users');
    }

    public function profile_action()
    {
        
        $postdata['full_name'] = $this->input->post('full_name');
        $postdata['mobile_no'] = $this->input->post('mobile_no');
        $postdata['email_id'] = $this->input->post('email_id');
        $id = $this->session->userdata('user_id');
        if($id)
        {
            $postdata['updated_by'] = $this->session->userdata('user_id');
            $this->db->where('id', $id);
            $this->db->update('users', $postdata);
            $this->session->set_flashdata('message', 'Profile Updated Successfully!');
        }       

        redirect('profile');
    }

    public function fetch_record(){
        $result = array();
        $id = $_GET['id'];
        $sql_select = "SELECT * from role WHERE id =".$id;
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
            $success = $this->db->update('users', ['delete_flag' => 1]);
            if($success)
            {
                $array['status'] = 'Success';
                echo json_encode($array);
            }
        }
    }

    
    public function change_status()
    {
        $array = [];
        $id = $this->input->post('id');
        $action = $this->input->post('action');

        if($id != '' && $id != 0)
        {
            $this->db->where('id', $id);
            $active = $action == 'Deactivate' ? 0 : 1;
            $success = $this->db->update('users', ['active' => $active]);

            if($success)
            {
                $array['active'] = $active;
                echo json_encode($array);
            }
        }
    }

    
    public function check_allocated_order()
    {
        $production_order = $this->db->query('SELECT * FROM `production_order` WHERE `assigned_to` = '.$_REQUEST['id']);
        if($production_order->num_rows() > 0)
        {
            echo json_encode(['status' => 0]);
        }
        else
        {
            echo json_encode(['status' => 1]);
        }
    }

    public function check_duplicate()
    {
        $type = $this->input->post('type');
        $value = $this->input->post('value');
        
        if($type == 'email')
        {
            $query = $this->db->get_where('users', ['email_id' => $value]);
        }
        else if($type == 'mobile_no')
        {
            $query = $this->db->get_where('users', ['mobile_no' => $value]);
        }

        if($query->num_rows() == 0)
        {
            $output = array(
                'status' => 1
          );
        }
        else
        {
            $output = array(
                'status' => 0
          );
        }
        echo json_encode($output);
    }
}
?>
