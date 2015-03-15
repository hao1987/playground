<?php

var_dump(strtotime('now'));
$now = new DateTime('now', new DateTimeZone('America/New_York'));

var_dump($now->format('Y-m-d H:i:sP'));


var_dump(bsearch(2, array(1, 4, 5, 9, 43, 57)));
function bsearch($needle, $haystack) {

	if(count($haystack) == 0) {
		return false;
	} else {
		$mid = count($haystack) / 2;
		if($haystack[$mid] == $needle) {
			return true;
		} else if($haystack[$mid] < $needle) {
			return bsearch($needle, array_slice($haystack, $mid+1));
		} else {
			return bsearch($needle, array_slice($haystack, 0, $mid));
		}
	}
}

var_dump(getSquareRoot(4, 36));
function getSquareRoot($mid, $target) {
	if($target < 0) {return false;}

	if(pow($mid, 2) == $target) {
		return $mid;
	} else {
		if(pow($mid, 2) < $target) {
			return getSquareRoot(++$mid, $target);
		} else {
			return getSquareRoot(--$mid, $target);
		}
	}
}




// gale-shapley algo, stable marriage
$manPref  = array(
	array(1, 0, 2), // man 0 like wom 1 the most, wom 0 the sec and wom 2 the least
	array(2, 0, 1),
	array(0, 1, 2));

$womPref  = array(
	array(2, 1, 0),
	array(0, 2, 1),
	array(0, 1, 2));

$m = array('tom', 'jon', 'mat');
$w = array('karen', 'lucy', 'julie');

$single = array(0, 1, 2);


$engagement = array(
	0 => 99,
	1 => 99,
	2 => 99);

var_dump(proposeToMarriage($single, $manPref, $womPref, $engagement));
function proposeToMarriage($single, $manPref, $womPref, $engagement) {
	$i = 0;
	while (count($single) > 0) {
		$pick = array_search(min($manPref[$i]), $manPref[$i]);
		$cur = array_search($pick, $engagement);
		echo 'man' . $i . ' picked ---> ' . $pick. ' ------> ' . $cur. "\r\n";

		if($cur === false) {
			$engagement[$i] = $pick;
			unset($single[$i]);
			$i++;
		} else if ($cur == $i) {
			$i++;
			continue;
		} else {
			$herPref = $womPref[$pick];
			echo 'wom' . $pick. ' rands man ' . $cur . ' -> ' . $herPref[$cur] . "\r\n";
			echo 'wom' . $pick. ' rands man ' . $i . ' -> ' . $herPref[$i] . "\r\n";

			if($herPref[$cur] > $herPref[$i]) { // replace her current fiance
				$single[$cur] = $cur;
				$engagement[$cur] = 99;

				$engagement[$i] = $pick;
				unset($single[$i]);
				$i++;
			} else { // propose rejected, he will keep looking
				unset($manPref[$i][$pick]);
			}
		}
		if($i >= count($single)) {$i = 0;} // if $i exceeds # of $single, reset to 0
		// if($i == 3) {
		// 	var_dump($single);
		// 	break;}
		
	}
	return $engagement;
}















