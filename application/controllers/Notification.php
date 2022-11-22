<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
	}

	
	public function fetch()
	{
		if(isset($_REQUEST['view'])){

			if($_REQUEST["view"] != '')
			{
			   $this->db->query("UPDATE comments SET comment_status = 1 WHERE comment_status=0");
			   
			}

			$result = $this->db->query("SELECT * FROM comments WHERE comment_status = 0 ORDER BY id DESC LIMIT 5");
			$output = '';
			if($result->num_rows() > 0)
			{
				
				$row = $result->result_array();
				foreach ($row as $key => $value) 
				{
					$active = $key == 0 ? 'active' : '';
					 $output .= '
								  <a href="'.base_url().'admin/notification" class="list-group-item list-group-item-action '.$active.'">
	                                                <div class="notification-info">
	                                                    
	                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">'.$value['subject'].'</span>'.$value['comment'].'
	                                                        <div class="notification-date">'.date('d F Y', strtotime($value['created_date'])).'</div>
	                                                    </div>
	                                                </div>
	                                            </a>
								  ';
				}
				
			}
			else
			{
			    $output .= '<li><a href="#" class="text-bold text-italic text-center">No Notification Found</a></li>';
			}
			
			$result_query = $this->db->query("SELECT * FROM comments WHERE comment_status = 0");
			$count = $result_query->num_rows();
			$data = array(
			   'notification' => $output,
			   'unseen_notification'  => $count
			);
			echo json_encode($data);


		}

		
		
	}

	public function index()
	{
		$this->load->view('admin/notification/notification_view');
	}
	
}
?>
