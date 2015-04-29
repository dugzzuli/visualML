<?php
// function Average($array)
// {
//     return (float) array_sum($array) / count($array);
// }
 
// function SumSTD($array = array())
// {
//     $number = 0;
//     $check  = array();
//     $count  = count($array) - 1;

//     if($count == 0)
//     {
//         $count = 1;
//     }

//     foreach ($array as $key => $value)
//     {
//         if( isset($value) && $value != '' )
//         {
//             $check[] = pow( ($value-$this->Average($array)), 2 );
//         }
//     }

//     foreach ($check as $key => $value)
//     {
//        $number = $value+$number;
//     }

//     if( $this->Average($array) == 0 )
//     {
//         $Average = 1;
//     }
//     else
//     {
//         $Average = $this->Average($array);
//     }

//     $number = $number/$count;
//     $number = sqrt($number)/$Average;
//     $number = $number*100;

//     return $number;
// }

function probByType($data){
	$all = count($data);
	$agg = ['A'=>0, 'B'=>0, 'C'=>0, 'D'=>0, 'E'=>0];
	foreach($data as $aPoint){
		if($aPoint['label']=='U') continue;
		$agg[$aPoint['label']] += 1;
	}
	foreach ($agg as $key => $value) {
		$agg[$key] = $agg[$key]/$all;
	}
	return $agg;
}

function findProbNormal($x,$mean,$sd){
	$sqrt2pi = sqrt(2*M_PI);
	$pow = -pow($x-$mean,2)/(2*$sd*$sd);
	return pow(M_E,$pow)/($sd*$sqrt2pi);
}

function naive_bayes($data){
	$n = count($data);
	//$prob = probByType($data);
	$stat = ['A'=>['x'=>['mean'=>0,'sd'=>1],'y'=>['mean'=>0,'sd'=>1],'count'=>0,'prob'=>0],
			'B'=>['x'=>['mean'=>0,'sd'=>1],'y'=>['mean'=>0,'sd'=>1],'count'=>0,'prob'=>0],
			'C'=>['x'=>['mean'=>0,'sd'=>1],'y'=>['mean'=>0,'sd'=>1],'count'=>0,'prob'=>0],
			'D'=>['x'=>['mean'=>0,'sd'=>1],'y'=>['mean'=>0,'sd'=>1],'count'=>0,'prob'=>0],
			'E'=>['x'=>['mean'=>0,'sd'=>1],'y'=>['mean'=>0,'sd'=>1],'count'=>0,'prob'=>0]
			];
	$agg = ['A'=>['x'=>[],'y'=>[]],
			'B'=>['x'=>[],'y'=>[]],
			'C'=>['x'=>[],'y'=>[]],
			'D'=>['x'=>[],'y'=>[]],
			'E'=>['x'=>[],'y'=>[]],
			];
	$allTrain = 0;
	foreach($data as $aPoint){
		if($aPoint['label']=='U') continue;
		$class = $aPoint['label'];
		$agg[$class]['x'][]=$aPoint['x'];
		$agg[$class]['y'][]=$aPoint['y'];
		$stat[$class]['count']+=1;
		$allTrain+=1;
	}
	$debug = [];
	foreach (['A','B','C','D','E'] as $key) {
		if($stat[$key]['count']==0) continue;
		$stat[$key]['prob'] = $stat[$key]['count']/$allTrain;
		// $debug[] = $key;
		// $debug[] = $agg[$key]['x'];
		// $debug[] = $agg[$key]['y'];
		$stat[$key]['x']['mean'] = Average($agg[$key]['x']);
		$stat[$key]['x']['sd'] = SumSTD($agg[$key]['x']);
		$stat[$key]['y']['mean'] = Average($agg[$key]['y']);
		$stat[$key]['y']['sd'] = SumSTD($agg[$key]['y']);
		// $debug[] = Average($agg[$key]['x']);
		// $debug[] = SumSTD($agg[$key]['x']);
		// $debug[] = Average($agg[$key]['y']);
		// $debug[] = SumSTD($agg[$key]['y']);
	}
	$correctClassify = 0;
	foreach ($data as $index=>$aPoint) {
		$classMax = null;
		$likeMax = -1;
		foreach (['A','B','C','D','E'] as $key) {
			if($stat[$key]['prob']==0) continue;
			$likelihood = findProbNormal($aPoint['x'],$stat[$key]['x']['mean'],$stat[$key]['x']['sd'])*
						findProbNormal($aPoint['y'],$stat[$key]['y']['mean'],$stat[$key]['y']['sd'])*
						$stat[$key]['prob'];
			//$debug[] = [$key,$likelihood];
			if($likelihood>$likeMax){
				$likeMax = $likelihood;
				$classMax = $key;
				//$debug[] = ['updateClassMax',$key];
			}
		}
		//$debug[] = $classMax;
		$data[$index]['predict']=$classMax;
		if($data[$index]['label']!='U'){
			if($data[$index]['predict']==$data[$index]['label']) $correctClassify+=1;
		}
	}

	


	$results = [];
	$results['Algorithm'] = 'Naive Bayes (Parametric Estimation)';
	$results['Total Testing Cases'] = $n-$allTrain;
	$results['Total Training Cases'] = $allTrain;
	$results['Classify Training Case Correctly'] = $correctClassify;
	$results['Classify Training Case Accuracy'] = number_format($correctClassify*100/$allTrain,2)."%";

	return ['data'=>$data,
			'stat'=>$stat,
			'results'=>$results,
			'debug'=>$debug];
}

?>
