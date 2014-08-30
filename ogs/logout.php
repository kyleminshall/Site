<?php
	session_start();
	
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	
	header("location: login.php");

	session_destroy();
	$cookieParams = session_get_cookie_params();
	setcookie(session_name(), '', 0, $cookieParams['path'], $cookieParams['domain'], $cookieParams['secure'], $cookieParams['httponly']);
	$_SESSION = array();
?>