<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Preference.php';

require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('preferences');

// This page depends on statisticsFieldsDelivery plugins, so get the required
// information about all such plugins installed in this installation
$aStatisticsFieldsDeliveryPlugins = &MAX_Plugin::getPlugins('statisticsFieldsDelivery');
uasort($aStatisticsFieldsDeliveryPlugins, array('OA_Admin_Statistics_Common', '_pluginSort'));

// This page depends on inventoryProperties plugins, so get the required
// information about all such plugins installed in this installation
$aInvPlugins = &MAX_Plugin::getPlugins('inventoryProperties');
foreach ($aInvPlugins as $pluginKey => $oPlugin) {
    if ($oPlugin->getType() != 'settings-defaults') {
        unset($aInvPlugins[$pluginKey]);
    }
}

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {

}








require_once MAX_PATH . '/lib/OA/Admin/Statistics/Common.php';


if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobal('gui_show_campaign_info', 'gui_show_banner_info',
                          'gui_show_campaign_preview', 'gui_show_banner_html',
                          'gui_show_banner_preview', 'gui_hide_inactive',
                          'gui_show_matching', 'gui_show_parents', 'begin_of_week',
                          'percentage_decimals', 'gui_campaign_anonymous'
                          );

    // Register input variables for inventory plugins
    foreach ($aInvPlugins as $plugin) {
        call_user_func_array('phpAds_registerGlobal', $plugin->getGlobalVars());
    }

    // Set up the preferences object
    $oPreferences = new OA_Admin_Preferences();
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
    {
        $oPreferences->setPrefChange('gui_show_campaign_info',       isset($gui_show_campaign_info));
        $oPreferences->setPrefChange('gui_show_banner_info',         isset($gui_show_banner_info));
        $oPreferences->setPrefChange('gui_show_campaign_preview',    isset($gui_show_campaign_preview));
        $oPreferences->setPrefChange('gui_show_banner_html',         isset($gui_show_banner_html));
        $oPreferences->setPrefChange('gui_show_banner_preview',      isset($gui_show_banner_preview));
        $oPreferences->setPrefChange('gui_hide_inactive',            isset($gui_hide_inactive));
        $oPreferences->setPrefChange('gui_show_matching',            isset($gui_show_matching));
        $oPreferences->setPrefChange('gui_show_parents',             isset($gui_show_parents));
        $oPreferences->setPrefChange('gui_campaign_anonymous',       isset($gui_campaign_anonymous));
        if (isset($begin_of_week)) {
            $oPreferences->setPrefChange('begin_of_week',            $begin_of_week);
        }
        if (isset($percentage_decimals)) {
            $oPreferences->setPrefChange('percentage_decimals',      $percentage_decimals);
        }
    }

    // Advertiser / publisher preferences
    foreach ($aStatisticsFieldsDeliveryPlugins as $plugin) {
        $aVars = array_keys($plugin->getVisibilitySettings());
        $aVars2 = array();
        foreach ($aVars as $var) {
            $aVars2[] = $var.'_label';
            $aVars2[] = $var.'_rank';
        }
        call_user_func_array('phpAds_registerGlobal', $aVars);
        call_user_func_array('phpAds_registerGlobal', $aVars2);
        foreach ($aVars as $var) {
            $varlabel = $var.'_label';
            $varrank  = $var.'_rank';
            $aFinal    = array();
            foreach (array(OA_ACCOUNT_ADMIN_ID, OA_ACCOUNT_ADVERTISER_ID, OA_ACCOUNT_TRAFFICKER_ID, OA_ACCOUNT_MANAGER_ID) as $perm) {
                $aFinal[$perm] = array('show' => true, 'label' => '', 'rank' => 0);
                if (isset($$var)) {
                    $aFinal[$perm]['show'] = (bool)($$var & $perm);
                }
                if (isset(${$varlabel}[$perm])) {
                    $aFinal[$perm]['label'] = ${$varlabel}[$perm];
                }
                if (isset(${$varrank}[$perm])) {
                    $aFinal[$perm]['rank'] = (int)${$varrank}[$perm];
                }
            }

            $oPreferences->setPrefChange($var, serialize($aFinal));
        }
    }

    // Save settings for inventory plugins
    foreach ($aInvPlugins as $plugin) {
        foreach ($plugin->prepareVariables() as $k => $v) {
            $oPreferences->setPrefChange($k, $v);
        }
    }

    if (!$oPreferences->writePrefChange()) {
        // Unable to update the preferences
        $aErrormessage[0][] = $strUnableToWritePrefs;
    } else {
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            MAX_Admin_Redirect::redirect('account-preferences-user-interface.php');
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            MAX_Admin_Redirect::redirect('account-settings-defaults.php?clientid='.OA_Permission::getEntityId());
        } else {
            MAX_Admin_Redirect::redirect('account-settings-defaults.php?affiliateid='.OA_Permission::getEntityId());
        }
    }
}

