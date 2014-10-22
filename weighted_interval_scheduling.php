<?php

$jobs = array(
	array(23, array(0, 6)),
	array(12, array(1, 4)),
	array(26, array(3, 8)),
	array(16, array(8, 11)),
	array(11, array(6, 10)),
	array(13, array(4, 7)),
	array(20, array(5, 9)),
	array(20, array(3, 5))
);
var_dump(weighted_interval_schedule($jobs));

// dynamic programming, exclude vs include its own weight
function weighted_interval_schedule($jobs) {
	usort($jobs, 'sort_by_finish_time');
	// var_dump($jobs); die();
	$opt = array();
	$opt[-1] = 0;
	$opt[0] = $jobs[0][0];
	$parent = array();
	$parent[0] = 0;
	for ($i=1; $i < count($jobs); $i++) {
		$previous_jobs = array_slice($jobs, 0, $i);
		$included = $jobs[$i][0];
		if (count($previous_jobs) > 0) {
			$overlap = 0;
			foreach ($previous_jobs as $key => $value) {
				if ($value[1][1] >= $jobs[$i][1][0]) {
					// unset($previous_jobs[$key]);
					$overlap ++;
				}
			}
			$included += $opt[count($previous_jobs) - $overlap - 1];
			// var_dump($included);
			// die();
		}
		$excluded = $opt[$i-1];
		if ($excluded >= $included) {
			$opt[$i] = $excluded;
			$parent[$i] = $i - 1;
		} else {
			$opt[$i] = $included;
			$parent[$i] = 0;
		}

		// var_dump($included);
		// var_dump($excluded);
		// break;
	}
	return $opt;
}


function sort_by_finish_time($job_1, $job_2) {
	return $job_1[1][1] >= $job_2[1][1] ? 1 : 0;	
}

function sort_by_weight($job_1, $job_2) {
	return $job_1[0] >= $job_2[0] ? 1 : 0;
}