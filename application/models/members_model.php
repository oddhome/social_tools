<?php
class Members_Model extends CI_Model{
	var $table_name = 'members';
	function __construct()
	{
		parent::__construct();
	}

	function query_line_user($line_user_id)
	{
		$this->db->from($this->table_name);
		$this->db->where('line_user_id',$line_user_id);
		$query = $this->db->get();
		return $query;
	}
}