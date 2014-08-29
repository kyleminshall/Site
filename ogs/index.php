<?php

require_once 'classes/membership.php';
$membership = New Membership();

$con=mysql_connect("localhost","KyleM","Minshall1!");
$db_selected = mysql_select_db('Site', $con);

$membership->confirm();

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
					Website version 0.0.1<br>
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
					$admin_row = mysql_fetch_assoc(mysql_query("SELECT is_admin as admin FROM OGs WHERE username='$username'"));
					$is_admin = $admin_row['admin']==1;
				
				?>
				Successfully authenticated user: <h1><b> <?php echo $name ?> </b></h1>
			</p>
			<p>
				<?php
					if($is_admin)
					{
						echo $name.' is an admin!';
					}
					else
					{
						echo $name.' is <b>not</b> an admin.';
					}
				?>
			</p>
			<p style="font-size:22px; text-decoration:none">
				<a style="text-decoration:none" href="login.php?status=loggedout"><button class="turquoise-flat-button">Log Out</button></a>
			</p>
		</div><!-- end main --> 
	</body>
</html>