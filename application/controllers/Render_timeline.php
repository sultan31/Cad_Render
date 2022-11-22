<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Render_timeline extends CI_Controller
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
        $this->render_btn_permissions = $this->master_model->get_render_btn_permissions();
	}

	public function index($id = '')
	{
		$data['order_id'] = $id;
		$this->load->view('render_timeline/render_timeline_view', $data);
	}

}
?>
