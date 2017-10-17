<?php
class Members extends CI_Controller{
	var $title = "Line Social Members";

	function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');

		$this->load->database();

		$this->load->model('members_model');
		$this->load->model('bot_model');
	}

	function index()
	{

	}

	function test_member()
	{
		$this->load->library('table');
		$data = array();
		$Data = $this->load->view('members/test_member',$data,true);
		$data['title'] = 'Test Members';
		$data['content'] = $Data;
		$this->load->view('master',$data);
	}

	function remove_test_member($members_id)
	{
		$this->db->where('members_id',$members_id);
		$this->db->update('members',array('test_group'=>0));
		redirect ('members/test_member');
	}

	function add_test_member($members_id)
	{
		$this->db->where('members_id',$members_id);
		$this->db->update('members',array('test_group'=>1));
		redirect ('members/test_member');
	}

	function register()
	{
		$line_user_id = $this->input->get('user_id');
		$data = array(
			'line_user_id'=>$line_user_id,
			'options'=>array(
				'top_bar'=>false,
				'left_side_bar'=>false,
			),
		);
		$Data = $this->load->view('members/register',$data,true);
		$data['title'] = 'Register';
		$data['content'] = $Data;
		$this->load->view('master',$data);
	}

	function do_save_register()
	{
		$data = $this->input->post();
		unset($data['conf_email']);
		#print_r ($data);
		if (is_array($data)) { extract($data); }
		if (isset($line_user_id))
		{
			$query = $this->members_model->query_line_user($line_user_id);
			if ($query->num_rows()>0)
			{
				$rows = $query->row();
				echo 'Error: User exists with email: ' .$rows->email;
			}
			else
			{
				$this->db->insert('members',$data);
				$id = $this->db->insert_id();
				echo 'Register Successful';
			}
		}
		else
		{
			echo 'Error: Can not direct access';
		}



	}

	function bot_pr()
	{
		$query = $this->members_model->query_all_active_users();
		if ($query->num_rows()>0)
		{
			foreach ($query->result() as $rows) {
				$this->db->from('bot_pr');
				$this->db->where('createdate >=',date("Y-m-d"). ' 00:00:00');
				$query_pr = $this->db->get();
				#echo $this->db->last_query();
				if ($query_pr->num_rows()>0)
				{
					foreach ($query_pr->result() as $rows_pr) {
						//Check is Pr Send ?
						$this->db->from('members_link_pr');
						$this->db->where('members_id',$rows->members_id);
						$this->db->where('bot_pr_id',$rows_pr->bot_pr_id);
						$query_check = $this->db->get();
						if ($query_check->num_rows()==0)
						{
							$picture_url = base_url(). 'uploads/wp_pr/' .$rows_pr->id. '.jpg';
							$baseurl = site_url('wp_pr/picture/' .$rows_pr->id);
							//Send Line Bot
							#$this->bot_model->send_message($rows->line_user_id,$rows_pr->title. ' รายละเอียด => ' .$rows_pr->link);
							$this->bot_model->send_message_imagemap($rows->line_user_id,$rows_pr->title,$baseurl,$rows_pr->link,$picture_url);


							//Save History
							$data = array(
								'members_id'=>$rows->members_id,
								'bot_pr_id'=>$rows_pr->bot_pr_id,
								'status'=>1,
							);
							$this->db->insert('members_link_pr',$data);
						}
					}
				}
			}
		}
	}
}