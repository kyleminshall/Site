<?php
	
ini_set('display_errors',1);
error_reporting(E_ALL);

class Mysql {
	
	function verify($key, $fname, $lname, $username, $password, $cpassword)
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
		
		$valid = "SELECT * FROM pem WHERE `key`='$key' AND used=0";
		
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
			
		$insert = "INSERT INTO OGs (name, username, password) VALUES ('".$fname." ".$lname."', '$username', '$password')";
		$return = mysql_query($insert, $con) or trigger_error(mysql_error()." ".$insert);
		
		$finish = mysql_query("UPDATE pem SET used=1 WHERE `key`='$key'", $con);
		
		return;
	}
}

?>