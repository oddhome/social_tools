<?php
class Members extends CI_Controller{
	var $title = "Line Social Members";

	function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
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
}