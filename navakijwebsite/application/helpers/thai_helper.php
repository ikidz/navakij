<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Project Name : CI Master V3
* Create Date : 2/25/2558 BE
*/
if ( ! function_exists('thai_shortmonth'))
{
	function thai_shortmonth($datestring)
	{
		if(!is_numeric($datestring)){
			$month = (int) date("m",strtotime($datestring));
			$month = (int) ($month-1);
		}else{
			$month = (int) $datestring;
		}
		
		if($month <1){ return '(ไม่รู้จัก)'; }
		$month_array = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
		$monthstring = (isset($month_array[$month]))?$month_array[$month]:'(ไม่รู้จัก)';
		return $monthstring;
	}
}
if ( ! function_exists('thai_fullmonth'))
{
	function thai_fullmonth($datestring)
	{
		if(!is_numeric($datestring)){
			$month = (int) date("m",strtotime($datestring));
			$month = (int) ($month-1);
		}else{
			$month = (int) $datestring;
		}
		
		if($month <1){ return '(ไม่รู้จัก)'; }
		$month_array = array('','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
		$monthstring = (isset($month_array[$month]))?$month_array[$month]:'(ไม่รู้จัก)';
		return $monthstring;
	}
}
if ( ! function_exists('thai_shortyear'))
{
	function thai_shortyear($datestring)
	{
		if(!is_numeric($datestring)){
			$globalyear = (int) date("Y",strtotime($datestring));
		}else{
			$globalyear=$datestring;
		}
		$thaiyear = (int) ($globalyear+543);
		$thaiyear = substr($thaiyear, -2,2);
		return $thaiyear;
	}
}
if ( ! function_exists('thai_fullyear'))
{
	function thai_fullyear($datestring)
	{
		if(!is_numeric($datestring)){
			$globalyear = (int) date("Y",strtotime($datestring));
		}else{
			$globalyear=$datestring;
		}
		$thaiyear = (int) ($globalyear+543);
		return $thaiyear;
	}
}
if ( ! function_exists('thai_convert_shortdate'))
{
	function thai_convert_shortdate($datestring)
	{
		list($date,$month,$year) = explode('-', date("d-m-Y",strtotime($datestring)));
		$strdate = $date . " " . thai_shortmonth($month) . " " . thai_fullyear($year);
		return $strdate;
	}
}
if ( ! function_exists('thai_convert_fulldate'))
{
	function thai_convert_fulldate($datestring)
	{
		list($date,$month,$year) = explode('-', date("d-m-Y",strtotime($datestring)));
		$strdate = $date . " " . thai_fullmonth($month) . " " . thai_fullyear($year);
		return $strdate;
	}
}

if( ! function_exists('utf8_strlen'))
{
	function utf8_strlen( $str='' ){
		$count = strlen($str);
		$length = 0;
		for ($i = 0; $i < $count; ++$i){
			if( ( ord( $str[$i] ) & 0xC0 ) != 0x80 ){
				$length++;
			}
		}
		return $length;
	}
}