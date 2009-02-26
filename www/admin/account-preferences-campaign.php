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
$Id: account-preferences-user-interface.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Preferences.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Campaigns.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);

// Load the account's preferences, with additional information, into a specially named array
$GLOBALS['_MAX']['PREF_EXTRA'] = OA_Preferences::loadPreferences(true, true);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('preferences');
$prefSection = "campaign";

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and which
    // of the preferences are checkboxes
    $aElements   = array();
    $aCheckboxes = array();
    
    // eCPM
    $aElements[] = 'campaign_ecpm_enabled';
    $aCheckboxes['campaign_ecpm_enabled'] = true;

    // Save the preferences
    $result = OA_Preferences::processPreferencesFromForm($aElements, $aCheckboxes);
    if ($result) {
        if ((bool) $_POST['campaign_ecpm_enabled'] != (bool) $pref['campaign_ecpm_enabled']) {
            // update all campaigns across MANAGER account
            if (!empty($pref['campaign_ecpm_enabled'])) {
                $updateFrom = DataObjects_Campaigns::PRIORITY_ECPM;
                $updateTo = DataObjects_Campaigns::PRIORITY_REMNANT;
            } else {
                $updateFrom = DataObjects_Campaigns::PRIORITY_REMNANT;
                $updateTo = DataObjects_Campaigns::PRIORITY_ECPM;
            }
            $oDal = OA_Dal::factoryDAL('campaigns');
            $agencyId = OA_Permission::getAgencyId();
            $aCampaigns = $oDal->updateCampaignsPriorityByAgency($agencyId, $updateFrom, $updateTo);
            $aInactivatedCampaignsIds = array();
            foreach($aCampaigns as $campaignId => $aCampaign) {
                if ($aCampaign['status_changed'] && $aCampaign['status'] == OA_ENTITY_STATUS_INACTIVE) {
                    // store without string indexes, to not to waste space in session
                    $aInactivatedCampaignsIds[$campaignId] =
                        array($campaignId, $aCampaign['clientid'], $aCampaign['campaignname']);
                }
            }
            // store the list of inactivated campaigns in the session
            if (!empty($aInactivatedCampaignsIds)) {
                $session['aInactivatedCampaignsIds'] = $aInactivatedCampaignsIds;
                phpAds_SessionDataStore();
            }

            // Run the Maintenance Priority Engine process
            OA_Maintenance_Priority::scheduleRun();
        }
        
        // Queue confirmation message
        $setPref = $oOptions->getSettingsPreferences($prefSection);
        $title = $setPref[$prefSection]['name'];
        $translation = new OX_Translation ();
        $translated_message = $translation->translate($GLOBALS['strXPreferencesHaveBeenUpdated'],
            array(htmlspecialchars($title)));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        OX_Admin_Redirect::redirect(basename($_SERVER['PHP_SELF']));
    }
    // Could not write the preferences to the database, store this
    // error message and continue
    $aErrormessage[0][] = $strUnableToWritePrefs;
}

// Set the correct section of the preference pages and display the drop-down menu
$setPref = $oOptions->getSettingsPreferences($prefSection);
$title = $setPref[$prefSection]['name'];

// Display the settings page's header and sections
$oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel($title);
phpAds_PageHeader('account-preferences-index', $oHeaderModel);

$ecpmInfoText = $strEnableECPM . '<br/>&nbsp;&nbsp;&nbsp;&nbsp;';
$ecpmInfoText .= !empty($pref['campaign_ecpm_enabled']) ? $strEnableECPMfromECPM : 
    $strEnableECPMfromRemnant;

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array (
    array (
        'text'  => $strECPMInformation,
        'items' => array (
            array (
                'type'  => 'checkbox',
                'name'  => 'campaign_ecpm_enabled',
                'text'  => $ecpmInfoText
            ),
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Show the list of inactivated campaigns
if (!empty($session['aInactivatedCampaignsIds']) && is_array($session['aInactivatedCampaignsIds'])) {
    echo '<br /><br /><br />';
    echo '<b>' . $strInactivatedCampaigns . '</b><br/>';
    echo '<ul>';
    foreach($session['aInactivatedCampaignsIds'] as $aCampaign) {
        $campaignUrl = 'campaign-edit.php?clientid='.$aCampaign[1].'&amp;campaignid='.$aCampaign[0];
        echo '<li><a href="'.$campaignUrl.'" target="_blank">'.smarty_modifier_escape($aCampaign[2]).'</a></li>';
    }
    echo '<ul>';
    unset($session['aInactivatedCampaignsIds']);
    phpAds_SessionDataStore();
}

// Display the page footer
phpAds_PageFooter();

?>