<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller
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
        $this->load->view('department/department_view');
    }

    public function form_action()
    {
        // pre($_REQUEST);exit;
        $id = $this->input->post('department_id');
        $postdata['dept_name'] = $this->input->post('dept_name');
        $postdata['label'] = $this->input->post('label');

        $this->db->where('dept_id', $id);
        $this->db->delete('department_association');

        if($id != '' && $id != 0)
        {
            $postdata['updated_by'] = $this->session->userdata('user_id');
            $this->db->where('id', $id);
            $this->db->update('department', $postdata);
            $this->session->set_flashdata('message', 'Department Updated Successfully!');
        }
        else{
            $postdata['created_by'] = $this->session->userdata('user_id');
            $this->db->insert('department', $postdata);
            $id = $this->db->insert_id();
            $this->session->set_flashdata('message', 'Department Added Successfully!');

            
        }

        
        $move_to_dept = isset($_REQUEST['move_to_dept']) ? $_REQUEST['move_to_dept'] : [];
        if(!empty($move_to_dept))
        {
            for ($i=0; $i < count($move_to_dept); $i++) { 
                $this->db->insert('department_association', ['dept_id' => $id, 'related_dept_id' => $move_to_dept[$i], 'type' => 1, 'created_by' => $this->session->userdata('id')]);
            }
        }

        $go_back_dept = isset($_REQUEST['go_back_dept']) ? $_REQUEST['go_back_dept'] : [];
        if(!empty($go_back_dept))
        {
            for ($i=0; $i < count($go_back_dept); $i++) { 
                $this->db->insert('department_association', ['dept_id' => $id, 'related_dept_id' => $go_back_dept[$i], 'type' => 2, 'created_by' => $this->session->userdata('id')]);
            }
        }

        redirect('department');
    }

    public function fetch_record(){
        $result = array();
        $id = $_GET['id'];
        $sql_select = "SELECT * from department WHERE id =".$id;
        $res1 = $this->db->query($sql_select);
        if($res1){
            $row = $res1->result_array();
            $result['status'] = true;
            $result['message'] = 'Successfully fetch';
            $result['data'] = $row[0];

            $move_to_query = $this->db->query('SELECT related_dept_id FROM department_association WHERE type = 1 AND dept_id = '.$id);
            if($move_to_query->num_rows() > 0)
            {
                $move_to = array_column($move_to_query->result_array(), 'related_dept_id');
            }

            

            $go_back_query = $this->db->query('SELECT related_dept_id FROM department_association WHERE type = 2 AND dept_id = '.$id);
            if($go_back_query->num_rows() > 0)
            {
                $go_back = array_column($go_back_query->result_array(), 'related_dept_id');
            }

            

            $department = $this->db->query('SELECT * FROM `department`');
            if($department->num_rows() > 0)
            {
                $html = '';
                $html2 = '';
                $department = $department->result_array();
                
                foreach($department as $r)
                {
                    $selected = isset($move_to) && in_array($r['id'], $move_to) ? 'selected' : '';
                    $html .= '<option value="'.$r['id'].'" '.$selected.'>'.$r['dept_name'].'</option>';

                    $selected1 = isset($go_back) && in_array($r['id'], $go_back) ? 'selected' : '';
                    $html2 .= '<option value="'.$r['id'].'" '.$selected1.'>'.$r['dept_name'].'</option>';
                }
            }

            $result['move_to'] = $html;
            $result['go_back'] = $html2;
             

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
            $success = $this->db->delete('department');
            if($success)
            {
                $array['status'] = 'Success';
                echo json_encode($array);
            }
        }
    }

}
?>
