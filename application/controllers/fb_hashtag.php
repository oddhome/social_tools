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
	public function index()
	{
		error_reporting(0);
		$hashtag = $this->input->get('hashtag');
		$cache_file = 'uploads/hashtag.json';
		$url = 'http://www.facebook-hashtag.com/search/hashtag/' .$hashtag;

		echo '#' .$hashtag. ' Data From : ' .$url;
		echo '<hr />';

		$json_data = $this->curl_get($url);

		$data = json_encode($json_data,true);
		
		if (is_array($data))
		{

			$fp = fopen ($cache_file,'w');
			$fwrite($fp,$json_data,strlen($json_data));
			fclose($fp);
		}
		else
		{
			if (file_exists($cache_file))
			{
				$fp = fopen ($cache_file, 'rb');
				$json_data = fread($fp, filesize($cache_file));
				fclose($fp);
				#echo $json_data;
				$data = json_decode($json_data,true);
				#print_r ($data);
			}
			else
			{
				echo 'Read Error no cache file';
			}
		}

		if (is_array($data))
		{
			#print_r ($data);
			echo '<!-- Latest compiled and minified CSS -->
		}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
			echo '<table class="table table-bordered">';
			echo '<tr>';
			echo '<th>Users</th>';
			echo '<th>Content</th>';
			echo '<th>Likes</th>';
			echo '<th>Share</th>';
			echo '<th>Comment</th>';
			echo '</tr>';
			foreach ($data['result'] as $key => $value) {
				echo '<tr>';
				echo '<td>' .$value['user']. '</td>';
				echo '<td>' .$value['content']. '</td>';
				echo '<td>' .$value['likes']. '</td>';
				echo '<td>' .$value['shares']. '</td>';
				echo '<td>' .$value['comments']. '</td>';
				echo '</tr>';
			}
			echo '</table>';
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