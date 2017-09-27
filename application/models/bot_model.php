<?php
class Bot_Model extends CI_Model{
	function __construct()
	{
		parent::__construct();
	}

	function send_message_imagemap($line_user_id,$message,$baseurl,$url,$picture_url,$cron_date='')
	{
		if ($cron_date=='') $cron_date = date("Y-m-d H:i:s");
		$data = array(
			'line_user_id'=>$line_user_id,
			'type'=>'imagemap',
			'message'=>$message,
			'baseurl'=>$baseurl,
			'url'=>$url,
			'picture_url'=>$picture_url,
			'cron_date'=>$cron_date
		);
		$this->db->insert('bot_message',$data);
	}

	function send_message_template($line_user_id,$message,$url,$picture_url,$cron_date='')
	{
		if ($cron_date=='') $cron_date = date("Y-m-d H:i:s");
		$data = array(
			'line_user_id'=>$line_user_id,
			'type'=>'template',
			'message'=>$message,
			'url'=>$url,
			'picture_url'=>$picture_url,
			'cron_date'=>$cron_date
		);
		$this->db->insert('bot_message',$data);
	}

	function send_message($line_user_id,$message,$cron_date='')
	{
		if ($cron_date=='') $cron_date = date("Y-m-d H:i:s");
		$data = array(
			'line_user_id'=>$line_user_id,
			'message'=>$message,
			'cron_date'=>$cron_date
		);
		$this->db->insert('bot_message',$data);
	}
}