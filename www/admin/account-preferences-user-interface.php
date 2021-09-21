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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Delivery/Affiliates.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Delivery/Default.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);

// Load the account's preferences, with additional information, into a specially named array
$GLOBALS['_MAX']['PREF_EXTRA'] = OA_Preferences::loadPreferences(true, true);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('preferences');
$prefSection = "user-interface";

$aStatisticsFieldsDelivery['affiliates'] = new OA_StatisticsFieldsDelivery_Affiliates();
$aStatisticsFieldsDelivery['default'] = new OA_StatisticsFieldsDelivery_Default();

// Prepare an array for storing error messages
$aErrormessage = [];

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and which
    // of the preferences are checkboxes
    $aElements = [];
    $aCheckboxes = [];
    // Inventory
    $aElements[] = 'ui_show_campaign_info';
    $aCheckboxes['ui_show_campaign_info'] = true;
    $aElements[] = 'ui_show_banner_info';
    $aCheckboxes['ui_show_banner_info'] = true;
    $aElements[] = 'ui_show_campaign_preview';
    $aCheckboxes['ui_show_campaign_preview'] = true;
    $aElements[] = 'ui_show_banner_html';
    $aCheckboxes['ui_show_banner_html'] = true;
    $aElements[] = 'ui_show_banner_preview';
    $aCheckboxes['ui_show_banner_preview'] = true;
    $aElements[] = 'ui_hide_inactive';
    $aCheckboxes['ui_hide_inactive'] = true;
    $aElements[] = 'ui_html_wyswyg_enabled';
    $aCheckboxes['ui_html_wyswyg_enabled'] = true;
    $aElements[] = 'ui_show_matching_banners';
    $aCheckboxes['ui_show_matching_banners'] = true;
    $aElements[] = 'ui_show_matching_banners_parents';
    $aCheckboxes['ui_show_matching_banners_parents'] = true;
    $aElements[] = 'ui_show_entity_id';
    $aCheckboxes['ui_show_entity_id'] = true;
    // Confirmation in User Interface
    $aElements[] = 'ui_novice_user';
    $aCheckboxes['ui_novice_user'] = true;
    // Statistics
    $aElements[] = 'ui_week_start_day';
    $aElements[] = 'ui_percentage_decimals';
    // Stats columns
    foreach ($aStatisticsFieldsDelivery as $obj) {
        $aVars = $obj->getVisibilitySettings();
        $aSuffixes = ['_label', '_rank'];
        foreach (array_keys($aVars) as $name) {
            $aElements[] = $name;
            $aCheckboxes[$name] = true;
            foreach ($aSuffixes as $suffix) {
                $aElements[] = $name . $suffix;
            }
        }
    }
    // Save the preferences
    $result = OA_Preferences::processPreferencesFromForm($aElements, $aCheckboxes);
    if ($result) {
        // Queue confirmation message
        $setPref = $oOptions->getSettingsPreferences($prefSection);
        $title = $setPref[$prefSection]['name'];
        $translation = new OX_Translation();
        $translated_message = $translation->translate(
            $GLOBALS['strXPreferencesHaveBeenUpdated'],
            [htmlspecialchars($title)]
        );
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

// Prepare an array of columns to be used shortly
$aStatistics = [];
foreach ($aStatisticsFieldsDelivery as $obj) {
    $aVars = $obj->getVisibilitySettings();
    foreach ($aVars as $name => $text) {
        $aStatistics[] = [
            'text' => $text,
            'name' => $name
        ];
    }
}

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = [
    [
        'text' => $strInventory,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'ui_show_campaign_info',
                'text' => $strShowCampaignInfo
            ],
            [
                'type' => 'checkbox',
                'name' => 'ui_show_banner_info',
                'text' => $strShowBannerInfo
            ],
            [
                'type' => 'checkbox',
                'name' => 'ui_show_campaign_preview',
                'text' => $strShowCampaignPreview
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'ui_show_banner_html',
                'text' => $strShowBannerHTML
            ],
            [
                'type' => 'checkbox',
                'name' => 'ui_show_banner_preview',
                'text' => $strShowBannerPreview
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'ui_html_wyswyg_enabled',
                'text' => $strUseWyswygHtmlEditorByDefault,
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'ui_hide_inactive',
                'text' => $strHideInactive
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'ui_show_matching_banners',
                'text' => $strGUIShowMatchingBanners
            ],
            [
                'type' => 'checkbox',
                'name' => 'ui_show_matching_banners_parents',
                'text' => $strGUIShowParentCampaigns
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'ui_show_entity_id',
                'text' => $strShowEntityId
            ]
        ]
    ],
    [
        'text' => $strConfirmationUI,
        'items' => [
             [
                'type' => 'checkbox',
                'name' => 'ui_novice_user',
                'text' => $strNovice
            ],
        ]
    ],
    [
        'text' => $strStatisticsDefaults,
        'items' => [
            [
                'type' => 'select',
                'name' => 'ui_week_start_day',
                'text' => $strBeginOfWeek,
                'items' => [$strDayFullNames[0], $strDayFullNames[1]]
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'select',
                'name' => 'ui_percentage_decimals',
                'text' => $strPercentageDecimals,
                'items' => [0, 1, 2, 3]
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'statscolumns',
                'name' => '',
                'rows' => $aStatistics
            ]
        ]
    ]
];
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();
