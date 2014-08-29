<?php

session_start();

require_once 'classes/membership.php';
$membership = new Membership();

if($_POST && !empty($_POST['username']) && !empty($_POST['password']))
{
	$response = $membership->validateUser($_POST['username'], $_POST['password']);	
}

?>