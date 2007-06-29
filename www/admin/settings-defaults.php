<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/Common.php';

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Client + phpAds_Affiliate);


// Load and sort statisticsFieldsDelivery plugins
$statisticsFieldsDeliveryPlugins = &MAX_Plugin::getPlugins('statisticsFieldsDelivery');
uasort($statisticsFieldsDeliveryPlugins, array('OA_Admin_Statistics_Common', '_pluginSort'));

// Load inventory plugins
$invPlugins = &MAX_Plugin::getPlugins('inventoryProperties');
foreach($invPlugins as $pluginKey => $plugin) {
    if ($plugin->getType() != 'settings-defaults') {
        unset($invPlugins[$pluginKey]);
    }
}

$errormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobal('gui_show_campaign_info', 'gui_show_banner_info',
                          'gui_show_campaign_preview', 'gui_show_banner_html',
                          'gui_show_banner_preview', 'gui_hide_inactive',
                          'gui_show_matching', 'gui_show_parents', 'begin_of_week',
                          'percentage_decimals', 'default_banner_weight',
                          'default_campaign_weight', 'gui_campaign_anonymous',
                          'publisher_default_tax_id', 'publisher_default_approved',
                          'publisher_payment_modes', 'publisher_currencies',
                          'publisher_categories', 'publisher_help_files'
                          );

    // Register input variables for inventory plugins
    foreach ($invPlugins as $plugin) {
        call_user_func_array('phpAds_registerGlobal', $plugin->getGlobalVars());
    }

    // Set up the preferences object
    $preferences = new MAX_Admin_Preferences();
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency))
    {
        $preferences->setPrefChange('gui_show_campaign_info',       isset($gui_show_campaign_info));
        $preferences->setPrefChange('gui_show_banner_info',         isset($gui_show_banner_info));
        $preferences->setPrefChange('gui_show_campaign_preview',    isset($gui_show_campaign_preview));
        $preferences->setPrefChange('gui_show_banner_html',         isset($gui_show_banner_html));
        $preferences->setPrefChange('gui_show_banner_preview',      isset($gui_show_banner_preview));
        $preferences->setPrefChange('gui_hide_inactive',            isset($gui_hide_inactive));
        $preferences->setPrefChange('gui_show_matching',            isset($gui_show_matching));
        $preferences->setPrefChange('gui_show_parents',             isset($gui_show_parents));
        $preferences->setPrefChange('gui_campaign_anonymous',       isset($gui_campaign_anonymous));
        if (isset($begin_of_week)) {
            $preferences->setPrefChange('begin_of_week',            $begin_of_week);
        }
        if (isset($percentage_decimals)) {
            $preferences->setPrefChange('percentage_decimals',      $percentage_decimals);
        }
        if (isset($default_banner_weight)) {
            $preferences->setPrefChange('default_banner_weight',    $default_banner_weight);
        }
        if (isset($default_campaign_weight)) {
            $preferences->setPrefChange('default_campaign_weight',  $default_campaign_weight);
        }

        // Publisher defaults
        $preferences->setPrefChange('publisher_default_tax_id',    isset($publisher_default_tax_id));
        $preferences->setPrefChange('publisher_default_approved',  isset($publisher_default_approved));
        if (isset($publisher_payment_modes)) {
            $preferences->setPrefChange('publisher_payment_modes', $publisher_payment_modes);
        }
        if (isset($publisher_currencies)) {
            $preferences->setPrefChange('publisher_currencies',    $publisher_currencies);
        }
        if (isset($publisher_categories)) {
            $preferences->setPrefChange('publisher_categories',    $publisher_categories);
        }
        if (isset($publisher_help_files)) {
            $preferences->setPrefChange('publisher_help_files',    $publisher_help_files);
        }
    }

    // Advertiser / publisher preferences
    foreach ($statisticsFieldsDeliveryPlugins as $plugin) {
        $vars = array_keys($plugin->getVisibilitySettings());
        $vars2 = array();
        foreach ($vars as $var) {
            $vars2[] = $var.'_label';
            $vars2[] = $var.'_rank';
        }
        call_user_func_array('phpAds_registerGlobal', $vars);
        call_user_func_array('phpAds_registerGlobal', $vars2);
        foreach ($vars as $var) {
            $varlabel = $var.'_label';
            $varrank  = $var.'_rank';
            $final    = array();
            foreach (array(phpAds_Admin, phpAds_Client, phpAds_Affiliate, phpAds_Agency) as $perm) {
                $final[$perm] = array('show' => true, 'label' => '', 'rank' => 0);
                if (isset($$var)) {
                    $final[$perm]['show'] = (bool)($$var & $perm);
                }
                if (isset(${$varlabel}[$perm])) {
                    $final[$perm]['label'] = ${$varlabel}[$perm];
                }
                if (isset(${$varrank}[$perm])) {
                    $final[$perm]['rank'] = (int)${$varrank}[$perm];
                }
            }

            $preferences->setPrefChange($var, serialize($final));
        }
    }

    // Save settings for inventory plugins
    foreach ($invPlugins as $plugin) {
        foreach ($plugin->prepareVariables() as $k => $v) {
            $preferences->setPrefChange($k, $v);
        }
    }

    if (!$preferences->writePrefChange()) {
        // Unable to update the preferences
        $errormessage[0][] = $strUnableToWritePrefs;
    } else {
        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
            MAX_Admin_Redirect::redirect('settings-invocation.php');
        } elseif (phpAds_isUser(phpAds_Client)) {
            MAX_Admin_Redirect::redirect('settings-defaults.php?clientid='.phpAds_getUserId());
        } else {
            MAX_Admin_Redirect::redirect('settings-defaults.php?affiliateid='.phpAds_getUserId());
        }
    }
}

