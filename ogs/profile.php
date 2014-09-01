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
		<title>Profile</title>
		<link rel="stylesheet" type="text/css" href="css/default.css">
	</head>
	<body style="background-image: none;">
		<div id="main">
			<p>
				Current profile picture:<br>
				<img src="https://s3-us-west-1.amazonaws.com/kyleminshall/Hi.jpg" alt="Profile" height="100%" width="100%">
			</p>
		</div><!-- end main --> 
	</body>
</html>