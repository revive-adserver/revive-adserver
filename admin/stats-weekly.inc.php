<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the Martin Braun <martin@braun.cc>             */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



/*********************************************************/
/* Main code                                             */
/*********************************************************/

function GetWeekSigns()
{
	global $phpAds_begin_of_week;
	
	// check mysql if it's capable of %v/%x - some installations don't
	$res = db_query("SELECT DATE_FORMAT('2001-01-01','%v/%x')") or mysql_die();
	$mySQLok = ( mysql_result($res,0 ,0) != 'v/x' );
	
	// week starts on mondays
	if ($phpAds_begin_of_week == '1')  
	{
		$php_week_sign = '%W';
		if ($mySQLok)
			$mysql_week_sign = '%v/%x';
		else
			// weeks overlapping end of year might be split
			$mysql_week_sign = '%u/%Y';
	}
	
	// week starts on sundays
	else
	{
		$php_week_sign = '%U';
		if ($mySQLok)
			$mysql_week_sign = '%V/%X';
		else
			// weeks overlapping end of year might be split
			$mysql_week_sign = '%U/%Y';  
	}
	
	return array($php_week_sign,$mysql_week_sign);
}
