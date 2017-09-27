<?php
class Wordpress_Model extends CI_Model{
	function __contruct()
	{
		parent::__contruct();
	}

	function get_picture($post_id)
	{
		$wp_get_post_url = 'http://www.iamcar.net/wp-json/wp/v2/posts/' .$post_id;
		$upload_dir = 'uploads/wp_pr';
		$picture_url = '';

		// if ($post_id==39554)
		// {
		

		if (!file_exists($upload_dir. '/' .$post_id. '.jpg'))
		{
			$json_data = $this->curl_post($wp_get_post_url);
			$data = json_decode($json_data,true);
			//print_r ($data['_links']);
			$wp_feature_media = $data['_links']['wp:featuredmedia'][0]['href'];

			$json_data = $this->curl_post($wp_feature_media);
			$data = json_decode($json_data,true);
			//print_r ($data);
			$picture_url = $data['guid']['rendered'];

			$picture_data = $this->curl_post($picture_url);
			$fp = fopen($upload_dir. '/' .$post_id. '.jpg','w+');
			fputs($fp,$picture_data);
			fclose($fp);
		}
		//}
		$picture_url = base_url(). '' .$upload_dir. '/' .$post_id. '.jpg';

		return $picture_url;
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