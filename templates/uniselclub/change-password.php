<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<?php
if(isset($_GET['change-password'])){
	if(strlen($_POST['password2']) > 0 || strlen($_POST['password']) > 0)
	{
		$params['password'] = md5($_POST['password']);
		update("users","student_id",$_SESSION['login']['id'],$params);
	}
	else
	{
		echo "Registration Failed. Please fill up the form provided. Thank you.<br/> <input type='button' class='btn btn-default' value='Back' onclick=\"window.location='self.history.back()'\">";
	}
	exit;
}else{

?>
<div class="alert alert-info" id="register_success" style="display:none"></div>
<form class="form-horizontal" id="change-password-form" method="post">
<div class="box">

<div class="form-group">
<label class="control-label col-xs-12"><?php echo $content['title'] ?></label>
</div>

<div class="form-group">
	<label class="control-label col-xs-4" for="password">New Password</label>
	<div class="col-xs-8"><input type="password" class="form-control" id="password" name="password" tabindex="1" required></div>
</div>

<div class="form-group">
	<label class="control-label col-xs-4" for="password2">Confirm New Password</label>
	<div class="col-xs-8"><input type="password" class="form-control" id="password2" name="password2" tabindex="1" required></div>
</div>

<div class="form-group">
	<div class="buttonreg">
		<button type="submit" class="btn btn-primary" id="update-password">Change Password</button>
	</div>
</div>	
<hr>
</form>

</div>
<script>
$(document).ready(function(){
	$("form#change-password-form").submit(function() {	
	pass1 = $("#password").val();
	pass2 = $("#password2").val();
	if(pass1 != pass2){
		alert('Your Password and Confirm Password is different.');
		return false;
	}
	$('#update-password').attr('disabled','disabled');
	$('#update-password').html('Changing your password. Please wait...');
		$.ajax({
			type: "POST",
			url: "?change-password=true",
			data: $('form[id=change-password-form]').serialize(),
			success: function(info){
				display	= info.split(":::");
				alert(display[1]);
				$('#register_success').fadeIn(1000);
				$('#register_success').text(display[1]);
				$('#change-password-form').slideUp();
			},
			
		});
	return false;
	});
});
</script>
<?php
}
?>
