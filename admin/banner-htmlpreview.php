<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");


// Initialize random generator
mt_srand((double)microtime() * 1000000);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		bannerid = '$bannerid'
	") or phpAds_sqlDie();



if ($res)
{
	$row = phpAds_dbFetchArray($res);
	
	echo "<html><head><title>".strip_tags(phpAds_buildBannerName ($bannerid, $row['description'], $row['alt']))."</title>";
	echo "<link rel='stylesheet' href='images/".$phpAds_TextDirection."/interface.css'></head>";
	echo "<body marginheight='0' marginwidth='0' leftmargin='0' topmargin='0' bgcolor='#EFEFEF'>";
	echo "<table cellpadding='0' cellspacing='0' border='0'>";
	echo "<tr height='32'><td width='32'><img src='images/cropmark-tl.gif' width='32' height='32'></td>";
	echo "<td background='images/ruler-top.gif'>&nbsp;</td><td width='32'><img src='images/cropmark-tr.gif' width='32' height='32'></td></tr>";
	echo "<tr height='".$row['height']."'><td width='32' background='images/ruler-left.gif'>&nbsp;</td><td bgcolor='#FFFFFF' width='".$row['width']."'>";
	
	// Output banner
	echo phpAds_buildBannerCode ($row['bannerid'], true);
	
	echo "</td><td width='32'>&nbsp;</td></tr>";
	echo "<tr height='32'><td width='32'><img src='images/cropmark-bl.gif' width='32' height='32'></td><td>";
	
	if ($row['contenttype'] == 'txt')
		echo "&nbsp;";
	else
		echo "&nbsp;&nbsp;&nbsp;".$strWidth.": ".$row['width']."&nbsp;&nbsp;".$strHeight.": ".$row['height']."&nbsp".($row['bannertext'] ? '+ text&nbsp;' : '');
	
	echo "</td><td width='32'><img src='images/cropmark-br.gif' width='32' height='32'></td></tr>";
	echo "</table>";
	
	echo "</body></html>";
}


?>