<?php
class Members extends CI_Controller{
	var $title = "Line Social Members";

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{

	}

	function register()
	{
		$line_user_id = $this->input->get('user_id');
		$data = array(
			'line_user_id'=>$line_user_id,
		);
		$Data = $this->load->view('members/register',$data,true);
		$data['title'] = $this->title;
		$data['content'] = $Data;
		$this->load->view('master',$data);
	}
}