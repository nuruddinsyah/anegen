<?php
/*
------------------------------------------------------------
 Luxi - Simple PHP Framework
------------------------------------------------------------
 Version : 1.9.01
 By : Muhammad Faruq Nuruddinsyah
 Division of D-Webs - DaftLabs, Dafturn Technology
------------------------------------------------------------
 License : GNU/LGPL (GNU Lesser GPL)
 Home Page : http://dafturn.org/daftlabs/dwebs/luxi
------------------------------------------------------------
 Copyright 2011. All Rights Reserved.
------------------------------------------------------------
 Library : Date and Time
------------------------------------------------------------
*/

if(function_exists('date_default_timezone_set')) date_default_timezone_set(LUXI_DATE_TIME_DEFAULT_TIMEZONE);

function date_time($format = 'Y-m-d H:i:s', $date = ''){
	$month_name_full = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	$day_name_full = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	$month_name = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
	$day_name = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
	
	$month_key = array('%m-1%', '%m-2%', '%m-3%', '%m-4%', '%m-5%', '%m-6%', '%m-7%', '%m-8%', '%m-9%', '%m-10%', '%m-11%', '%m-12%');
	$day_key = array('%d-1%', '%d-2%', '%d-3%', '%d-4%', '%d-5%', '%d-6%', '%d-7%');
	$month_key_full = array('%mf-1%', '%mf-2%', '%mf-3%', '%mf-4%', '%mf-5%', '%mf-6%', '%mf-7%', '%mf-8%', '%mf-9%', '%mf-10%', '%mf-11%', '%mf-12%');
	$day_key_full = array('%df-1%', '%df-2%', '%df-3%', '%df-4%', '%df-5%', '%df-6%', '%df-7%');
	
	$time_stamp = time();
	
	if($date!=''){
		if(strpos($date, '-')!==false && strpos($date, ':')!==false){
			// date from database with full date and time format: Y-m-d H:i:s
			
			$pieces = explode(' ', $date, 2);
			
			$p_date = explode('-', $pieces[0]);
			$p_time = explode(':', $pieces[1]);
			
			$time_stamp = mktime($p_time[0], $p_time[1], $p_time[2], $p_date[1], $p_date[2], $p_date[0]);
			
		}else if(strpos($date, '-')!==false){
			// date from database with full date format: Y-m-d

			$p_date = explode('-', $date);
			$time_stamp = mktime(0, 0, 0, $p_date[1], $p_date[2], $p_date[0]);
			
		}else if(strpos($date, ':')!==false){
			// date from database with full time format: H:i:s
			
			$p_time = explode(':', $date);
			$time_stamp = mktime($p_time[0], $p_time[1], $p_time[2]);
		}
	}
	
	$result = date($format, $time_stamp);
	
	$result = str_replace($day_name_full, $day_key_full, $result);
	$result = str_replace($month_name_full, $month_key_full, $result);
	$result = str_replace($day_name, $day_key, $result);
	$result = str_replace($month_name, $month_key, $result);
	
	$result = str_replace($day_key_full, $GLOBALS['luxi_day_names_full'], $result);
	$result = str_replace($month_key_full, $GLOBALS['luxi_month_names_full'], $result);
	$result = str_replace($day_key, $GLOBALS['luxi_day_names'], $result);
	$result = str_replace($month_key, $GLOBALS['luxi_month_names'], $result);
	
	return $result;
}

function days_of_month($month, $year){
	switch($month){
		case 1:
    	case 3:
    	case 5:
    	case 7:
    	case 8:
    	case 10:
    	case 12: return 31;
    	case 4:
    	case 6:
    	case 9:
    	case 11: return 30;
    	case 2:
      		if($year%4==0) return 29;
      		else return 28;
	}
}

function get_age($date_birth, $section = 'y'){
	$date_now_y = date_time('Y');
	$date_now_m = date_time('m');
	$date_now_d = date_time('d');
	
	$explode = explode('-', $date_birth);
	$date_birth_y = $explode[0];
	$date_birth_m = $explode[1];
	$date_birth_d = $explode[2];
	
	$date_now_j = gregoriantojd($date_now_m, $date_now_d, $date_now_y);
	$date_birth_j = gregoriantojd($date_birth_m, $date_birth_d, $date_birth_y);
	
	$interval = $date_now_j - $date_birth_j;
	
	$year = floor($interval / 365);
	$month = floor(($interval - ($year * 365)) / 30);
	$day = $interval - $month * 30 - $year * 365;
	
	switch($section){
		case 'y': case 'year':
			return $year;
		case 'm': case 'month':
			return $month;
		case 'd': case 'day':
			return $day;
		case 'ds':
			return $interval;
		default:
			return $year;
	}
}

?>
