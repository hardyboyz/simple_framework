<?php
if( !defined( "_HARDYBOYZ_FRAMEWORK_" ) )
{
	header("HTTP/1.0 404 Not Found");
	exit();
}
global $content;
?>
<?php
if($json != true){
?>
 <!-- Page Content -->
  <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
<?php
}
?>
<?php
if(strpos($content['content'],".php") > 0){
	if(file_exists($config->config['templates'].$content['content'])){
		require ($config->config['templates'].$content['content']);
	}else{
		echo "<br>Module ".$content['content']. " not available";
	}
}else{
	echo $content['content'];
}
?>
<?php
if($json != true){
?>
           </div>
                </div>
            </div>
        </div>

<?php
}
?>
