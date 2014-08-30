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
	
			$con=mysql_connect("localhost","KyleM","Minshall1!");
			$db_selected = mysql_select_db('Site', $con);
	
			$date = date("Y-m-d H:i:s");
	
			$q ="UPDATE OGs SET last_login = '$date' WHERE username='$username'"; 
			$q2 = mysql_query($q) or trigger_error(mysql_error()." ".$q); 
	
			header("location: index.php");
		} 
		else 
		{
			return "Incorrect Username or Password";
		}
	}
}

?>