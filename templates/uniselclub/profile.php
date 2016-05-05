<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<?php
//print_r($_SESSION);
if(isset($_GET['update'])){
		update_table("students",$_POST, $_SESSION['login']['student_id']);
	exit;
}else{
$applicant = get_student($_SESSION['login']['student_id']);
//print_r($_SESSION);
?>

<form class="form-horizontal" id="register-form" method="post">
<div class="box">

<div class="form-group">
<label class="control-label col-xs-12"><?= $content['title'] ?></label>
</div>

<div class="form-group">
		<label class="control-label col-xs-4" for="name">Name</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="name" name="name" tabindex="1" required value="<?php echo $applicant['name'] ?>"></div>
		</div>

		<?php if($_SESSION['login']['campus'] != '3') { ?>
		<div class="form-group">
		<label class="control-label col-xs-4" for="course">Course</label>
		<div class="col-xs-8"><input type="text" class="form-control" id="course" name="course" tabindex="1" required  value="<?php echo $applicant['course'] ?>"></div>
		</div>
		<?php } ?>

		<div class="form-group">
		<label class="control-label col-xs-4" for="matric"><?php echo $_SESSION['login']['campus'] == '3' ? 'IC No.' :  'Matric Card No.'; ?></label>
		<div class="col-xs-8"><input type="text" class="form-control" id="matric" name="matric" tabindex="1"  disabled  value="<?php echo $applicant['matric'] ?>"></div>
		</div>

		<div class="form-group">
			<label class="control-label col-xs-4" for="email">Email</label>
			<div class="col-xs-8"><input type="email" class="form-control" id="email" name="email" tabindex="1" required value="<?php echo $applicant['email'] ?>"></div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-xs-4" for="phone">Phone</label>
			<div class="col-xs-8"><input type="text" class="form-control" id="phone" name="phone" tabindex="1" required value="<?php echo $applicant['phone'] ?>"></div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-xs-4" for="status">Status</label>
			<div class="col-xs-8">
			<?php
				$status = array(0=>"Not Active",1=>"Active");
				foreach($status as $i =>$val){
						if($i == $applicant['status']){
							echo $val;
					}
				}
			?>
			</div>
		</div>

		<div class="form-group">
			<div class="buttonreg">
				<button type="submit" class="btn btn-primary" id="register">Update</button>
			</div>
		</div>	
		<hr>
		</form>
</div>

<script>
$(document).ready(function(){
	$("form#register-form").submit(function() {	
	$('#register').attr('disabled','disabled');
	$('#register').html('Updating your data. Please wait...');
		$.ajax({
			type: "POST",
			url: "?update=true",
			data: $('form[id=register-form]').serialize(),
			success: function(info){
				display	= info.split(":::");
				alert(display[1]);
				$('#register_success').fadeIn(1000);
				$('#register_success').text(display[1]);
				//$('#register-form').slideUp();
				//$('#register').removeAttr('disabled');
				$('#register').text(display[1]);
			},
			
		});
	return false;
	});
});
</script>
<?php
}
?>
