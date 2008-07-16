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
require_once MAX_PATH . '/lib/max/Admin/Inventory/TrackerAppend.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid);

// Initialize trackerAppend class
$trackerAppend = new Max_Admin_Inventory_TrackerAppend();

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
header("Content-Type: text/html; charset=ISO-8859-1");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trackerAppend->handlePost($_POST);
} else {
    $trackerAppend->handleGet();
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Get other trackers
$doTrackers = OA_Dal::factoryDO('trackers');
$doTrackers->clientid = $clientid;
if (isset($navorder) && isset($navdirection)) {
    $doTrackers->addListOrderBy($navorder, $navdirection);
}
$doTrackers->find();

while ($doTrackers->fetch() && $row = $doTrackers->toArray()) {
    phpAds_PageContext(
        MAX_buildName ($row['trackerid'], $row['trackername']),
        "tracker-append.php?clientid=".$clientid."&trackerid=".$row['trackerid'],
        $trackerid == $row['trackerid']
    );
}

phpAds_PageShortcut($strClientProperties, 'advertiser-edit.php?clientid='.$clientid, 'images/icon-advertiser.gif');

$extra  = "\t\t\t\t<form action='tracker-modify.php'>"."\n";
$extra .= "\t\t\t\t<input type='hidden' name='trackerid' value='$trackerid'>"."\n";
$extra .= "\t\t\t\t<input type='hidden' name='clientid' value='$clientid'>"."\n";
$extra .= "\t\t\t\t<input type='hidden' name='returnurl' value='tracker-append.php'>"."\n";
$extra .= "\t\t\t\t<br /><br />"."\n";
$extra .= "\t\t\t\t<b>$strModifyTracker</b><br />"."\n";
$extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='160' vspace='4'><br />"."\n";
$extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-duplicate-tracker.gif' align='absmiddle'>&nbsp;<a href='tracker-modify.php?clientid=".$clientid."&trackerid=".$trackerid."&duplicate=true&returnurl=tracker-campaigns.php'>$strDuplicate</a><br />"."\n";
$extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='160' vspace='4'><br />"."\n";
$extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-move-tracker.gif' align='absmiddle'>&nbsp;$strMoveTo<br />"."\n";
$extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/spacer.gif' height='1' width='160' vspace='2'><br />"."\n";
$extra .= "\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."\n";
$extra .= "\t\t\t\t<select name='moveto' style='width: 110;'>"."\n";

$doClients = OA_Dal::factoryDO('clients');
$doClients->clientid = $clientid;

if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    $doClients->addReferenceFilter('agency', OA_Permission::getEntityId());
}
$doClients->find();

while ($doClients->fetch() && $row = $doClients->toArray()) {
    $extra .= "\t\t\t\t\t<option value='".$row['clientid']."'>".MAX_buildName($row['clientid'], $row['clientname'])."</option>\n";
}

$extra .= "\t\t\t\t</select>&nbsp;\n";
$extra .= "\t\t\t\t<input type='image' src='" . MAX::assetPath() . "/images/".$phpAds_TextDirection."/go_blue.gif'><br />\n";
$extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='160' vspace='4'><br />\n";
$extra .= "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-recycle.gif' align='absmiddle'>\n";
$extra .= "\t\t\t\t<a href='tracker-delete.php?clientid=$clientid&trackerid=$trackerid&returnurl=advertiser-trackers.php'".phpAds_DelConfirm($strConfirmDeleteTracker).">$strDelete</a><br />\n";
$extra .= "\t\t\t\t</form>\n";

phpAds_PageHeader("4.1.4.6", $extra);
echo "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid)."\n";
echo "\t\t\t\t<img src='" . MAX::assetPath() . "/images/".$phpAds_TextDirection."/caret-rs.gif'>\n";
echo "\t\t\t\t<img src='" . MAX::assetPath() . "/images/icon-tracker.gif' align='absmiddle'>\n";
echo "\t\t\t\t<b>".phpAds_getTrackerName($trackerid)."</b><br /><br /><br />\n";
phpAds_ShowSections(array("4.1.4.2", "4.1.4.3", "4.1.4.5", "4.1.4.6", "4.1.4.4"));


$trackerAppend->display();



/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['tracker-variables.php']['trackerid'] = $trackerid;


phpAds_SessionDataStore();

phpAds_PageFooter();

?>