<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';
require_once MAX_PATH . '/www/admin/lib-install-db.inc.php';
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin);

$errormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    phpAds_registerGlobal('webpath_admin', 'webpath_delivery', 'webpath_deliverySSL',
                          'webpath_images', 'webpath_imagesSSL',
                          'file_click', 'file_conversionvars', 'file_content', 'file_conversion',
                          'file_conversionjs', 'file_frame', 'file_image', 'file_js', 'file_layer',
                          'file_log', 'file_popup', 'file_view', 'file_xmlrpc', 'file_local', 'file_frontcontroller',
                          'file_flash', 'store_mode', 'store_webDir', 'store_ftpHost', 'store_ftpPath',
                          'store_ftpUsername','store_ftpPassword',
                          'delivery_cache', 'delivery_cacheExpire',
                          'delivery_acls', 'delivery_obfuscate', 'delivery_execPhp',
                          'origin_type','origin_host','origin_port','origin_script','origin_timeout','origin_protocol',
                          'delivery_ctDelimiter',
                          'p3p_policies', 'p3p_compactPolicy', 'p3p_policyLocation');
    // Set up the configuration .ini file
    $config = new MAX_Admin_Config();
    if (isset($webpath_admin)) {
        $config->setConfigChange('webpath', 'admin',         preg_replace('#/$#', '', $webpath_admin));
    }
    if (isset($webpath_delivery)) {
        $config->setConfigChange('webpath', 'delivery',      preg_replace('#/$#', '', $webpath_delivery));
    }
    if (isset($webpath_deliverySSL)) {
        $config->setConfigChange('webpath', 'deliverySSL',   preg_replace('#/$#', '', $webpath_deliverySSL));
    }
    if (isset($webpath_images)) {
        $config->setConfigChange('webpath', 'images',        preg_replace('#/$#', '', $webpath_images));
    }
    if (isset($webpath_imagesSSL)) {
        $config->setConfigChange('webpath', 'imagesSSL',     preg_replace('#/$#', '', $webpath_imagesSSL));
    }
    if (isset($store_mode)) {
        $config->setConfigChange('store', 'mode',            $store_mode);
    }
    if (isset($store_webDir)) {
        // Check that the web directory is writable
        if (is_writable($store_webDir)) {
            $config->setConfigChange('store', 'webDir',  $store_webDir);
        } else {
            $errormessage[1][] = $strTypeDirError;
        }
    }
    if (isset($store_ftpHost)) {
        // Check that the FTP host can be contacted


    if(!function_exists(ftp_connect)) {
        include_once MAX_PATH . '/www/admin/lib-ftp.inc.php';
    }

        if ($ftpsock = @ftp_connect($store_ftpHost)) {
            if (@ftp_login($ftpsock, $store_ftpUsername, $store_ftpPassword)) {
                if (empty($store_ftpPath) || @ftp_chdir($ftpsock, $store_ftpPath)) {
                    // Can login okay
                    $config->setConfigChange('store', 'ftpHost',    $store_ftpHost);
                    $config->setConfigChange('store', 'ftpPath',     $store_ftpPath);
                    $config->setConfigChange('store', 'ftpUsername', $store_ftpUsername);
                    $config->setConfigChange('store', 'ftpPassword', $store_ftpPassword);
                } else {
                    $errormessage[1][] = $strTypeFTPErrorDir;
                }
            } else {
                $errormessage[1][] = $strTypeFTPErrorConnect;
            }
            @ftp_quit($ftpsock);
        } else {
            $errormessage[1][] = $strTypeFTPErrorHost;
        }
    }
    if (isset($file_click)) {
        $config->setConfigChange('file', 'click',            $file_click);
    }
    if (isset($file_conversionvars)) {
        $config->setConfigChange('file', 'conversionvars',   $file_conversionvars);
    }
    if (isset($file_content)) {
        $config->setConfigChange('file', 'content',          $file_content);
    }
    if (isset($file_conversion)) {
        $config->setConfigChange('file', 'conversion',       $file_conversion);
    }
    if (isset($file_conversionjs)) {
        $config->setConfigChange('file', 'conversionjs',     $file_conversionjs);
    }
    if (isset($file_frame)) {
        $config->setConfigChange('file', 'frame',            $file_frame);
    }
    if (isset($file_image)) {
        $config->setConfigChange('file', 'image',            $file_image);
    }
    if (isset($file_js)) {
        $config->setConfigChange('file', 'js',               $file_js);
    }
    if (isset($file_layer)) {
        $config->setConfigChange('file', 'layer',            $file_layer);
    }
    if (isset($file_log)) {
        $config->setConfigChange('file', 'log',              $file_log);
    }
    if (isset($file_popup)) {
        $config->setConfigChange('file', 'popup',            $file_popup);
    }
    if (isset($file_view)) {
        $config->setConfigChange('file', 'view',             $file_view);
    }
    if (isset($file_xmlrpc)) {
        $config->setConfigChange('file', 'xmlrpc',           $file_xmlrpc);
    }
    if (isset($file_local)) {
        $config->setConfigChange('file', 'local',            $file_local);
    }
    if (isset($file_frontcontroller)) {
        $config->setConfigChange('file', 'frontcontroller',  $file_frontcontroller);
    }
    if (isset($file_flash)) {
        $config->setConfigChange('file', 'flash',  $file_flash);
    }
    if (isset($delivery_cacheExpire)) {
        $config->setConfigChange('delivery', 'cacheExpire',  $delivery_cacheExpire);
    }
    $config->setConfigChange('delivery', 'acls',             isset($delivery_acls));
    $config->setConfigChange('delivery', 'obfuscate',        isset($delivery_obfuscate));
    $config->setConfigChange('delivery', 'execPhp',          isset($delivery_execPhp));
    if (isset($delivery_ctDelimiter)) {
        $config->setConfigChange('delivery', 'ctDelimiter',  $delivery_ctDelimiter);
    }
    $config->setConfigChange('p3p', 'policies',              isset($p3p_policies));
    if (isset($p3p_compactPolicy)) {
        $config->setConfigChange('p3p', 'compactPolicy',     $p3p_compactPolicy);
    }
    if (isset($p3p_policyLocation)) {
        $config->setConfigChange('p3p', 'policyLocation',    $p3p_policyLocation);
    }
    
    if (isset($origin_type)) {
        $config->setConfigChange('origin', 'type',    $origin_type);
    }
    if (isset($origin_host)) {
        $config->setConfigChange('origin', 'host',    $origin_host);
    }
    if (isset($origin_port)) {
        $config->setConfigChange('origin', 'port',    $origin_port);
    }
    if (isset($origin_script)) {
        $config->setConfigChange('origin', 'script',  $origin_script);
    }
    if (isset($origin_timeout)) {
        $config->setConfigChange('origin', 'timeout', $origin_timeout);
    }
    if (isset($origin_protocol)) {
        $config->setConfigChange('origin', 'protocol',$origin_protocol);
    }

    
    if (!count($errormessage)) {
        if (!$config->writeConfigChange()) {
            // Unable to write the config file out
            $errormessage[0][] = $strUnableToWriteConfig;
        } else {
            MAX_Admin_Redirect::redirect('settings-general.php');
        }
    }
}

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
phpAds_SettingsSelection("delivery");

