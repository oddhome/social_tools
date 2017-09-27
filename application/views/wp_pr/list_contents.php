<script type="text/javascript">
	$(function(){
		$(".form_submit").submit(function(){
			if (confirm("คุณแน่ใจที่จะดำเนินการประชาสัมพันธ์กิจกรรม"))
			{
				return true;
			}
			else
			{
				return false;
			}
			
		});
	});
</script>
<table class="table table-bordered">
	<tr>
		<th width="100">Picture</th>
		<th>Title</th>
		<th width="60">PR Count</th>
		<th width="60">User Receive</th>
		<th width="120">Tools</th>
	</tr>
<?php
	$Data = '';
	$json_data = json_decode($wp_contents,true);
	foreach ($json_data as $key => $value) {
		$Data .= '<tr>';
		$Data .= '<td><img src="' .$this->wordpress_model->get_picture($value['id']). '" width="100"></td>';
		$Data .= '<td><a href="' .$value['link']. '" target="_blank">' .$value['title']['rendered']. '</a><br /><label class="label label-default">' .$value['date']. '</label></td>';
		$this->db->select('bot_pr_id');
		$this->db->from('bot_pr');
		$this->db->where('id',$value['id']);
		$query = $this->db->get();
		$pr_count = $query->num_rows();
		$Data .= '<td align="center">' .$pr_count. '</td>';
		$bot_pr_id = 0;
		$user_receive = 0;
		if ($query->num_rows()>0)
		{
			$rows = $query->row_array();
			$bot_pr_id = $rows['bot_pr_id'];

			$this->db->from('members_link_pr');
			$this->db->where_in('bot_pr_id',$bot_pr_id);
			$query = $this->db->get();
			$user_receive = $query->num_rows();
		}
		
		
		$Data .= '<td align="center">' .$user_receive. '</td>';
		$Data .= '<td>';
		//Test
		$Data .= '<form name="test_' .$value['id']. '" class="form_submit" action="' .site_url('wp_pr/do_add_bot_pr_test'). '" method="post">';
		$Data .= '<input type="hidden" name="id" value="' .$value['id']. '">';
		$Data .= '<input type="hidden" name="title" value="' .$value['title']['rendered']. '">';
		$Data .= '<input type="hidden" name="link" value="' .$value['link']. '">';
		$Data .= '<input type="hidden" name="categories" value="' .implode(',',$value['categories']). '">';
		$Data .= '<button class="btn btn-warning"><span class="fa fa-bullhorn"></span> Test</button>';
		$Data .= '</form><br />';

		//Real
		$Data .= '<form name="' .$value['id']. '" class="form_submit" action="' .site_url('wp_pr/do_add_bot_pr'). '" method="post">';
		$Data .= '<input type="hidden" name="id" value="' .$value['id']. '">';
		$Data .= '<input type="hidden" name="title" value="' .$value['title']['rendered']. '">';
		$Data .= '<input type="hidden" name="link" value="' .$value['link']. '">';
		$Data .= '<input type="hidden" name="categories" value="' .implode(',',$value['categories']). '">';
		$Data .= '<button class="btn btn-success"><span class="fa fa-bullhorn"></span> Send</button>';
		$Data .= '</form>';
		$Data .= '</td>';
		$Data .= '</tr>';
	}
	echo $Data;
?>
</table>