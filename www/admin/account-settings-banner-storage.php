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
require_once MAX_PATH . '/lib/OA/Admin/Settings.php';

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');
$prefSection = "banner-storage";

// Prepare an array for storing error messages
$aErrormessage = [];

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = [];

    // Allowed Banner Types
    $aElements += [
        'allowedBanners_sql' => [
            'allowedBanners' => 'sql',
            'bool' => true
        ],
        'allowedBanners_web' => [
            'allowedBanners' => 'web',
            'bool' => true
        ],
        'allowedBanners_url' => [
            'allowedBanners' => 'url',
            'bool' => true
        ],
        'allowedBanners_html' => [
            'allowedBanners' => 'html',
            'bool' => true
        ],
        'allowedBanners_text' => [
            'allowedBanners' => 'text',
            'bool' => true
        ]
    ];
    // Webserver Local Banner Storage Settings
    $aElements += [
        'store_mode' => ['store' => 'mode'],
        'store_webDir' => ['store' => 'webDir'],
        'store_ftpHost' => ['store' => 'ftpHost'],
        'store_ftpPath' => ['store' => 'ftpPath'],
        'store_ftpUsername' => ['store' => 'ftpUsername'],
        'store_ftpPassword' => ['store' => 'ftpPassword'],
        'store_ftpPassive' => [
            'store' => 'ftpPassive',
            'bool' => 'true'
        ]
    ];
    // Test the writablility of the web or FTP storage, if required
    phpAds_registerGlobal('store_webDir');
    if (isset($store_webDir)) {
        // Check that the web directory is writable
        if (is_writable($store_webDir)) {
            //  If web store path has changed, copy the 1x1.gif to the
            // new location, else create it
            if ($conf['store']['webDir'] != $store_webDir) {
                if (file_exists($conf['store']['webDir'] . '/1x1.gif')) {
                    copy($conf['store']['webDir'] . '/1x1.gif', $store_webDir . '/1x1.gif');
                } else {
                    $fp = fopen($store_webDir . '/1x1.gif', 'w');
                    fwrite($fp, base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='));
                    fclose($fp);
                }
            }
        } else {
            $aErrormessage[0][] = $strTypeDirError;
        }
    }
    phpAds_registerGlobal('store_ftpHost');
    if (isset($store_ftpHost)) {
        phpAds_registerGlobal('store_ftpUsername');
        phpAds_registerGlobal('store_ftpPassword');
        phpAds_registerGlobal('store_ftpPassive');
        phpAds_registerGlobal('store_ftpPath');
        // Check that PHP has support for FTP
        if (function_exists('ftp_connect')) {
            // Check that the FTP host can be contacted
            if ($ftpsock = @ftp_connect($store_ftpHost)) {
                // Check that the details to log into the FTP host are correct
                if (@ftp_login($ftpsock, $store_ftpUsername, $store_ftpPassword)) {
                    if ($store_ftpPassive) {
                        ftp_pasv($ftpsock, true);
                    }
                    //Check path to ensure there is not a leading slash
                    if (($store_ftpPath != "") && (substr($store_ftpPath, 0, 1) == "/")) {
                        $store_ftpPath = substr($store_ftpPath, 1);
                    }

                    if (empty($store_ftpPath) || @ftp_chdir($ftpsock, $store_ftpPath)) { // Changes path if store_ftpPath is not empty!
                        // Save the 1x1.gif temporarily
                        $filename = MAX_PATH . '/var/1x1.gif';
                        $fp = @fopen($filename, 'w+');
                        @fwrite($fp, base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='));

                        // Upload to server
                        if (!@ftp_put($ftpsock, '1x1.gif', MAX_PATH . '/var/1x1.gif', FTP_BINARY)) {
                            $aErrormessage[0][] = $strTypeFTPErrorUpload;
                        }
                        // Chmod file so that it's world readable
                        if (function_exists('ftp_chmod') && !@ftp_chmod($ftpsock, 0644, '1x1.gif')) {
                            OA::debug('Unable to modify FTP permissions for file: ' . $store_ftpPath . '/1x1.gif', PEAR_LOG_INFO);
                        }
                        // Delete temp 1x1.gif file
                        @fclose($fp);
                        @ftp_close($ftpsock);
                        unlink($filename);
                    } else {
                        $aErrormessage[0][] = $strTypeFTPErrorDir;
                    }
                } else {
                    $aErrormessage[0][] = $strTypeFTPErrorConnect;
                }
                @ftp_quit($ftpsock);
            } else {
                $aErrormessage[0][] = $strTypeFTPErrorHost;
            }
        } else {
            $aErrormessage[0][] = $strTypeFTPErrorNoSupport;
        }
    }
    if (empty($aErrormessage)) {
        // Create a new settings object, and save the settings!
        $oSettings = new OA_Admin_Settings();
        $result = $oSettings->processSettingsFromForm($aElements);
        if ($result) {
            // Queue confirmation message
            $setPref = $oOptions->getSettingsPreferences($prefSection);
            $title = $setPref[$prefSection]['name'];
            $translation = new OX_Translation();
            $translated_message = $translation->translate(
                $GLOBALS['strXSettingsHaveBeenUpdated'],
                [htmlspecialchars($title)]
            );
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

            // The settings configuration file was written correctly,
            // go to the "next" settings page from here
            OX_Admin_Redirect::redirect(basename($_SERVER['SCRIPT_NAME']));
        }
        // Could not write the settings configuration file, store this
        // error message and continue
        $aErrormessage[0][] = $strUnableToWriteConfig;
    }
}

// Set the correct section of the settings pages and display the drop-down menu
$setPref = $oOptions->getSettingsPreferences($prefSection);
$title = $setPref[$prefSection]['name'];

// Display the settings page's header and sections
$oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel($title);
phpAds_PageHeader('account-settings-index', $oHeaderModel);

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = [
   [
        'text' => $strAllowedBannerTypes,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'allowedBanners_sql',
                'text' => $strTypeSqlAllow
            ],
            [
                'type' => 'checkbox',
                'name' => 'allowedBanners_web',
                'text' => $strTypeWebAllow
            ],
            [
                'type' => 'checkbox',
                'name' => 'allowedBanners_url',
                'text' => $strTypeUrlAllow
            ],
            [
                'type' => 'checkbox',
                'name' => 'allowedBanners_html',
                'text' => $strTypeHtmlAllow
            ],
            [
                'type' => 'checkbox',
                'name' => 'allowedBanners_text',
                'text' => $strTypeTxtAllow
            ]
        ]
    ],
    [
        'text' => $strTypeWebSettings,
        'items' => [
            [
                'type' => 'select',
                'name' => 'store_mode',
                'text' => $strTypeWebMode,
                'items' => [
                    0 => $strTypeWebModeLocal,
                    1 => $strTypeWebModeFtp,
                ],
                'depends' => 'allowedBanners_web==1',
            ],
            [
                'type' => 'break',
                'size' => 'full'
            ],
            [
                'type' => 'text',
                'name' => 'store_webDir',
                'text' => $strTypeWebDir,
                'size' => 35,
                'depends' => 'allowedBanners_web==1 && store_mode==0'
            ],
            [
                'type' => 'break',
                'size' => 'full'
            ],
            [
                'type' => 'text',
                'name' => 'store_ftpHost',
                'text' => $strTypeFTPHost,
                'size' => 35,
                'depends' => 'allowedBanners_web==1 && store_mode==1'
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'store_ftpPath',
                'text' => $strTypeFTPDirectory,
                'size' => 35,
                'depends' => 'allowedBanners_web==1 && store_mode==1'
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'store_ftpUsername',
                'text' => $strTypeFTPUsername,
                'size' => 35,
                'depends' => 'allowedBanners_web==1 && store_mode==1'
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'password',
                'name' => 'store_ftpPassword',
                'text' => $strTypeFTPPassword,
                'size' => 35,
                'depends' => 'allowedBanners_web==1 && store_mode==1'
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'store_ftpPassive',
                'text' => $strTypeFTPPassive,
                'depends' => 'allowedBanners_web==1 && store_mode==1'
            ]
        ]
    ]
];
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();