phpAds_PageHeader("5.1");
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    // Show all "My Account" sections
    phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    // Show the "Preferences", "User Log" and "Channel Management" sections of the "My Account" sections
    phpAds_ShowSections(array("5.1", "5.3", "5.7"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    // Show the "Preferences" section of the "My Account" sections
    phpAds_ShowSections(array("5.1"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    // Show the "Preferences" section of the "My Account" sections
    phpAds_ShowSections(array("5.1"));
}

$oOptions->selection("user-interface");

$admin_settings = OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER);

$aSettings = array (
    array (
        'text'  => $strInventory,
        'visible' => $admin_settings,
        'items' => array (
            array (
                'type'  => 'checkbox',
                'name'  => 'gui_show_campaign_info',
                'text'  => $strShowCampaignInfo,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'gui_show_banner_info',
                'text'  => $strShowBannerInfo,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'gui_show_campaign_preview',
                'text'  => $strShowCampaignPreview,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'gui_show_banner_html',
                'text'  => $strShowBannerHTML,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'gui_show_banner_preview',
                'text'  => $strShowBannerPreview,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'gui_hide_inactive',
                'text'  => $strHideInactive,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'gui_show_matching',
                'text'  => $strGUIShowMatchingBanners,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'gui_show_parents',
                'text'  => $strGUIShowParentCampaigns,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'gui_campaign_anonymous',
                'text'  => $strGUIAnonymousCampaignsByDefault,
                'visible' => $admin_settings
            )
        )
    ),
    array (
        'text'  => $strConfirmationUI,
        'items' => array (
             array (
                'type'    => 'checkbox',
                'name'    => 'novice',
                'text'    => $strNovice
            ),
        )
    ),
    array (
        'text'  => $strStatisticsDefaults,
        'items' => array (
            array (
                'type'  => 'select',
                'name'  => 'begin_of_week',
                'text'  => $strBeginOfWeek,
                'items' => array($strDayFullNames[0], $strDayFullNames[1]),
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'select',
                'name'  => 'percentage_decimals',
                'text'  => $strPercentageDecimals,
                'items' => array(0, 1, 2, 3),
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            )
        )
    )
);

// Add column visibility settings from plugins
$i = 0;
foreach ($aStatisticsFieldsDeliveryPlugins as $plugin) {
    $defaultRanks = $plugin->getDefaultRanks();
    foreach ($plugin->getVisibilitySettings() as $k => $v) {
        // Prepare fake serialized preferences for the next blocks
        $GLOBALS['_MAX']['PREF'][$k.'_label'] = array();
        $GLOBALS['_MAX']['PREF'][$k.'_rank']  = array(1 => $i+1, 2 => $i+1, 4 => $i+1, 8 => $i+1);
        if (isset($GLOBALS['_MAX']['PREF'][$k.'_array'])) {
            foreach ($GLOBALS['_MAX']['PREF'][$k.'_array'] as $kk => $vv) {
                $GLOBALS['_MAX']['PREF'][$k.'_label'][$kk] = $vv['label'];
                $GLOBALS['_MAX']['PREF'][$k.'_rank'][$kk]  = $vv['rank'];
            }
        } elseif ($GLOBALS['_MAX']['PREF'][$k] == -1) {
            if (isset($defaultRanks[$k])) {
                $rank = $defaultRanks[$k];
                $GLOBALS['_MAX']['PREF'][$k] = 15;
                $GLOBALS['_MAX']['PREF'][$k.'_rank']  = array(1 => $rank, 2 => $rank, 4 => $rank, 8 => $rank);
            } else {
                $rank = '';
                $GLOBALS['_MAX']['PREF'][$k] = 0;
                $GLOBALS['_MAX']['PREF'][$k.'_rank']  = array(1 => $rank, 2 => $rank, 4 => $rank, 8 => $rank);
            }
        }
        $GLOBALS['_MAX']['PREF'][$k.'_label'] = serialize($GLOBALS['_MAX']['PREF'][$k.'_label']);
        $GLOBALS['_MAX']['PREF'][$k.'_rank']  = serialize($GLOBALS['_MAX']['PREF'][$k.'_rank']);

        $show_headers = ($i++ == 0) ? $admin_settings : 0;
        $aSettings[2]['items'][] = array (
            'type'         => 'usertype_checkboxes',
            'name'         => $k,
            'text'         => sprintf(MAX_Plugin_Translation::translate('Show %s column', 'statisticsFieldsDelivery', null), $v),
            'show_headers' => $show_headers
        );
    }
}

$aSettings[2]['items'][] = array ('type' => 'break');

// Add column labels settings from plugins
$i = 0;
foreach ($aStatisticsFieldsDeliveryPlugins as $plugin) {
    foreach ($plugin->getVisibilitySettings() as $k => $v) {
        $show_headers = ($i++ == 0) ? $admin_settings : 0;
        $aSettings[2]['items'][] = array (
            'type'         => 'usertype_textboxes',
            'name'         => $k.'_label',
            'text'         => sprintf(MAX_Plugin_Translation::translate('Custom label for %s column', 'statisticsFieldsDelivery', null), $v),
            'show_headers' => $show_headers
        );
    }
}

$aSettings[2]['items'][] = array ('type' => 'break');

// Add column labels settings from plugins
$i = 0;
foreach ($aStatisticsFieldsDeliveryPlugins as $plugin) {
    foreach ($plugin->getVisibilitySettings() as $k => $v) {
        $show_headers = ($i++ == 0) ? $admin_settings : 0;
        $aSettings[2]['items'][] = array (
            'type'         => 'usertype_textboxes',
            'name'         => $k.'_rank',
            'text'         => sprintf(MAX_Plugin_Translation::translate('Rank of %s column', 'statisticsFieldsDelivery', null), $v),
            'show_headers' => $show_headers
        );
    }
}

// Add settings from inventory plugins
foreach ($aInvPlugins as $plugin) {
    $plugin->addSettings($aSettings);
}












$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>