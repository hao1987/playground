<?php

// divide and conquer on closest pair pts, 
$points = array(
	array(1, 0),
	array(4, -1),
	array(-1, 1),
	array(10, 0),
	array(8, 6)
);
var_dump(closest_pair($points));

function closest_pair_bf($points) {
	$dist = PHP_INT_MAX; $pair = array();
	if (count($points) < 2) {
		$pair[0] = $points[0];
		$pair[1] = array($dist, $dist);
	} else {
		for ($i=0; $i < count($points); $i++) { 
			for ($j=$i+1; $j < count($points); $j++) { 
				$min = m_dist($points[$i], $points[$j]);
				if ($min < $dist) {
					$dist = $min; $pair[0] = $points[$i]; $pair[1] = $points[$j];
				}
			}
		}
	}
	return array($dist, $pair);
}

function closest_pair($points) {
	if (count($points) <= 3) {
		return closest_pair_bf($points);
	} else {
		usort($points, 'sort_by_x');
		$mid = intval(count($points) / 2);
		$res_l = closest_pair(array_slice($points, 0, $mid));
		$res_r = closest_pair(array_slice($points, $mid+1));
		$mid_point = $points[$mid];
		$sub_min_d = $res_l[0]; $sub_closest_pair = $res_l[1];
		if ($res_l[0] > $res_r[0]) {
			$sub_min_d = $res_r[0];
			$sub_closest_pair = $res_r[1];
		}
		
		$mid_zone_points = array();
		foreach ($points as $point) {
			if (m_dist($point, $mid_point) <= $sub_min_d/2) {
				array_push($mid_zone_points, $point);
			}
		}

		// only need to compare with 6 neighbors, if mid_zone is 2*sub_min_d wide, change
		// 6 to 16, so here instead of O(n^2), we have O(n)
		for ($i=0; $i < min(6, count($mid_zone_points)); $i++) { 
			for ($j=$i+1; $j < min(6, count($mid_zone_points)); $j++) { 
				$min = m_dist($mid_zone_points[$i], $mid_zone_points[$j]);
				if ($min < $sub_min_d) {
					$sub_min_d = $min; 
					$sub_closest_pair[0] = $mid_zone_points[$i]; 
					$sub_closest_pair[1] = $mid_zone_points[$j];
				}
			}
		}
		return array($sub_min_d, $sub_closest_pair);
	}
}

function sort_by_x($i, $j) {
	if ($i[0] == $j[0]) {
		return 0;
	}
	return ($i[0] > $j[0] ? 1 : 0);
}

function sort_by_y($i, $j) {
	if ($i[1] == $j[1]) {
		return 0;
	}
	return ($i[1] > $j[1] ? 1 : 0);
}


function m_dist($x, $y) {
	return abs($y[1] - $x[1]) + abs($y[0] - $x[0]);
}