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
require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

// Register input variables
phpAds_registerGlobal (
	 'trackername'
	,'description'
	,'move'
	,'submit'
	,'invtype'
	,'trackerid'
	,'clientid'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid);

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($submit)) {
	// If ID is not set, it should be a null-value for the auto_increment

    $doTrackers = OA_Dal::factoryDO('trackers');
    $doTrackers->trackername = $trackername;
    $doTrackers->description = $description;
    $doTrackers->clientid = $clientid;
    if (empty($trackerid)) {
        $trackerid = $doTrackers->insert();
        $new_tracker = true;
    } else {
        $doTrackers->trackerid = $trackerid;
        $doTrackers->update();
    }
	Header("Location: tracker-campaigns.php?clientid=".$clientid."&trackerid=".$trackerid);
	exit;
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($trackerid != "") {
	// Get other trackers
	$doTrackers = OA_Dal::factoryDO('trackers');
	$doTrackers->addSessionListOrderBy('advertiser-trackers.php');
	$doTrackers->clientid = $clientid;
	$doTrackers->find();

	while ($doTrackers->fetch() && $row = $doTrackers->toArray()) {
		phpAds_PageContext(
			phpAds_buildName ($row['trackerid'], $row['trackername']),
			"tracker-invocation.php?clientid=".$clientid."&trackerid=".$row['trackerid'],
			$trackerid == $row['trackerid']
		);
	}
	phpAds_PageShortcut($strClientProperties, 'advertiser-edit.php?clientid='.$clientid, 'images/icon-advertiser.gif');
	$extra  = "\t\t\t\t<form name='modif' action='tracker-modify.php'>"."\n";
	$extra .= "\t\t\t\t<input type='hidden' name='trackerid' value='$trackerid'>"."\n";
	$extra .= "\t\t\t\t<input type='hidden' name='clientid' value='$clientid'>"."\n";
	$extra .= "\t\t\t\t<input type='hidden' name='returnurl' value='tracker-invocation.php'>"."\n";
	$extra .= "\t\t\t\t<br /><br />"."\n";
	$extra .= "\t\t\t\t<b>$strModifyTracker</b><br />"."\n";
	$extra .= "\t\t\t\t<img src='images/break.gif' height='1' width='160' vspace='4'><br />"."\n";
	$extra .= "\t\t\t\t<img src='images/icon-duplicate-tracker.gif' align='absmiddle'>&nbsp;<a href='tracker-modify.php?clientid=".$clientid."&trackerid=".$trackerid."&duplicate=true&returnurl=tracker-invocation.php'>$strDuplicate</a><br />"."\n";
	$extra .= "\t\t\t\t<img src='images/break.gif' height='1' width='160' vspace='4'><br />"."\n";
	$extra .= "\t\t\t\t<img src='images/icon-move-tracker.gif' align='absmiddle'>&nbsp;$strMoveTo<br />"."\n";
	$extra .= "\t\t\t\t<img src='images/spacer.gif' height='1' width='160' vspace='2'><br />"."\n";
	$extra .= "\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."\n";
	$extra .= "\t\t\t\t<select name='moveto' style='width: 110;'>"."\n";

	$doClients = OA_Dal::factoryDO('clients');
	$doClients->whereAdd('clientid <> '.$clientid);
	if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
	    $doClients->addReferenceFilter('agency', OA_Permission::getAgencyId());
	}
	$doClients->find();
	while ($doClients->fetch() && $row = $doClients->toArray()) {
		$extra .= "\t\t\t\t\t<option value='".$row['clientid']."'>".phpAds_buildName($row['clientid'], $row['clientname'])."</option>\n";
	}
	$extra .= "\t\t\t\t</select>&nbsp;\n";
	$extra .= "\t\t\t\t<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif'><br />\n";
	$extra .= "\t\t\t\t<img src='images/break.gif' height='1' width='160' vspace='4'><br />\n";
	$extra .= "\t\t\t\t<img src='images/icon-recycle.gif' align='absmiddle'>\n";
	$extra .= "\t\t\t\t<a href='tracker-delete.php?clientid=$clientid&trackerid=$trackerid&returnurl=advertiser-trackers.php'".phpAds_DelConfirm($strConfirmDeleteTracker).">$strDelete</a><br />\n";
	$extra .= "\t\t\t\t</form>\n";

	phpAds_PageHeader("4.1.4.4", $extra);
		echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName(phpAds_getTrackerParentClientID($trackerid));
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-tracker.gif' align='absmiddle'>&nbsp;<b>".phpAds_getTrackerName($trackerid)."</b><br /><br /><br />";
		phpAds_ShowSections(array("4.1.4.2", "4.1.4.3", "4.1.4.5", "4.1.4.6", "4.1.4.4"));
} else {
	if (isset($move) && $move == 't') {
		// Convert client to tracker
		phpAds_PageHeader("4.1.4.4");
		echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-tracker.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br /><br /><br />";
		phpAds_ShowSections(array("4.1.4.4"));
	} else {
		// New tracker
		phpAds_PageHeader("4.1.4.1");
		echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-tracker.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br /><br /><br />";
		phpAds_ShowSections(array("4.1.4.1"));
	}
}

