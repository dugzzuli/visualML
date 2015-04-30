<?php

$debug = array();
function distance($p1,$p2){
	global $debug;
	//$debug[] = [$p1['x'],$p2['x'],$p1['y'],$p2['y']];
	//$debug[] = sqrt(pow($p1['x']-$p2['x'],2)+pow($p1['y']-$p2['y'],2));
	return sqrt(pow($p1['x']-$p2['x'],2)+pow($p1['y']-$p2['y'],2));
}

$clusters = array();
$visited = array();
$assigned = array();

function tui_regionQuery($data, $index, $eps){
	global $debug;
	$region = array();
	foreach($data as $i=>$aPoint){
		//$debug[] = $aPoint;
		//$debug[] = $data[$index];
		//$p1 = [$aPoint]
		if(distance($aPoint,$data[$index])<=$eps) $region[]=$i;
	}
	//$debug[] = [$index,$region];
	return $region;
}

function tui_expandCluster($index,$neighborPts,$aCluster,$eps,$minPts,$data){
	global $clusters;
	global $visited;
	$clusters[$aCluster][] = $index;
	$assigned[] = $index;
	$i = 0;
	//foreach ($neighborPts as $key => $aPointIndex) {
	while(count($neighborPts)>$i){	
		if(!in_array($neighborPts[$i], $visited)){
			$visited[] = $neighborPts[$i];
			$neighborPtsPrime = tui_regionQuery($data, $neighborPts[$i], $eps);
			if(count($neighborPtsPrime)>=$minPts){
				$neighborPts = array_merge($neighborPts,$neighborPtsPrime);
			}
		}
		if(!in_array($neighborPts[$i], $assigned)){
			$clusters[$aCluster][] = $neighborPts[$i];
			$assigned[] = $neighborPts[$i];
		}
		$i+=1;
	}
}

function tui_dbscan($data,$eps,$minPts){
	global $clusters;
	global $visited; 
	global $assigned;
	global $debug;
	$clusters = array();
	$visited = array();
	$assigned = array();
	foreach ($data as $index => $aPoint) {
		if(in_array($index, $visited)) continue;
		$visited[] = $index;
		$neighborPts = tui_regionQuery($data, $index, $eps);
		if(count($neighborPts)>=$minPts){
			$clusters[] = array();
			tui_expandCluster($index,$neighborPts,count($clusters)-1,$eps,$minPts,$data);
		}	
	}

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
	$results['No. of outliers'] = count($data)-array_sum($numPoints);
	//$debug = [];
	return ['data'=>$data,
			//'clusters'=>$clusters,
			//'visit'=>$visited,
			'results'=>$results,
			'debug'=>$debug];
}
?>