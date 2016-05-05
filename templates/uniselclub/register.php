<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<?php
if(isset($_GET['register'])){
	if(strlen($_POST['name']) > 0 || 
		strlen($_POST['matric']) > 0 || 
		strlen($_POST['course']) > 0 || 
		strlen($_POST['phone']) > 0)
	{
		$params=array();
		$params=$_POST;
		registration("students",$params);
	}
	else
	{
		echo "Registration Failed. Please fill up the form provided. Thank you.<br/> <input type='button' class='btn btn-default' value='Back' onclick=\"window.location='self.history.back()'\">";
	}
	exit;
}else{

?>
<div class="alert alert-info" id="register_success" style="display:none"></div>
<form class="form-horizontal" id="register-form" method="post">
<div class="box">
<div class="boxheader"><h3 class="text-center"> <?= $config->config['sitename'] ?> </h3></div>

<div class="form-group">
<label class="control-label col-xs-12">Registration Form</label>
</div>

<div class="form-group">
<label class="control-label col-xs-4" for="name">Name</label>
<div class="col-xs-8"><input type="text" class="form-control" id="name" name="name" tabindex="1" required></div>
</div>

<div class="form-group">
<label class="control-label col-xs-4" for="campus">Register as</label>
	<div class="col-xs-8">
		<select name="campus" class="form-control" id="campus">
		<option value="1">Student Unisel Bestari Jaya</option>
		<option value="2">Student Unisel Shah Alam</option>
		<option value="3">Volunter</option>
		</select>	
	</div>
</div>

<div class="form-group" id="block_course">
<label class="control-label col-xs-4" for="course">Course</label>
<div class="col-xs-8"><input type="text" class="form-control" id="course" name="course" tabindex="1"></div>
</div>

<div class="form-group">
<label class="control-label col-xs-4" for="matric" id="lmatric">Matric Card No.</label>
<div class="col-xs-8"><input type="text" class="form-control" id="matric" name="matric" tabindex="1"></div>
</div>

<div class="form-group">
<label class="control-label col-xs-4" for="phone">Phone</label>
<div class="col-xs-8"><input type="text" class="form-control" id="phone" name="phone" tabindex="1" required></div>
</div>

<div class="form-group">
	<label class="control-label col-xs-4" for="email">Email</label>
	<div class="col-xs-8"><input type="email" class="form-control" id="email" name="email" tabindex="1" required></div>
</div>

<div class="form-group">
	<label class="control-label col-xs-4" for="password">Password</label>
	<div class="col-xs-8"><input type="password" class="form-control" id="password" name="password" tabindex="1" required></div>
</div>

<div class="form-group">
	<label class="control-label col-xs-4" for="password2">Confirm Password</label>
	<div class="col-xs-8"><input type="password" class="form-control" id="password2" name="password2" tabindex="1" required></div>
</div>

<div class="form-group">
	<div class="buttonreg">
		<button type="submit" class="btn btn-primary">Register</button>
	</div>
</div>	
<hr>
</form>

</div>
<script>
$(document).ready(function(){
	
	$("#campus").change(function(){
		if($("#campus").val() == "3"){
			$("#block_course").hide();
			$("#lmatric").html('IC No.');
		}else{
			$("#block_course").show();
			$("#lmatric").html('Matric Card No.');
		}
	});
	
	$("form#register-form").submit(function() {	
	pass1 = $("#password").val();
	pass2 = $("#password2").val();
	if(pass1 != pass2){
		alert('Your Password and Confirm Password is different.');
		return false;
	}
	$('#register').attr('disabled','disabled');
	$('#register').html('Registering your data. Please wait...');
		$.ajax({
			type: "POST",
			url: "?register=true",
			data: $('form[id=register-form]').serialize(),
			success: function(info){
				display	= info.split(":::");
				alert(display[1]);
				$('#register_success').fadeIn(1000);
				$('#register_success').text(display[1]);
				$('#register-form').slideUp();
			},
			
		});
	return false;
	});
});
</script>
<?php
}
?>
