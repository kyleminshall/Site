<?php

	ini_set('display_errors',1);
	error_reporting(E_ALL);

	//connect to your database 
	$con=mysql_connect("localhost","KyleM","Minshall1!");
	$db_selected = mysql_select_db("Site", $con);
	
	//query comments for this page of this article 
	$inf = "SELECT * FROM comments"; 
	
	$info = mysql_query($inf) or trigger_error(mysql_error()." ".$inf); 
	
	if(!$info)
	{
		die(mysql_error()); 
	}

	$info_rows = mysql_num_rows($info); 
	
	if($info_rows > 0) 
	{ 
		echo '<h5>Comments:</h5>'; 
		echo '<table width="95%">'; 
		while($info2 = mysql_fetch_object($info)) 
		{     
			echo '<tr>';    
			echo '<td>"'.stripslashes($info2->subject).'" by: <a href="'.$info2->contact.'">'.stripslashes($info2->username).'</a></td>'; 
			echo '</tr><tr>'; 
			echo '<td colspan="2"> <p>'.strip_tags(stripslashes($info2->comment)).'</p> </td>'; 
			echo '</tr>'; 
		}//end while 
		echo '</table>'; 
		echo '<hr width="95%" noshade>'; 
	} 
	else 
	{
		echo "No comments for this page. Feel free to be the first <br>"; 
	}

	if(isset($_POST['submit'])) 
	{ 
		if(!addslashes($_POST['username']))
		{
			die('<u>ERROR:</u> you must enter a username to add a comment.'); 
		} 
		if(!addslashes($_POST['contact']))  
		{
			die('<u>ERROR:</u> enter contact method in contact field.'); 
		}
		if(!addslashes($_POST['subject'])) 
		{
			die('<u>ERROR:</u> enter a subject to your comment.'); 
		}
		if(!addslashes($_POST['comment'])) 
		{
			die('<u>ERROR:</u> cannot add comment if you do not enter one!?'); 
		}


		//this is for a valid contact  
		if(substr($_POST['contact'],0,7) != 'mailto:' && !strstr($_POST['contact'],'//')) { 
			if(strstr($_POST['contact'],'@'))
			{ 
				$_POST['contact'] = "mailto:".$_POST['contact'].""; 
			}
			else 
			{
				$_POST['contact'] = "http://".$_POST['contact'].""; 
			}
		} //end valid contact 
		
		//add comment 
		$q ="INSERT INTO comments (username, contact, subject, comment)  
			VALUES ('".addslashes(htmlspecialchars($_POST['username']))."','".addslashes(htmlspecialchars($_POST['contact']))."', 
		'".addslashes(htmlspecialchars($_POST['subject']))."', '".addslashes(htmlspecialchars(nl2br($_POST['comment'], false)))."')"; 

		$q2 = mysql_query($q) or trigger_error(mysql_error()." ".$q2); 
		if(!$q2) 
		{
			die(mysql_error()); 
		}

		//refresh page so they can see new comment 
		header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); 

	} 
	else 
	{  //display form 
		?> 
		<form name="comments" action="" method="post"> 

			<table width="90%" border="0" cellspacing="0" cellpadding="0"> 
				<tr>  
					<td><div align="right">Username:   </div></td>  
					<td><input name="username" type="text" size="30" value=""></td> 
				</tr> 
				<tr>  
					<td><div align="right">Contact:   </div></td> 
					<td><input type="text" name="contact" size="30" value=""> <i>(email or url)</i></td> 
				</tr> 
				<td><div align="right">Subject:   </div></td> 
				<td><input type="text" name="subject" size="30" value=""></td> 
			</tr> 
			<tr> 
				<td><div align="right">Comment:   </div></td> 
				<td><textarea name="comment" cols="45" rows="5" wrap="VIRTUAL"></textarea></td> 
			</tr> 
			<tr>  
				<td></td> 
				<td colspan="2"><input type="reset" value="Reset Fields">      
					<input type="submit" name="submit" value="Add Comment"></td> 
				</tr> 
			</table> 
		</form> 
		<?php
	} // end else 
	?> 