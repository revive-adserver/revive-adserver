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



/*********************************************************/
/* Resolve ip to domainname                              */
/*********************************************************/

if (isset($ip))
{
	header("Content-type: application/x-javascript");
	while (list(,$v) = each($ip)) {
		echo "setTextOfLayer('host".str_replace('.', '_', $v)."', '".@gethostbyaddr($v)."');\n";
	}
	
	exit;
}





// Include required files
require	(phpAds_path."/libraries/resources/res-iso3166.inc.php"); 
require	(phpAds_path."/libraries/resources/res-continent.inc.php"); 


/*********************************************************/
/* Show hourly statistics                                */
/*********************************************************/

$gethostbyaddr = array();

if (!$phpAds_config['compact_stats']) 
{
	$begin = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)));
	$end   = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2) + 1, substr($day, 0, 4)));
	
	echo "<br><br>";
	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
  	echo "<tr><td height='25' colspan='2'>&nbsp;&nbsp;<b>".$strTopHosts."</b></td><td><b>".$strCountry."</b></td>";
	echo "<td align='".$phpAds_TextAlignRight."'><b>".$strViews."</b>&nbsp;&nbsp;</td></tr>";
  	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
   	$result = phpAds_dbQuery("
    	SELECT
        	host,
			country,
        	COUNT(*) AS qnt,
			UNIX_TIMESTAMP(MAX(t_stamp)) AS time
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
		
		if (ereg('[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}', $row['host']))
		{
			$gethostbyaddr[str_replace('.', '_', $row['host'])] = $row['host'];
		}
		
        echo "<tr><td height='25' bgcolor='".$bgcolor."'>&nbsp;&nbsp;";
		echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;";
		echo strftime($time_format, $row['time']);
        echo "</td><td height='25' bgcolor='".$bgcolor."' nowrap>";
        echo "<span id='host".str_replace('.', '_', $row['host'])."'>".$row['host']."</span>";
        echo "</td><td height='25' bgcolor='".$bgcolor."'>&nbsp;";

		$flag = ($row["country"] == '' || $row["country"] == 'A1' || $row["country"] == 'A2') 'unknown' : strtolower($row["country"]);
		echo "<img src='images/flags/".$flag.".gif' width='19' height'11'>&nbsp;".($row["country"] != '' ? $phpAds_ISO3166[$row["country"]] : '-');
		
		echo "</td><td height='25' bgcolor='".$bgcolor."' align='".$phpAds_TextAlignRight."'>";
		echo $row["qnt"];
		echo "&nbsp;&nbsp;</td></tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
   	}
	/*
	echo "</table>";
	echo "<br><br>";
	echo "<br><br>";
	*/
	
	$begin = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)));
	$end   = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2) + 1, substr($day, 0, 4)));
	
	//echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
  	echo "<tr><td><br><br><br><br></td></tr>";
	echo "<tr><td height='25' colspan='2'>&nbsp;&nbsp;<b>".$strRecentHosts."</b></td><td><b>".$strCountry."</b></td>";
	echo "<td align='".$phpAds_TextAlignRight."'><b>".$strViews."</b>&nbsp;&nbsp;</td></tr>";
  	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
   	$result = phpAds_dbQuery("
    	SELECT
        	host,
			country,
        	COUNT(*) AS qnt,
			UNIX_TIMESTAMP(MAX(t_stamp)) AS time
       	FROM
       		".$phpAds_config['tbl_adviews']."
        WHERE
			t_stamp >= $begin AND t_stamp < $end
        	".(isset($lib_hourly_where) ? 'AND '.$lib_hourly_where : '')."
		GROUP BY
        	host, country
        ORDER BY
        	time DESC
        LIMIT 15
	") or phpAds_sqlDie();
	
	$i = 0;
	while ($row = phpAds_dbFetchArray($result))
	{
    	$bgcolor="#FFFFFF";
        $i % 2 ? 0: $bgcolor= "#F6F6F6";
        $i++;
		
		if (ereg('[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}', $row['host']))
		{
			$gethostbyaddr[str_replace('.', '_', $row['host'])] = $row['host'];
		}
        
		echo "<tr><td height='25' bgcolor='".$bgcolor."'>&nbsp;&nbsp;";
		echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;";
		echo strftime($time_format, $row['time']);
        echo "</td><td height='25' bgcolor='".$bgcolor."' nowrap>";
        echo "<span id='host".str_replace('.', '_', $row['host'])."'>".$row['host']."</span>";
        echo "</td><td height='25' bgcolor='".$bgcolor."'>&nbsp;";
		echo $row["country"] != '' ? "<img src='images/flags/".strtolower($row["country"]).".gif' width='19' height'11'>&nbsp;".$phpAds_ISO3166[$row["country"]] : '-';
		echo "</td><td height='25' bgcolor='".$bgcolor."' align='".$phpAds_TextAlignRight."'>";
		echo $row["qnt"];
		echo "&nbsp;&nbsp;</td></tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
   	}
	
	echo "</table>";
	echo "<br><br>";
	echo "<br><br>";
	
	
	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
  	echo "<tr><td height='25' colspan='1'>&nbsp;&nbsp;<b>".$strTopCountries."</b></td><td><b>".$strContinent."</b></td>";
	echo "<td align='".$phpAds_TextAlignRight."'><b>".$strViews."</b>&nbsp;&nbsp;</td></tr>";
  	echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
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
        echo "</td><td height='25' bgcolor='".$bgcolor."'>&nbsp;";
		echo $row["country"] != '' ? $phpAds_cont_name[$phpAds_continent[$row["country"]]] : '-';
		echo "</td><td height='25' bgcolor='".$bgcolor."' align='".$phpAds_TextAlignRight."'>";
		echo $row["qnt"];
		echo "&nbsp;&nbsp;</td></tr>";
		
		echo "<tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
   	}
	
	echo "</table>";
	echo "<br><br>";
	
	phpAds_PageFooter();
	
	if (count($gethostbyaddr))
	{
		?>
	
	<script language='JavaScript'>
	<!--
		function gethostbyaddr() {
			document.write ("<script language='JavaScript' src='lib-hourly-hosts.inc.php?ip[]=<?php echo implode ('&ip[]=', $gethostbyaddr); ?>'></script>");
		}
		
		gethostbyaddr();
	//-->
	</script>
	
		<?php
	}
	
	exit;
}

?>