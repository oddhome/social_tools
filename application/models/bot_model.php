<?php
class Bot_Model extends CI_Model{
	function __construct()
	{
		parent::__construct();
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