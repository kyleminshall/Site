<?php
	session_start();
	$error = false;
	
	include('classes/membership.php');
	$membership = new Membership();
	
	if(isset($_GET['status']) && $_GET['status'] == 'loggedout')
	{
		$membership->logOut();
	}

	if($_POST && !empty($_POST['key']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['cpassword']))
	{
		$response = $membership->signup($_POST['number'], $_POST['firstName'], $_POST['lastName'], $_POST['username'], $_POST['password'], $_POST['cpassword']);
		$error = false;	
	}
	else
	{
		$error = true;
	}
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<title>Welcome to the Site</title>
		<link rel="stylesheet" type="text/css" href="css/default.css">
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<script src="js/modernizr.custom.js"></script>
	</head>
	<body>
		<div id="login">
			<div id="box">
				<p>
					<h1 style="color:#494949">Register</h1>
				</p>
				<form method="post" action="">
					<p>
						<input class="form" id="number" name="key" type="text" placeholder="Permission Key" ><br>
						<input class="form" id="Password" name="firstName" type="text" placeholder="First Name" ><br>
						<input class="form" id="Password" name="lastName" type="text" placeholder="Last Name" ><br>
						<input class="form" id="Password" name="username" type="text" placeholder="Username" ><br>
						<input class="form" id="Password" name="password" type="text" placeholder="Password"><br>
						<input class="form" id="Password" name="cpassword" type="text" placeholder="Confirm Password"><br>
						<button type="submit" name="submit" class="btn btn-4 btn-4a icon-arrow-right" style="padding:10px 62px !important;">Sign Up!</button>
					</p>
				</form>
				<?php if(isset($response)) echo "<h4 class='alert'>" . $response . "</h4>";?>
			</div>
		</div><!-- end signup --> 
	</body>
</html>