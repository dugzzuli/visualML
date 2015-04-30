<?php

function entropy($count){
	$entropy = 0;
	$maxClass = 'A';
	$max = 0;
	foreach($count as $key=>$value){
		if($key!='all' && $value!=0){
			$p = $value/$count['all'];
			$entropy+= -$p*log($p,2);
			if($value>$max){
				$maxClass = $key;
				$max = $value;
			}
		}
	}
	return [$entropy,$maxClass];
}

function isIn($aPoint, $aChunk){
	if($aPoint['x']>=$aChunk[0] && $aPoint['x']<$aChunk[1] && $aPoint['y']>=$aChunk[2] && $aPoint['y']<$aChunk[3]){
		return true;
	}
	return false;
}

function aggregate($data,$aChunk){
	$agg = ['A'=>0, 'B'=>0, 'C'=>0, 'D'=>0, 'E'=>0, 'all'=>0];
	foreach($data as $aPoint){
		if(isIn($aPoint,$aChunk)){
			$agg[$aPoint['label']] += 1;
			$agg['all']+=1;
		}
	}
	return $agg;
}

function decisionTree($data,$minpts){
	$allData = $data;
	$count = count($data);
	$aggStart = ['A'=>0, 'B'=>0, 'C'=>0, 'D'=>0, 'E'=>0];
	for($i=0;$i<$count;$i+=1){
		if($data[$i]['label']=='U'){
		 	unset($data[$i]);
		}
		else{
			$aggStart[$data[$i]['label']]+=1;
		}
	}
	$chunk = [[0,1000,0,1000,array_keys($aggStart,max($aggStart))[0]]];
 	$finish= [];
 	$debug = [];
 	while(count($chunk)!=0){
 		$aChunk = array_pop($chunk);
 		if(is_null($aChunk[4])) continue;
 		$aggregateArray = aggregate($data,$aChunk);
 		array_push($debug, [$aggregateArray,$aChunk]);
 		if($aggregateArray['all']<=$minpts) array_push($finish, $aChunk);
 		else{
 			$oldEntropy = entropy($aggregateArray);
 			array_push($debug, [$aggregateArray,$aChunk,$oldEntropy]);
 			$maxInfogain = 0;
 			$split = ['x',0,1,1];
 			for($x = $aChunk[0]+1;$x<$aChunk[1];$x+=1){
 				$chunkLeft = $aChunk;
 				$chunkLeft[1] = $x;
 				$aggLeft = aggregate($data,$chunkLeft);
 				if($aggLeft['all']<$minpts) continue;
 				$entLeft = entropy($aggLeft);
 				$chunkRight = $aChunk;
 				$chunkRight[0] = $x;
 				$aggRight = aggregate($data,$chunkRight);
 				if($aggRight['all']<$minpts) continue;
 				$entRight = entropy($aggRight);
 				$infoGain = $oldEntropy[0] - (($aggLeft['all']/$aggregateArray['all'])*$entLeft[0]+($aggRight['all']/$aggregateArray['all'])*$entRight[0]);
 				if($infoGain>$maxInfogain){
 					$split = ['x',$x,$entLeft,$entRight];
 					$maxInfogain = $infoGain;
 				}
 			}
 			for($y = $aChunk[2]+1;$y<$aChunk[3];$y+=1){
 				$chunkLeft = $aChunk;
 				$chunkLeft[3] = $y;
 				$aggLeft = aggregate($data,$chunkLeft);
 				if($aggLeft['all']<$minpts) continue;
 				$entLeft = entropy($aggLeft);
 				$chunkRight = $aChunk;
 				$chunkRight[2] = $y;
 				$aggRight = aggregate($data,$chunkRight);
 				if($aggRight['all']<$minpts) continue;
 				$entRight = entropy($aggRight);
 				$infoGain = $oldEntropy[0] - (($aggLeft['all']/$aggregateArray['all'])*$entLeft[0]+($aggRight['all']/$aggregateArray['all'])*$entRight[0]);
 				if($infoGain>$maxInfogain){
 					$split = ['y',$y,$entLeft,$entRight];
 					$maxInfogain = $infoGain;
 				}
 			}
 			if($maxInfogain==0 && !is_null($aChunk[4])) array_push($finish, $aChunk);
 			if($split[0]=='x'){
 				$chunkLeft = $aChunk;
 				$chunkLeft[1] = $split[1]; 				
 				$chunkRight = $aChunk;
 				$chunkRight[0] = $split[1]; 	 						
 			}
 			else{
 				$chunkLeft = $aChunk;
 				$chunkLeft[3] = $split[1];
 				$chunkRight = $aChunk;
 				$chunkRight[2] = $split[1];
 			}
 			$chunkLeft[4] = $split[2][1];
 			$chunkRight[4] = $split[3][1];	
 			if(!is_null($chunkLeft[4])){
 				if($split[2][0]==0) array_push($finish, $chunkLeft);
				else array_push($chunk, $chunkLeft);
 			}
 			if(!is_null($chunkRight[4])){
 				if($split[3][0]==0) array_push($finish, $chunkRight);
				else array_push($chunk, $chunkRight);
 			}		
		}
	}

	$correctClassify = 0;

	foreach ($allData as &$aPoint) {
		$aPoint['predict'] = "U";
		foreach($finish as $aChunk){
			if(isIn($aPoint,$aChunk)){
				$aPoint['predict'] = $aChunk[4];
				if($aPoint['predict']==$aPoint['label']) $correctClassify += 1;
				break;
			}
		}
	}

	$results = [];
	$results['Algorithm'] = 'Decision Tree (ID3)';
	$results['Total Testing Cases'] = count($allData)-count($data);
	$results['Total Training Cases'] = count($data);
	$results['Classify Training Case Correctly'] = $correctClassify;
	if(count($data)!=0){
		
		$results['Classify Training Case Accuracy'] = number_format($correctClassify*100/count($data),2)."%";	
	}
	else{
		$results['Classify Training Case Accuracy'] = "0%";		
	}
	



	return ['data'=>$allData,
			'boundary'=>$finish,
			'results'=>$results,
			'debug'=>$debug];
}

?>