<?php
class Fb_Hashtag_Model extends CI_Model{
	var $upload_dir = 'uploads/fb_hashtag/'; 

	function __construct(){
		parent::__construct();
	}

	function get_hashtag_result($json_data)
	{
		$data = json_decode($json_data,true);

		$Data = '<table class="table table-bordered">';
		$Data .= '<tr>';
		$Data .= '<th>Users</th>';
		$Data .= '<th>Content</th>';
		$Data .= '<th width="50" align="center"><span class="fa fa-thumbs-up" data-toggle="tooltip" data-placement="top" title="Likes"></span></th>';
		$Data .= '<th width="50" align="center"><span class="fa fa-share" data-toggle="tooltip" data-placement="top" title="Share"></span></th>';
		$Data .= '<th width="50" align="center"><span class="fa fa-thumbs-up" data-toggle="tooltip" data-placement="top" title="Comment"></span></th>';
		$Data .= '</tr>';
		foreach ($data['result'] as $key => $value) {
			$Data .= '<tr>';
			$Data .= '<td>' .$value['user']. '</td>';
			$Data .= '<td><a href="https://www.facebook.com/' .$value['userID']. '/posts/' .$value['postID']. '" target="_blank">' .$value['content']. '</a><br />' .date("Y-m-d H:i:s",$value['created']). '</td>';
			$Data .= '<td>' .$value['likes']. '</td>';
			$Data .= '<td>' .$value['shares']. '</td>';
			$Data .= '<td>' .$value['comments']. '</td>';
			$Data .= '</tr>';
		}
		$Data .= '</table>';

		return $Data;
	}

	function get_hashtag($json_data)
	{
		$check_data = array();
		$hashtag = '';
		$data = json_decode($json_data,true);

		$iLoop = 0;
		foreach ($data['result'] as $key => $value) {
			$end_pos = 0;
			$content = $value['content'];

			#echo $content;
			$array_data = explode(" ", $content);
			foreach ($array_data as $key => $hashtag) {
				if (strpos($hashtag,'#')===FALSE)
				{
					unset($array_data[$key]);
				}
				else
				{
					if (!isset($check_data[strtolower($hashtag)]))
					{
						$check_data[strtolower($hashtag)] = 1;
					}
					else
					{
						$check_data[strtolower($hashtag)] = $check_data[strtolower($hashtag)]+1;
					}
				}

			}
			#print_r ($array_data);
			#echo '<br />';
		}

		//Check Max Hashtag
		#rsort($check_data);
		#print_r ($check_data);
		$max = 0;
		foreach ($check_data as $key => $value) {
			if ($value>$max)
			{
				$max = $value;
				$hashtag = $key;
			}
		}

		return $hashtag;
	}

	function read_hashtag_file($hashtag_file)
	{
		$fp = fopen($this->upload_dir. '/' .$hashtag_file,'r');
		$json_data = fread($fp, filesize($this->upload_dir. '/' .$hashtag_file));
		fclose($fp);

		return $json_data;
	}
}