<?php
	
ini_set('display_errors',1);
error_reporting(E_ALL);

class Mysql {
	
	function signup($key, $fname, $lname, $username, $password, $cpassword)
	{
		if($password !== $cpassword)
		{
			return "Passwords do not match.";
		}
		
		$con=mysql_connect("localhost","KyleM","Minshall1!");
		$db_selected = mysql_select_db('Site', $con);
		
		if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$valid = "SELECT * FROM pem WHERE `key`='$key'";
		$result = mysql_query($valid, $con) or trigger_error(mysql_error()." ".$valid);
		$row = mysql_fetch_assoc($result);
		
		if($row['key'] != $key)
		{
			mysql_close($con);
			return "Please enter a valid permission key.";
		}
		
		if($row['used']==1)
		{
			mysql_close($con);
			return "This permission key has already been used.";
		}
		
		$user = "SELECT * FROM OGs WHERE username='$username'";
		$check = mysql_query($user, $con);
		
		if(!empty($check))
		{
			return "This username has already been taken.";
		}
			
		$insert = "INSERT INTO OGs (name, username, password) VALUES ('".$fname." ".$lname."', '$username', '$password')";
		$return = mysql_query($insert, $con) or trigger_error(mysql_error()." ".$insert);
		
		$sql = "UPDATE pem SET used = 1 WHERE `key` = '$key'";
		$finish = mysql_query($sql, $con) or trigger_error(mysql_error()." ".$sql);
		
		return;
	}
	
	function verify($username, $password)
	{
		$con=mysql_connect("localhost","KyleM","Minshall1!");
		$db_selected = mysql_select_db('Site', $con);
		
		if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$query = "SELECT * FROM OGs WHERE username='$username'";
		
		$result = mysql_query($query, $con) or trigger_error(mysql_error()." ".$query);
		
		$row = mysql_fetch_assoc($result);
		
		if($password === $row['password'])
		{
			mysql_close($con);
			return $row['username'];
		}
		else
		{
			mysql_close($con);
			return;
		}
	}
}

?>