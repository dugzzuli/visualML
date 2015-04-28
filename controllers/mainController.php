<?php

include("../models/DecisionTree.php");
include("../models/Kmeans.php");

$algorithm = $_POST["Algorithm"];
$data = $_POST["inputData"];
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
?>