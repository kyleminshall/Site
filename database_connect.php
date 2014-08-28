<?php

	$con=mysqli_connect("localhost","KyleM","Minshall1!","Site");
	
	if(mysqli_connect_errno()) 
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>