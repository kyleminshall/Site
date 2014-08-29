<?php


	$con=mysql_connect("localhost","KyleM","Minshall1!");
	$db_selected = mysql_select_db('Site', $con);
	
	$date = date("Y-m-d H:i:s");
	
	$q ="INSERT INTO OGs (last_login) VALUES ('$date')"; 
	$q2 = mysql_query($q) or trigger_error(mysql_error()." ".$q); 
	
	header("location: login.php");

	session_destroy();
	$cookieParams = session_get_cookie_params();
	setcookie(session_name(), '', 0, $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);
	$_SESSION = array();
?>