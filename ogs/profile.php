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
		<div align="center">
			<?php
			$username = $_SESSION['username'];
			$sql = "SELECT profile FROM OGs WHERE username='$username'";
			$profile_pic = mysql_result($mysql, 0);
			?>
			<p>
				Current profile picture:<br><br>
				<img src="<?php echo $profile_pic ?>" alt="Profile" height="20%" width="20%">
			</p>
		</div><!-- end main --> 
	</body>
</html>