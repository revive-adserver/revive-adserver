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
$Id: stats-campaign-sources.php 5724 2006-10-16 06:03:30Z arlen $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/www/admin/lib-data-sources.inc.php';
require_once MAX_PATH . '/www/admin/lib-data-campaigns.inc.php';

// Register input variables
phpAds_registerGlobal (
	 'collapse'
	,'expand'
	,'listorder'
	,'orderdirection'
);


// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);

// Check to see if they are switching...
if (isset($distributiontype) && ($distributiontype == 'z') )
{
	Header("Location: stats.php?entity=campaign&breakdown=affiliates&clientid=".$clientid."&campaignid=".$campaignid);
	exit;
}

/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($listorder))
{
	if (isset($session['prefs']['stats.php?entity=campaign&breakdown=sources']['listorder']))
		$listorder = $session['prefs']['stats.php?entity=campaign&breakdown=sources']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($session['prefs']['stats.php?entity=campaign&breakdown=sources']['orderdirection']))
		$orderdirection = $session['prefs']['stats.php?entity=campaign&breakdown=sources']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($session['prefs']['stats.php?entity=campaign&breakdown=sources']['nodes']))
	$node_array = explode (",", $session['prefs']['stats.php?entity=campaign&breakdown=sources']['nodes']);
else
	$node_array = array();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (isset($session['prefs']['stats.php?entity=advertiser&breakdown=campaigns']['listorder']))
	$navorder = $session['prefs']['stats.php?entity=advertiser&breakdown=campaigns']['listorder'];
else
	$navorder = '';

if (isset($session['prefs']['stats.php?entity=advertiser&breakdown=campaigns']['orderdirection']))
	$navdirection = $session['prefs']['stats.php?entity=advertiser&breakdown=campaigns']['orderdirection'];
else
	$navdirection = '';