if (phpAds_isUser(phpAds_Admin)) {
    phpAds_PageHeader("5.1");
    phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
} elseif (phpAds_isUser(phpAds_Agency)) {
    phpAds_PageHeader("5.1");
//    phpAds_ShowSections(array("5.1", "5.3", "5.2"));
    phpAds_ShowSections(array("5.1", "5.2"));
} elseif (phpAds_isUser(phpAds_Client)) {
    phpAds_PageHeader("4.1");
    phpAds_ShowSections(array("4.1"));
} else {
    $sections = array();
    $sections[] = "4.1";
    if (phpAds_isAllowed(phpAds_ModifyInfo)) {
        $sections[] = "4.2";
    }
    phpAds_PageHeader('4.1');
    phpAds_ShowSections($sections);
}
phpAds_SettingsSelection("defaults");

$admin_settings = phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency);

$settings = array (
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
    ),
    array (
        'text'  => $strWeightDefaults,
        'visible' => $admin_settings,
        'items' => array (
            array (
                'type'  => 'text',
                'name'  => 'default_banner_weight',
                'text'  => $strDefaultBannerWeight,
                'size'  => 12,
                'check' => 'number+',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'text',
                'name'  => 'default_campaign_weight',
                'text'  => $strDefaultCampaignWeight,
                'size'  => 12,
                'check' => 'number+',
                'visible' => $admin_settings
            )
        )
    ),
    array (
        'text'  => $strPublisherDefaults,
        'visible' => $admin_settings,
        'items' => array (
            array (
                'type'  => 'text',
                'name'  => 'publisher_payment_modes',
                'text'  => $strModesOfPayment,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'text',
                'name'  => 'publisher_currencies',
                'text'  => $strCurrencies,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'text',
                'name'  => 'publisher_categories',
                'text'  => $strCategories,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'text',
                'name'  => 'publisher_help_files',
                'text'  => $strHelpFiles,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'break',
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'publisher_default_tax_id',
                'text'  => $strHasTaxID,
                'visible' => $admin_settings
            ),
            array (
                'type'  => 'checkbox',
                'name'  => 'publisher_default_approved',
                'text'  => $strDefaultApproved,
                'visible' => $admin_settings
            )
        )
    )
);

// Add column visibility settings from plugins
$i = 0;
foreach ($statisticsFieldsDeliveryPlugins as $plugin) {
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
        $settings[1]['items'][] = array (
            'type'         => 'usertype_checkboxes',
            'name'         => $k,
            'text'         => sprintf(MAX_Plugin_Translation::translate('Show %s column', 'statisticsFieldsDelivery', null), $v),
            'show_headers' => $show_headers
        );
    }
}

$settings[1]['items'][] = array ('type' => 'break');

// Add column labels settings from plugins
$i = 0;
foreach ($statisticsFieldsDeliveryPlugins as $plugin) {
    foreach ($plugin->getVisibilitySettings() as $k => $v) {
        $show_headers = ($i++ == 0) ? $admin_settings : 0;
        $settings[1]['items'][] = array (
            'type'         => 'usertype_textboxes',
            'name'         => $k.'_label',
            'text'         => sprintf(MAX_Plugin_Translation::translate('Custom label for %s column', 'statisticsFieldsDelivery', null), $v),
            'show_headers' => $show_headers
        );
    }
}

$settings[1]['items'][] = array ('type' => 'break');

// Add column labels settings from plugins
$i = 0;
foreach ($statisticsFieldsDeliveryPlugins as $plugin) {
    foreach ($plugin->getVisibilitySettings() as $k => $v) {
        $show_headers = ($i++ == 0) ? $admin_settings : 0;
        $settings[1]['items'][] = array (
            'type'         => 'usertype_textboxes',
            'name'         => $k.'_rank',
            'text'         => sprintf(MAX_Plugin_Translation::translate('Rank of %s column', 'statisticsFieldsDelivery', null), $v),
            'show_headers' => $show_headers
        );
    }
}

// Add settings from inventory plugins
foreach ($invPlugins as $plugin) {
    $plugin->addSettings($settings);
}

phpAds_ShowSettings($settings, $errormessage);
phpAds_PageFooter();

?>
