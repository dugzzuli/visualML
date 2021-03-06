<?php

include("../models/DecisionTree.php");
include("../models/Kmeans.php");
include("../models/Dbscan.php");
include("../models/LinearRegression.php");
include("../models/NaiveBayes.php");
include("../models/LogisticRegression.php");

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
	$result = tui_dbscan($data, $eps, $minPts);
	print json_encode(array("status"=>$status, "result"=>$result));
}
else if($algorithm == "modalLR"){
	$result = linear_regression($data);
	print json_encode(array("status"=>$status, "result"=>$result));
}
else if($algorithm == "modalNB"){
	$result = naive_bayes($data);
	print json_encode(array("status"=>$status, "result"=>$result));
}
else if($algorithm == "modalLO"){
	$alpha = $_POST["alpha"];
	$lambda = $_POST["lambda"];
	$result = logistic_regression($data,$alpha,$lambda);
	print json_encode(array("status"=>$status, "result"=>$result));
}
?>