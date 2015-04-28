<?php

include("../models/Learning-Library-for-PHP-master/lib/unsupervised/kmeans.php");

function kmeans($data,$k){
	$count = count($data);
	$xs=[];
	for($i=0;$i<$count;$i+=1){
		array_push($xs,[$data[$i]['x'],$data[$i]['y']]);
	}
	$debug = [];
	//$xs=[[10,12],[0,4],[9,4],[2,3],[9,11],[6,2],[5,1]];
	$allData = ll_kmeans($xs,$k);
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