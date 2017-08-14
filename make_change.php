<?php
//test
$denomination = array(1, 5, 7, 13);
$total = 37;

var_dump(make_change(34, $denomination));


// dynamic programming
function make_change($total, $denomination) {
	if ($total < 1) {
		return null;
	} else {
		$parent = array();
		$parent[0] = 0;
		$opt = array();
		$opt[0] = 0;
		for ($i=1; $i <= $total; $i++) {
			$parent[$i] = $i - 1; //total amount $i, $parent[$i] prior to that one single denomination, the previous total amount
			$opt[$i] = 1 + $opt[$parent[$i]];
			foreach ($denomination as $value) {
				if ($i >= $value) {
					if ($opt[$i] > 1 + $opt[$i - $value]) {
						$opt[$i] = 1 + $opt[$i - $value];
						$parent[$i] = $i - $value;
					}
				}
			}
		}
	}

	// back tracking
	$ans = array();
	while ($total > 0) {
		array_push($ans, $total - $parent[$total]);
		$total = $parent[$total];
	}
	return $ans;
}
