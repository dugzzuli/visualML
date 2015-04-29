<?php
function Average($array)
{
    return (float) array_sum($array) / count($array);
}
 
function SumSTD($array = array())
{
    $number = 0;
    $check  = array();
    $count  = count($array) - 1;

    if($count == 0)
    {
        $count = 1;
    }

    foreach ($array as $key => $value)
    {
        if( isset($value) && $value != '' )
        {
            $check[] = pow( ($value-Average($array)), 2 );
        }
    }

    foreach ($check as $key => $value)
    {
       $number = $value+$number;
    }

    if( Average($array) == 0 )
    {
        $Average = 1;
    }
    else
    {
        $Average = Average($array);
    }

    $number = $number/$count;
    $number = sqrt($number)/$Average;
    $number = $number*100;

    return $number;
}
function linear_regression($data){
	$n = count($data);
	$xs=[];
	$sumX = 0;
	$sumY = 0;
	$sumXY = 0;
	$sumX2 = 0;
	for($i=0;$i<$n;$i+=1){
		//array_push($xs,[$data[$i]['x'],$data[$i]['y']]);
		$sumX += $data[$i]['x'];
		$sumY += $data[$i]['y'];
		$sumXY += $data[$i]['x']*$data[$i]['y'];
		$sumX2 += $data[$i]['x']*$data[$i]['x'];
	}
	$m = ($sumX*$sumY-$n*$sumXY)/($sumX*$sumX-$n*$sumX2);
	$c = ($sumY-$m*$sumX)/$n;
	$xIntercept = [-$c/$m,0];
	$yIntercept = [0,$c];
	$sumSQError = 0;
	$sumError = 0;
	for($i=0;$i<$n;$i+=1){
		$data[$i]['predict'] = $m*$data[$i]['x'] + $c;
		$error = $data[$i]['predict'] - $data[$i]['y'];
		$sumError += abs($error);
		$sumSQError += $error*$error;
	}
	$meanSQError = $sumSQError/$n;
	$value = [	'm'=>$m,
				'c'=>$c,
				'xIntercept'=>$xIntercept,
				'yIntercept'=>$yIntercept,
				'sumSQError'=>$sumSQError,
				'meanError'=>$sumError/$n,
				'meanSQError'=>$meanSQError
			];
	$results = [];
	$results['Algorithm'] = 'Simple Linear Regression';
	$results['Total Examples'] = $n;
	$results['Equation'] = 'y = '.number_format($m,2).'x + '.number_format($c,2);
	$results['Sum of square errors'] = number_format($sumSQError,2);
	$results['Mean of errors'] = number_format($sumError/$n,2);
	$debug = [];
	//$boundary = [];
	return ['value'=>$value,
			//'boundary'=>$boundary,
			'results'=>$results,
			'debug'=>$debug];
}

?>
