<?php

require_once 'classes/membership.php';
$membership = New Membership();

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
		<div id="main">
			<p>
				Successfully authenticated user: <h1><b> <?php echo $_GET['user'] ?> </b></h1>
			</p>
			<p style="font-size:22px; text-decoration:none">
				<a style="text-decoration:none" href="login.php?status=loggedout"><button class="turquoise-flat-button">Log Out</button></a>
			</p>
		</div><!-- end main --> 
	</body>
</html>