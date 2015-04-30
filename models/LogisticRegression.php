<?php
function g($z){
	return 1/(1+pow(M_E,-$z));
}

function computePredict($theta,$data){
	$predict = array();
	//$error = array();
	for($i=0;$i<count($data);$i+=1){
		$predict[$i] = g($theta[0]+$theta[1]*$data[$i]['x']+$theta[2]*$data[$i]['y']);
	}
	return $predict;
}

function onePredict($theta,$data){
	$predict = g($theta[0]+$theta[1]*$data['x']+$theta[2]*$data['y']);
	return $predict;
}
function logistic_regression($data,$alpha,$lambda){
	$countAll = count($data);
	$allData = $data;
	$aggStart = ['A'=>0, 'B'=>0, 'C'=>0, 'D'=>0, 'E'=>0];
	for($i=0;$i<$countAll;$i+=1){
		if($data[$i]['label']=='U'){
		 	unset($data[$i]);
		}
		else{
			$aggStart[$data[$i]['label']]+=1;
		}
	}
	$m = count($data);
	$theta = ['A'=>[],'B'=>[],'C'=>[],'D'=>[],'E'=>[]];
	$numClass = 0;
	foreach ($aggStart as $value) {
		if($value>0) $numClass+=1;
	}
	$maxRound = (900000/($numClass*$m));
	foreach(['A','B','C','D','E'] as $class){
		if($aggStart[$class]==0) continue;
		//$theta[$class] = [rand(-50,50), rand(-50,50), rand(-50,50)];
		$theta[$class] = [0,0,0];
		$continue = true;
		$count = 0;
		while($continue){
			$oldTheta = $theta[$class];
			$predict = computePredict($theta[$class],$data);
			$y=0;
			//-----------theta 0 -------------
			$sum = 0;
			for($i=0;$i<$m;$i+=1){
				if($data[$i]['label']==$class) $y = 1;
				else $y = 0; 
				$sum += $predict[$i]-$y;
			}
			$theta[$class][0] -= ($alpha*$sum)/($m);
			//-----------theta 1 -------------
			$sum = 0;
			for($i=0;$i<$m;$i+=1){
				if($data[$i]['label']==$class) $y = 1;
				else $y = 0; 
				$sum += ($predict[$i]-$y)*$data[$i]['x'];
			}
			$theta[$class][1] -= ($alpha*($sum-$lambda*$theta[$class][1]))/($m);
			//-----------theta 2 -------------
			$sum = 0;
			for($i=0;$i<$m;$i+=1){
				if($data[$i]['label']==$class) $y = 1;
				else $y = 0; 
				$sum += ($predict[$i]-$y)*$data[$i]['y'];
			}
			$theta[$class][2] -= ($alpha*($sum-$lambda*$theta[$class][2]))/($m);
			//$continue = false;
			$continue = ($oldTheta!=$theta[$class]) && ($count!==$maxRound);
			//$continue = ($oldTheta!=$theta[$class]);
			$count += 1;
			//$continue = ($count!== 2000);
		}
	}
	$correctClassify = 0;
	foreach ($allData as &$aPoint) {
		$aPoint['predict'] = "U";
		$classMax = null;
		$maxProb = -1;
		foreach(['A','B','C','D','E'] as $class){
			if($aggStart[$class]==0) continue;
			$prob = onePredict($theta[$class],$aPoint);
			if($prob>$maxProb){
				$maxProb = $prob;
				$classMax = $class;
			}
		}
		$aPoint['predict'] = $classMax;
		if($aPoint['predict']==$aPoint['label']) $correctClassify += 1;
	}
	$line = array();
	foreach(['A','B','C','D','E'] as $class){
		if($aggStart[$class]==0) continue;
		$line[$class]['m'] = -($theta[$class][1]/$theta[$class][2]);
		$line[$class]['c'] = -($theta[$class][0]/$theta[$class][2]);
	}

	$results = [];
	$results['Algorithm'] = 'Logistic Regression';
	$results['Total Testing Cases'] = $countAll-$m;
	$results['Total Training Cases'] = $m;
	$results['Classify Training Case Correctly'] = $correctClassify;
	$results['Classify Training Case Accuracy'] = number_format($correctClassify*100/$m,2)."%";
	$debug = [];
	//$boundary = [];
	return ['theta'=>$theta,
			'data'=>$allData,
			'line'=>$line,
			'results'=>$results,
			'debug'=>$debug];
}

?>
