<?php

include("../models/Learning-Library-for-PHP-master/lib/unsupervised/DBSCAN.php");

function distance($p1,$p2){
	return sqrt(pow($p1['x']-$p2['x'],2)+pow($p1['y']-$p2['y'],2));
}

function dbscan($data,$eps,$minPts){
	$count = count($data);
	// $xs=[];
	// for($i=0;$i<$count;$i+=1){
	// 	array_push($xs,[$data[$i]['x'],$data[$i]['y']]);
	// }
	$points = range(0, $count-1);
	$distance = array();
	for($i=0;$i<$count;$i+=1){
		$aRow = array();
		for($j=$i+1;$j<$count;$j+=1){
			$aRow[$j] = distance($data[$i],$data[$j]);
		}
		$distance[$i] = $aRow;
	}
	$process = new DBSCAN($distance,$points);
	$clusters = $process->dbscan($eps,$minPts);
	//$clusters=tt_dbscan($xs,$eps,$minPts);
	$cid=0;
	$numPoints=array();
	for($i=0;$i<count($clusters);$i+=1){
		if(count($clusters[$i])<$minPts){
			unset($clusters[$i]);	
		}
		else{
			$cid+=1;
			$numPoints[$cid] = count($clusters[$i]);
			foreach ($clusters[$i] as $id) {
				$data[$id]['predict'] = $cid;
			}
		}
	}
	$results = [];
	$results['Algorithm'] = 'DBSCAN';
	$results['Total Examples'] = count($data);
	$results['EPS'] = $eps;
	$results['MinPts'] = $minPts;
	$results['Total Clusters'] = $cid;
	foreach ($numPoints as $key => $value) {
		$results['No. of examples in C'.$key] = $value;
	}

	$debug=[];

	return ['clusters'=>$data,
			//'centroids'=>$centroids,
			'results'=>$results,
			'debug'=>$debug];
}

$clusters = array();
$visited = array();

function regionQuery($data, $index, $eps){
	$region = array();
	foreach($data as $index=>$aPoint){
		if(distance($aPoint,$data[$index])<=$eps) $region[]=$index;
	}
	return $region;
}

function tui_dbscan($data,$eps,$minPts){
	$clusters = array();
	$visited = array();

	foreach ($data as $index => $aPoint) {
		if(in_array($index, $visited)) continue;
		$visited[] = $index;
		$neighborPts = regionQuery($data, $index, $eps);
		if(count($neighborPts)>=$minPts){
			$clusters[] = array();
			expandCluster($index,$neighborPts,$clusters[count($clusters)-1],$eps,$minPts,$data);
		}	
	}

	return ['clusters'=>$data,
			//'centroids'=>$centroids,
			'results'=>$results,
			'debug'=>$debug];
}
?>