<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/




/*********************************************************/
/* Show hourly statistics                                */
/*********************************************************/

if (!$phpAds_config['compact_stats']) 
{
	$begin = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)));
	$end   = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2) + 1, substr($day, 0, 4)));
	
	echo "<br><br>";
	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
  	echo "<tr><td height='25' colspan='2'><b>".$strTopTenHosts."</b></td></tr>";
  	echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
   	$result = phpAds_dbQuery("
    	SELECT
        	host,
        	COUNT(*) AS qnt
       	FROM
       		".$phpAds_config['tbl_adviews']."
        WHERE
			t_stamp >= $begin AND t_stamp < $end
        	".(isset($lib_hourly_where) ? 'AND '.$lib_hourly_where : '')."
		GROUP BY
        	host
        ORDER BY
        	qnt DESC
        LIMIT 10
	") or phpAds_sqlDie();
	
	$i = 0;
	while ($row = phpAds_dbFetchArray($result))
	{
    	$bgcolor="#FFFFFF";
        $i % 2 ? 0: $bgcolor= "#F6F6F6";
        $i++;
		
        echo "<tr><td height='25' bgcolor='".$bgcolor."'>&nbsp;";
		echo $row["host"]."</td>";
		echo "<td height='25' bgcolor='".$bgcolor."'>";
		echo "<b>".$row["qnt"]."</b></td></tr>";
		
		echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
   	}
}

echo "</table>";
echo "<br><br>";

?>