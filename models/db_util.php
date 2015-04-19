<?php

$db = null;
function dbUtil_connect(){
	global $db;
	$db = mysqli_connect("ap-cdbr-azure-southeast-a.cloudapp.net","bcafd004bce288","1fe07586","pljwebprogMysql");
	if(mysqli_connect_errno($db)){
		$db = null;
	}
	return isset($db);
}

?>