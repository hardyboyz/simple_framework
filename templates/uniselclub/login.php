<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{	
	header("HTTP/1.0 404 Not Found");
	exit();
}

if(isset($_GET['signin'])){
	if(strlen($_POST['username']) > 0 || strlen($_POST['password']) > 0){
		echo cek_login($_POST['username'],$_POST['password']);
	}
}else{
?>

<form class="form-horizontal" id="frm-signin" method="post">
<div class="box">
<div class="boxheader"><h3 class="text-center"> <?= $config->config['sitename'] ?> </h3></div>

    <div class="form-group">
        <div class="col-xs-12 input-group">
		<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <input type="text" class="form-control" id="inputEmail" placeholder="Username" name="username" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 input-group">
		<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password" required>
        </div>
    </div>
    <div class="form-group">
        <div class="buttonreg">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </div>
</form>

<script>
$(document).ready(function(){
	$("form[id=frm-signin]").submit(function() {
		$.ajax({
			type: "POST",
			url: "?signin=true",
			data: $('form[id=frm-signin]').serialize(),
			success: function(info){
				display	= info.split(":::");
				if(display[1]!="Login Error."){
					window.location=display[1];
				}else{
					alert(display[1]);
					return false;
				}
			}			
		});
	return false;
	});
});
</script>
<?php
}
?>
