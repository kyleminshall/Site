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
		
		static function auto_link_text($text) {
		    $pattern  = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';
		    return preg_replace_callback($pattern, array('', 'auto_link_text_callback'), $text);
		}

		static function auto_link_text_callback($matches) {
		    $max_url_length = 50;
		    $max_depth_if_over_length = 2;
		    $ellipsis = '&hellip;';

		    $url_full = $matches[0];
		    $url_short = '';

		    if (strlen($url_full) > $max_url_length) {
		        $parts = parse_url($url_full);
		        $url_short = $parts['scheme'] . '://' . preg_replace('/^www\./', '', $parts['host']) . '/';

		        $path_components = explode('/', trim($parts['path'], '/'));
		        foreach ($path_components as $dir) {
		            $url_string_components[] = $dir . '/';
		        }

		        if (!empty($parts['query'])) {
		            $url_string_components[] = '?' . $parts['query'];
		        }

		        if (!empty($parts['fragment'])) {
		            $url_string_components[] = '#' . $parts['fragment'];
		        }

		        for ($k = 0; $k < count($url_string_components); $k++) {
		            $curr_component = $url_string_components[$k];
		            if ($k >= $max_depth_if_over_length || strlen($url_short) + strlen($curr_component) > $max_url_length) {
		                if ($k == 0 && strlen($url_short) < $max_url_length) {
		                    // Always show a portion of first directory
		                    $url_short .= substr($curr_component, 0, $max_url_length - strlen($url_short));
		                }
		                $url_short .= $ellipsis;
		                break;
		            }
		            $url_short .= $curr_component;
		        }

		    } else {
		        $url_short = $url_full;
		    }

		    return "<a rel=\"nofollow\" href=\"$url_full\">$url_short</a>";
		}
	}

?>