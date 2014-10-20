<?php
$i = 1980;
$j = 2315;
var_dump($i*$j);
var_dump(multiple($i, $j));
// var_dump(chop_number($j, 2, 1));

//http://www.cs.cmu.edu/~cburch/pgss99/lecture/0721-divide.html
function multiple($i, $j) {
	if ( number_of_digits($i) == 1 && number_of_digits($j) == 1 ) {
		return $i*$j;
	} else {
		$i_digit = number_of_digits($i);
		$j_digit = number_of_digits($j);
		$max_digit = max($i_digit, $j_digit);
		$mid_digit = intval($max_digit / 2);
		$i_l = chop_number($i, $mid_digit);
		$i_r = chop_number($i, $i_digit - $mid_digit, 1);
		$j_l = chop_number($j, $mid_digit);
		$j_r = chop_number($j, $j_digit - $mid_digit, 1);

		if ($i_digit > $j_digit) {
			$i_l = chop_number($i, $mid_digit);
			$i_r = chop_number($i, $i_digit - $mid_digit, 1);
	
			$j_l = chop_number($j, $j_digit - $mid_digit);
			$j_r = chop_number($j, $mid_digit, 1);
		} else {
			$j_l = chop_number($j, $mid_digit);
			$j_r = chop_number($j, $j_digit - $mid_digit, 1);
	
			$i_l = chop_number($i, $i_digit - $mid_digit);
			$i_r = chop_number($i, $mid_digit, 1);
		}

		$x1 = multiple($i_l, $j_l);
		$x2 = multiple($i_r, $j_r);
		$x3	= multiple($i_l + $i_r, $j_l + $j_r) - $x1 - $x2;

		return $x1 * pow(10, $max_digit) + $x3 * pow(10, $mid_digit) + $x2; 
	}	
}

function number_of_digits($number) {
	$res = 0;
	if ($number == 0) {
		$res = 1;
	} else {
		while ($number > 0) {
			$res ++;
			$number = intval($number/10);
		}
	}
	return $res;
}

// chop number to desired digits
// $len --> length of the result number
// $order --> 0 from left to right
function chop_number($number, $len, $order=0) {
	$res = 0;
	$digit = number_of_digits($number)-1;

	for ($i=0; $i < $len; $i++) { 
		if ($order == 0){
			$res = (10 * $res + intval($number/pow(10, $digit-$i)));
			$number = intval($number % pow(10, $digit-$i)); 
		} else {
			$res += (pow(10, $i) * intval($number%10));
			$number /= 10;
		} 	
	}
	return $res;
}