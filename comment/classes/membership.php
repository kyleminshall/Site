<?php

include('mysql.php');

class Membership 
{
	function validateUser($username, $password)
	{
		$mysql = New Mysql();
		$ensure_credentials = $mysql->verify($username, $password);
		
		if(!is_null($ensure_credentials))
		{
			$_SESSION['status'] = 'authorized';
			header("location: index.php?user=". $ensure_credentials . "");
		} 
		else 
		{
			return "Incorrect Username or Password";
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