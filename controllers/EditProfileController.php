<?php

include("../models/Users.php");

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$_SESSION["message"] = array();

$username = $_SESSION["username"];
$email = $_POST["email"];
$newPassword = $_POST["new_password"];
$confirmNewPassword = $_POST["confirm_new_password"];
$currentPassword = $_POST["current_password"];

if($currentPassword == ""){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"Please enter current password");
	header("Location: ../editProfile.php");
}
else if(($newPassword != "" || $confirmNewPassword != "") && $newPassword != $confirmNewPassword){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"New Password does not match the confirm new password");
	header("Location: ../editProfile.php");
}
else if(($newPassword != "" || $confirmNewPassword != "") && strlen($newPassword) < 6){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"Password must be at least 6 characters");
	header("Location: ../editProfile.php");
}
else if(!dbUtil_connect()){
	$_SESSION["message"][] = array("type"=>"error", "content"=>"Cannot connect to the Database");
	header("Location: ../editProfile.php");
}
else{
	$user = findUser($username);
	if($user && password_verify($currentPassword, $user["password"])){
		if($newPassword == "" && $confirmNewPassword == ""){
			$_SESSION["message"][] = array("type"=>"success", "content"=>"Save successfully");
			updateUserEmail($username, $email);
			header("Location: ../editProfile.php");
		}
		else{
			updateUserWithNewPassword($username, $email, password_hash($newPassword, PASSWORD_DEFAULT));
			if(isset($_SESSION['username'])){
				session_destroy();
			}
			header("Location: ../login.php");
		}	
	}
	else{
		$_SESSION["message"][] = array("type"=>"error", "content"=>"Incorrect current password");
		header("Location: ../editProfile.php");
	}
}



?>