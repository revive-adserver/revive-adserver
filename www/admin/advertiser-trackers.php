<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal ('listorder', 'orderdirection');


/*-------------------------------------------------------*/
/* Advertiser interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);

/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($listorder))
{
	if (isset($session['prefs']['advertiser-trackers.php']['listorder']))
		$listorder = $session['prefs']['advertiser-trackers.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($session['prefs']['advertiser-trackers.php']['orderdirection']))
		$orderdirection = $session['prefs']['advertiser-trackers.php']['orderdirection'];
	else
		$orderdirection = '';
}



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
{
    addPageTools($clientid);
    addAdvertiserPageToolsAndShortcuts($clientid);
	$oHeaderModel = buildAdvertiserHeaderModel($clientid);
	phpAds_PageHeader(null, $oHeaderModel);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Get clients & campaign and build the tree
$doTrackers = OA_Dal::factoryDO('trackers');
$doTrackers->clientid = $clientid;
$doTrackers->addListOrderBy($listorder, $orderdirection);
$doTrackers->find();

echo "\t\t\t\t<table border='0' width='100%' cellpadding='0' cellspacing='0'>\n";


echo "\t\t\t\t<tr height='25'>\n";
echo "\t\t\t\t\t<td height='25' width='40%'>\n";
echo "\t\t\t\t\t\t<b>&nbsp;&nbsp;";
echo "<a href='advertiser-trackers.php?clientid=".$clientid."&listorder=name'>".$GLOBALS['strName']."</a>";

if (($listorder == "name") || ($listorder == ""))
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo "<a href='advertiser-trackers.php?clientid=".$clientid."&orderdirection=up'>";
		echo "<img src='" . OX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''>";
	}
	else
	{
		echo "<a href='advertiser-trackers.php?clientid=".$clientid."&orderdirection=down'>";
		echo "<img src='" . OX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''>";
	}
	echo "</a>";
}

echo "</b>\n";
echo "\t\t\t\t\t</td>\n";
echo "\t\t\t\t\t<td height='25'><b><a href='advertiser-trackers.php?clientid=".$clientid."&listorder=id'>".$GLOBALS['strID']."</a>";

if ($listorder == "id")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo "<a href='advertiser-trackers.php?clientid=".$clientid."&orderdirection=up'>";
		echo "<img src='" . OX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''>";
	}
	else
	{
		echo "<a href='advertiser-trackers.php?clientid=".$clientid."&orderdirection=down'>";
		echo "<img src='" . OX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''>";
	}
	echo "</a>";
}

echo "</b>&nbsp;&nbsp;&nbsp;";
echo "</td>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";


if (!$doTrackers->getRowCount())
{
	echo "\t\t\t\t<tr height='25' bgcolor='#F6F6F6'>\n";
	echo "\t\t\t\t\t<td height='25' colspan='4'>";
	echo "&nbsp;&nbsp;".$strNoTrackers;
	echo "</td>\n";
	echo "\t\t\t\t</tr>\n";

	echo "\t\t\t\t<tr>\n";
	echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>\n";
	echo "\t\t\t\t</tr>\n";
}

$i=0;
while ($doTrackers->fetch() && $row_trackers = $doTrackers->toArray())
{
	if ($i > 0)
	{
		echo "\t\t\t\t<tr>\n";
		echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>\n";
		echo "\t\t\t\t</tr>\n";
	}
	echo "\t\t\t\t<tr height='25'".($i%2==0?" bgcolor='#F6F6F6'":"").">\n";
	echo "\t\t\t\t\t<td height='25'>";
	echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-tracker.gif' align='absmiddle'>&nbsp;";

	if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
		echo "<a href='tracker-edit.php?clientid=".$clientid."&trackerid=".$row_trackers['trackerid']."'>".htmlspecialchars($row_trackers['trackername'])."</a>";
	else
		echo htmlspecialchars($row_trackers['trackername']);

//	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td>\n";

	// ID
	echo "\t\t\t\t\t<td height='25'>".$row_trackers['trackerid']."</td>\n";

	// Button 1, 2 & 3
	echo "\t\t\t\t\t<td height='25'>";
	if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
		echo "<img src='" . OX::assetPath() . "/images/icon-zone-linked.gif' border='0' align='absmiddle'>&nbsp;<a href='tracker-campaigns.php?clientid=".$clientid."&trackerid=".$row_trackers['trackerid']."'>$strLinkedCampaigns</a>";
	else
		echo "&nbsp;";
	echo "</td>\n";

	echo "\t\t\t\t\t<td height='25'>";
	if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
		echo "<img src='" . OX::assetPath() . "/images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;<a href='tracker-delete.php?clientid=".$clientid."&trackerid=".$row_trackers['trackerid']."&returnurl=advertiser-trackers.php'".phpAds_DelConfirm($strConfirmDeleteTracker).">$strDelete</a>";
	else
		echo "&nbsp;";
	echo "</td>\n";

	echo "\t\t\t\t</tr>\n";

	$i++;
}

if ($doTrackers->getRowCount())
{
	echo "\t\t\t\t<tr height='1'>\n";
	echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%'></td>\n";
	echo "\t\t\t\t</tr>\n";
	echo "\t\t\t\t<tr height='25'>\n";
	echo "\t\t\t\t\t<td colspan='4' height='25' align='".$phpAds_TextAlignRight."'>";
	echo "<img src='" . OX::assetPath() . "/images/icon-recycle.gif' border='0' align='absmiddle'>&nbsp;<a href='tracker-delete.php?clientid=".$clientid."&returnurl=advertiser-trackers.php'".phpAds_DelConfirm($strConfirmDeleteAllTrackers).">$strDeleteAllTrackers</a>&nbsp;&nbsp;";
	echo "</td>\n";
	echo "\t\t\t\t</tr>\n";
}


echo "\t\t\t\t</table>\n";
echo "\t\t\t\t<br /><br />\n";



/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['advertiser-trackers.php']['listorder'] = $listorder;
$session['prefs']['advertiser-trackers.php']['orderdirection'] = $orderdirection;

phpAds_SessionDataStore();



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

function addPageTools($clientid)
{
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        addPageLinkTool($GLOBALS["strAddTracker_Key"], "tracker-edit.php?clientid=$clientid", "iconTrackerAdd", $GLOBALS["strAddNew"] );
    }
}


?>
