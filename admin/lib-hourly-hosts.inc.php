<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require	(phpAds_path."/admin/resources/res-iso3166.inc.php"); 



/*********************************************************/
/* Show hourly statistics                                */
/*********************************************************/

if (!$phpAds_config['compact_stats']) 
{
	$begin = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)));
	$end   = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2) + 1, substr($day, 0, 4)));
	
	echo "<br><br>";
	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
  	echo "<tr><td height='25' colspan='1'>&nbsp;&nbsp;<b>".$strTopHosts."</b></td><td><b>".$strCountry."</b></td>";
	echo "<td align='".$phpAds_TextAlignRight."'><b>".$strViews."</b>&nbsp;&nbsp;</td></tr>";
  	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
   	$result = phpAds_dbQuery("
    	SELECT
        	host,
			country,
        	COUNT(*) AS qnt
       	FROM
       		".$phpAds_config['tbl_adviews']."
        WHERE
			t_stamp >= $begin AND t_stamp < $end
        	".(isset($lib_hourly_where) ? 'AND '.$lib_hourly_where : '')."
		GROUP BY
        	host, country
        ORDER BY
        	qnt DESC
        LIMIT 15
	") or phpAds_sqlDie();
	
	$i = 0;
	while ($row = phpAds_dbFetchArray($result))
	{
    	$bgcolor="#FFFFFF";
        $i % 2 ? 0: $bgcolor= "#F6F6F6";
        $i++;
		
        echo "<tr><td height='25' bgcolor='".$bgcolor."'>&nbsp;&nbsp;";
		echo $row["host"];
        echo "</td><td height='25' bgcolor='".$bgcolor."'>&nbsp;";
		echo $row["country"] != '' ? "<img src='images/flags/".strtolower($row["country"]).".gif' width='19' height'11'>&nbsp;".$phpAds_ISO3166[$row["country"]] : '-';
		echo "</td><td height='25' bgcolor='".$bgcolor."' align='".$phpAds_TextAlignRight."'>";
		echo $row["qnt"];
		echo "&nbsp;&nbsp;</td></tr>";
		
		echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
   	}
	
	echo "</table>";
	echo "<br><br>";
	
	
	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
  	echo "<tr><td height='25' colspan='1'>&nbsp;&nbsp;<b>".$strTopCountries."</b></td><td align='".$phpAds_TextAlignRight."'><b>".$strViews."</b>&nbsp;&nbsp;</td></tr>";
  	echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
   	$result = phpAds_dbQuery("
    	SELECT
			country,
        	COUNT(*) AS qnt
       	FROM
       		".$phpAds_config['tbl_adviews']."
        WHERE
			t_stamp >= $begin AND t_stamp < $end
        	".(isset($lib_hourly_where) ? 'AND '.$lib_hourly_where : '')."
		GROUP BY
        	country
        ORDER BY
        	qnt DESC
        LIMIT 15
	") or phpAds_sqlDie();
	
	$i = 0;
	while ($row = phpAds_dbFetchArray($result))
	{
    	$bgcolor="#FFFFFF";
        $i % 2 ? 0: $bgcolor= "#F6F6F6";
        $i++;
		
        echo "<tr><td height='25' bgcolor='".$bgcolor."'>&nbsp;&nbsp;";
		echo $row["country"] != '' ? "<img src='images/flags/".strtolower($row["country"]).".gif' width='19' height'11'>&nbsp;".$phpAds_ISO3166[$row["country"]] : $strUnknown;
		echo "</td><td height='25' bgcolor='".$bgcolor."' align='".$phpAds_TextAlignRight."'>";
		echo $row["qnt"];
		echo "&nbsp;&nbsp;</td></tr>";
		
		echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
   	}
	
	echo "</table>";
	echo "<br><br>";
}

?>