<?php
class Bot extends CI_Controller{
    //Line
    var $channel_secret;
    var $access_token;
    
    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->database();
        $this->load->model('members_model');

        $bot_name = $this->input->get('bot_name');
        switch ($bot_name)
        {
            default:
                $this->load->config('ideaplus');
            break;
        }

        $this->channel_secret = $this->config->item('line_channel_secret');
        $this->access_token = $this->config->item('line_access_token');

       
    }

    function index()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        
        $url = 'https://api.line.me/v2/bot/message/reply';
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $this->access_token);
		// Get POST body content
		$content = file_get_contents('php://input');
		// Parse JSON
		if ($content)
		{
			// $this->db->insert('questions',array('source'=>$content));
			// $q_id = $this->db->insert_id();
		}
		$events = json_decode($content, true);
		// Validate parsed JSON data
		if (!is_null($events['events'])) {
			// Loop through each event
			foreach ($events['events'] as $event) {
				$replyToken = $event['replyToken'];
				
				if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
					// Get text sent
					$text = $event['message']['text'];

					$user_id = $event['source']['userId'];
					if ($user_id=='')
					{
						$user_id = $event['message']['id'];
					}

					$data = [
						'from'=>$user_id,
						'replyToken' => $replyToken,
						'message'=>$text,
					];

					
					//answer with 1-to-1 chat
					if ($event['source']['type']=='user')
					{   
                        switch ($text)
                        {
                            case 'register':
                            	$query = $this->members_model->query_line_user($user_id);
                            	if ($query->num_rows()>0)
                            	{
                            		$result = $this->line_reply($replyToken,'Register Successful : คุณลงทะเบียนเรียบร้อยแล้ว');
                            	}
                            	else
                            	{
                            		$result = $this->line_reply($replyToken,'ลงทะเบียนกรุณากด :=> ' .site_url('members/register'). '?user_id=' .$user_id);
                            	}
                                
                            break;
                            default:
                                $result = $this->line_reply($replyToken,$text);
                            break;
                        }
                        
					}
					echo $result . "\r\n";
				}
			}
		}
		echo "OK";
    }

    function line_reply($replyToken,$text)
	{
		$url = 'https://api.line.me/v2/bot/message/reply';
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $this->access_token);
		
		if ((strpos($text,'http')!==false)&&(strpos($text,'10.225.208')!==false))
		{
			//Image
			$messages = [
				'type' => 'image',
				'originalContentUrl' => $text,
				'previewImageUrl'=>$text,
			];
		}
		elseif ((strpos($text,'http')!==false)&&(strpos($text,'.jpg')!==false))
		{
			//Image
			$messages = [
				'type' => 'image',
				'originalContentUrl' => $text,
				'previewImageUrl'=>$text,
			];
		}
		else
		{
			$messages = [
				'type' => 'text',
				'text' => $text
			];
		}

		$data = [
			'replyToken' => $replyToken,
			'messages' => [$messages],
		];

		$post = json_encode($data);
		
		// $this->db->where('replyToken',$replyToken);
		// $this->db->where('app_source','line');
		// $this->db->update('nn_questions',array('debug'=>$post));

		$result = $this->curl_post($url,$headers,$post);
		return $result;
    }

    function send()
    {
    	$url = 'https://api.line.me/v2/bot/message/push';
		$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $this->access_token);

		$this->db->from('bot_message');
		$this->db->where('send_status',0);
		$this->db->where('cron_date < "' .date("Y-m-d H:i:s"). '"');
		$this->db->order_by('msg_id','asc');
		$this->db->limit(20);
		$query = $this->db->get();
		if ($query->num_rows()>0)
		{
			foreach ($query->result() as $rows) {

				switch ($rows->type) {
					case 'imagemap':
						//Get Image Width , Height
						$size = getimagesize($rows->picture_url);
						#print_r ($size);
						$width = $size[0];
						$height = $size[1];

						// if (($width>1040)||($height>1040))
						// {
						// 	if ($width > $height)
						// 	{
						// 		$scale = 1040/$width;
						// 	}

						// 	if ($height > $width)
						// 	{
						// 		$scale = 1040/$height;
						// 	}

						// 	$width = $width * $scale;
						// 	$height = $height * $scale;
						// }

						
						$actions = [
							[
								'type' => 'uri',
								'linkUri' => $rows->url,
								'area' => [
									'x' => 0,
									'y' => 0,
									'width' => $width,
									'height' => $height,
								],
							],
						];

						$messages = [
							'type' => 'imagemap',
							'baseUrl' => $rows->baseurl,
							'altText' => $rows->message,
							'baseSize' => [
								'height' => $height,
								'width' => $width,
							],
							'actions' => $actions,
						];


						$data = [
							'to' => $rows->line_user_id,
							'messages' => [$messages],
						];
						#print_r ($data);
						#exit();
					break;
					case 'template':
						$actions = [
							[
								'type' => 'uri',
								'label' => 'View detail',
								'uri' => $rows->url
							],
						];

						$template = [
							'type' => 'buttons',
							'thumbnailImageUrl' => $rows->picture_url,
							'title' => 'menu',
							'text' => 'Please select',
							'actions' => $actions
						];

						$messages = [
							'type' => 'template',
							'altText' => "this is a buttons template",
							'template' => $template,
						];

						$data = [
							'to' => $rows->line_user_id,
							'messages' => [$messages],
						];
					break;
					
					default:
						$messages = [
							'type' => 'text',
							'text' => $rows->message
						];

						$data = [
							'to' => $rows->line_user_id,
							'messages' => [$messages],
						];
					break;
				}
				

				print_r ($data);
				$post = json_encode($data);
				$result = $this->curl_post($url,$headers,$post);

				if ($result=='{}')
				{
					$this->db->where('msg_id',$rows->msg_id);
					$this->db->update('bot_message',array('send_status'=>1,'send_date'=>date("Y-m-d H:i:s")));
				}

				echo $result . "\r\n";
			}
		}
    }
    
    function verify()
	{
		$url = 'https://api.line.me/v1/oauth/verify';
		$headers = array('Authorization: Bearer ' . $this->access_token);

		$result = $this->curl_post($url,$headers);

		echo $result;
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

    function test()
    {
        echo $this->access_token;
    }
}