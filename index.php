<?php
session_start();
define( '_HARDYBOYZ_FRAMEWORK_','If you didnt define this, then your files are not secure.');

require_once ("./config/config.php");

$config = new Config();
$default_url = "home";
if($_GET['url']!="index.php") $default_url = $_GET['url'];

require_once ($config->config['functions']);

require_once ($config->config['class']."db.php");

$db = new MysqliDb($config->db['host'], $config->db['username'],$config->db['password'], $config->db['dbname'] );

require_once ($config->config['templates'].'index.php');

exit();

?>
