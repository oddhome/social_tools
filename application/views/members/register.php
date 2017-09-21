<script type="text/javascript">
	$(function(){
		$("#email").on("keyup",function(){
			debug_email();
		});

		$("#email").blur(function(){
			debug_email();
		});

		$("#conf_email").on("keyup",function(){
			debug_email();
		});

		$("#conf_email").blur(function(){
			debug_email();
		});
	});	

	function debug_email()
	{
		var email_master = $("#email").val();
		var conf_email = $("#conf_email").val();
		if (email_master.length>0)
		{
			if (email_master == conf_email)
			{
				$("#debug_email").text("Email Match");
				$("#debug_email").css("color","green");
			}
			else
			{
				$("#debug_email").text("Email Not Match");
				$("#debug_email").css("color","red");
			}
		}
	}
</script>

<form name="frm_register" action="<?php echo site_url('members/do_save_register'); ?>" method="post">
	<input type="hidden" name="line_user_id" value="<?php echo $line_user_id; ?>">
	<div class="input-group">
  		<span class="input-group-addon" id="basic-addon1">Email*</span>
		<input type="text" name="email" id="email" value="" class="form-control" required>
	</div>
	<div class="input-group">
  		<span class="input-group-addon" id="basic-addon1">Confirm Email*</span>
		<input type="text" name="conf_email" id="conf_email" value="" class="form-control" required>
	</div>
	<span id="debug_email"></span>
	<div class="input-group">
  		<span class="input-group-addon" id="basic-addon1">Facebook ID</span>
		<input type="text" name="fb_id" value="" class="form-control">
	</div>
	<div class="input-group">
  		<span class="input-group-addon" id="basic-addon1">Mobile</span>
		<input type="text" name="mobile" value="" class="form-control">
	</div>
	<button class="btn btn-success"><span class="fa fa-check"></span> Register</button>
</form>