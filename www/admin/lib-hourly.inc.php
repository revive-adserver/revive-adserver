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
$Id$
*/

/*-------------------------------------------------------*/
/* Show hourly statistics                                */
/*-------------------------------------------------------*/

$query = "
	SELECT
		hour,
        SUM(requests) AS requests,
		SUM(impressions) AS views,
		SUM(clicks) AS clicks,
		SUM(conversions) AS conversions
	FROM
		".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']."
	WHERE
		day = ".$day."
		".(isset($lib_hourly_where) ? 'AND '.$lib_hourly_where : '')."
	GROUP BY 
		hour";
$result = phpAds_dbQuery($query)
    or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($result)) {
    $requests[$row['hour']]     = $row['requests'];
	$views[$row['hour']] 		= $row['views'];
	$clicks[$row['hour']] 		= $row['clicks'];
	$conversions[$row['hour']] 	= $row['conversions'];
}

echo "<br /><br />";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr bgcolor='#FFFFFF' height='25'>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strHour</b></td>";
if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' nowrap height='25'><b>$strRequests</b></td>";
echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strImpressions."</b></td>";
echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strClicks."</b></td>";
echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strCTRShort."</b>&nbsp;&nbsp;</td>";
echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strConversions."</b>&nbsp;&nbsp;</td>";
echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strCNVR."</b>&nbsp;&nbsp;</td>";
echo "</tr>";

echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

$totalrequests = 0;
$totalviews = 0;
$totalclicks = 0;
$totalconversions = 0;

for ($i=0; $i<24; $i++) {
	$bgcolor = ($i % 2 ? "#FFFFFF": "#F6F6F6");
	
	if (!isset($requests[$i])) $requests[$i] = 0;
	if (!isset($views[$i])) $views[$i] = 0;
	if (!isset($clicks[$i])) $clicks[$i] = 0;
	if (!isset($conversions[$i])) $conversions[$i] = 0;
	
	$totalrequests      += $requests[$i];
	$totalviews 		+= $views[$i];
	$totalclicks 		+= $clicks[$i];
	$totalconversions 	+= $conversions[$i];
	
	if ($requests[$i] > 0 || $views[$i] > 0 || $clicks[$i] > 0 || $conversions[$i] > 0) {
		$ctr 				= phpAds_buildRatioPercentage($clicks[$i], $views[$i]);
		$requests[$i]       = phpAds_formatNumber($requests[$i]);
		$views[$i] 			= phpAds_formatNumber($views[$i]);
		$clicks[$i] 		= phpAds_formatNumber($clicks[$i]);
		$conversions[$i]	= phpAds_formatNumber($conversions[$i]);
		$cr					= phpAds_buildRatioPercentage($conversions[$i], $clicks[$i]);
	} else {
		$ctr				= '-';
		$requests[$i]       = '-';
		$views[$i]			= '-';
		$clicks[$i]			= '-';
		$conversions[$i]	= '-';
		$cr					= '-';
	}
	
	$basestamp = mktime ($i, 0, 0, date('m'), date('d'), date('Y'));
	
	echo "<tr>";
	echo "<td height='25' bgcolor='$bgcolor'>&nbsp;";
	echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;"; 
	echo strftime ($minute_format, $basestamp)."&nbsp;-&nbsp;". strftime ($minute_format, $basestamp + (59 * 60));
	echo "</td>";
	if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".$requests[$i]."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".$views[$i]."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".$clicks[$i]."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".$ctr."&nbsp;&nbsp;</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>";
	if($conversions[$i] !== '-') {
        $statsConvUrl = "stats-conversions.php?day=".$day."&hour=".strftime('%H', $basestamp);
        if(!empty($clientid)) {
            $statsConvUrl .= '&clientid='.$clientid;
        }
        if(!empty($affiliateid)) {
            $statsConvUrl .= '&affiliateid='.$affiliateid;
        }
        if(!empty($zoneid)) {
            $statsConvUrl .= '&zoneid='.$zoneid;
        }
        echo "<a href='$statsConvUrl'><u>".$conversions[$i]."</u></a>";
    } else {
        echo $conversions[$i];
    }
	echo "&nbsp;&nbsp;</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".$cr."&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

if ($totalrequests > 0 || $totalviews > 0 || $totalclicks > 0 || $totalconversions > 0) {
	echo "<tr><td colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."'>&nbsp;</td></tr>";	
	echo "<tr><td colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."'>&nbsp;</td></tr>";

	echo "<tr bgcolor='#FFFFFF' height='25'>";
	echo "<td></td>";
	if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strRequests."</b></td>";
	echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strImpressions."</b></td>";
	echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strClicks."</b></td>";
	echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strCTRShort."</b>&nbsp;&nbsp;</td>";
	echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strConversions."</b>&nbsp;&nbsp;</td>";
	echo "<td align='".$phpAds_TextAlignRight."' width='15%' nowrap height='25'><b>".$strCNVR."</b>&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td height='25'>&nbsp;<b>$strTotal</b></td>";
	if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalrequests)."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalviews)."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalclicks)."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildRatioPercentage($totalclicks, $totalviews)."&nbsp;&nbsp;</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25'>";
	if($totalconversions !== '-') {
        $statsConvUrl = "stats-conversions.php?day=".$day;
        if(!empty($clientid)) {
            $statsConvUrl .= '&clientid='.$clientid;
        }
        if(!empty($affiliateid)) {
            $statsConvUrl .= '&affiliateid='.$affiliateid;
        }
        if(!empty($zoneid)) {
            $statsConvUrl .= '&zoneid='.$zoneid;
        }
        echo "<a href='$statsConvUrl'><u>".phpAds_formatNumber($totalconversions)."</u></a>";
    } else {
        echo phpAds_formatNumber($totalconversions);
    }
	echo "&nbsp;&nbsp;</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_buildRatioPercentage($totalconversions, $totalclicks)."&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	echo "<tr>";
	echo "<td height='25'>&nbsp;".$strAverage."</td>";
	if ($conf['logging']['adRequests']) echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalrequests / 24)."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalviews / 24)."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalclicks / 24)."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25'>"."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25'>".phpAds_formatNumber($totalconversions / 24)."&nbsp;&nbsp;</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25'>"."&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='".(($conf['logging']['adRequests']) ? '7' : '6')."' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";
echo "<br /><br />";

?>