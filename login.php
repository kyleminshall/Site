<?php
	session_start();

	require_once('classes/membership.php');
	/*$membership = new Membership();

	if($_POST && !empty($_POST['username']) && !empty($_POST['password']))
	{
		$response = $membership->validateUser($_POST['username'], $_POST['password']);	
	}*/
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<title>Terrible Programmers</title>
		<link rel="stylesheet" type="text/css" href="css/default.css">
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<script src="js/modernizr.custom.js"></script>
	</head>
	<body>
		<div id="login">
			<div id="box">
				<form method="post" action="">
					<img class="profile-img" src="css/avatar_2x.png" alt="">
					<p>
						<input class="form" id="username" name="Email" type="email" placeholder="username" value="" spellcheck="false" class=""><br>
						<input class="form" id="password" name="Password" type="password" placeholder="Password" class=""><br>
						<button type="submit" name="submit" class="btn btn-4 btn-4a icon-arrow-right">Login</button>
					</p>
				</form>
				<?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>";?>
			</div>
		</div><!-- end login --> 
	</body>
</html>