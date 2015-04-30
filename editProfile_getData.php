<?php
	include("models/Users.php");
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 

	if(!dbUtil_connect()){
		$_SESSION["message"][] = array("type"=>"error", "content"=>"Cannot connect to the Database");
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