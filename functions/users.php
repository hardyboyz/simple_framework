<?php

function register_user($register_data){
  array_walk($register_data, 'array_sanitize');


  $fields ='`' . implode('`, `', array_keys($register_data)) . '`';

  $data = '\'' . implode('\', \'', $register_data) . '\'';


  mysql_query("INSERT INTO users ($fields) VALUES ($data)");
}


function email_exists($email){
  $email = sanitize($email);
  return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `user` WHERE `email` = '$email'"), 0) == 1) ? true: false;

}



function change_password($user_id, $password){
       $user_id = (int)$user_id;
       $password = md5($password);

       mysql_query("UPDATE user SET password='$password' WHERE user_id=$user_id");
}

function admin($username){
  $username = ($username);

  $query = mysql_query("SELECT  `username` = '$username' FROM user WHERE type = 1");

  return(mysql_result($query, 0) == 1) ? true : false;
}

 function user_data($idno){
   $data = array();
   $idno = (int)$idno;

   //$func_num_args = func_num_args();
   //$func_get_args = func_get_args();

   //if ($func_num_args > 1) {
     // unset($func_get_args[0]);

      //$fields = '`' . implode('` , `', $func_get_args) . '`';
	  $query=mysql_query("SELECT * FROM user WHERE user_id='".$idno."'");
      $data = mysql_fetch_assoc($query);

      return $data;
  //}

 }

  function user_exists($username){
   $query = mysql_query("SELECT COUNT(`user_id`) FROM `user` WHERE `username`='$username'");
   return (mysql_result($query, 0) == 1) ? true : false;
  }

  function user_id_from_username($username){
     return mysql_result(mysql_query("SELECT user_id FROM user WHERE username='$username'"), 0, 'user_id');

  }

  function login($username, $password){
    $user_id = user_id_from_username($username);

    $password 	= md5($password);
	$query		= mysql_query("SELECT * FROM user WHERE username='$username' AND password='$password'");
	$data		= array();
	$data		= mysql_fetch_assoc($query);
	
	return $data;
    
  }

  function logged_in(){
   return (isset($_SESSION['idn'])) ? true : false;

  }
?>