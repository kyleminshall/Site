<?php
	session_start();

	ini_set('display_errors',1);
	error_reporting(E_ALL);

	//connect to your database 
	$con=mysql_connect("localhost","KyleM","Minshall1!");
	$db_selected = mysql_select_db("Site", $con);
	
	//query comments for this page of this article 
	$inf = "SELECT * FROM posts ORDER BY date DESC"; 

	
	
	$info = mysql_query($inf) or trigger_error(mysql_error()." ".$inf); 
	
	if(!$info)
	{
		die(mysql_error()); 
	}

	$info_rows = mysql_num_rows($info); 
	
	$username = $_SESSION['username'];
	
	echo '<title>Posts</title>';
	echo '<link rel="stylesheet" type="text/css" href="css/default.css">';
	echo '<body style="font-family:helvetica;background-image:none;">';
	echo '<center><h3>Commenting as: '.$username.'</h3></center>';

	if(isset($_POST['submit'])) 
	{ 
		if(!addslashes($_POST['comment'])) 
		{
			die('<u>ERROR:</u> cannot post if you don\'t enter anything.'); 
		}
		
		$date = date("Y-m-d H:i:s");
		
		//add comment 
		$q ="INSERT INTO posts (username, comment, date)  
			VALUES ('$username', '".addslashes(nl2br($_POST['comment'], false))."','$date')"; 

		$q2 = mysql_query($q) or trigger_error(mysql_error()." ".$q); 
		if(!$q2) 
		{
			die(mysql_error()); 
		}

		//refresh page so they can see new comment 
		header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); 

	} 
	else if(isset($_POST['comment'])) 
	{ 
		if(!addslashes($_POST['reply'])) 
		{
			die('<u>ERROR:</u> cannot add comment if you don\'t enter anything'); 
		}
		
		$post_num = $_POST['post']; //Knowing which post the user replied to
		$date = date("Y-m-d H:i:s");
		
		//add comment 
		$q ="INSERT INTO replies (post, username, reply, date)  
			VALUES ('$post_num', '$username', '".addslashes(nl2br($_POST['reply'], false))."','$date')"; 

		$q2 = mysql_query($q) or trigger_error(mysql_error()." ".$q); 
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
		<div align="center">
			<p style="font-size:22px; text-decoration:none">
				<a style="text-decoration:none" href="index.php"><button class="turquoise-flat-button" style="background:#FC4144">Go Back</button></a>
			</p>
		</div>
		<br>
		<br>
		<div align="center">
			<form name="comments" action="" method="post"> 
				<table width="500px" border="0" cellspacing="0" cellpadding="0"> 
					<tr style="background-color: #f6f6f6"> 
						<td>
							<textarea name="comment" placeholder="Submit a post..." style="width:500px;resize:none;border:none;padding:10px;background:transparent;font-size:18px" rows="3" wrap="VIRTUAL"></textarea></textarea>
						</td> 
					</tr> 
					<tr align="right" style="background-color: #dddddd"> 
						<td>
							<input type="submit" name="submit" value="Submit">
						</td> 
					</tr> 
				</table> 
			</form>
		</div> 
		<?php
		echo '<hr width="50%" noshade>'; 
	} // end else 
	echo '<div align="center">';
	echo '<h2>Posts:</h2>'; 
	while($info2 = mysql_fetch_object($info)) 
	{     
		echo '<table style="border-collapse:collapse;table-layout:fixed;" width="500px" cellpadding="10px">'; 
		echo '<tr>';    
		$post_number = $info2->id;
		$time = strtotime($info2->date);
		$submitted = date("m/d/y \a\\t g:i A", $time);
		$rep = "SELECT * FROM replies WHERE post='$info2->id'";
		$replies = mysql_query($rep) or trigger_error(mysql_error())." ".$rep;
		$count = mysql_num_rows($replies);
		echo '<td style="width:65%"><p style="font-size:18px;color:000"><b>'.stripslashes($info2->username).'</b><br><span style="font-size:12px;color:#494949;">'.$submitted.'</span></p></td>'; 
		echo '<td style="width:30%;padding:0;"><p style="font-size:14px;color:000;text-align:right">Likes :<br>Comments :</p></td>'; 
		echo '<td style="width:5%;padding:0;"><p style="font-size:14px;color:000;text-align:center">'.$info2->likes.'<br>'.$count.' </p></td>';
		echo '</tr>';
		echo '<tr>'; 
		echo '<td colspan="3"> <p style="font-size:18px;color:000">'.stripslashes($info2->comment).'</p><br></td>'; 
		echo '</tr>';
		echo '<tr>'; 
		echo '<td colspan="3" style="padding-left: 10px;"><p style="font-size:12px;padding:0;text-align:left">Like</p></td>'; 
		echo '</tr>';
		while($replies2 = mysql_fetch_object($replies)) 
		{
			$time = strtotime($replies2->date);
			$replied = date("m/d/y \a\\t g:i A", $time);
  			echo '<tr style="background-color:#f6f6f6;">'; 
  			echo '<td colspan="3"> 
					<p style="font-size:14px;color:000;margin:0">
						<b>'.stripslashes($replies2->username).'</b> : '.stripslashes($replies2->reply).'<br>
						<span style="font-size:12px;color:#494949;">'.$replied.'</span>
					</p>
				  </td>'; 
  			echo '</tr>';
		}
		echo '<tr style="background-color:#f6f6f6;border-top:1px solid black;">';
		echo '<td colspan="3" style="padding:5px">
				<form style="margin:0;" name="like" action="" method="post">
					<textarea name="reply" placeholder="Reply..." style="width:90%;resize:none;border:none;background:transparent;font-size:12px" rows="1" wrap="physical"></textarea>
					<input type="hidden" name="post" value="'.$post_number.'">
					<input style="vertical-align:top;" type="submit" name="comment" value="Post">
				</form>
			  </td>';	
		echo '</tr>';
		echo '</table>';
		echo '<br><br>';
	}//end while 
	echo '</div>';
	echo '<br>';
	echo '<br>';
	?> 