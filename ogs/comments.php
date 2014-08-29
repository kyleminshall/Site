<?php
	session_start();

	ini_set('display_errors',1);
	error_reporting(E_ALL);

	//connect to your database 
	$con=mysql_connect("localhost","KyleM","Minshall1!");
	$db_selected = mysql_select_db("Site", $con);
	
	//query comments for this page of this article 
	$inf = "SELECT * FROM comments ORDER BY date DESC"; 
	
	$info = mysql_query($inf) or trigger_error(mysql_error()." ".$inf); 
	
	if(!$info)
	{
		die(mysql_error()); 
	}

	$info_rows = mysql_num_rows($info); 
	
	$username = $_SESSION['username'];
	
	echo '<link rel="stylesheet" type="text/css" href="css/default.css">';
	echo '<body style="font-family:helvetica;background-image:none;">';
	echo '<center><h3>Commenting as: '.$username.'</h3></center>';

	if(isset($_POST['submit'])) 
	{ 
		if(!addslashes($_POST['subject'])) 
		{
			die('<u>ERROR:</u> enter a subject to your comment.'); 
		}
		if(!addslashes($_POST['comment'])) 
		{
			die('<u>ERROR:</u> cannot add comment if you do not enter one.'); 
		}
		
		$date = date("Y-m-d H:i:s");
		
		//add comment 
		$q ="INSERT INTO comments (username, subject, comment, date)  
			VALUES ('$username','".addslashes(htmlspecialchars($_POST['subject']))."', '".addslashes(nl2br($_POST['comment'], false))."','$date')"; 

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
		<br>
		<br>
		<div align="center">
			<form name="comments" action="" method="post"> 
				<table width="500px" border="0" cellspacing="0" cellpadding="0"> 
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
		</div> 
		<div align="center">
			<p style="font-size:22px; text-decoration:none">
				<a style="text-decoration:none" href="index.php"><button class="turquoise-flat-button" style="background:#FC4144">Go Back</button></a>
			</p>
		</div>
		<?php
		echo '<hr width="50%" noshade>'; 
	} // end else 
	
	if($info_rows > 0) 
	{
		echo '<div align="center">';
		echo '<h2>Comments:</h2>'; 
		echo '<table width="500px" cellpadding="10px">'; 
		while($info2 = mysql_fetch_object($info)) 
		{     
			echo '<tr>';    
			echo '<td colspan="2">"'.stripslashes($info2->subject).'" by: <b>'.stripslashes($info2->username).'</b></td>'; 
			echo '</tr>';
			echo '<tr><td><p><br><br></td></tr>';
			echo '<tr bgcolor="#F5F5F5">'; 
			echo '<td colspan="2"> <p text-align="center" style="font-size:18px">'.stripslashes($info2->comment).'</p><br></td>'; 
			echo '</tr>'; 
		}//end while 
		echo '</table>'; 
		echo '</div>';
		echo '<br>';
		echo '<br>';
	} 
	else 
	{
		echo '<div align="center">';
		echo "No comments for this page. Feel free to be the first <br>"; 
		echo '</div>';
	}
	?> 