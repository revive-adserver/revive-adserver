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
$Id: stats-campaign-optimise.php 5724 2006-10-16 06:03:30Z arlen $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-data-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-data-campaigns.inc.php';
require_once MAX_PATH . '/www/admin/lib-prefs.inc.php';

// Register input variables
phpAds_registerGlobal (
	 'campaignid'
	,'clientid'
	,'collapse'
	,'expand'
	,'keep'
	,'listorder'
	,'omit'
	,'orderdirection'
);

$page = 'stats.php?entity=campaign&breakdown=optimise';

// BUILD PAGE HEADER
if (phpAds_isUser(phpAds_Admin))
{
	$res = phpAds_dbQuery(
		"SELECT *".
		" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
		" WHERE clientid = '".$clientid."'"
	) or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildName ($row['campaignid'], $row['campaignname']),
			$page."&clientid=".$clientid."&campaignid=".$row['campaignid'],
			$campaignid == $row['campaignid']
		);
	}
	
	phpAds_PageShortcut($strClientProperties, 'advertiser-edit.php?clientid='.$clientid, 'images/icon-advertiser.gif');
	phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
	
	phpAds_PageHeader("2.1.2.5");
		echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getParentClientName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getCampaignName($campaignid)."</b><br /><br /><br />";
		phpAds_ShowSections(array("2.1.2.1", "2.1.2.2", "2.1.2.3", "2.1.2.4", "2.1.2.5"));
}

// GET PREFERENCES
if (!isset($listorder))
	$listorder = phpAds_getPref($page, 'listorder');
if (!isset($orderdirection))
	$orderdirection = phpAds_getPref($page, 'orderdirection');
if ($campaignid == phpAds_getPref($page, 'campaignid'))
{
	$expand_arr = phpAds_getPrefArray($page, 'expand');
	if (isset($omit) && is_array($omit))
	{
		for ($i=0; $i<sizeof($omit); $i++)
		{
			if (!in_array($omit[$i], $keep))
				$omit_arr[] = $omit[$i];
		}
	}
	else
		$omit_arr = phpAds_getPrefArray($page, 'omit');
	
//	$total_arr = phpAds_getPrefArray($page, 'total');
//	$banner_arr = phpAds_getPrefArray($page, 'banners');
}
else
{
	$expand_arr = array();
	$omit_arr = array();
}
$expand_arr = phpAds_updateExpandArray($expand_arr, $expand, $collapse);

// GET DATA
$campaign = phpAds_getCampaignByCampaignID($campaignid);
$total_arr = phpAds_getStatsByCampaignID($campaignid, $strUnfilteredTotal);
$banner_arr = phpAds_getBannerStatsByCampaignID($campaignid, $strBannerFilter, $listorder, $orderdirection, $omit_arr);
$time_arr = phpAds_getHourStatsByCampaignIDBannerIDs($campaignid, $banner_arr['id'], $strHourFilter, $listorder, $orderdirection, $omit_arr);
$source_arr = phpAds_getSourceStatsByCampaignIDBannerIDsHours($campaignid, $banner_arr['id'], $time_arr['id'], $strSourceFilter, $listorder, $orderdirection, $omit_arr);

$filtered_total_arr['name'] = $strFilteredTotal;
$filtered_total_arr['path'] = $time_arr['path'];
$filtered_total_arr['views'] = $time_arr['views'];
$filtered_total_arr['clicks'] = $time_arr['clicks'];
$filtered_total_arr['conversions'] = $time_arr['conversions'];
$filtered_total_arr['ctr'] = $time_arr['ctr'];
$filtered_total_arr['cnvr'] = $time_arr['cnvr'];

// DISPLAY DATA
/// Display Form and Hidden Data...
echo "\t\t\t\t<form action='".$page."' method='post'>\n";
echo "\t\t\t\t<input type='hidden' name='clientid' value='".$campaign['clientid']."'>\n";
echo "\t\t\t\t<input type='hidden' name='campaignid' value='".$campaign['campaignid']."'>\n";

