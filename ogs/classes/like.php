<?php
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	
	$con=mysql_connect("localhost","KyleM","Minshall1!");
	$db_selected = mysql_select_db("Site", $con);
	
	function exists($post_id)
	{
		$post_id = (int)$post_id;
		return (mysql_result(mysql_query("SELECT COUNT(id) FROM posts WHERE id='$post_id'"), 0) == 0) ? false : true;
	}
	
	function liked($post_id)
	{
		$post_id = (int)$post_id;
		$username = $_SESSION['username'];
		return (mysql_result(mysql_query("SELECT COUNT(id) FROM likes WHERE username='$username' AND post='$post_id'") , 0) ==0) ? false : true;
	}
	
	function like_count($post_id)
	{
		$post_id = (int)$post_id;
		return (int)mysql_result(mysql_query("SELECT COUNT(id) FROM posts WHERE id='$post_id'"), 0);
	}
	
	function add_like($post_id)
	{
		$post_id = (int)$post_id;
		mysql_query("UPDATE posts SET 'likes' = 'likes' + 1 WHERE id='$post_id'");
		$username = $_SESSION['username'];
		mysql_query("INSERT INTO likes (username, post) VALUES ('$username', '$post_id')");
	}
	
	function delete_like($post_id)
	{
		$post_id = (int)$post_id;
		mysql_query("UPDATE posts SET 'likes' = 'likes' - 1 WHERE post='$post_id'");
		$username = $_SESSION['username'];
		mysql_query("DELETE FROM likes WHERE username='$username' AND post='$post_id')");
	}

?>