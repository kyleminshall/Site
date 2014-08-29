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
	
	echo '<link rel="stylesheet" type="text/css" href="css/default.css">';
	echo '<body style="font-family:helvetica;background-image:none;">';
	echo '<center><h3>Commenting as: '.$username.'</h3></center>';

	if(isset($_POST['submit'])) 
	{ 
		if(!addslashes($_POST['comment'])) 
		{
			die('<u>ERROR:</u> cannot add comment if you do not enter one.'); 
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
	else 
	{  //display form 
		?> 
		<br>
		<br>
		<div align="center">
			<form name="comments" action="" method="post"> 
				<table width="500px" border="0" cellspacing="0" cellpadding="0"> 
					<tr> 
						<td>
							<textarea name="comment" placeholder="Submit a post!" style="width:500px;resize:none;border: none" rows="3" wrap="VIRTUAL"></textarea></textarea>
						</td> 
					</tr> 
					<tr aligh="right"> 
						<td>
							<input type="submit" name="submit" value="Submit">
						</td> 
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
	echo '<div align="center">';
	echo '<h2>Posts:</h2>'; 
	while($info2 = mysql_fetch_object($info)) 
	{     
		echo '<table style="border-collapse:collapse;table-layout:fixed;" width="500px" cellpadding="10px">'; 
		echo '<tr>';    
		$time = strtotime($info2->date);
		$submitted = date("m/d/y \a\\t g:i A", $time);
		echo '<td style="width:65%"><p style="font-size:18px;color:000"><b>'.stripslashes($info2->username).'</b><br><span style="font-size:12px;color:#494949;">'.$submitted.'</span></p></td>'; 
		echo '<td style="width:30%;padding:0;"><p style="font-size:14px;color:000;text-align:right">Likes :<br>Comments :</p></td>'; 
		echo '<td style="width:5%;padding:0;"><p style="font-size:14px;color:000;text-align:center">'.$info2->likes.'<br> 0 </p></td>';
		echo '</tr>';
		echo '<tr>'; 
		echo '<td colspan="3"> <p style="font-size:18px;color:000">'.stripslashes($info2->comment).'</p><br></td>'; 
		echo '</tr>';
		echo '<tr>'; 
		echo '<td colspan="3" style="padding-left: 10px;"><p style="font-size:12px;padding:0;">Like &nbsp;&nbsp;&nbsp; Comment</p></td>'; 
		echo '</tr>';
		echo '<tr>';
		echo '<td style="padding:0px;"><textarea name="reply" placeholder="Reply..." style="width:500px;padding:0px;margin:0px;resize:none;" rows="2" wrap="physical"></textarea></textarea></td>';
		echo '</tr>';
		echo '</table>';
		echo '<br><br>';
	}//end while 
	echo '</div>';
	echo '<br>';
	echo '<br>';
	?> 