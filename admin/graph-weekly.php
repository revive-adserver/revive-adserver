<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Martin Braun <martin@braun.cc>                 */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("stats-weekly.inc.php");



/*********************************************************/
/* Prepare data for graph                                */
/*********************************************************/

$where=urldecode($where); 

// Get week signs for mySQL queries
list($php_week_sign, $mysql_week_sign) = GetWeekSigns();

mysql_select_db($GLOBALS["phpAds_db"]);

$text=array(
    'value1' => $GLOBALS['strViews'],
    'value2' => $GLOBALS['strClicks']);


if ($phpAds_compact_stats) {
    // Get totals from compact stats
    $query="
    	SELECT 
    		sum(views), 
    		sum(clicks), 
    		DATE_FORMAT(day,'".$mysql_week_sign."'),
    		DATE_FORMAT(day,'%Y".$mysql_week_sign."') AS week 
    	FROM
    		".$GLOBALS['phpAds_tbl_adstats']."
    	$where
    	GROUP BY 
    		week
    	ORDER BY 
    		week DESC
    	LIMIT ".$max_weeks;
    
    $result = db_query($query) or mysql_die();
    
    $items = array();
    $num2 = mysql_num_rows($result);
    $i=0;
    while ($row = mysql_fetch_row($result))   
    {
    	$items[$i]=array();
    	$items[$i]['value1'] = $row[0];     // views
    	$items[$i]['value2'] = $row[1];     // clicks
    	$items[$i]['text'] = $row[2];       // week sign
    	$i++;
    }
}
else
{
    $query="
    	SELECT 
    		count(*), 
    		DATE_FORMAT(t_stamp,'".$mysql_week_sign."'),
    		DATE_FORMAT(t_stamp,'%Y".$mysql_week_sign."') AS week 
    	FROM
    		".$GLOBALS['phpAds_tbl_adviews']."
    	$where
    	GROUP BY 
    		week
    	ORDER BY 
    		week DESC
    	LIMIT ".$max_weeks;
    
    $query2="
    	SELECT 
    		count(*), 
    		DATE_FORMAT(t_stamp,'".$mysql_week_sign."'),
    		DATE_FORMAT(t_stamp,'%Y".$mysql_week_sign."') AS week 
    	FROM
    		".$GLOBALS['phpAds_tbl_adclicks']."
    	$where
    	GROUP BY 
    		week
    	ORDER BY 
    		week DESC
    	LIMIT ".$max_weeks;
                
    $result = db_query($query) or mysql_die();
    $result2 = db_query($query2) or mysql_die();
    
    $items = array();
    $num2 = mysql_num_rows($result2);
    $row2 = mysql_fetch_row($result2);
    $i=0;
    while ($row = mysql_fetch_row($result))   
    {
    	$items[$i]=array();
    	$items[$i]['value1'] = $row[0];
    	$items[$i]['value2'] = 0;
    	$items[$i]['text'] = $row[1];
    	if ($row[2]==$row2[2])
    	{
    		$items[$i]['value2'] = $row2[0];
    		if ( $i < $num2 - 1 )
    			$row2 = mysql_fetch_row($result2);
    	}
    	else
    		$items[$i]['value2'] = 0;
    	$i++;
    }
}

// Build the graph
include('lib-graph.inc.php');

?>
 
