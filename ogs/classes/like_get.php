<?php
	include 'like.php';
	
	if(isset($_POST['post_id'], $_SESSION['username']) && exists($_POST['post_id']))
	{
		echo like_count($_POST['post_id']);
	}
?>