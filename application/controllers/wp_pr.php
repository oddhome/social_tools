<?php
class Wp_Pr extends CI_Controller{
	var $title = "Wordpress Line PR";
	var $wp_json_posts = 'http://www.iamcar.net/wp-json/wp/v2/posts';
	function __construct()
	{
		parent::__construct();

		$this->load->helper('html');
		$this->load->helper('url');

		$this->load->database();
	}

	function index()
	{
		redirect('wp_pr/list_contents');
	}

	function list_contents()
	{
		$wp_contents = $this->curl_post($this->wp_json_posts);
		$data = array(
			'wp_contents'=>$wp_contents,
		);
		$Data = $this->load->view('wp_pr/list_contents',$data,true);
		$data['title'] = $this->title;
		$data['content'] = $Data;
		$this->load->view('master',$data);
	}

	function do_add_bot_pr()
	{
		$data = $this->input->post();
		print_r ($data);
	}

	function curl_post($url,$headers='',$post='')
	{
		$ch = curl_init($url);
		#curl_setopt($ch, CURLOPT_ENCODING ,"UTF-8");
		if ($post!='')
		{
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		else
		{
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if ($headers!='')
		{
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}