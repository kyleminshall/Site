<?php
	
ini_set('display_errors',1);
error_reporting(E_ALL);

class Mysql {
	
	function verify($username, $password)
	{
		$con=mysql_connect("localhost","KyleM","Minshall1!");
		$db_selected = mysql_select_db('Site', $con);
		
		if(mysqli_connect_errno()) 
		{
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$query = "SELECT id, name FROM Users WHERE username='$username' AND password='$password'";
		
		$result = mysql_query($query, $con) or trigger_error(mysql_error()." ".$query);
		
		$row = mysql_fetch_assoc($result);
		
		if(!is_null($row['id']))
		{
			mysql_close($con);
			return $row['id']." ".$row['name'];
		}
		else
		{
			mysql_close($con);
			return;
		}
	}
}

?>