echo "\t\t\t\t<br /><br />\n";
// Check to see if there is any data
if ( ($total_arr['views'] > 0) || ($total_arr['clicks'] > 0) || ($total_arr['conversions'] > 0) )
{
	// Get Column Headers...
	echo "\t\t\t\t<table border='0' width='100%' cellpadding='0' cellspacing='0'>\n";	
	echo "\t\t\t\t<tr height='25'>\n";
	
	$link = $page."?clientid=".$campaign['clientid']."&campaignid=".$campaign['campaignid'];
	
	// Name column header
	echo "\t\t\t\t\t<td>&nbsp;</td>\n";
	echo "\t\t\t\t\t<td width='40%'>".phpAds_getColumnHeader($GLOBALS['strName'], "name", $link, ($listorder=='' ? 'name':$listorder), $orderdirection)."</td>\n";
	// Views column header
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_getColumnHeader($GLOBALS['strImpressions'], 'views', $link, $listorder, $orderdirection)."</td>\n";
	echo "\t\t\t\t\t<td align='center'>%</td>\n";
	// Clicks column header
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_getColumnHeader($GLOBALS['strClicks'], 'clicks', $link, $listorder, $orderdirection)."</td>\n";
	echo "\t\t\t\t\t<td align='center'>%</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_getColumnHeader($GLOBALS['strCTRShort'], 'ctr', $link, $listorder, $orderdirection)."</td>\n";
	echo "\t\t\t\t\t<td align='center'>%</td>\n";
	// Conversions column header
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_getColumnHeader($GLOBALS['strConversions'], "conversions", $link, $listorder, $orderdirection)."</td>\n";
	echo "\t\t\t\t\t<td align='center'>%</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_getColumnHeader($GLOBALS['strCNVRShort'], 'cnvr', $link, $listorder, $orderdirection)."&nbsp;&nbsp;</td>\n";
	echo "\t\t\t\t\t<td align='center'>%</td>\n";
	echo "\t\t\t\t</tr>\n";
	
	phpAds_printTableBreak(12);
	
	$cnt = 0;
	// Total stats before optimisation
	phpAds_displayStatsRow($total_arr, $total_arr, $expand_arr, $omit_arr);	
	// Banner statistics
	phpAds_displayStatsRow($banner_arr, $total_arr, $expand_arr, $omit_arr);	
	// Hour statistics
	phpAds_displayStatsRow($time_arr, $banner_arr, $expand_arr, $omit_arr);
	// Source statistics
	phpAds_displayStatsRow($source_arr, $time_arr, $expand_arr, $omit_arr);
	// Total stats after optimisation
	phpAds_displayStatsRow($filtered_total_arr, $total_arr, $expand_arr, $omit_arr);
	/*
	// Get the list of sources...
	$display_expand = true;
	$expand = ( $expand_arr == 'all' || ( isset($expand_arr['sources']) && ($expand_arr['sources'] == 1) ) );
	$expand_true_link = $page."?clientid=".$clientid."&campaignid=".$campaignid."&collapse=sources";
	$expand_false_link = $page."?clientid=".$clientid."&campaignid=".$campaignid."&expand=sources";
	phpAds_displayStatsRow($source_arr, $strSources, $display_expand, $expand, $expand_true_link, $expand_false_link);
	
	if ($source_arr['views'] > 0 || $source_arr['clicks'] > 0 || $source_arr['conversions'] > 0)
	{
		if ($expand)
		{
			$cnt=0;
		
			for ($i=0; $i<sizeof($source_arr['children']); $i++)
			{
				if (is_array($source_arr['children'][$i]))
				{
					phpAds_printTableBreak(7,1,($cnt%2==0?"#F6F6F6":""));
					phpAds_printSourceRow($source_arr['children'][$i], $sources, $expand_arr, $listorder, $orderdirection, "&nbsp;&nbsp;");
					$cnt++;
				}
			}
		}
		
		// Break
		echo "\t\t\t\t<tr height='1'><td colspan='7' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>\n";
	
		// Expand / Collapse
		echo "\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t<td colspan='7' align='".$phpAds_TextAlignRight."' nowrap>";
		echo "<img src='images/triangle-d.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='stats-campaign-optimise.php?clientid=".$clientid."&campaignid=".$campaignid."&expand=all' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
		echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
		echo "<img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='stats-campaign-optimise.php?clientid=".$clientid."&campaignid=".$campaignid."&expand=none' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>";
		echo "</td>\n";
		echo "\t\t\t\t</tr>";
	
	}
*/
	echo "\t\t\t\t</table>\n";
	echo "\t\t\t\t<br /><br />\n";
}
else
{
	echo "\t\t\t\t<br /><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>";
	echo $strNoStats."</div>\n";
}

