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
    // Some additional calculations are required, increase the memory
    OX_increaseMemoryLimit(OX_getMinimumRequiredMemory('maintenance'));

    // Prepare an array of the HTML elements to process, and which
    // of the preferences are checkboxes
    $aElements   = array();
    $aCheckboxes = array();

    // eCPM
    $aElements[] = 'campaign_ecpm_enabled';
    $aElements[] = 'contract_ecpm_enabled';
    $aCheckboxes['campaign_ecpm_enabled'] = true;
    $aCheckboxes['contract_ecpm_enabled'] = true;

    // Save the preferences
    $aInactivatedCampaignsIds = array();
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
            foreach($aCampaigns as $campaignId => $aCampaign) {
                if ($aCampaign['status_changed'] && $aCampaign['status'] == OA_ENTITY_STATUS_INACTIVE) {
                    // store without string indexes, to not to waste space in session
                    $aInactivatedCampaignsIds[$campaignId] =
                        array($campaignId, $aCampaign['clientid'], $aCampaign['campaignname']);
                }
            }
            $runMaintenance = true;
        }

        // We changed contract
        if ((bool) $_POST['contract_ecpm_enabled'] != (bool) $pref['contract_ecpm_enabled']) {

            // Reload the prefs we just changed into the global variable because
            // we use it when setting ecpm_enabled in the DO.
            OA_Preferences::loadPreferences();
            $oDal = OA_Dal::factoryDAL('campaigns');
            $agencyId = OA_Permission::getAgencyId();
            $aCampaigns = $oDal->updateEcpmEnabledByAgency($agencyId);
            foreach($aCampaigns as $campaignId => $aCampaign) {
                if ($aCampaign['status_changed'] && $aCampaign['status'] == OA_ENTITY_STATUS_INACTIVE) {
                    // store without string indexes, to not to waste space in session
                    $aInactivatedCampaignsIds[$campaignId] =
                        array($campaignId, $aCampaign['clientid'], $aCampaign['campaignname']);
                }
            }
            $runMaintenance = true;
        }

        // store the list of inactivated campaigns in the session
        if (!empty($aInactivatedCampaignsIds)) {
            $session['aInactivatedCampaignsIds'] = $aInactivatedCampaignsIds;
            phpAds_SessionDataStore();
        }

        if ($runMaintenance) {
            OA_Maintenance_Priority::scheduleRun();
        }

        // Queue confirmation message
        $setPref = $oOptions->getSettingsPreferences($prefSection);
        $title = $setPref[$prefSection]['name'];
        $translation = new OX_Translation ();
        $translated_message = $translation->translate($GLOBALS['strXPreferencesHaveBeenUpdated'],
            array(htmlspecialchars($title)));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
        OX_Admin_Redirect::redirect(basename($_SERVER['SCRIPT_NAME']));
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

$remnantEcpmInfoText = $strEnableECPM . '<br/>&nbsp;&nbsp;&nbsp;&nbsp;';
$remnantEcpmInfoText .= !empty($pref['campaign_ecpm_enabled']) ? $strEnableECPMfromECPM :
    $strEnableECPMfromRemnant;

$contractEcpmInfoText = $strEnableContractECPM;

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array (
    array (
        'text'  => $strECPMInformation,
        'items' => array (
            array (
                'type'  => 'checkbox',
                'name'  => 'campaign_ecpm_enabled',
                'text'  => $remnantEcpmInfoText,
                'disabled' => OA_Permission::isAccount(OA_ACCOUNT_ADMIN)
            ),
            array(
                'type' => 'checkbox',
                'name' => 'contract_ecpm_enabled',
                'text' => $contractEcpmInfoText,
                'disabled' => OA_Permission::isAccount(OA_ACCOUNT_ADMIN)
            )
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