<?php

include('mysql.php');

class Membership 
{
	function signup($key, $fname, $lname, $username, $password, $cpassword)
	{
		$mysql = New Mysql();
		$ensure_credentials = $mysql->verify($key, $fname, $lname, $username, $password, $cpassword);
		
		if(is_null($ensure_credentials))
		{
			header("location: login.php");
		} 
		else 
		{
			return $ensure_credentials;
		}
	}
	
	function logOut()
	{
		if(isset($_SESSION['status']))
		{
			unset($_SESSION['status']);
			
			if(isset($_COOKIE[session_name()]))
			{
				setcookie(session_name(), '', time() - 10000);
			}
			session_destroy();
		}
	}
	
	function confirm()
	{
		session_start();
		if($_SESSION['status'] != 'authorized')
		{
			header("location: login.php");
		}
	}
}

?>