echo "\t\t\t\t<input type='submit' value='Update Fields'>\n";
echo "\t\t\t\t</form>\n";

phpAds_PageFooter();

// STORE PREFERENCES
phpAds_setPref($page, 'listorder', $listorder);
phpAds_setPref($page, 'orderdirection', $orderdirection);
phpAds_setPref($page, 'expand', implode(',', $expand_arr));
phpAds_setPref($page, 'omit', implode(',', $omit_arr));
phpAds_setPref($page, 'campaignid', $campaignid);
//phpAds_setPref($page, 'total', $total_arr);
//phpAds_setPref($page, 'banners', $banner_arr);
phpAds_SessionDataStore();

function phpAds_displayStatsRow($data_arr, $total_arr, $expand_arr, $omit_arr, $level = 0)
{
	global
		 $campaignid
		,$clientid
		,$cnt
		,$phpAds_TextDirection
		,$phpAds_TextAlignRight
	;
	$show_children = false;
	
	echo "\t\t\t\t<tr height='25' ".($cnt%2==0?"bgcolor='#F6F6F6'":"").">\n";
	if ($level == 0)
		echo "\t\t\t\t\t<td colspan='2'>";
	else
	{
		$checked = in_array($data_arr['path'], $omit_arr) ? '' : ' checked';
		echo "\t\t\t\t\t<td><input type='checkbox' name='keep[]' value='".$data_arr['path']."'".$checked."><input type='hidden' name='omit[]' value='".$path."'></td>\n";
		echo "\t\t\t\t\t<td>";

		if ($level > 1)
			echo "<img src='images/spacer.gif' width='".($level*15)."' height='1' border='0'>";
	}
	
	if (isset($data_arr['children']) && is_array($data_arr['children']) && (sizeof($data_arr['children']) > 0) )
	{
		if (in_array($data_arr['name'], $expand_arr))
		{
			echo "<a href='stats.php?entity=campaign&breakdown=optimise&clientid=".$clientid."&campaignid=".$campaignid."&collapse=".$data_arr['name']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>";
			$show_children = true;
		}
		else
			echo "<a href='stats.php?entity=campaign&breakdown=optimise&clientid=".$clientid."&campaignid=".$campaignid."&expand=".$data_arr['name']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>";
	}

	if ($level == 0)
		echo "&nbsp;<b>".$data_arr['name']."</b></td>\n";
	else
		echo "&nbsp;".$data_arr['name']."</td>\n";

	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($data_arr['views'])."</td>\n";
	echo "\t\t\t\t\t<td align='center'>(".phpAds_formatPercentage(phpAds_buildRatio($data_arr['views'], $total_arr['views']),0).")</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($data_arr['clicks'])."</td>\n";
	echo "\t\t\t\t\t<td align='center'>(".phpAds_formatPercentage(phpAds_buildRatio($data_arr['clicks'], $total_arr['clicks']),0).")</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatPercentage($data_arr['ctr'])."</td>\n";
	echo "\t\t\t\t\t<td align='center'>(".phpAds_formatPercentage(phpAds_buildRatio($data_arr['ctr'], $total_arr['ctr']),0).")</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($data_arr['conversions'])."</td>\n";
	echo "\t\t\t\t\t<td align='center'>(".phpAds_formatPercentage(phpAds_buildRatio($data_arr['conversions'], $total_arr['conversions']),0).")</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatPercentage($data_arr['cnvr'])."&nbsp;&nbsp;</td>\n";
	echo "\t\t\t\t\t<td align='center'>(".phpAds_formatPercentage(phpAds_buildRatio($data_arr['cnvr'], $total_arr['cnvr']),0).")</td>\n";
	echo "\t\t\t\t</tr>\n";
	
	if ($show_children)
	{
		for ($i=0; $i<sizeof($data_arr['children']); $i++)
		{
			phpAds_displayStatsRow($data_arr['children'][$i], $total_arr, $expand_arr, $omit_arr, $level+1);
		}
	}
	
	if ($level == 0)
		$cnt++;
			
}	

