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
		
		function auto_link_text($text)
		{
		   // a more readably-formatted version of the pattern is on http://daringfireball.net/2010/07/improved_regex_for_matching_urls
		   $pattern  = '~(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))~';

		   $callback = create_function('$matches', '
		       $url       = array_shift($matches);
		       $url_parts = parse_url($url);

		       $text = parse_url($url, PHP_URL_HOST) . parse_url($url, PHP_URL_PATH);
		       $text = preg_replace("/^www./", "", $text);

		       return sprintf(\'<a rel="nofollow" href="%s">%s</a>\', $url, $text);
		   ');

		   return preg_replace_callback($pattern, $callback, $text);
		}
	}

?>