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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-expiration.inc.php';

// Register input variables
phpAds_registerGlobal('period', 'start', 'limit');

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client);

// Check so that user doesnt access page through URL
if (phpAds_isUser(phpAds_Client)) {
	if (phpAds_isAllowed(phpAds_ViewTargetingStats)) {
		$clientid = phpAds_getUserID();
		if (isset($campaignid) && $campaignid != '') {
			$query = "SELECT c.clientid".
				" FROM ".$conf['table']['prefix'].$conf['table']['clients']." AS c".
				",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
				" WHERE c.clientid=m.clientid".
				" AND c.clientid='".$clientid."'".
				" AND m.campaignid='".$campaignid."'".
				" AND agencyid=".phpAds_getAgencyID();
		} else {
			$query = "SELECT c.clientid".
				" FROM ".$conf['table']['prefix'].$conf['table']['clients']." AS c".
				" WHERE c.clientid='".$clientid."'".
				" AND agencyid=".phpAds_getAgencyID();
		}
		$res = phpAds_dbQuery($query) or phpAds_sqlDie();
		if (phpAds_dbNumRows($res) == 0) {
			phpAds_PageHeader("2");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
	} else {
		phpAds_PageHeader("2");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
} elseif (phpAds_isUser(phpAds_Agency)) {
	if (isset($campaignid) && $campaignid != '') {
		$query = "SELECT c.clientid".
			" FROM ".$conf['table']['prefix'].$conf['table']['clients']." AS c".
			",".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
			" WHERE c.clientid=m.clientid".
			" AND c.clientid='".$clientid."'".
			" AND m.campaignid='".$campaignid."'".
			" AND agencyid=".phpAds_getUserID();
	} else {
		$query = "SELECT c.clientid".
			" FROM ".$conf['table']['prefix'].$conf['table']['clients']." AS c".
			" WHERE c.clientid='".$clientid."'".
			" AND agencyid=".phpAds_getUserID();
	}
	$res = phpAds_dbQuery($query) or phpAds_sqlDie();
	if (phpAds_dbNumRows($res) == 0) {
		phpAds_PageHeader("2");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (isset($session['prefs']['stats.php?entity=advertiser&breakdown=campaigns']['listorder'])) {
	$navorder = $session['prefs']['stats.php?entity=advertiser&breakdown=campaigns']['listorder'];
} else {
	$navorder = '';
}
if (isset($session['prefs']['stats.php?entity=advertiser&breakdown=campaigns']['orderdirection'])) {
	$navdirection = $session['prefs']['stats.php?entity=advertiser&breakdown=campaigns']['orderdirection'];
} else {
	$navdirection = '';
}
if (phpAds_isUser(phpAds_Client)) {
	if (phpAds_getUserID() == phpAds_getCampaignParentClientID ($campaignid)) {
		$res = phpAds_dbQuery(
			"SELECT campaignid,campaignname".
			" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
			" WHERE clientid= ".phpAds_getUserID().
			phpAds_getCampaignListOrder ($navorder, $navdirection)
		) or phpAds_sqlDie();
		while ($row = phpAds_dbFetchArray($res)) {
			phpAds_PageContext (
				phpAds_buildName ($row['campaignid'], $row['campaignname']),
				"stats.php?entity=placement&breakdown=target&clientid=".$clientid."&campaignid=".$row['campaignid'],
				$campaignid == $row['campaignid']
			);
		}
		phpAds_PageHeader("1.2.4");
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getCampaignName($campaignid)."</b><br /><br /><br />";
		phpAds_ShowSections(array("1.2.1", "1.2.2", "1.2.3", "1.2.4"));
    } else {
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}
if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
	if (phpAds_isUser(phpAds_Admin)) {
		$query = "SELECT campaignid,campaignname".
			" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
			" WHERE clientid='".$clientid."'".
			phpAds_getCampaignListOrder ($navorder, $navdirection);
	} elseif (phpAds_isUser(phpAds_Agency)) {
		$query = "SELECT m.campaignid,m.campaignname".
			" FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
			",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
			" WHERE m.clientid=c.clientid".
			" AND m.clientid='".$clientid."'".
			" AND c.agencyid=".phpAds_getUserID().
			phpAds_getCampaignListOrder ($navorder, $navdirection);
	}
	$res = phpAds_dbQuery($query)
		or phpAds_sqlDie();
	while ($row = phpAds_dbFetchArray($res)) {
		phpAds_PageContext(
			phpAds_buildName ($row['campaignid'], $row['campaignname']),
			"stats.php?entity=placement&breakdown=target&clientid=".$clientid."&campaignid=".$row['campaignid'],
			$campaignid == $row['campaignid']
		);
	}
	phpAds_PageShortcut($strClientProperties, 'advertiser-edit.php?clientid='.$clientid, 'images/icon-advertiser.gif');
	phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
	phpAds_PageHeader("2.1.2.4");
	echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getParentClientName($campaignid);
	echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getCampaignName($campaignid)."</b><br /><br /><br />";
	phpAds_ShowSections(array("2.1.2.1", "2.1.2.2", "2.1.2.3", "2.1.2.4"));
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$lib_targetstats_params = array('clientid' => $clientid, 'campaignid' => $campaignid);
$lib_targetstats_where  = "campaignid = '".$campaignid."'";
$view = "placement_summary";
include_once "lib-targetstats.inc.php";

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
