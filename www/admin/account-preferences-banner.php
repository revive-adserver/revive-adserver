<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
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
$Id: settings-banner.php 12637 2007-11-20 19:02:36Z miguel.correa@openads.org $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';

$oOptions = new OA_Admin_Option('preferences');

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

$aErrormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobal('default_banner_url', 'default_banner_destination',
                          'banner_html_auto', 'default_banner_weight',
                          'default_campaign_weight');

    // Set up the preferences object
    $oPreferences = new OA_Admin_Preferences();
    if (isset($default_banner_url)) {
        $oPreferences->setPrefChange('default_banner_url', $default_banner_url);
    }
    if (isset($default_banner_destination)) {
        $oPreferences->setPrefChange('default_banner_destination', $default_banner_destination);
    }
    if (isset($default_banner_weight)) {
        $oPreferences->setPrefChange('default_banner_weight',    $default_banner_weight);
    }
    if (isset($default_campaign_weight)) {
        $oPreferences->setPrefChange('default_campaign_weight',  $default_campaign_weight);
    }

    $oPreferences->setPrefChange('banner_html_auto', isset($banner_html_auto));

    if (!$oPreferences->writePrefChange()) {
        // Unable to update the preferences
        $aErrormessage[0][] = $strUnableToWritePrefs;
    } else {
       if (phpAds_isUser(phpAds_Admin)) {
            MAX_Admin_Redirect::redirect('account-preferences-campaing-email-reports.php');
        } else {
          MAX_Admin_Redirect::redirect('account-settings-defaults.php');
       }
    }
}

phpAds_PageHeader("5.1");
if (phpAds_isUser(phpAds_Admin)) {
	phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
} elseif (phpAds_isUser(phpAds_Agency)) {
//    phpAds_ShowSections(array("5.2", "5.4", "5.3"));
    phpAds_ShowSections(array("5.2", "5.3"));
}
$oOptions->selection("banner");

$aSettings = array (
    array (
        'text'  => $strDefaultBanners,
        'items' => array (
            array (
                'type'    => 'text',
                'name'    => 'default_banner_url',
                'text'    => $strDefaultBannerUrl,
                'size'    => 35,
                'check'   => 'url'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'default_banner_destination',
                'text'    => $strDefaultBannerDestination,
                'size'    => 35,
                'check'   => 'url'
            )
        )
    ),
    array (
        'text'  => $strTypeHtmlSettings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'banner_html_auto',
                'text'    => $strTypeHtmlAuto,
                'depends' => 'type_html_allow==true'
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
    )
);

$oOptions->show($aSettings, $aErrormessage);
phpAds_PageFooter();

?>
