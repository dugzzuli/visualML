<?php

include('db_util.php');

function insertUser($username, $email, $password){
	global $db;
	if(!isset($db)) return false;
	$q = "INSERT INTO users (username, email, password) 
			VALUES ('".$username."',
					'".$email."',
					'".$password."')";
	return mysqli_query($db,$q);
}

function findUser($username){
	global $db;
	if(!isset($db)) return false;
	$q = 'SELECT * FROM users WHERE username = "'.$username.'"';
	$r = mysqli_query($db,$q);
	if($r = mysqli_query($db,$q)){
		$row = mysqli_fetch_assoc($r);
		return $row;
	}
	return false;
}

function isUsernameExist($username){
	global $db;
	if(!isset($db)) return false;
	$q = 'SELECT * FROM users WHERE username = "'.$username.'"';
	$r = mysqli_query($db,$q);
	return mysqli_num_rows($r) > 0;
}

?>