$settings = array(
    array (
        'text'  => $strWebPath,
        'items' => array (
            array (
                'type'    => 'url', 
                'name'    => 'webpath_admin',
                'text'    => $strAdminUrlPrefix,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'urln', 
                'name'    => 'webpath_delivery',
                'text'    => $strDeliveryUrlPrefix,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'urls', 
                'name'    => 'webpath_deliverySSL',
                'text'    => $strDeliveryUrlPrefixSSL,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'urln', 
                'name'    => 'webpath_images',
                'text'    => $strImagesUrlPrefix,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'urls', 
                'name'    => 'webpath_imagesSSL',
                'text'    => $strImagesUrlPrefixSSL,
                'size'    => 35
            )
        )
    ),
    array (
    	'text' 	=> $strTypeWebSettings,
    	'items'	=> array (
    		array (
    			'type' 	  => 'select', 
    			'name' 	  => 'store_mode',
    			'text' 	  => $strTypeWebMode,
    			'items'   => array('local' => $strTypeWebModeLocal,
    			                   'ftp'   => $strTypeWebModeFtp)
    		),
    		array (
    			'type'    => 'break',
    			'size'	  => 'full'
    		),
    		array (
    			'type' 	  => 'text', 
    			'name' 	  => 'store_webDir',
    			'text' 	  => $strTypeWebDir,
    			'size'	  => 35,
    			'depends' => 'store_mode==0'
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
    		)
    	)
    ),
    array (
        'text'  => $strDeliveryFilenames,
        'items' => array (
            array (
                'type'    => 'text',
                'name'    => 'file_click',
                'text'    => $strDeliveryFilenamesAdClick,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_conversionvars',
                'text'    => $strDeliveryFilenamesAdConversionVars,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_content',
                'text'    => $strDeliveryFilenamesAdContent,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_conversion',
                'text'    => $strDeliveryFilenamesAdConversion,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_conversionjs',
                'text'    => $strDeliveryFilenamesAdConversionJS,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_frame',
                'text'    => $strDeliveryFilenamesAdFrame,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_image',
                'text'    => $strDeliveryFilenamesAdImage,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_js',
                'text'    => $strDeliveryFilenamesAdJS,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_layer',
                'text'    => $strDeliveryFilenamesAdLayer,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_log',
                'text'    => $strDeliveryFilenamesAdLog,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_popup',
                'text'    => $strDeliveryFilenamesAdPopup,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_view',
                'text'    => $strDeliveryFilenamesAdView,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_xmlrpc',
                'text'    => $strDeliveryFilenamesXMLRPC,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_local',
                'text'    => $strDeliveryFilenamesLocal,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_frontcontroller',
                'text'    => $strDeliveryFilenamesFrontController,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_flash',
                'text'    => $strDeliveryFilenamesFlash,
                'req'     => true
            )
        )
    ),
    array (
        'text'  => $strDeliveryCaching,
        'items' => array (
            array (
                'type'    => 'text',
                'name'    => 'delivery_cacheExpire',
                'text'    => $strDeliveryCacheLimit,
            )
        )
    ),
    array (
        'text'  => $strOrigin,
        'items' => array(
            array (
                'type'    => 'select',
                'name'    => 'origin_type',
                'text'    => $strOriginType,
                'items'   => array($strNone => $strNone, $strOriginTypeXMLRPC => $strOriginTypeXMLRPC),
            ),
            array (
                'type'    => 'break'
            ),            
            array(
                'type'    => 'text',
                'name'    => 'origin_host',
                'text'    => $strOriginHost,
                'depends' => 'origin_type>0',
            ),
            array (
                'type'    => 'break'
            ),
            array(
                'type'    => 'text',
                'name'    => 'origin_port',
                'text'    => $strOriginPort,
                'depends' => 'origin_type>0',
            ),
            array (
                'type'    => 'break'
            ),
            array(
                'type'    => 'text',
                'name'    => 'origin_script',
                'text'    => $strOriginScript,
                'depends' => 'origin_type>0',
            ),
            array (
                'type'    => 'break'
            ),
            array(
                'type'    => 'text',
                'name'    => 'origin_timeout',
                'text'    => $strOriginTimeout,
                'depends' => 'origin_type>0',
            ),
            array (
                'type'    => 'break'
            ),
            array(
                'type'    => 'select',
                'name'    => 'origin_protocol',
                'text'    => $strOriginProtocol,
                'items'   => array('http' => 'http', 'https' => 'https'),
                'depends' => 'origin_type>0',
            ),
            
        ),
    ),    
    array (
        'text'  => $strDeliveryBanner,
        'items' => array (
            array (
                'type'    => 'checkbox', 
                'name'    => 'delivery_acls',
                'text'    => $strDeliveryAcls
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'delivery_obfuscate',
                'text'    => $strDeliveryObfuscate
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'delivery_execPhp',
                'text'    => $strDeliveryExecPhp
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'delivery_ctDelimiter',
                'text'    => $strDeliveryCtDelimiter
            )
        )
    ),
    array (
    	'text' 	=> $strP3PSettings,
    	'items'	=> array (
    		array (
    			'type'    => 'checkbox',
    			'name'    => 'p3p_policies',
    			'text'	  => $strUseP3P
    		),
    		array (
    			'type'    => 'break'
    		),
    		array (
    			'type' 	  => 'text', 
    			'name' 	  => 'p3p_compactPolicy',
    			'text' 	  => $strP3PCompactPolicy,
    			'size'	  => 35,
    			'depends' => 'p3p_policies==true'
    		),
    		array (
    			'type'    => 'break'
    		),
    		array (
    			'type' 	  => 'text', 
    			'name' 	  => 'p3p_policyLocation',
    			'text' 	  => $strP3PPolicyLocation,
    			'size'	  => 35,
    			'depends' => 'p3p_policies==true',
    			'check'   => 'url'
    		)
    	)
    )
);

phpAds_ShowSettings($settings, $errormessage);
phpAds_PageFooter();

?>
