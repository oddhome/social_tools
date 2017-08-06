<script type="text/javascript">
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
</script>
<div class="row">
  <div class="col-md-6">
  	<!-- Upload List -->
  	<?php
  		$files = get_dir_file_info($upload_dir,TRUE);
  		#print_r ($files);
  		echo '<table class="table table-bordered">';
  		echo '<tr>';
  		echo '<th>File Name</th>';
  		echo '<th>Update Time</th>';
  		echo '</tr>';
  		echo '<tr>';
  		echo '<td colspan="2">';
  		echo 'Grab file from <a href="http://www.facebook-hashtag.com" target="_blank">http://www.facebook-hashtag.com</a></hr >';
  		echo form_open_multipart('fb_hashtag/do_upload');
  		echo '<div class="input-group">';
  		echo '<input type="file" name="userfile" class="form-control">';
  		echo '<span class="input-group-btn">';
  		echo '<button class="btn btn-success">Upload</button>';
  		echo '</span>';
  		echo '</div>';
  		echo '</form>';
  		echo '</td>';
  		echo '</tr>';
  		foreach($files as $file)
  		{
  			if ($hashtag_file==$file['name'])
  			{
  				$class="success";
  				$fa = "fa fa-check-square-o";
  			}
  			else
  			{
  				$class='';
  				$fa = 'fa fa-square-o';
  			}
  			echo '<tr class="' .$class. '">';
  			echo '<td><span class="' .$fa. '"></span> <a href="' .site_url('fb_hashtag/index?hashtag_file=' .$file['name']). '">' .$file['name']. '</a></td><td width="150">' .date("Y-m-d H:i:s",$file['date']). '</td>';
  			echo '</tr>';
  		}
  		echo '</table>';
  	?>
  </div>
  <div class="col-md-6">
  	<?php
  		if ((isset($hashtag_file))&&(file_exists($upload_dir. '/' .$hashtag_file))&&($hashtag_file!=''))
  		{
  			$json_data = $this->fb_hashtag_model->read_hashtag_file($hashtag_file);

  			$data = json_decode($json_data,true);
  			echo '<table class="table table-bordered">';
  			echo '<tr>';
  			echo '<td width="150">Last Update</td>';
  			echo '<td>' .$data['updateTime']. '</td>';
  			echo '</tr>';
  			echo '<tr>';
  			echo '<td>Result</td>';
  			echo '<td>' .count($data['result']). '</td>';
  			echo '</tr>';
  			echo '<tr>';
  			echo '<td>Hashtag</td>';
  			echo '<td>' .$this->fb_hashtag_model->get_hashtag($json_data). '</td>';
  			echo '<tr>';
  			echo '</table>';
  		}
  	?>
  </div>
</div>

<?php
	if ((isset($hashtag_file))&&(file_exists($upload_dir. '/' .$hashtag_file))&&($hashtag_file!=''))
  	{
  		echo $this->fb_hashtag_model->get_hashtag_result($json_data);
  	}
?>
