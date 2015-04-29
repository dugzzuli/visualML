<?php
/*
 * Density-Based Clustering
 *
 * Domenica Arlia, Massimo Coppola. "Experiments in Parallel Clustering with DBSCAN". Euro-Par 2001: Parallel Processing: 7th International Euro-Par Conference Manchester, UK August 28–31, 2001, Proceedings. Springer Berlin.
 * Hans-Peter Kriegel, Peer Kröger, Jörg Sander, Arthur Zimek (2011). "Density-based Clustering". WIREs Data Mining and Knowledge Discovery 1 (3): 231–240. doi:10.1002/widm.30.
 */

function ll_dbscan($data, $e, $minimumPoints=10) {
   $clusters = array();
   $visited = array();

   foreach($data as $index=>$datum) {
      if(in_array($index, $visited))
         continue;

      $visited[] = $index;

      $regionPoints = _ll_points_in_region(array($index=>$datum), $data, $e);
      if(count($regionPoints) >= $minimumPoints) {
         $clusters[] = _ll_expand_cluster(array($index=>$datum), $regionPoints, $e, $minimumPoints, $visited);
      }
   }
   
   return $clusters;
}

function _ll_points_in_region($point, $data, $epsilon) {
   $region = array();
   foreach($data as $index=>$datum) {
      if(ll_euclidian_distance($point, $datum) < $epsilon) {
         $region[$index] = $datum;
      }
   }
   return $region;
}

function _ll_expand_cluster($point, $data, $epsilon, $minimumPoints, &$visited) {
   $cluster = array( $point );

   foreach($data as $index=>$datum) {
      if(!in_array($index, $visited)) {
         $visited[] = $index;
         $regionPoints = _ll_points_in_region(array($index=>$datum), $data, $epsilon);

         if(count($regionPoints) > $minimumPoints) {
            $cluster = _ll_join_clusters($regionPoints, $cluster);
         }
      }

      // supposed to check if it belongs to any clusters here.
      // only add the point if it isn't clustered yet.
      $cluster[] = array($index=>$datum);
   }
   return $cluster;
}

function _ll_join_clusters($one, $two) {
   return array_merge($one, $two);
}

$clusters = array();
$visited = array();
$hasCluster = array();

function tt_dbscan($data, $e, $minimumPoints=10) {
   global $clusters;
   global $visited;
   global $hasCluster;
   $clusters = array();
   $visited = array();
   $hasCluster = array();
   $numCluster = 0;
   foreach($data as $index=>$aPoint) {
      if(in_array($index, $visited))
         continue;

      $visited[] = $index;

      $regionPoints = _tt_points_in_region($index, $data, $e);
      if(count($regionPoints) >= $minimumPoints) {
         $numCluster +=1;
         $hasCluster[] = $index;
         $members = _tt_expand_cluster(array($index), $regionPoints, $data, $e, $minimumPoints);
         $clusters[$numCluster] = $members;
      }
   }
   
   return $clusters;
}

function _tt_points_in_region($point, $data, $epsilon) {
   $region = array();
   
   foreach($data as $index=>$datum) {
      if(ll_euclidian_distance($data[$point], $datum) < $epsilon) {
         $region[] = $index;
      }
   }
   return $region;
}

function _tt_expand_cluster($cluster, $regionPoints, $data, $epsilon, $minimumPoints) {
   global $visited;
   global $hasCluster;
   //$cluster = array( $point );

   foreach($regionPoints as $datum) {
      if(!in_array($datum, $visited)) {
         $visited[] = $datum;
         $thisRegPoints = _tt_points_in_region($datum, $data, $epsilon);

         if(count($thisRegPoints) >= $minimumPoints) {
            foreach ($thisRegPoints as $index) {
               if(!in_array($index, $hasCluster)) $hasCluster[] = $index; 
            }
            $cluster = _tt_join_clusters($thisRegPoints, $cluster);
         }
      }

      // supposed to check if it belongs to any clusters here.
      // only add the point if it isn't clustered yet.
      if(!in_array($datum, $hasCluster)){
         $cluster = _tt_join_clusters($cluster, array($datum));
         $hasCluster[] = $datum;
      }
         
   }
   return $cluster;
}

function _tt_join_clusters($one, $two) {
   $result = $one;
   foreach($two as $aPoint){
      if(!in_array($aPoint, $result)) $result[]=$aPoint;
   }
   return $result;
}
?>
