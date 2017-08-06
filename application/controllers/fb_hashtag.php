<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fb_Hashtag extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	var $title = "FB #Hashtag";
	var $upload_dir;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('form');

		$this->load->model('fb_hashtag_model');
		$this->upload_dir = $this->fb_hashtag_model->upload_dir;
	}

	public function index()
	{

		$data = array();
		$data['hashtag_file'] = $this->input->get('hashtag_file');
		$data['upload_dir'] = $this->upload_dir;
		
		#$Data = '';
		$Data = $this->load->view('fb_hashtag/index',$data,true);

		$data['title'] = $this->title;
		$data['content'] = $Data;
		$this->load->view('master',$data);
	}

	function do_upload()
	{
		$config['upload_path'] = $this->upload_dir;
		$config['allowed_types'] = '*';
		$config['max_size']	= '100';
		$config['file_name'] = date("YmdHis.json");

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
			//$this->load->view('upload_form', $error);
		}
		else
		{
			$data = $this->upload->data();
			redirect("fb_hashtag/index?hashtag_file=" .$data['file_name']);
			//$this->load->view('upload_success', $data);
		}
	}

	function curl_post($url, array $post = NULL, array $options = array()) 
	{ 
	    $defaults = array( 
	        CURLOPT_POST => 1, 
	        CURLOPT_HEADER => 0, 
	        CURLOPT_URL => $url, 
	        CURLOPT_FRESH_CONNECT => 1, 
	        CURLOPT_RETURNTRANSFER => 1, 
	        CURLOPT_FORBID_REUSE => 1, 
	        CURLOPT_TIMEOUT => 4, 
	        CURLOPT_POSTFIELDS => http_build_query($post) 
	    ); 

	    $ch = curl_init(); 
	    curl_setopt_array($ch, ($options + $defaults)); 
	    if( ! $result = curl_exec($ch)) 
	    { 
	        trigger_error(curl_error($ch)); 
	    } 
	    curl_close($ch); 
	    return $result; 
	} 

	function curl_get($url, array $get = NULL, array $options = array()) 
	{    
		if (is_array($get))
		{
			$defaults = array( 
		        CURLOPT_URL => $url. (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get), 
		        CURLOPT_HEADER => 0, 
		        CURLOPT_RETURNTRANSFER => TRUE, 
		        CURLOPT_TIMEOUT => 4 
		    ); 
		}
		else
		{
			$defaults = array( 
		        CURLOPT_URL => $url, 
		        CURLOPT_HEADER => 0, 
		        CURLOPT_RETURNTRANSFER => TRUE, 
		        CURLOPT_TIMEOUT => 4 
		    ); 
		}
	    
	    
	    $ch = curl_init(); 
	    curl_setopt_array($ch, ($options + $defaults)); 
	    if( ! $result = curl_exec($ch)) 
	    { 
	        trigger_error(curl_error($ch)); 
	    } 
	    curl_close($ch); 
	    return $result; 
	} 
}

/* End of file welcome.php */
/* Location: ./application/controllers/fb_hashtag.php */