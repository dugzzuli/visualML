<?php

include("../models/Learning-Library-for-PHP-master/lib/unsupervised/kmeans.php");

function tui_reposition_centroids($centroids, $belongs_to, $xs){
	foreach($centroids as $key=>&$aCenter){
		$sumX = 0;
		$sumY = 0;
		foreach ($belongs_to[$key] as $index => $aPoint) {
			$sumX += $aPoint[0];
			$sumY += $aPoint[1];
		}
		$aCenter = [$sumX/count($belongs_to[$key]),$sumY/count($belongs_to[$key])];
	}
	return $centroids;
}

function tui_closest_centroid($aPoint,$centroids){
	$minDist = 2000000;
	$minClus = null;
	foreach($centroids as $index=>$aCenter){
		$dist = sqrt(pow($aPoint[0]-$centroids[0],2)+pow($aPoint[1]-$centroids[1],2));
		if($dist<$minDist){
			$minDist = $dist;
			$minClus = $index;
		}
	}
	return $minClus;
}

function tui_kmeans($xs,$k){
	$count=count($xs);
	if($count<$k) return false;
	$used=array();
	$centroids=array();
	for($i=0;$i<$k;$i+=1){
		do{
			$pointIndex = rand(0,$count-1);
		}
		while(in_array($pointIndex, $used));
		$used[]=$pointIndex;
		$centroids[]=$xs[$pointIndex];
	}
	$continue = true;
	$belongs_to = array();
	while($continue){
		$belongs_to = array();
		foreach($xs as $aPoint){
			$belongs_to[tui_closest_centroid($xs[$i], $centroids)][] = $i;
		}
		$old_centroids = $centroids;
		$centroids = tui_reposition_centroids($centroids, $belongs_to, $xs);
		$continue = !($old_centroids == $centroids);		
	}
	return [$belongs_to,$centroids];
}

function kmeans($data,$k){
	$count = count($data);
	$xs=[];
	for($i=0;$i<$count;$i+=1){
		array_push($xs,[$data[$i]['x'],$data[$i]['y']]);
	}
	$debug = [];
	//$xs=[[10,12],[0,4],[9,4],[2,3],[9,11],[6,2],[5,1]];
	$allData = tui_kmeans($xs,$k);
	$belongs_to = $allData[0];
	$centroids = $allData[1];
	for($i=0;$i<$k;$i+=1){
		for($j=0;$j<count($belongs_to[$i]);$j+=1){
			$data[$belongs_to[$i][$j]]['predict']=$i;
		}
	}

	$results = [];
	$results['Algorithm'] = 'K-means';
	$results['Total Examples'] = count($data);
	$results['k'] = $k;
	for($i=0;$i<$k;$i+=1){
		$results['C'.($i+1).' (x = '.number_format($centroids[$i][0],2).', y = '.number_format($centroids[$i][1],2).')'] = count($belongs_to[$i]);
	}

	return ['belongs_to'=>$data,
			'centroids'=>$centroids,
			'results'=>$results,
			'debug'=>$debug];
}

?>