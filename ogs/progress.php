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
		<title>Current Work in Progress</title>
		<link rel="stylesheet" type="text/css" href="css/default.css">
	</head>
	<body style="background-image: none;">
		<div id="top">
			<center>
				<p>
					Website Version : 0.2.5<br>
					The OG Social Network
				</p>
			</center>
		</div>
		<div id="main" style="width:500px;margin-left:-250px;line-height:28px">
			<p>
				<b>Current features that are being worked on:</b><br>
				<br>
				- Bug Fixes (This site is young. Lots of bugs.)<br>
				- Security enhancements (Prepared statements for SQL, XSS protection)<br>
				- Ability to delete posts<br>
				- Ability to delete comments<br>
				- Ability to edit posts (Not going to allow comments being edited)<br>
				- AJAX. Lots and lots of AJAX. Not looking forward to this. <br>
			</p>
			<p style="font-size:22px; text-decoration:none">
				<a style="text-decoration:none" href="index.php"><button class="turquoise-flat-button" style="background:#FC4144">Go Back</button></a>
			</p>
		</div><!-- end main --> 
	</body>
</html>