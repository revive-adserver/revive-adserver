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
require_once MAX_PATH . '/lib/max/Admin/Cache.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';

$oOptions = new OA_Admin_Option('settings');

// Security check
phpAds_checkAccess(phpAds_Admin);

$aErrormessage = array();
$redirectUploadFile = false;

if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    phpAds_registerGlobal('webpath_admin', 'webpath_delivery', 'webpath_deliverySSL',
                          'webpath_images', 'webpath_imagesSSL',
                          'file_click', 'file_conversionvars', 'file_content', 'file_conversion',
                          'file_conversionjs', 'file_frame', 'file_image', 'file_js', 'file_layer',
                          'file_log', 'file_popup', 'file_view', 'file_xmlrpc', 'file_local', 'file_frontcontroller',
                          'file_flash', 'store_mode', 'store_webDir', 'store_ftpHost', 'store_ftpPath',
                          'store_ftpUsername','store_ftpPassword', 'store_ftpPassive',
                          'delivery_cache', 'delivery_cacheExpire',
                          'delivery_acls', 'delivery_obfuscate', 'delivery_execPhp',
                          'origin_type','origin_host','origin_port','origin_script','origin_timeout','origin_protocol',
                          'delivery_ctDelimiter',
                          'p3p_policies', 'p3p_compactPolicy', 'p3p_policyLocation',
                          'type_sql_allow', 'type_web_allow', 'type_url_allow','type_html_allow',
                          'type_txt_allow');
    // Set up the configuration .ini file
    $oConfig = new OA_Admin_Settings();
    if (isset($webpath_admin)) {
        $oConfig->setConfigChange('webpath', 'admin',         preg_replace('#/$#', '', $webpath_admin));
    }
    if (isset($webpath_delivery)) {
        $oConfig->setConfigChange('webpath', 'delivery',      preg_replace('#/$#', '', $webpath_delivery));
    }
    if (isset($webpath_deliverySSL)) {
        $oConfig->setConfigChange('webpath', 'deliverySSL',   preg_replace('#/$#', '', $webpath_deliverySSL));
    }
    if (isset($webpath_images)) {
        $oConfig->setConfigChange('webpath', 'images',        preg_replace('#/$#', '', $webpath_images));
    }
    if (isset($webpath_imagesSSL)) {
        $oConfig->setConfigChange('webpath', 'imagesSSL',     preg_replace('#/$#', '', $webpath_imagesSSL));
    }
    if (isset($store_mode)) {
        $oConfig->setConfigChange('store', 'mode',            $store_mode);
    }
    if (isset($store_webDir)) {
        // Check that the web directory is writable
        if (is_writable($store_webDir)) {
            $oConfig->setConfigChange('store', 'webDir',  $store_webDir);

            //  if path has changed copy 1x1.gif to new location else create it
            if ($conf['store']['webDir'] != $store_webDir) {
                if (file_exists($conf['store']['webDir'] .'/1x1.gif')) {
                    copy($conf['store']['webDir'].'/1x1.gif', $store_webDir.'/1x1.gif');
                } else {
                    $fp = fopen($store_webDir.'/1x1.gif', 'w');
                    fwrite($fp, base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='));
                    fclose($fp);
                }
            }
        } else {
            $aErrormessage[1][] = $strTypeDirError;
        }
    }
    if (isset($store_ftpHost)) {

        // Check that the FTP host can be contacted
        if ($ftpsock = @ftp_connect($store_ftpHost)) {
            if (@ftp_login($ftpsock, $store_ftpUsername, $store_ftpPassword)) {

                // old library has no support for second param to check if passive should be enabled
                if( $store_ftpPassive ) {
                  ftp_pasv( $ftpsock, true );
                }

                if (empty($store_ftpPath) || @ftp_chdir($ftpsock, $store_ftpPath)) {
                    // Can login okay
                    $oConfig->setConfigChange('store', 'ftpHost',    $store_ftpHost);
                    $oConfig->setConfigChange('store', 'ftpPath',     $store_ftpPath);
                    $oConfig->setConfigChange('store', 'ftpUsername', $store_ftpUsername);
                    $oConfig->setConfigChange('store', 'ftpPassword', $store_ftpPassword);
                    $oConfig->setConfigChange('store', 'ftpPassive', $store_ftpPassive);

                    //  save the 1x1.gif temporarily
                    $filename = MAX_PATH .'/var/1x1.gif';
                    $fp = @fopen($filename, 'w+');
                    @fwrite($fp, base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='));
                    // check path to ensure there is not a leading slash
                    if (($store_ftpPath != "") && (substr($store_ftpPath, 0, 1) == "/")) {
                        $store_ftpPath = substr($store_ftpPath, 1);
                    }
                    // change path
                    if ($store_ftpPath != "") {
                        @ftp_chdir($ftpsock, $store_ftpPath);
                    }
                    //  upload to server
                    @ftp_put($ftpsock, '1x1.gif', MAX_PATH.'/var/1x1.gif', FTP_BINARY);
                    //  chmod file so that it's world readable
                    if (function_exists('ftp_chmod') && !@ftp_chmod($ftpsock, 0644, '1x1.gif')) {
                        OA::debug('Unable to modify FTP permissions for file: '. $store_ftpPath .'/1x1.gif', PEAR_LOG_INFO);
                    }
                    //  delete temp 1x1.gif file
                    @fclose($fp);
                    @ftp_close($ftpsock);
                    unlink($filename);
                } else {
                    $aErrormessage[1][] = $strTypeFTPErrorDir;
                }
            } else {
                $aErrormessage[1][] = $strTypeFTPErrorConnect;
            }
            @ftp_quit($ftpsock);
        } else {
            $aErrormessage[1][] = $strTypeFTPErrorHost;
        }
    }
    if (isset($file_click)) {
        $oConfig->setConfigChange('file', 'click',            $file_click);
    }
    if (isset($file_conversionvars)) {
        $oConfig->setConfigChange('file', 'conversionvars',   $file_conversionvars);
    }
    if (isset($file_content)) {
        $oConfig->setConfigChange('file', 'content',          $file_content);
    }
    if (isset($file_conversion)) {
        $oConfig->setConfigChange('file', 'conversion',       $file_conversion);
    }
    if (isset($file_conversionjs)) {
        $oConfig->setConfigChange('file', 'conversionjs',     $file_conversionjs);
    }
    if (isset($file_frame)) {
        $oConfig->setConfigChange('file', 'frame',            $file_frame);
    }
    if (isset($file_image)) {
        $oConfig->setConfigChange('file', 'image',            $file_image);
    }
    if (isset($file_js)) {
        $oConfig->setConfigChange('file', 'js',               $file_js);
    }
    if (isset($file_layer)) {
        $oConfig->setConfigChange('file', 'layer',            $file_layer);
    }
    if (isset($file_log)) {
        $oConfig->setConfigChange('file', 'log',              $file_log);
    }
    if (isset($file_popup)) {
        $oConfig->setConfigChange('file', 'popup',            $file_popup);
    }
    if (isset($file_view)) {
        $oConfig->setConfigChange('file', 'view',             $file_view);
    }
    if (isset($file_xmlrpc)) {
        $oConfig->setConfigChange('file', 'xmlrpc',           $file_xmlrpc);
    }
    if (isset($file_local)) {
        $oConfig->setConfigChange('file', 'local',            $file_local);
    }
    if (isset($file_frontcontroller)) {
        $oConfig->setConfigChange('file', 'frontcontroller',  $file_frontcontroller);
    }
    if (isset($file_flash)) {
        $oConfig->setConfigChange('file', 'flash',  $file_flash);
    }
    if (isset($delivery_cacheExpire)) {
        $oConfig->setConfigChange('delivery', 'cacheExpire',  $delivery_cacheExpire);
    }
    $oConfig->setConfigChange('delivery', 'acls',             isset($delivery_acls));
    $oConfig->setConfigChange('delivery', 'obfuscate',        isset($delivery_obfuscate));
    $oConfig->setConfigChange('delivery', 'execPhp',          isset($delivery_execPhp));
    if (isset($delivery_ctDelimiter)) {
        $oConfig->setConfigChange('delivery', 'ctDelimiter',  $delivery_ctDelimiter);
    }
    $oConfig->setConfigChange('p3p', 'policies',              isset($p3p_policies));
    if (isset($p3p_compactPolicy)) {
        $oConfig->setConfigChange('p3p', 'compactPolicy',     $p3p_compactPolicy);
    }
    if (isset($p3p_policyLocation)) {
        $oConfig->setConfigChange('p3p', 'policyLocation',    $p3p_policyLocation);
    }

    $oPreferences = new OA_Admin_Preferences();
    $oPreferences->setPrefChange('type_sql_allow', isset($type_sql_allow));
    $oPreferences->setPrefChange('type_web_allow', isset($type_web_allow));
    $oPreferences->setPrefChange('type_url_allow', isset($type_url_allow));
    $oPreferences->setPrefChange('type_html_allow', isset($type_html_allow));
    $oPreferences->setPrefChange('type_txt_allow', isset($type_txt_allow));


    if (!count($aErrormessage)) {
        if (!$oConfig->writeConfigChange()) {
            // Unable to write the config file out
            $aErrormessage[0][] = $strUnableToWriteConfig;
        } else {
            if (!$oPreferences->writePrefChange()) {
                // Unable to update the preferences
                $aErrormessage[0][] = $strUnableToWritePrefs;
            } else {
                if ($redirectUploadFile) {
                    MAX_Admin_Redirect::redirect('settings-upload.php');
                } else {
                    MAX_Admin_Redirect::redirect('account-settings-database.php');
                }
            }
        }
    }

}

phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
$oOptions->selection("banner-storage");

$aSettings = array(
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
        'text' 	=> $strTypeWebSettings,
        'items'	=> array (
            array (
                'type'      => 'select',
                'name'      => 'store_mode',
                'text'      => $strTypeWebMode,
                'items'     => array('local' => $strTypeWebModeLocal,
                'ftp'       => $strTypeWebModeFtp),
                'depends'   => 'type_web_allow==1',
            ),
            array (
                'type'      => 'break',
                'size'      => 'full'
            ),
            array (
                'type' 	  => 'text',
                'name' 	  => 'store_webDir',
                'text' 	  => $strTypeWebDir,
                'size'	  => 35,
                //'depends' => 'store_mode==0'
                'depends'   => 'type_web_allow==1 && store_mode==0'
            ),
            array (
                'type'    => 'break',
                'size'	  => 'full'
            ),
            array (
                'type' 	  => 'text',
                'name' 	  => 'store_ftpHost',
                'text' 	  => $strTypeFTPHost,
                'size'	  => 35,
                'depends' => 'store_mode==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type' 	  => 'text',
                'name' 	  => 'store_ftpPath',
                'text' 	  => $strTypeFTPDirectory,
                'size'	  => 35,
                'depends' => 'store_mode==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type' 	  => 'text',
                'name' 	  => 'store_ftpUsername',
                'text' 	  => $strTypeFTPUsername,
                'size'	  => 35,
                'depends' => 'store_mode==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type' 	  => 'password',
                'name' 	  => 'store_ftpPassword',
                'text' 	  => $strTypeFTPPassword,
                'size'	  => 35,
                'depends' => 'store_mode==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type' 	  => 'checkbox',
                'name' 	  => 'store_ftpPassive',
                'text' 	  => $strTypeFTPPassive,
                'depends' => 'store_mode==1'
            )
        )
    )
);

$oOptions->show($aSettings, $aErrormessage);
phpAds_PageFooter();

?>