if ($trackerid != "" || (isset($move) && $move == 't')) {
	// Edit or Convert
	// Fetch exisiting settings
	// Parent setting for converting, tracker settings for editing
	if ($trackerid != "") {
	    $ID = $trackerid;
	}
	if (isset($move) && $move == 't') {
		if (isset($clientid) && $clientid != "") {
		    $ID = $clientid;
		}
	}
	$doTrackers = OA_Dal::factoryDO('trackers');
	if ($doTrackers->get($ID)) {
	    $row = $doTrackers->toArray();
	}
} else {
	// New tracker
	$doClients = OA_Dal::factoryDO('clients');
	if ($doClients->get($clientid)) {
	    $client = $doClients->toArray();
	}

	if ($client) {
		$row['trackername'] = $client['clientname'].' - ';
	} else {
		$row["trackername"] = '';
	}
	$row["trackername"] .= $strDefault;
}

$trackerDetails = phpAds_getTrackerDetails($trackerid);
$trackerVariables = Admin_DA::getVariables(array('tracker_id' => $trackerid), true);

// Default to JS invocation if either appended HTML is found, or the tracker has variables
if (empty($invtype) && (!empty($trackerDetails['appendcode']) || !empty($trackerVariables))) {
   $invtype = 'js';
}

$maxInvocation = new MAX_Admin_Invocation();

if (isset($invtype) && $invtype == 'js') {
    $tracker_code = $maxInvocation->generateJavascriptTrackerCode($trackerid);
} else {
    $tracker_code = $maxInvocation->generateTrackerCode($trackerid);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$tabindex = 1;

// START CODE
echo "<table border='0' width='95%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='2'><b>".$GLOBALS['strChooseInvocationType']."</b></td></tr>\n";
echo "<tr><td height='35'>";
echo "<form name='invform' action='".$_SERVER['PHP_SELF']."' method='POST'>\n";
echo "<input type='hidden' name='trackerid' value='".$trackerid."'>\n";
echo "<input type='hidden' name='clientid' value='".$clientid."'>\n";
echo "<select name='invtype' onChange=\"this.form.submit()\">\n";
echo "<option value='img' " . ($invtype != 'js' ? 'selected="selected"' : '') . " >Image Tag</option>\n";
echo "<option value='js' "  . ($invtype == 'js' ? 'selected="selected"' : '') . " >Javascript Tag</option>\n";
echo "</select>\n";
echo "&nbsp;<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif' border='0'>\n";
echo "</form>\n";

if ($invtype == 'img' && !empty($trackerDetails['appendcode'])) {
    echo "<div class='errormessage'><img class='errormessage' src='images/warning.gif' align='absmiddle'>
              <span class='tab-r'>{$GLOBALS['strWarning']}</span> - {$GLOBALS['strImgWithAppendWarning']}
          </div>";
}

echo "</td></tr>\n";
phpAds_ShowBreak();

echo "<tr><td height='25'><img src='images/icon-generatecode.gif' align='absmiddle'>&nbsp;<b>".$GLOBALS['strTrackercode']."</b></td>";

// Show clipboard button only on IE since Mozilla will throw a security warning
if (strpos ($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 &&	strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera') < 1) {
	echo "<td height='25' align='right'width='95%'><img src='images/icon-clipboard.gif' align='absmiddle'>&nbsp;";
	echo "<a href='javascript:max_CopyClipboard(\"bannercode\");'>".$GLOBALS['strCopyToClipboard']."</a></td><td width='5%'>&nbsp;</td></tr>";
} else {
	echo "<td colspan='2'>&nbsp;</td>";
}

echo "<tr><td colspan='3'><textarea name='bannercode' class='code-gray' rows='15' cols='80' style='width:95%; border: 1px solid black' readonly>".htmlspecialchars($tracker_code)."</textarea></td></tr>";
echo "</table>";
echo "<br />";
// END CODE
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "</table>"."\n";

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
