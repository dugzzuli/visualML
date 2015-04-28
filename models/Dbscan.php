<?php

include("../models/Learning-Library-for-PHP-master/lib/unsupervised/dbscan.php");

function dbscan($data,$eps,$minPts){
	$count = count($data);
	$xs=[];
	for($i=0;$i<$count;$i+=1){
		array_push($xs,[$data[$i]['x'],$data[$i]['y']]);
	}
	$clusters=ll_dbscan($xs,$eps,$minPts);
	$results = [];
	$debug=[];

	return ['clusters'=>$clusters,
			//'centroids'=>$centroids,
			'results'=>$results,
			'debug'=>$debug];
}

?>