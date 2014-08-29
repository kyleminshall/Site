<?php
	
	header("location: index.php");
	
	if(isset($_SESSION['status']))
	{
		unset($_SESSION['status']);
	
		if(isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(), '', time() - 10000);
		}
		session_destroy();
	}
?>