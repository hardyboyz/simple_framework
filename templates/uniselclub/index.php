<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{	
	header("HTTP/1.0 404 Not Found");
	exit();
}
?>
<?php 
$content = get_content2($default_url);
$json = isset($_GET['json']) ? true : false;
	if(sizeof($content) == 0){
	$content['content'] = "<div class='space'>Content not available</div>";
	$content['title_browser'] = "Content not available";
	}else{
	$content['title_browser'] = $content['title'].' - '.$config->config['sitename'];
	}
?>
<?php get_header($json); ?>
<?php get_content($json); ?>
<?php get_footer($json); ?>
