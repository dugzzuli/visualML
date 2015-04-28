<?php

include("../models/DecisionTree.php");

$algorithm = $_POST["Algorithm"];
$data = $_POST["inputData"];
$status = "success";

if($algorithm == "modalDT"){
	$minpts = $_POST["minpts"];
	$result = decisionTree($data, $minpts);
	print json_encode(array("status"=>$status, "result"=>$result));
}

?>