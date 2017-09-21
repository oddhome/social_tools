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
	}

	function index()
	{

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
}