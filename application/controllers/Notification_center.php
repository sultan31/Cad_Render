<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_center extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_id') == '')
        {
            redirect('login');
        }
        $this->role_permissions = $this->master_model->get_role_permissions();
    }

    public function index()
    {
        $this->load->view('notification_center/notification_center_view');
    }
    

}
?>
