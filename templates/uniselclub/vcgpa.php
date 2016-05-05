<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{	
	header("HTTP/1.0 404 Not Found");
	exit();
}
//print_r($_SESSION);
if(isset($_GET['vcgpa'])){
	if(strlen($_POST['vcgpa']) > 0){
		update("students","id",$_SESSION['login']['id'],$_POST);
		$_SESSION['login']['vcgpa'] = $_POST['vcgpa'];
	}
}else{
?>
<div class="alert alert-info" id="vcgpa_success" style="display:none"></div>
<form class="form-horizontal" id="frm-vcgpa" method="post">
<div class="box">
<div class="boxheader"><h3 class="text-center"> <?= $config->config['sitename'] ?> </h3></div>

    <div class="form-group">
        <div class="col-xs-12 input-group">
		<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <input type="text" class="form-control" id="inputVCGPA" placeholder="VCGPA" name="vcgpa" required value="<?php echo $_SESSION['login']['vcgpa'] ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="buttonreg">
            <button type="submit" class="btn btn-primary">SAVE</button>
        </div>
    </div>
</form>

<script>
$(document).ready(function(){
	$("form[id=frm-vcgpa]").submit(function() {
		$.ajax({
			type: "POST",
			url: "?vcgpa=true",
			data: $('form[id=frm-vcgpa]').serialize(),
			success: function(info){
				display	= info.split(":::");
				alert(display[1]);
				$('#vcgpa_success').fadeIn(1000);
				$('#vcgpa_success').text(display[1]);
			},
		});
	return false;
	});
});
</script>
<?php
}
?>
