<?php

require_once 'classes/membership.php';

$con=mysql_connect("localhost","KyleM","Minshall1!");
$db_selected = mysql_select_db('Site', $con);

membership::confirm();

?>

<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<title>Success</title>
		<link rel="stylesheet" type="text/css" href="css/default.css">
	</head>
	<body style="background-image: none;">
		<div id="top">
			<center>
				<p>
					Website version 0.1.1<br>
					The OG Social Network
				</p>
			</center>
		</div>
		<div id="main">
			<p>
				<?php 
					$username = $_SESSION['username'];
					$name_row = mysql_fetch_assoc(mysql_query("SELECT name FROM OGs WHERE username='$username'"));
					$name = $name_row['name'];
				?>
				Successfully authenticated user: <h1><b> <?php echo $name ?> </b></h1>
			</p>
			<p>
				<?php
					
					$last_login_row = mysql_fetch_assoc(mysql_query("SELECT last_login FROM OGs WHERE username='$username'"));
					$last_login = $last_login_row['last_login'];
					
					$date = date("Y-m-d H:i:s");
					$username = $_SESSION['username'];
	
					$q ="UPDATE OGs SET last_login = '$date' WHERE username='$username'"; 
					$q2 = mysql_query($q) or trigger_error(mysql_error()." ".$q); 
				?>
				Last login: <?php echo $last_login;?>
			</p>
			<p style="font-size:22px; text-decoration:none">
				<a style="text-decoration:none" href="comments.php"><button class="turquoise-flat-button">Comments</button></a>
			</p>
			<p style="font-size:22px; text-decoration:none">
				<a style="text-decoration:none" href="logout.php"><button class="turquoise-flat-button" style="background:#FC4144">Log Out</button></a>
			</p>
		</div><!-- end main --> 
	</body>
</html>