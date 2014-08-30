<?php
	
	class Submit{
	
		static function post($username, $comment)
		{
			if(!addslashes($comment)) 
			{
				return false; //breaks because of an error
			}
			
			$con=mysql_connect("localhost","KyleM","Minshall1!");
			$db_selected = mysql_select_db("Site", $con);
			
			$date = date("Y-m-d H:i:s");
			
			$q ="INSERT INTO posts (username, comment, date)  
				VALUES ('$username', '$comment','$date')"; 
			
			$q2 = mysql_query($q) or trigger_error(mysql_error()." ".$q); 
			
			if(!$q2) 
			{
				die(mysql_error()); 
			}
			
			return true; //successful submission
		}
	}

?>