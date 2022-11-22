<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
		$this->load->view('dashboard/dashboard_view');
	}

}
?>
