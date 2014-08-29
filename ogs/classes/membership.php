<?php

include('mysql.php');

class Membership 
{
	static function signup($key, $fname, $lname, $username, $password, $cpassword)
	{
		$ensure_credentials = mysql::signup($key, $fname, $lname, $username, $password, $cpassword);
		
		if(is_null($ensure_credentials))
		{
			header("location: login.php");
		} 
		else 
		{
			return $ensure_credentials;
		}
	}
	
	static function logOut()
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
	
	static function confirm()
	{
		session_start();
		if($_SESSION['status'] != 'authorized')
		{
			header("location: login.php");
		}
	}
	
	static function validateUser($username, $password)
	{
		$password = md5($password);
		$ensure_credentials = mysql::verify($username, $password);
		
		if(!is_null($ensure_credentials))
		{
			$_SESSION['status'] = 'authorized';
			$_SESSION['username'] = $username;
			header("location: index.php");
		} 
		else 
		{
			return "Incorrect Username or Password";
		}
	}
}

?>