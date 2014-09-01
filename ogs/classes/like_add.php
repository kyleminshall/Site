<?php
	include 'like.php';
	
	if(isset($_POST['post_id'], $_SESSION['username']) && exists($_POST['post_id']))
	{
		$post_id = (int)$_POST['post_id'];
		
		if(liked($post_id)) 
		{
			delete_like($post_id);
		}
		else
		{
			add_like($post_id);
		}
		echo "success";
	}
?>