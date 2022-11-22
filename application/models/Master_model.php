<?php
class Master_model extends CI_Model
{

    public function get_one_record($table, $field, $id)
    {
        $result = $this->db->select($field)->get_where($table, ['id' => $id])->result_array();
        if(!empty($result))
        {
            return $result[0][$field];
        }
        else{
            return '';
        }

    }

    public function insert_entry()
    {
        $this->title    = $_POST['title']; // please read the below note
        $this->content  = $_POST['content'];
        $this->date     = time();

        $this->db->insert('entries', $this);
    }

    public function update_entry()
    {
        $this->title    = $_POST['title'];
        $this->content  = $_POST['content'];
        $this->date     = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

    public function get_role_permissions()
    {
        $result = [];
        $role_permissions = $this->db->get_where('role_permissions', ['role_id' => $this->session->userdata('user_role')])->result_array();
        foreach ($role_permissions as $key => $value) 
        {
            $result[$value['menu_shortcode']] = ['add_perm' => $value['add_perm'], 'view_perm' => $value['view_perm'], 'edit_perm' => $value['edit_perm'], 'delete_perm' => $value['delete_perm']];
        }

        return $result;
    }

    public function get_btn_permissions()
    {
        $result = [];
        $btn_permissions = $this->db->get_where('btn_permissions', ['role_id' => $this->session->userdata('user_role')])->result_array();
        foreach ($btn_permissions as $key => $value) 
        {
            $result[$value['btn_shortcode']] = ['view_perm' => $value['view_perm']];
        }

        return $result;
    }

    public function get_render_btn_permissions()
    {
        $result = [];
        $render_btn_permissions = $this->db->get_where('render_btn_permissions', ['role_id' => $this->session->userdata('user_role')])->result_array();
        foreach ($render_btn_permissions as $key => $value) 
        {
            $result[$value['btn_shortcode']] = ['view_perm' => $value['view_perm']];
        }

        return $result;
    }

    

}
?>