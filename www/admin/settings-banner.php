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
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

$errormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobal('default_banner_url', 'default_banner_destination',
                          'type_sql_allow', 'type_web_allow', 'type_url_allow',
                          'type_html_allow', 'type_txt_allow',
                          'banner_html_auto');
    // Set up the preferences object
    $preferences = new MAX_Admin_Preferences();
    if (isset($default_banner_url)) {
        $preferences->setPrefChange('default_banner_url', $default_banner_url);
    }
    if (isset($default_banner_destination)) {
        $preferences->setPrefChange('default_banner_destination', $default_banner_destination);
    }
    $preferences->setPrefChange('type_sql_allow', isset($type_sql_allow));
    $preferences->setPrefChange('type_web_allow', isset($type_web_allow));
    $preferences->setPrefChange('type_url_allow', isset($type_url_allow));
    $preferences->setPrefChange('type_html_allow', isset($type_html_allow));
    $preferences->setPrefChange('type_txt_allow', isset($type_txt_allow));
    $preferences->setPrefChange('banner_html_auto', isset($banner_html_auto));
    if (!$preferences->writePrefChange()) {
        // Unable to update the preferences
        $errormessage[0][] = $strUnableToWritePrefs;
    } else {
       if (phpAds_isUser(phpAds_Admin)) {
            MAX_Admin_Redirect::redirect('settings-db.php');
        } else {
          MAX_Admin_Redirect::redirect('settings-defaults.php');
       }
    }
}

phpAds_PageHeader("5.1");
if (phpAds_isUser(phpAds_Admin)) {
	phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
} elseif (phpAds_isUser(phpAds_Agency)) {
    phpAds_ShowSections(array("5.1", "5.3", "5.2"));
}
phpAds_SettingsSelection("banner");

$settings = array (
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
        'text'  => $strAllowedBannerTypes,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'type_sql_allow',
                'text'    => $strTypeSqlAllow
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'type_web_allow',
                'text'    => $strTypeWebAllow
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'type_url_allow',
                'text'    => $strTypeUrlAllow
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'type_html_allow',
                'text'    => $strTypeHtmlAllow
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'type_txt_allow',
                'text'    => $strTypeTxtAllow
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
    )
);

phpAds_ShowSettings($settings, $errormessage);
phpAds_PageFooter();

?>
