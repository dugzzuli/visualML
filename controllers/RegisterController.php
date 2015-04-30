<?php

include("../models/Users.php");

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$_SESSION["message"] = array();

$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if(!dbUtil_connect()){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"Cannot connect to the Database");
}

if($email == ""){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"Please enter email address");
	header("Location: ../register.php");
}
else if($username == ""){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"Please enter username");
	header("Location: ../register.php");
}
else if(strlen($password) < 6){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"Password must be at least 6 characters");
	header("Location: ../register.php");
}
else if($password!=$confirm_password){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"Password does not match the confirm password");
	header("Location: ../register.php");
}
else if(isUsernameExist($username)){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"This username has already existed");
	header("Location: ../register.php");
}
else{
	
	//insertUser($username, $email, password_hash($password, PASSWORD_DEFAULT));
	insertUser($username, $email, $password);
	header("Location: ../login.php");
}

?>