<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Render_dashboard extends CI_Controller
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
		$data['role_name'] = $this->db->query('SELECT role_name FROM role WHERE id = '.$this->session->userdata('user_role'))->result_array()[0]['role_name'];
		$this->load->view('dashboard/render_dashboard_view', $data);
	}

}
?>
