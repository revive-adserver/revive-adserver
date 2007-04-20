<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

$errormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobal('name', 'my_header', 'my_footer', 'my_logo',
                          'gui_header_foreground_color', 'gui_header_background_color',
                          'gui_header_active_tab_color', 'gui_header_text_color',
                          'client_welcome', 'client_welcome_msg',
                          'publisher_welcome', 'publisher_welcome_msg',
                          'content_gzip_compression', 'default_tracker_status',
                          'default_tracker_type', 'default_tracker_linkcampaigns', 
                          'publisher_agreement', 'publisher_agreement_text', 'more_reports');
    // Set up the preferences object
    $preferences = new MAX_Admin_Preferences();
    if (isset($name)) {
        $preferences->setPrefChange('name', $name);
    }
    if (isset($default_tracker_status)) {
        $preferences->setPrefChange('default_tracker_status', $default_tracker_status);
    }
    if (isset($default_tracker_type)) {
        $preferences->setPrefChange('default_tracker_type', $default_tracker_type);
    }

    $preferences->setPrefChange('more_reports', $more_reports);

    $preferences->setPrefChange('default_tracker_linkcampaigns', isset($default_tracker_linkcampaigns));

    if (isset($my_header)) {
        if (file_exists($my_header) || $my_header == '') {
            $preferences->setPrefChange('my_header', $my_header);
        } else {
            $errormessage[0][] = $strMyHeaderError;
        }
    }
    if (isset($my_footer)) {
        if (file_exists($my_footer) || $my_footer == '') {
            $preferences->setPrefChange('my_footer', $my_footer);
        } else {
            $errormessage[0][] = $strMyFooterError;
        }
    }
    if (isset($my_logo)) {
        if (file_exists("./images/$my_logo") || $my_logo == '') {
            $preferences->setPrefChange('my_logo', $my_logo);
        } else {
            $errormessage[0][] = $strMyLogoError;
        }
    }
    if (isset($gui_header_background_color))  {
        if ($gui_header_background_color == '' || preg_match('/[0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f]/', $gui_header_background_color)) {
            $preferences->setPrefChange('gui_header_background_color', $gui_header_background_color);
        } else {
            $errormessage[0][] = $strColorError;
        }
    }
    if (isset($gui_header_foreground_color)) {
        if ($gui_header_foreground_color == '' || preg_match('/[0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f]/', $gui_header_foreground_color)) {
            $preferences->setPrefChange('gui_header_foreground_color', $gui_header_foreground_color);
        } else {
            $errormessage[0][] = $strColorError;
        }
    }
    if (isset($gui_header_active_tab_color)) {
        if ($gui_header_active_tab_color == '' || preg_match('/[0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f]/', $gui_header_active_tab_color)) {
            $preferences->setPrefChange('gui_header_active_tab_color', $gui_header_active_tab_color);
        } else {
            $errormessage[0][] = $strColorError;
        }
    }
    if (isset($gui_header_text_color)) {
        if ($gui_header_text_color == '' || preg_match('/[0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f]/', $gui_header_text_color)) {
            $preferences->setPrefChange('gui_header_text_color', $gui_header_text_color);
        } else {
            $errormessage[0][] = $strColorError;
        }
    }
    $preferences->setPrefChange('content_gzip_compression', isset($content_gzip_compression));
    $preferences->setPrefChange('client_welcome', isset($client_welcome));
    if (isset($client_welcome_msg)) {
        $preferences->setPrefChange('client_welcome_msg', $client_welcome_msg);
    }
    $preferences->setPrefChange('publisher_welcome', isset($publisher_welcome));
    if (isset($publisher_welcome_msg)) {
        $preferences->setPrefChange('publisher_welcome_msg', $publisher_welcome_msg);
    }

    $preferences->setPrefChange('publisher_agreement', isset($publisher_agreement));
    if (isset($publisher_agreement_text)) {
        $preferences->setPrefChange('publisher_agreement_text', $publisher_agreement_text);
    } else {
        $preferences->setPrefChange('publisher_agreement_text', '');
    }

    if (!count($errormessage)) {
        if (!$preferences->writePrefChange()) {
            // Unable to update the preferences
            $errormessage[0][] = $strUnableToWritePrefs;
        } else {
            MAX_Admin_Redirect::redirect('settings-index.php');
        }
    }
}

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
if (phpAds_isUser(phpAds_Admin)) {
    phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
} elseif (phpAds_isUser(phpAds_Agency)) {
    phpAds_ShowSections(array("5.1", "5.3", "5.2"));
}
phpAds_SettingsSelection("interface");

$statuses = array();
foreach($GLOBALS['_MAX']['STATUSES'] as $statusId => $statusName) {
    $statuses[$statusId] = $GLOBALS[$statusName];
}

$trackerTypes = array();
foreach($GLOBALS['_MAX']['CONN_TYPES'] as $typeId => $typeName) {
    $trackerTypes[$typeId] = $GLOBALS[$typeName];
}

$settings = array (
    array (
        'text'  => $strGeneralSettings,
        'items' => array (
            array (
                'type'    => 'text', 
                'name'    => 'name',
                'text'    => $strAppName,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text', 
                'name'    => 'my_header',
                'text'    => $strMyHeader,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text', 
                'name'    => 'my_footer',
                'text'    => $strMyFooter,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'my_logo',
                'text'    => $strMyLogo,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'gui_header_foreground_color',
                'text'    => $strGuiHeaderForegroundColor,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'gui_header_background_color',
                'text'    => $strGuiHeaderBackgroundColor,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'gui_header_active_tab_color',
                'text'    => $strGuiActiveTabColor,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'gui_header_text_color',
                'text'    => $strGuiHeaderTextColor,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'content_gzip_compression',
                'text'    => $strGzipContentCompression
            )
        )
    ),
    array (
        'text'  => $strClientInterface,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'client_welcome',
                'text'    => $strClientWelcomeEnabled
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'textarea', 
                'name'    => 'client_welcome_msg',
                'text'    => $strClientWelcomeText,
                'depends' => 'client_welcome==true'
            )
        )
    ),
    array (
        'text'  => $strPublisherInterface,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'publisher_welcome',
                'text'    => $strClientWelcomeEnabled
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'textarea', 
                'name'    => 'publisher_welcome_msg',
                'text'    => $strClientWelcomeText,
                'depends' => 'publisher_welcome==true'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'publisher_agreement',
                'text'    => $strPublisherAgreementEnabled
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'textarea', 
                'name'    => 'publisher_agreement_text',
                'text'    => $strPublisherAgreementText,
                'depends' => 'publisher_agreement==true'
            )
        )
    ),
    array (
        'text'  => $strTracker,
        'items' => array (
            array (
                'type'    => 'select', 
                'name'    => 'default_tracker_status',
                'text'    => $strDefaultTrackerStatus,
                'items'   => $statuses
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'select', 
                'name'    => 'default_tracker_type',
                'text'    => $strDefaultTrackerType,
                'items'   => $trackerTypes
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox', 
                'name'    => 'default_tracker_linkcampaigns',
                'text'    => $strLinkCampaignsByDefault
            )
        )
    ),
    array (
        'text'  => $strReportsInterface,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'more_reports',
                'text'    => $strAllowMoreReports
            )
        )
    )    
);

phpAds_ShowSettings($settings, $errormessage);
phpAds_PageFooter();

?>
