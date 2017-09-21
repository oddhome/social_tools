<table class="table table-bordered">
<?php
	$Data = '';
	$json_data = json_decode($wp_contents,true);
	foreach ($json_data as $key => $value) {
		$Data .= '<tr>';
		$Data .= '<td><a href="' .$value['link']. '" target="_blank">' .$value['title']['rendered']. '</a></td>';
		$Data .= '<td width="60">';
		$Data .= '<form name="' .$value['id']. '" action="' .site_url('wp_pr/do_add_bot_pr'). '" method="post">';
		$Data .= '<input type="hidden" name="id" value="' .$value['id']. '">';
		$Data .= '<input type="hidden" name="title" value="' .$value['title']['rendered']. '">';
		$Data .= '<input type="hidden" name="link" value="' .$value['link']. '">';
		$Data .= '<input type="hidden" name="categories" value="' .implode(',',$value['categories']). '">';
		$Data .= '<button class="btn btn-success"><span class="fa fa-bullhorn"></span></button>';
		$Data .= '</form>';
		$Data .= '</td>';
		$Data .= '</tr>';
	}
	echo $Data;
?>
</table>