function phpAds_printSourceRow($source_row, $sources, $expand_arr, $listorder, $orderdirection, $begin_str)
{
	global
		 $anonymous
		,$campaignid
		,$clientid
		,$cnt
		,$phpAds_TextDirection
		,$phpAds_TextAlignRight
	;
	
	$expand = ( $expand_arr == 'all' || ( isset($expand_arr['sources/'.$source_row['path']]) && ($expand_arr['sources/'.$source_row['path']] == 1) ) );
	$children_present = ( isset($source_row['children']) && is_array($source_row['children']) & (sizeof($source_row['children']) > 0) );
	$checked = '';
	for ($i=0; $i<sizeof($sources); $i++)
	{
		if ($sources[$i] == $source_row['path'])
		{
			$checked = ' checked';
			break;
		}
	}

	echo "\t\t\t\t<tr height='25' ".($cnt%2==0?"bgcolor='#F6F6F6'":"").">\n";
	echo "\t\t\t\t\t<td><input type='checkbox' name='sources[]' value='".$source_row['path']."'".$checked."></td>\n";
	echo "\t\t\t\t\t<td>";
	echo $begin_str;
	
	if ($children_present && !$anonymous)
	{
		if ($expand)
			echo "<a href='stats.php?entity=campaign&breakdown=optimise&clientid=".$clientid."&campaignid=".$campaignid."&collapse=".urlencode('sources/'.$source_row['path'])."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
		else
			echo "<a href='stats.php?entity=campaign&breakdown=optimise clientid=".$clientid."&campaignid=".$campaignid."&expand=".urlencode('sources/'.$source_row['path'])."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
	}
	else
		echo "<img src='images/spacer.gif' align='absmiddle' width='16' height='16' border='0'>";

	if ($anonymous)
		echo "(hidden source #".($cnt+1).")";
	else
		echo $source_row['source'];

	echo "</td>\n";	
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($source_row['views'])."</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($source_row['clicks'])."</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($source_row['views'], $source_row['clicks'])."</td>";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($source_row['conversions'])."</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($source_row['clicks'], $source_row['conversions'])."&nbsp;&nbsp;</td>";
	echo "\t\t\t\t</tr>\n";
	
	if ($expand && $children_present && !$anonymous)
	{
		$child_source_row = $source_row['children'];
		for ($i=0; $i<sizeof($child_source_row); $i++)
		{
			phpAds_printTableBreak(7,2,($cnt%2==0?"#F6F6F6":""));
			phpAds_printSourceRow($child_source_row[$i], $sources, $expand_arr, $listorder, $orderdirection, $begin_str."&nbsp;&nbsp;&nbsp;&nbsp;");
		}
	}
}

function phpAds_printTableBreak($num_columns, $offset=0, $bgcolor='')
{
	
	echo "\t\t\t\t<tr height='1'";

	if ($offset > 0)
	{
		if (strlen($bgcolor) > 0)
		{
			$bgcolor = " bgcolor='".$bgcolor."'";
		}

		echo $bgcolor."><td";
		
		if ($offset > 1)
		{
			echo " colspan='".$offset."'";
		}
		
		echo "><img src='images/spacer.gif' width='100%' height='1' border='0'></td>";
	}
	
	echo "<td colspan='".($num_columns-$offset)." bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>\n";
}

function phpAds_getColumnHeader($name, $id, $link, $listorder, $orderdirection)
{
	$str = "<b><a href='".$link."&listorder=".$id."'>".$name."</a>";
	
	if (($listorder == $id))
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			$str .= "<a href='".$link."&orderdirection=up'>";
			$str .= "<img src='images/caret-ds.gif' border='0' alt='' title=''>";
		}
		else
		{
			$str .= "<a href='".$link."&orderdirection=down'>";
			$str .= "<img src='images/caret-u.gif' border='0' alt='' title=''>";
		}
		$str .= "</a>";
	}
	
	$str .= "</b>";
	
	return $str;
}
?>
