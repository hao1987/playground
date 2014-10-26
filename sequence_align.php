<?php

$s1 = 'ocurrance';
$s2 = 'occurrence';

var_dump(seq_align($s1, $s2));

// lecture-13, no-crossing sequence alignment, cost of a mismatch and gap equals
// O(mn)
function seq_align($a, $b) {
	$a = ' '.$a; $a = str_split($a);
	$b = ' '.$b; $b = str_split($b);
	$opt = array();
	$opt[0] = array(0);
	for ($i=1; $i <= count($a); $i++) { 
		$opt[$i] = array($i);
	}

	for ($j=1; $j <= count($b); $j++) { 
		array_push($opt[0], $j);
	}

	$parent = array();
	for($i=1; $i < count($a); $i++) {
		for ($j=1; $j < count($b); $j++) {
			$alignment1 = ($a[$i] != $b[$j]) + $opt[$i-1][$j-1]; //xi matches yj, equal or not
			$alignment2 = 1 + $opt[$i][$j-1]; // * matches yj
			$alignment3 = 1 + $opt[$i-1][$j]; // xi matches *

			$opt[$i][$j] = min($alignment1, $alignment2, $alignment3);

			switch ($opt[$i][$j]) {
				case $alignment1:
					$parent[$i][$j] = array($i-1, $j-1);
					break;
				case $alignment2:
					$parent[$i][$j] = array($i, $j-1);
					break;
				case $alignment3:
					$parent[$i][$j] = array($i-1, $j);
					break;
				default:
					break;
			}
		}
	}


	// back-tracking
	$i = count($a)-1; $j = count($b)-1;
	$count = $opt[$i][$j];

	$ans = array();
	$ans[0] = array();
	$ans[1] = array();
	while ($i > 0 && $j > 0) {
		$p = $parent[$i][$j];
		if ($p == array($i-1, $j-1)) {
			array_unshift($ans[0], $a[$i]);
			array_unshift($ans[1], $b[$j]);
		} else if ($p == array($i, $j-1)) {
			array_unshift($ans[0], '*');
			array_unshift($ans[1], $b[$j]);
		} else if ($p == array($i-1, $j)) {
			array_unshift($ans[0], $a[$i]);
			array_unshift($ans[1], '*');
		}
		$i = $p[0]; $j = $p[1];
	}

	return array($count, $ans);
}