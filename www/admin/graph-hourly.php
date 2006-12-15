<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: graph-hourly.php 4346 2006-03-06 16:43:19Z andrew@m3.net $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';

// Register input variables
phpAds_registerGlobal ('where');

/*-------------------------------------------------------*/
/* Prepare data for graph                                */
/*-------------------------------------------------------*/

$where   = urldecode($where); 
$query	 = "SELECT impressions AS views,clicks,hour".
	" FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].
	" WHERE ($where)";

$result  = phpAds_dbQuery($query)
	or phpAds_sqlDie();

if (isset ($GLOBALS['phpAds_CharSet']) && $GLOBALS['phpAds_CharSet'] != '') {
	$text=array(
	    'value1' => 'AdViews',
	    'value2' => 'AdClicks');
} else {
	$text=array(
	    'value1' => $GLOBALS['strImpressions'],
	    'value2' => $GLOBALS['strClicks']);
}

$items = array();
// preset array (not every hour may be occupied)
for ($i = 0; $i <= 23; $i++) {
	$items[$i] = array();
	$items[$i]['value1'] = 0;
	$items[$i]['value2'] = 0;
	$items[$i]['text'] = '';
}

while ($row = phpAds_dbFetchArray($result)) {
	$i=$row['hour'];
	$items[$i]['value1'] = $row['views'];
	$items[$i]['value2'] = $row['clicks'];
	$items[$i]['text'] = sprintf("%d",$i);
}

$width=385;   // absolute definition due to width/height declaration in stats.inc.php
$height=150;  // adapt this if embedding html-document will change

// Build the graph
include("lib-graph.inc.php");

?>