if (phpAds_isUser(phpAds_Client))
{
	if (phpAds_getUserID() == phpAds_getCampaignParentClientID ($campaignid))
	{
		$res = phpAds_dbQuery(
			"SELECT campaignid,campaignname".
			" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
			" WHERE clientid = ".phpAds_getUserID().
			phpAds_getCampaignListOrder ($navorder, $navdirection)
		) or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($res))
		{
			phpAds_PageContext (
				phpAds_buildName ($row['campaignid'], $row['campaignname']),
				"stats.php?entity=campaign&breakdown=sources&clientid=".$clientid."&campaignid=".$row['campaignid'],
				$campaignid == $row['campaignid']
			);
		}
		
		phpAds_PageHeader("1.2.3");
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getCampaignName($campaignid)."</b><br /><br /><br />";
			phpAds_ShowSections(array("1.2.1", "1.2.2", "1.2.3", "1.2.4"));
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}
elseif (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency))
{
	if (phpAds_isUser(phpAds_Admin))
	{
		$query = "SELECT campaignid,campaignname".
			" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
			" WHERE clientid='".$clientid."'".
			phpAds_getCampaignListOrder ($navorder, $navdirection);
	}
	elseif (phpAds_isUser(phpAds_Agency))
	{
		$query = "SELECT m.campaignid AS campaignid".
			",m.campaignname AS campaignname".
			" FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
			",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
			" WHERE m.clientid=c.clientid".
			" AND m.clientid='".$clientid."'".
			" AND c.agencyid=".phpAds_getUserID().
			phpAds_getCampaignListOrder ($navorder, $navdirection);
	}
	$res = phpAds_dbQuery($query)
		or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildName ($row['campaignid'], $row['campaignname']),
			"stats.php?entity=campaign&breakdown=sources&clientid=".$clientid."&campaignid=".$row['campaignid'],
			$campaignid == $row['campaignid']
		);
	}
	
	phpAds_PageShortcut($strClientProperties, 'advertiser-edit.php?clientid='.$clientid, 'images/icon-advertiser.gif');
	phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
	
	phpAds_PageHeader("2.1.2.3");
		echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getParentClientName($campaignid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getCampaignName($campaignid)."</b><br /><br /><br />";
		phpAds_ShowSections(array("2.1.2.1", "2.1.2.2", "2.1.2.3", "2.1.2.4", "2.1.2.5"));
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Check to see if this campaign is anonymous
$campaign = phpAds_getCampaignByCampaignID($campaignid);
$anonymous = ($campaign['anonymous'] == 't');

// Add ID found in expand to expanded nodes
if (isset($expand) && ($expand != ''))
{
	if ($expand == 'none')
	{
		$node_array = array();
	}
	elseif ($expand != 'all')
	{
		$node_array[] = $expand;
	}
}

$arrlen = sizeof($node_array);
for ($i=0; $i<$arrlen; $i++)
{
	if (isset($collapse) && ($collapse == $node_array[$i]) )
	{
		unset ($node_array[$i]);
	}
	elseif (strlen($node_array[$i]) == 0)
	{
		unset ($node_array[$i]);
	}
	else
	{
		$sources_expand[$node_array[$i]] = 1;
	}
}

if ($expand == 'all')
	$sources_expand = 'all';

// Get the list of sources...
$source_arr = phpAds_getSourceStatsByCampaignID($campaignid, $listorder, $orderdirection);

echo "\t\t\t\t<form action='".$_SERVER['PHP_SELF']."'>\n";
echo "\t\t\t\t<input type='hidden' name='clientid' value='".$clientid."'>\n";
echo "\t\t\t\t<input type='hidden' name='campaignid' value='".$campaignid."'>\n";
echo "\t\t\t\t".$strDistributionBy." <select name='distributiontype' onChange='this.form.submit();' accesskey='".$keyList."' tabindex='".($tabindex++)."'>\n";
echo "\t\t\t\t\t<option value='z'>".$strZone."</option>\n";
echo "\t\t\t\t\t<option value='s' selected>".$strSource."</option>\n";
echo "\t\t\t\t</select>\n";

phpAds_ShowBreak();
echo "\t\t\t\t</form>\n";


if ($source_arr['views'] > 0 || $source_arr['clicks'] > 0 || $source_arr['conversions'] > 0)
{
	echo "\t\t\t\t<br /><br />\n";
	echo "\t\t\t\t<table border='0' width='100%' cellpadding='0' cellspacing='0'>\n";	
	
	echo "\t\t\t\t<tr height='25'>\n";
	
	$link = "stats.php?entity=campaign&breakdown=sources&clientid=".$clientid."&campaignid=".$campaignid;

	// Name column header
	echo "\t\t\t\t\t<td height='25' width='40%'>".phpAds_getColumnHeader($GLOBALS['strName'], "name", $link, ($listorder=='' ? 'name':$listorder), $orderdirection)."</td>\n";
	// Views column header
	echo "\t\t\t\t\t<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_getColumnHeader($GLOBALS['strImpressions'], 'views', $link, $listorder, $orderdirection)."</td>\n";
	// Clicks column header
	echo "\t\t\t\t\t<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_getColumnHeader($GLOBALS['strClicks'], 'clicks', $link, $listorder, $orderdirection)."</td>\n";
	echo "\t\t\t\t\t<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_getColumnHeader($GLOBALS['strCTRShort'], 'ctr', $link, $listorder, $orderdirection)."</td>\n";
	// Conversions column header
	echo "\t\t\t\t\t<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_getColumnHeader($GLOBALS['strConversions'], "conversions", $link, $listorder, $orderdirection)."</td>\n";
	echo "\t\t\t\t\t<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_getColumnHeader($GLOBALS['strCNVRShort'], 'cnvr', $link, $listorder, $orderdirection)."&nbsp;&nbsp;</td>\n";
	echo "\t\t\t\t</tr>\n";
	
	echo "\t\t\t\t<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>\n";
	
	
	$cnt=0;

	for ($i=0; $i<sizeof($source_arr['children']); $i++)
	{
		if (is_array($source_arr['children'][$i]))
		{
			phpAds_printSourceRow($source_arr['children'][$i], $sources_expand, $listorder, $orderdirection, "&nbsp;&nbsp;");
			echo "\t\t\t\t<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>\n";
			$cnt++;
		}
	}
	
	// Total
	echo "\t\t\t\t<tr height='25'>\n";
	echo "\t\t\t\t\t<td>&nbsp;&nbsp;<b>".$strTotal."</b></td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($source_arr['views'])."</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($source_arr['clicks'])."</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatPercentage($source_arr['ctr'])."</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($source_arr['conversions'])."</td>\n";
	echo "\t\t\t\t\t<td align='".$phpAds_TextAlignRight."'>".phpAds_formatPercentage($source_arr['cnvr'])."&nbsp;&nbsp;</td>\n";
	echo "\t\t\t\t</tr>\n";
	
	// Break
	echo "\t\t\t\t<tr height='1'><td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>\n";

	// Expand / Collapse
	echo "\t\t\t\t<tr>\n";
	echo "\t\t\t\t\t<td colspan='6' align='".$phpAds_TextAlignRight."' nowrap>";
	echo "<img src='images/triangle-d.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='stats.php?entity=campaign&breakdown=sources&clientid=".$clientid."&campaignid=".$campaignid."&expand=all' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
	echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
	echo "<img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='stats.php?entity=campaign&breakdown=sources&clientid=".$clientid."&campaignid=".$campaignid."&expand=none' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>";
	echo "</td>\n";
	echo "\t\t\t\t</tr>";

	echo "\t\t\t\t</table>\n";
	echo "\t\t\t\t<br /><br />\n";
}
else
{
	echo "\t\t\t\t<br /><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>";
	echo $strNoStats."</div>\n";
}

/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['stats.php?entity=campaign&breakdown=sources']['listorder'] = $listorder;
$session['prefs']['stats.php?entity=campaign&breakdown=sources']['orderdirection'] = $orderdirection;
$session['prefs']['stats.php?entity=campaign&breakdown=sources']['nodes'] = implode (",", $node_array);

phpAds_SessionDataStore();



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

function phpAds_printSourceRow($source_row, $expand_arr, $listorder, $orderdirection, $begin_str)
{
	global
		 $anonymous
		,$campaignid
		,$clientid
		,$cnt
		,$phpAds_TextDirection
		,$phpAds_TextAlignRight
	;
	
	$expand = ( $expand_arr == 'all' || ( isset($expand_arr[$source_row['path']]) && ($expand_arr[$source_row['path']] == 1) ) );
	$children_present = ( isset($source_row['children']) && is_array($source_row['children']) & (sizeof($source_row['children']) > 0) );

	echo "\t\t\t\t<tr height='25' ".($cnt%2==0?"bgcolor='#F6F6F6'":"").">\n";
	echo "\t\t\t\t\t<td>";
	echo $begin_str;
	
	if ($children_present && !$anonymous)
	{
		if ($expand)
			echo "<a href='stats.php?entity=campaign&breakdown=sources&clientid=".$clientid."&campaignid=".$campaignid."&collapse=".urlencode($source_row['path'])."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
		else
			echo "<a href='stats.php?entity=campaign&breakdown=sources&clientid=".$clientid."&campaignid=".$campaignid."&expand=".urlencode($source_row['path'])."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
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
			echo "\t\t\t\t<tr height='1'".($cnt%2==0?" bgcolor='#F6F6F6'":"")."><td><img src='images/spacer.gif' width='100%' height='1' border='0'></td><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>\n";
			phpAds_printSourceRow($child_source_row[$i], $expand_arr, $listorder, $orderdirection, $begin_str."&nbsp;&nbsp;&nbsp;&nbsp;");
		}
	}
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
