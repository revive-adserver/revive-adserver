<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");


// Register input variables
phpAds_registerGlobal ('where');


/*********************************************************/
/* Prepare data for graph                                */
/*********************************************************/

if (!$phpAds_config['compact_stats']) 
{
	// NOTE: None of this works for the compact database 
	// format since hours are not tracked
	
    $where   = urldecode($where); 
    $query	 = "SELECT COUNT(*), DATE_FORMAT(t_stamp, '%k') AS hour FROM ".$phpAds_config['tbl_adviews']." WHERE ($where) GROUP BY hour";
    $query2  = "SELECT COUNT(*), DATE_FORMAT(t_stamp, '%k') AS hour FROM ".$phpAds_config['tbl_adclicks']." WHERE ($where) GROUP BY hour";
    $result  = phpAds_dbQuery($query);
    $result2 = phpAds_dbQuery($query2);
    
	
	if (isset ($GLOBALS['phpAds_CharSet']) && $GLOBALS['phpAds_CharSet'] != '')
		$text=array(
		    'value1' => 'AdViews',
		    'value2' => 'AdClicks');
	else
		$text=array(
		    'value1' => $GLOBALS['strViews'],
		    'value2' => $GLOBALS['strClicks']);
    
	
    $items = array();
    // preset array (not every hour may be occupied)
    for ($i=0;$i<=23;$i++)
    {
    	$items[$i] = array();
    	$items[$i]['value1'] = 0;
    	$items[$i]['value2'] = 0;
    	$items[$i]['text'] = '';
    }
	
    while ($row = phpAds_dbFetchRow($result))
    {
    	$i=$row[1];
    	$items[$i]['value1'] = $row[0];
    	$items[$i]['text'] = sprintf("%d",$i);
    }
	
    while ($row2 = phpAds_dbFetchRow($result2))
    {
    	$i=$row2[1];
    	$items[$i]['value2'] = $row2[0];
    	$items[$i]['text'] = sprintf("%d",$i);
    }          
    
    $width=385;   // absolute definition due to width/height declaration in stats.inc.php
    $height=150;  // adapt this if embedding html-document will change
    
    // Build the graph
	include("lib-graph.inc.php");
}

?>