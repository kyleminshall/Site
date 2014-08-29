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
}

?>