<?php
	
	class Submit{
	
		static function post($username, $comment)
		{
			if(!addslashes($comment)) 
			{
				return; //breaks because of an error
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
		}
		
		static function comment($username, $post, $reply)
		{
			if(!addslashes($reply)) 
			{
				return; 
			}
			
			$date = date("Y-m-d H:i:s");
			
			$con=mysql_connect("localhost","KyleM","Minshall1!");
			$db_selected = mysql_select_db("Site", $con);
			
			$q ="INSERT INTO replies (post, username, reply, date)  
				VALUES ('$post', '$username', '$reply','$date')"; 
			
			$q2 = mysql_query($q) or trigger_error(mysql_error()." ".$q); 
			
			if(!$q2) 
			{
				die(mysql_error()); 
			}
		}
	}

?>