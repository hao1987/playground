<?php

$s1 = 'cat';
$s2 = 'act';

var_dump(LCS($s1, $s2));


function LCS($a, $b) {
	$a = str_split(' '.$a);
	$b = str_split(' '.$b);

	$opt = array();
	$opt[0] = array();
	for ($j=0; $j < count($b); $j++) { 
		$opt[$j] = array(0);
		$parent[$j] = array();
	}
	for ($i=0; $i < count($a) ; $i++) { 
		array_push($opt[0], 0);
	}

	$parent = array(0);
	for ($i=1; $i < count($a); $i++) { 
		for ($j=1; $j < count($b); $j++) { 
			if ($a[$i] == $b[$j]) {
				$opt[$i][$j] = 1 + $opt[$i-1][$j-1];
				array_push($ans, $a[$i]);
			} else {
				$opt[$i][$j] = max($opt[$i-1][$j], $opt[$i][$j-1]);
			}
		}	
	}

	return array($opt[count($a) - 1][count($b) - 1], $ans);
}