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
		?>
		<script language="javascript">
		function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+d.toUTCString();
			document.cookie = cname + "=" + cvalue + "; " + expires;
		}

		function getCookie(cname) {
			var name = cname + "=";
			var ca = document.cookie.split(';');
			for(var i=0; i<ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1);
				if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
			}
			return "";
		}

		function checkCookie() {
			var user = getCookie("username");
			if (user != "") {

			} else {
				user = prompt("Please enter your name:", "");
				if (user != "" && user != null) {
					setCookie("username", user, 365);
				}
			}
		}
		
		function getName() {
			var user = getCookie("username");
			return user;
		}</script>
		<body style="font-family:helvetica">
		<?php
		echo '<script language="javascript">document.write("<b>You have been to this page "+gettimes()+" before.</b>");</script>';
		echo '<script language="javascript">checkCookie()</script>';
		echo '<center><h3>Hi! <script language="javascript">document.write(getName())</script></h3></center>';
		echo '<div align="center">';
		echo '<h2>Comments:</h2>'; 
		echo '<table width="500px">'; 
		while($info2 = mysql_fetch_object($info)) 
		{     
			echo '<tr>';    
			echo '<td colspan="2">"'.stripslashes($info2->subject).'" by: '.stripslashes($info2->username).'</td>'; 
			echo '</tr><tr>'; 
			echo '<td colspan="2"> <p text-align="center">'.stripslashes($info2->comment).'</p><br></td>'; 
			echo '</tr>'; 
		}//end while 
		echo '</table>'; 
		echo '</div>';
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
		if(!addslashes($_POST['subject'])) 
		{
			die('<u>ERROR:</u> enter a subject to your comment.'); 
		}
		if(!addslashes($_POST['comment'])) 
		{
			die('<u>ERROR:</u> cannot add comment if you do not enter one!?'); 
		}
		
		//add comment 
		$q ="INSERT INTO comments (username, contact, subject, comment)  
			VALUES ('".addslashes(htmlspecialchars($_POST['username']))."', 'NULL', 
		'".addslashes(htmlspecialchars($_POST['subject']))."', '".addslashes(nl2br($_POST['comment'], false))."')"; 

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
		<br>
		<br>
		<div align="center">
			<form name="comments" action="" method="post"> 
				<table border="0" cellspacing="0" cellpadding="0"> 
					<tr>  
						<td><div align="right">Username:   </div></td>  
						<td><input name="username" type="text" size="30" value=""></td> 
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
		</div> 
		<?php
	} // end else 
	?> 