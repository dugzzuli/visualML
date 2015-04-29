<?php

include("../models/DecisionTree.php");
include("../models/Kmeans.php");
include("../models/Dbscan.php");

$algorithm = $_POST["Algorithm"];
$data = json_decode($_POST["inputData"],true);
$status = "success";

if($algorithm == "modalDT"){
	$minpts = $_POST["minpts"];
	$result = decisionTree($data, $minpts);
	print json_encode(array("status"=>$status, "result"=>$result));
}
else if($algorithm == "modalKM"){
	$k = $_POST["k"];
	$result = kmeans($data, $k);
	print json_encode(array("status"=>$status, "result"=>$result));
}
else if($algorithm == "modalDB"){
	$eps = $_POST["eps"];
	$minPts = $_POST["minPts"];
	$result = dbscan($data, $eps, $minPts);
	print json_encode(array("status"=>$status, "result"=>$result));
}
?>