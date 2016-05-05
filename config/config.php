<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{
	header("HTTP/1.0 404 Not Found");
	exit();
}

class Config {
	var $url 	= 'http://localhost/uniselclub/';
	var $config = array('sitename'	=> "Comnet Portal System",
						'includes'	=> 	"includes/",
						'templates'	=> 	"templates/uniselclub/",
						'class'	=> 	"class/",
						'functions'	=>  "functions/function.php",
						'plugins'	=>  "plugins/",
						'uploads'	=>  "includes/uploads/"
					);
					
	var $db = array(	'host'		=> "localhost",
						'username'	=>	"root",
						'password'	=> 	"",
						'dbname'	=>  "uniselclub"
					);
}
?>
