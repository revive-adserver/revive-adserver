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

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
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
	// Get other advertisers
    $doAdvertiser = OA_Dal::factoryDO('clients');
	$doAdvertiser->agencyid = OA_Permission::getEntityId();
    $doAdvertiser->addSessionListOrderBy('advertiser-index.php');
    $doAdvertiser->find();
	while ($doAdvertiser->fetch() && $row = $doAdvertiser->toArray())
	{
		phpAds_PageContext(
			MAX_buildName ($row['clientid'], $row['clientname']),
			"advertiser-trackers.php?clientid=".$row['clientid'],
			$clientid == $row['clientid']
		);
	}

	phpAds_PageShortcut($strClientHistory, 'stats.php?entity=advertiser&breakdown=history&clientid='.$clientid, 'images/icon-statistics.gif');

	MAX_displayAdvertiserBreadcrumbs($clientid);
	phpAds_PageHeader("4.1.4");
    phpAds_ShowSections(array("4.1.2", "4.1.3", "4.1.4", "4.1.5"));
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Get clients & campaign and build the tree
$doTrackers = OA_Dal::factoryDO('trackers');
$doTrackers->clientid = $clientid;
$doTrackers->addListOrderBy($listorder, $orderdirection);
$doTrackers->find();

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
{
	echo "\t\t\t\t<img src='" . OX::assetPath() . "/images/icon-tracker-new.gif' border='0' align='absmiddle'>\n";
	echo "\t\t\t\t<a href='tracker-edit.php?clientid=".$clientid."' accesskey='".$keyAddNew."'>".$strAddTracker_Key."</a>&nbsp;&nbsp;\n";
	phpAds_ShowBreak();
}



echo "\t\t\t\t<br /><br />\n";
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
		echo "<a href='tracker-edit.php?clientid=".$clientid."&trackerid=".$row_trackers['trackerid']."'>".$row_trackers['trackername']."</a>";
	else
		echo $row_trackers['trackername'];

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

?>
