<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		$this->load->view('login_view');
	}


	public function check_login()
	{
		$emailaddress = $_POST['emailaddress'];
		$password = $_POST['password'];


		$res = $this->db->get_where('users', ['email_id' => $emailaddress, 'password' => $password, 'delete_flag' => 0, 'active' => 1]);

		if($res->num_rows() > 0)
		{
			$row = $res->result_array();
			$DB_Password = $row[0]['password'];
			$mobile_no = $row[0]['mobile_no'];
			$emailaddress = $row[0]['email_id'];
			$id = $row[0]['id'];
			$user_role = $row[0]['user_role']; 

			$full_name = $row[0]['full_name'];

			$newdata = ['user_id' => $id, 'mobile_no' => $mobile_no, 'full_name' => $full_name, 'emailaddress' => $emailaddress, 'user_role' => $user_role];

			if($DB_Password == $password)
			{
				$this->session->set_userdata($newdata);

				$this->db->insert('last_login', ['user_id' => $id, 'user_role' => $user_role, 'last_login_date' => date('Y-m-d')]);

				if($this->session->userdata('user_role') == '1' || $this->session->userdata('user_role') == '3' || $this->session->userdata('user_role') == '5' || $this->session->userdata('user_role') == '6' || $this->session->userdata('user_role') == '8' || $this->session->userdata('user_role') == '11')
				{
					redirect('dashboard');
				}
				else if($this->session->userdata('user_role') == '4' || $this->session->userdata('user_role') == '7')
				{
					redirect('render_dashboard');
				}
				else if($this->session->userdata('user_role') == '10')
				{
					redirect('render_production_orders');
				}
				else if($this->session->userdata('user_role') == '2')
				{
					redirect('designer_dashboard');
				}
				else
				{
					redirect('portal_orders');
				}
				
			}
			else{


				$message = "Invalid Password!";
				$this->session->set_flashdata('message', $message);
				redirect("login");
			}

		}
		else{
			$message = 'Invalid Email Id or Password!';

			$this->session->set_flashdata('message', $message);
			redirect("login");
		}

	}


	public function logout()
	{
		if($this->session->userdata('user_id') == '')
		{
			redirect('login');
		}
		$this->session->sess_destroy();
		redirect(base_url());
	}


}
?>
