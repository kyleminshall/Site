<?php
	session_start();
	
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	
	
	$con=mysql_connect("localhost","KyleM","Minshall1!");
	$db_selected = mysql_select_db('Site', $con);
	
	$date = date("Y-m-d H:i:s");
	$username = $_SESSION['username'];
	
	$q ="UPDATE OGs SET last_login = '$date' WHERE username='$username'"; 
	$q2 = mysql_query($q) or trigger_error(mysql_error()." ".$q); 
	
	header("location: login.php");

	session_destroy();
	$cookieParams = session_get_cookie_params();
	setcookie(session_name(), '', 0, $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);
	$_SESSION = array();
?>