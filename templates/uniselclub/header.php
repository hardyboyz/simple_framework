<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{
	header("HTTP/1.0 404 Not Found");
	exit();
}
global $content;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $content['title_browser'] ?></title>

    <!-- Bootstrap Core CSS -->
	<link href="<?php echo $config->url.$config->config['templates'] ?>css/jquery-ui.css" rel="stylesheet">
    <link href="<?php echo $config->url.$config->config['templates'] ?>css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $config->url.$config->config['templates'] ?>css/styles.css" rel="stylesheet">
	<link href="<?php echo $config->url.$config->config['templates'] ?>css/simple-sidebar.css" rel="stylesheet">
	

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	    <!-- jQuery Version 1.11.1 -->
	<script src="<?php echo $config->url.$config->config['templates'] ?>js/jquery.min.js"></script>
    <script src="<?php echo $config->url.$config->config['templates'] ?>js/jquery.js"></script>
	<script src="<?php echo $config->url.$config->config['templates'] ?>js/jquery-ui.js"></script>
	

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $config->url.$config->config['templates'] ?>js/bootstrap.min.js"></script>
	
	<?php if(isset($_SESSION['login'])){ ?>
	<script>
	function logout(){
		x=confirm('Are you sure want to logout?');
		if(x==true){
			window.location='?logout=true';
		}
	}
	</script>
	<?php } ?>

</head>

<body style="background:url('<?= $config->config['templates'].'images/background.jpg' ?>'); background-size:cover">
	

    <!-- Navigation -->
	<?php 
	$color = "#E17FE4";
	if(isset($_SESSION['login'])){
		$color = $_SESSION['login']['groups'] == 1 ? "#0E23B8" : "#E17FE4"; //print_r($_SESSION['login'][0]);
	}
	?>
	<div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="<?php echo $config->url ?>">
                        <?php echo $config->config['sitename'] ?>
                    </a>
                </li>
                 <?php echo get_menu_top();
			    if(isset($_SESSION['login'])){
				    $username = $_SESSION['login']['username'] == "admin" || $_SESSION['login']['username'] == "adminbt" || $_SESSION['login']['username'] == "adminsa"
					? $_SESSION['login']['username'] 
					: $_SESSION['login']['name'];
				    
				    echo "<li><a href='#' onclick='logout()'>Hi, ".$username.". Logout</a></li>";
			    }
		    ?>	
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
