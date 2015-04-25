<?php

include("../models/Users.php");

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$_SESSION["message"] = array();

$username = $_POST["username"];
$password = $_POST["password"];

if(!dbUtil_connect()){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"Cannot connect to the Database");
}

$user = findUser($username);
if($user && password_verify($password, $user["password"])){
	$_SESSION['username'] = $username;
	$_SESSION['session_start'] = date('d-M-Y H:i:s');	
	header("Location: ../index.php");
}
else{
	$_SESSION["message"][] = array("type"=>"error", "content"=>"Incorrect username or password");
	header("Location: ../login.php");
}
?>