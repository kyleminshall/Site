<?php

	header("location: login.php");

	if(isset($_SESSION))
	{
		session_destroy();
		
		if(isset($_COOKIE[session_name()]))
		{
			setcookie('PHPSESSID', '', time() - 10000);
		}
	}
?>