<?php
class Wp_Pr extends CI_Controller{
	var $title = "Wordpress Line PR";
	var $wp_json_posts = 'http://www.iamcar.net/wp-json/wp/v2/posts';
	//var $wp_json_posts = 'http://www.iamcar.net/wp-json/wp/v2/posts?per_page=20&after=' .date("Y-m"). '-01T00:00:00';

	function __construct()
	{
		parent::__construct();

		$this->load->helper('html');
		$this->load->helper('url');

		$this->load->model('wordpress_model');

		$this->load->database();

		$last_month = new DateTime();
		$last_month->modify("-1 Month");

		$this->wp_json_posts = 'http://www.iamcar.net/wp-json/wp/v2/posts?per_page=100&after=' .$last_month->format("Y-m"). '-01T00:00:00';
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

	function picture($post_id,$set_width=0)
	{
		$target_filename_here = 'uploads/wp_pr/' .$post_id. '_' .$set_width. '.jpg';
		if (!file_exists($target_filename_here))
		{

			$fn = base_url(). 'uploads/wp_pr/' .$post_id. '.jpg';
			$size = getimagesize($fn);

			$width = $size[0];
			$height = $size[1];

			if (($width>$set_width)||($height>$set_width))
			{
				if ($width > $height)
				{
					$scale = $set_width/$width;
				}

				if ($height > $width)
				{
					$scale = $set_width/$height;
				}

				$width = $width * $scale;
				$height = $height * $scale;
			}
			$src = imagecreatefromstring(file_get_contents($fn));
			$dst = imagecreatetruecolor($width,$height);
			imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
			imagedestroy($src);
			imagepng($dst,$target_filename_here);
		}

		$fp = fopen($target_filename_here,'r');
		$data = fread($fp,filesize($target_filename_here));
		header('Content-Type: image/png');
		echo $data;
	}

	function do_add_bot_pr_test()
	{
		$this->load->model('bot_model');
		$data = $this->input->post();
		print_r ($data);
		#exit();
		$line_user_id = 'U51a848aa434a3bebdd9f517f17f0e160';
		$picture_url = base_url(). 'uploads/wp_pr/' .$data['id']. '.jpg';
		$baseurl = site_url('wp_pr/picture/' .$data['id']);

		$this->db->from('members');
		$this->db->where('test_group',1);
		$query = $this->db->get();

		if ($query->num_rows()>0)
		{
			foreach ($query->result() as $rows) {
				#$this->bot_model->send_message($line_user_id,$data['title']. ' รายละเอียด => ' .$data['link']);
				$this->bot_model->send_message_imagemap($rows->line_user_id,$data['title'],$baseurl,$data['link'],$picture_url);
			}
		}
		
		redirect('wp_pr/list_contents');

	}

	function do_add_bot_pr()
	{
		$data = $this->input->post();
		print_r ($data);

		$this->db->insert('bot_pr',$data);
		redirect('wp_pr/list_contents');
	}

	function curl_post($url,$headers='',$post=''){ return $this->wordpress_model->curl_post($url,$headers,$post); }
}