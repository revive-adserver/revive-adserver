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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/other/lib-acl.inc.php';

// Register input variables

phpAds_registerGlobalUnslashed('acl', 'action', 'submit', 'channelid', 'agencyid');

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('channel', $channelid);

$pageName = basename($_SERVER['SCRIPT_NAME']);
$agencyId = OA_Permission::getAgencyId();
$tabindex = 1;

if (!empty($affiliateid)) {
    OA_Permission::enforceAccessToObject('affiliates', $affiliateid);

    /*-------------------------------------------------------*/
	/* Store preferences									 */
	/*-------------------------------------------------------*/
	$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
	phpAds_SessionDataStore();

    $aEntities = array('agencyid' => $agencyId, 'affiliateid' => $affiliateid, 'channelid' => $channelid);
    $aOtherChannels = Admin_DA::getChannels(array('publisher_id' => $affiliateid));
} else {
    $aEntities = array('agencyid' => $agencyId, 'channelid' => $channelid);
    $aOtherChannels = Admin_DA::getChannels(array('agency_id' => $agencyId, 'channel_type' => 'agency'));
}

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (!empty($action)) {
    if (empty($acl)) $acl = array();
    $acl = MAX_AclAdjust($acl, $action);
}
elseif (!empty($submit)) {
    OA_Permission::checkSessionToken();

    $acl = (isset($acl)) ? $acl : array();
    // Only save when inputs are valid
    if (OX_AclCheckInputsFields($acl, $pageName) === true) {
        if (MAX_AclSave($acl, $aEntities)) {

            // Queue confirmation message
            $doChannel = OA_Dal::factoryDO('channel');
            $doChannel->get($channelid);

            $translation = new OX_Translation ();
            $translated_message = $translation->translate ( $GLOBALS['strChannelAclHasBeenUpdated'], array(
                MAX::constructURL(MAX_URL_ADMIN, "channel-edit.php?" . (!empty($affiliateid) ? "affiliateid={$affiliateid}&" : "") . "channelid={$channelid}"),
                htmlspecialchars($doChannel->name)
            ));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

            // Redirect
            if (!empty($affiliateid)) {
                header("Location: channel-acl.php?affiliateid={$affiliateid}&channelid={$channelid}");
            } else {
                header("Location: channel-acl.php?channelid={$channelid}");
            }
            exit;
        }
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

MAX_displayNavigationChannel($pageName, $aOtherChannels, $aEntities);

$aChannel = Admin_DA::getChannel($channelid);
if (!isset($acl)) {
    $acl = Admin_DA::getChannelLimitations(array('channel_id' => $channelid));
    // This array needs to be sorted by executionorder, this should ideally be done in SQL
    // When we move to DataObject this should be addressed
    ksort($acl);
}

if (!empty($affiliateid)) {
    $aParams = array('affiliateid' => $affiliateid, 'channelid' => $channelid);
} else {
    $aParams = array('agencyid' => $agencyId, 'channelid' => $channelid);
}

MAX_displayAcls($acl, $aParams);

echo "<br /><input type='submit' name='submit' value='{$GLOBALS['strSaveChanges']}' tabindex='".($tabindex++)."'></form>";

phpAds_PageFooter();

?>
