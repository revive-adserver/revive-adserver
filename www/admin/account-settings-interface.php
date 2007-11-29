<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/OA/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';

$oOptions = new OA_Admin_Option('settings');

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

$aErrormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobal('max_uiEnabled','name', 'my_header', 'my_footer', 'my_logo',
                          'gui_header_foreground_color', 'gui_header_background_color',
                          'gui_header_active_tab_color', 'gui_header_text_color',
                          'client_welcome', 'client_welcome_msg',
                          'publisher_welcome', 'publisher_welcome_msg',
                          'content_gzip_compression', 'publisher_agreement',
                          'publisher_agreement_text', 'more_reports',
                          'max_requireSSL', 'max_sslPort');

    $oConfig = new OA_Admin_Settings();
    $oConfig->setConfigChange('max', 'requireSSL',   $max_requireSSL);
    $oConfig->setConfigChange('max', 'uiEnabled',    $max_uiEnabled);
    $oConfig->setConfigChange('max', 'sslPort',      $max_sslPort);


    // Set up the preferences object
    $oPreferences = new OA_Admin_Preferences();
    if (isset($name)) {
        $oPreferences->setPrefChange('name', $name);
    }

    $oPreferences->setPrefChange('more_reports', $more_reports);

    if (isset($my_header)) {
        if (file_exists($my_header) || $my_header == '') {
            $oPreferences->setPrefChange('my_header', $my_header);
        } else {
            $aErrormessage[0][] = $strMyHeaderError;
        }
    }
    if (isset($my_footer)) {
        if (file_exists($my_footer) || $my_footer == '') {
            $oPreferences->setPrefChange('my_footer', $my_footer);
        } else {
            $aErrormessage[0][] = $strMyFooterError;
        }
    }
    if (isset($my_logo)) {
        if (file_exists("./images/$my_logo") || $my_logo == '') {
            $oPreferences->setPrefChange('my_logo', $my_logo);
        } else {
            $aErrormessage[0][] = $strMyLogoError;
        }
    }
    if (isset($gui_header_background_color))  {
        if ($gui_header_background_color == '' || preg_match('/[0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f]/', $gui_header_background_color)) {
            $oPreferences->setPrefChange('gui_header_background_color', $gui_header_background_color);
        } else {
            $aErrormessage[0][] = $strColorError;
        }
    }
    if (isset($gui_header_foreground_color)) {
        if ($gui_header_foreground_color == '' || preg_match('/[0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f]/', $gui_header_foreground_color)) {
            $oPreferences->setPrefChange('gui_header_foreground_color', $gui_header_foreground_color);
        } else {
            $aErrormessage[0][] = $strColorError;
        }
    }
    if (isset($gui_header_active_tab_color)) {
        if ($gui_header_active_tab_color == '' || preg_match('/[0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f]/', $gui_header_active_tab_color)) {
            $oPreferences->setPrefChange('gui_header_active_tab_color', $gui_header_active_tab_color);
        } else {
            $aErrormessage[0][] = $strColorError;
        }
    }
    if (isset($gui_header_text_color)) {
        if ($gui_header_text_color == '' || preg_match('/[0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f][0-9A-Fa-f]/', $gui_header_text_color)) {
            $oPreferences->setPrefChange('gui_header_text_color', $gui_header_text_color);
        } else {
            $aErrormessage[0][] = $strColorError;
        }
    }
    $oPreferences->setPrefChange('content_gzip_compression', isset($content_gzip_compression));
    $oPreferences->setPrefChange('client_welcome', isset($client_welcome));
    if (isset($client_welcome_msg)) {
        $oPreferences->setPrefChange('client_welcome_msg', $client_welcome_msg);
    }
    $oPreferences->setPrefChange('publisher_welcome', isset($publisher_welcome));
    if (isset($publisher_welcome_msg)) {
        $oPreferences->setPrefChange('publisher_welcome_msg', $publisher_welcome_msg);
    }

    $oPreferences->setPrefChange('publisher_agreement', isset($publisher_agreement));
    if (isset($publisher_agreement_text)) {
        $oPreferences->setPrefChange('publisher_agreement_text', $publisher_agreement_text);
    } else {
        $oPreferences->setPrefChange('publisher_agreement_text', '');
    }

     if (!count($aErrormessage)) {
        if (!$oConfig->writeConfigChange()) {
            // Unable to write the config file out
            $aErrormessage[0][] = $strUnableToWriteConfig;
        } else {
            if (!$oPreferences->writePrefChange()) {
                // Unable to update the preferences
                $aErrormessage[0][] = $strUnableToWritePrefs;
            } else {
                MAX_Admin_Redirect::redirect('account-settings-maintenance.php');
            }
        }
    }

}

phpAds_PageHeader("5.2");
if (phpAds_isUser(phpAds_Admin)) {
    phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
} elseif (phpAds_isUser(phpAds_Agency)) {
//    phpAds_ShowSections(array("5.2", "5.4", "5.3"));
    phpAds_ShowSections(array("5.2", "5.3"));
}
$oOptions->selection("interface");

$aSettings = array (
    array (
        'text'  => $strGeneralSettings,
        'items' => array (
            array (
                'type'  => 'checkbox',
                'name'  => 'max_uiEnabled',
                'text'  => $uiEnabled
            ),
            array (
                'type'    => 'break'
            ),
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
    // These settings have no effect at the moment so they are removed from the interface.
    /*array (
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
    ),*/

    // This setting has no effect at the moment so it is removed from the interface.
    /*array (
        'text'  => $strReportsInterface,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'more_reports',
                'text'    => $strAllowMoreReports
            )
        )
    )*/
    array (
        'text'  => $strSSLSettings,
        'items' => array (
            array (
                'type'  => 'checkbox',
                'name'  => 'max_requireSSL',
                'text'  => $requireSSL
            ),
            array (
                'type'  => 'break'
            ),
            array (
                'type'  => 'text',
                'name'  => 'max_sslPort',
                'text'  => $sslPort
            ),
        )
    )
);

$oOptions->show($aSettings, $aErrormessage);
phpAds_PageFooter();

?>