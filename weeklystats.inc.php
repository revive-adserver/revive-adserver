<?
/* weeklystats.inc.php,v 1.0 2000/12/29 11:06:00 martin braun */

/* placed to GNU by martin@braun.cc */
    
function GetWeekSigns()
{
	// check mysql if it's capable of %v/%x - some installations don't
	$res = mysql_db_query($GLOBALS['phpAds_db'], "SELECT DATE_FORMAT('2001-01-01','%v/%x')") or mysql_die();
	$mySQLok = ( mysql_result($res,0 ,0) != 'v/x' );

	if ($phpAds_begin_of_week == '1')  // week starts on mondays
	{
		$php_week_sign = '%W';
		if ( $mySQLok )
			$mysql_week_sign = '%v/%x';
		else
			$mysql_week_sign = '%u/%Y';  // weeks overlapping end of year might be split
	}
	else                               // week starts on sundays
	{
		$php_week_sign = '%U';
		if ( $mySQLok )
			$mysql_week_sign = '%V/%X';
		else
			$mysql_week_sign = '%U/%Y';  // weeks overlapping end of year might be split
	}
	return array($php_week_sign,$mysql_week_sign);
}
