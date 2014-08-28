<?php

	require_once($_SERVER['DOCUMENT_ROOT'].'/database_connect.php');
	
	$con=mysql_connect("localhost","KyleM","Minshall1!");
	$db_selected = mysql_select_db('Site', $con);
	
	if(mysql_connect_errno()) 
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	//query comments for this page of this article
	$query = "SELECT * FROM `comments` WHERE page = '".stripslashes($_SERVER['REQUEST_URI'])."' ORDER BY time ASC";

	$info = mysql_query($inf);

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
	  	  	echo '<td>"'.htmlspecialchars(stripslashes($info2->subject)).'" by: <a href="'.$info2->contact.'">'.htmlspecialchars(stripslashes($info2->username)).'</a></td> <td><div align="right"> @ '.date('h:i:s a', $info2->time).' on '.$info2->date.'</div></td>';
	  	  	echo '</tr><tr>';
	  	  	echo '<td colspan="2"> '.htmlspecialchars(stripslashes(nl2br($info2->comment))).' </td>';
	  	  	echo '</tr>';
	 	 }//end while
		 
	 	 echo '</table>';
	  	echo '<hr width="95%" noshade>';
	  } 
	  else 
	  {
		  echo 'No comments for this page. Feel free to be the first <br>';
	  }
	  if(isset($_POST['submit'])) 
	  {
		  if(!addslashes($_POST['username'])) die('<u>ERROR:</u> you must enter a username to add a comment.');
		  if(!addslashes($_POST['contact']))  die('<u>ERROR:</u> enter contact method in contact field.');
		  if(!addslashes($_POST['subject']))  die('<u>ERROR:</u> enter a subject to your comment.');
		  if(!addslashes($_POST['comment']))  die('<u>ERROR:</u> cannot add comment if you do not enter one!?');
		  //this is for a valid contact 
		
		  if(substr($_POST['contact'],0,7) != 'mailto:' && !strstr($_POST['contact'],'//')) 
		  {
			  if(strstr($_POST['contact'],'@'))
			  {
				  $_POST['contact'] = "mailto:".$_POST['contact']."";
			  }
			  else
			  {
				  $_POST['contact'] = "http://".$_POST['contact']."";
			  }
		  } //end valid contact
		 
		  //try to prevent multiple posts and flooding...
		  $c = "SELECT * from `comments` WHERE ip = '".$_SERVER['REMOTE_ADDR']."'";

		  $c2 = mysql_query($c);
		 
		  while($c3 = mysql_fetch_object($c2)) 
		  {
			  $difference = time() - $c3->time;
			  if($difference < 300) 
			  {
				  die('<u>ALERT:</u> '.$c3->username.', You have already commented earlier; if you have a question, try the forums!<BR>');
			  }
		  } //end while
		  
		  //add comment
		  $q ="INSERT INTO `comments` (article_id, page, date, time, username, ip, contact, subject, comment) VALUES ('".$_GET['id']."', '".$_POST['page']."', '".$_POST['date']."', '".$_POST['time']."', '".addslashes($_POST['username'])."', '".$_SERVER['REMOTE_ADDR']."', '".addslashes($_POST['contact'])."', '".addslashes($_POST['subject'])."', '".addslashes($_POST['comment'])."')";

		  $q2 = mysql_query($q);
		  
		  if(!$q2)
		  {
			  die(mysql_error());	
		  } 
		  //refresh page so they can see new comment
		  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_POST['page'] . "#commentsrn"); 
	  } 
	  else 
	  {  //display form
		  ?>
			  <form name="comments" action="<? $_SERVER['PHP_SELF']; ?>" method="post">
			  	  <input type="hidden" name="page" value="<? echo($_SERVER['REQUEST_URI']); ?>">
				  <input type="hidden" name="date" value="<? echo(date("F j, Y.")); ?>">
				  <input type="hidden" name="time" value="<? echo(time()); ?>">
				  <table width="90%" border="0" cellspacing="0" cellpadding="0">
					  <tr> 
						  <td><div align="right">Username:   </div></td> 
						  <td><input name="username" type="text" size="30" value=""></td>
					  </tr>
					  <tr> 
						  <td><div align="right">Contact:   </div></td>
						  <td><input type="text" name="contact" size="30" value=""> <i>(email or url)</i></td>
					  </tr>
					  <td><div align="right">Subject:   </div></td>
					  <td><input type="text" name="subject" size="30" value=""></td>
				  </tr>
				  <tr>
					  <td><div align="right">Comment:   </div></td>
					  <td><textarea name="comment" cols="45" rows="5" wrap="VIRTUAL"></textarea></td>
				  </tr>
				  <tr> 
					  <td></td>
					  <td colspan="2"><input type="reset" value="Reset Fields">     
						  <input type="submit" name="submit" value="Add Comment"></td>
					  </tr>
				  </table>
			  </form>
		<?
	} // end else
?> 
	  
		