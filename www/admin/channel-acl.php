<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

$pageName = basename($_SERVER['PHP_SELF']);
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
