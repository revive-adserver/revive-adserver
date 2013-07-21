<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Admin/Invocation.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal (
	 'trackername'
	,'description'
	,'move'
	,'submit'
	,'invtype'
	,'trackerid'
	,'clientid'
    ,'append'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid);

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();

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
    $doClients = OA_Dal::factoryDO('clients');
    $doClients->whereAdd('clientid <>'.$trackerid);
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $doClients->agencyid = OA_Permission::getAgencyId();
    }
    $doClients->find();
    $aOtherAdvertisers = array();
    while ($doClients->fetch() && $row = $doClients->toArray()) {
        $aOtherAdvertisers[] = $row;
    }
    MAX_displayNavigationTracker($clientid, $trackerid, $aOtherAdvertisers);
}
else {
	if (isset($move) && $move == 't') {
		// Convert client to tracker
        // TODO: is this still used? if not, we may want to remove it
		phpAds_PageHeader("4.1.4.4");
		echo "<img src='" . OX::assetPath() . "/images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid);
		echo "&nbsp;<img src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='" . OX::assetPath() . "/images/icon-tracker.gif' align='absmiddle'>&nbsp;<b>".$strUntitled."</b><br /><br /><br />";
		phpAds_ShowSections(array("4.1.4.4"));
	} else {
		// New tracker
        // TODO: is this still used? if not, we may want to remove it
		phpAds_PageHeader("4.1.4.1");
        MAX_displayTrackerBreadcrumbs(null, $clientid);
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
    $tracker_code = $maxInvocation->generateJavascriptTrackerCode($trackerid, $append);
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
echo "<form name='invform' action='".$_SERVER['SCRIPT_NAME']."' method='POST'>\n";
echo "<input type='hidden' name='trackerid' value='".$trackerid."'>\n";
echo "<input type='hidden' name='clientid' value='".$clientid."'>\n";
echo "<select name='invtype' onChange=\"this.form.submit()\">\n";
echo "<option value='img' " . ($invtype != 'js' ? 'selected="selected"' : '') . " >".$GLOBALS['strTrackerImageTag']."</option>\n";
echo "<option value='js' "  . ($invtype == 'js' ? 'selected="selected"' : '') . " >".$GLOBALS['strTrackerJsTag']."</option>\n";
echo "</select>\n";
echo "&nbsp;<input type='image' src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/go_blue.gif' border='0'>\n";

if ($invtype == 'img' && !empty($trackerDetails['appendcode'])) {
    echo "<div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/warning.gif' align='absmiddle'>
              <span class='tab-r'>{$GLOBALS['strWarning']}</span> - {$GLOBALS['strImgWithAppendWarning']}
          </div>";
}

echo "</td></tr>\n";
phpAds_ShowBreak();

echo "<tr><td height='25'><img src='" . OX::assetPath() . "/images/icon-generatecode.gif' align='absmiddle'>&nbsp;<b>".$GLOBALS['strTrackercode']."</b></td>";

// Show clipboard button only on IE since Mozilla will throw a security warning
if (strpos ($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 &&	strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera') < 1) {
	echo "<td height='25' align='right'width='95%'><img src='" . OX::assetPath() . "/images/icon-clipboard.gif' align='absmiddle'>&nbsp;";
	echo "<a href='javascript:max_CopyClipboard(\"bannercode\");'>".$GLOBALS['strCopyToClipboard']."</a></td><td width='5%'>&nbsp;</td></tr>";
} else {
	echo "<td colspan='2'>&nbsp;</td>";
}

echo "<tr><td colspan='3'><textarea name='bannercode' id='bannercode' class='code-gray' rows='15' cols='80' style='width:95%; border: 1px solid black' readonly>".htmlspecialchars($tracker_code)."</textarea></td></tr>";
echo "</table>";
echo "<br />";
// END CODE
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
echo "</table>"."\n";

if ($invtype == 'js') {
    echo "<br /><br />\n";
    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>\n";
    echo "<tr><td height='25' colspan='3'><img src='" . OX::assetPath() . "/images/icon-overview.gif' align='absmiddle'>&nbsp;<b>".$GLOBALS['strParameters']."</b></td></tr>\n";
    echo "<tr><td width='30'>&nbsp;</td>\n";
    echo "<td width='200'>".$GLOBALS['strTrackerAlwaysAppend']."</td>\n";
    echo "<td width='370'><input type='radio' name='append' value='1'".(isset($append) && $append != 0 ? ' checked' : '')." tabindex='".($tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />\n";
    echo "<input type='radio' name='append' value='0'".(!isset($append) || $append == 0 ? ' checked' : '')." tabindex='".($tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>\n";
    echo "</tr>\n";
    echo "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>\n";
    echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>\n";
    echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>\n";
    echo "</table>\n";
    echo "<br /><br />\n";
    echo "<input type='submit' value='".$GLOBALS['strRefresh']."' name='submitbutton' tabindex='".($tabindex++)."'>\n";
}

echo "</form>\n";

echo "<script type='text/javascript'>
    <!--
    $(document).ready(function() {
        $('#bannercode').selectText();
    });
    //-->
    </script>";


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
