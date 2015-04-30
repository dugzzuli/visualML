<?php
	include("models/Users.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 

	$username = $_SESSION['username'];
	$user = findUser($username);

	if($user){
		$email = $user["email"];
	}
	else{
		$email = "cannot find email";
	}

?>