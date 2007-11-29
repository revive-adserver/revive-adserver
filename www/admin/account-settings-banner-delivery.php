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
require_once MAX_PATH . '/lib/max/Plugin.php';

$oOptions = new OA_Admin_Option('settings');

// Security check
phpAds_checkAccess(phpAds_Admin);

$aErrormessage = array();
$redirectUploadFile = false;

$aInvocationTags = MAX_Plugin::getPlugins('invocationTags');
$aInvocationSettings = MAX_Plugin::callOnPlugins($aInvocationTags, 'getPreferenceCode');
foreach($aInvocationSettings as $invocationSettingKey => $invocationSettingVal) {
    if(empty($invocationSettingVal)) {
        unset($aInvocationSettings[$invocationSettingKey]);
    }
}

if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobal(
        'delivery_cacheExpire',
        'webpath_admin', 'webpath_delivery', 'webpath_deliverySSL',
        'webpath_images', 'webpath_imagesSSL',
        'file_click', 'file_conversionvars', 'file_content', 'file_conversion',
        'file_conversionjs', 'file_frame', 'file_image', 'file_js', 'file_layer',
        'file_log', 'file_popup', 'file_view', 'file_xmlrpc', 'file_local', 'file_frontcontroller',
        'file_flash',
        'delivery_acls', 'delivery_obfuscate', 'delivery_execPhp',
        'origin_type','origin_host','origin_port','origin_script','origin_timeout','origin_protocol',
        'delivery_ctDelimiter',
        'p3p_policies', 'p3p_compactPolicy', 'p3p_policyLocation', 'gui_invocation_3rdparty_default'
    );

    // Set up the preferences object
    $oPreferences = new OA_Admin_Preferences();
    foreach($aInvocationSettings as $invocationCode) {
    	$oPreferences->setPrefChange($invocationCode, isset($_POST[$invocationCode]));
    }

    $oPreferences->setPrefChange('gui_invocation_3rdparty_default', $_POST['gui_invocation_3rdparty_default']);

    // Set up the settings configuration file
    $oConfig = new OA_Admin_Settings();
    if (isset($delivery_cacheExpire)) {
        $oConfig->setConfigChange('delivery', 'cacheExpire',  $delivery_cacheExpire);
    }
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
                    MAX_Admin_Redirect::redirect('account-settings-banner-logging.php');
                }
            }
        }
    }

}

phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
$oOptions->selection("banner-delivery");

include_once MAX_PATH . '/lib/max/Plugin/Translation.php';

$aInvocations =
    array(
        'text'  => $GLOBALS['strAllowedInvocationTypes'],
        'items' => array(),
    );

foreach($aInvocationSettings as $pluginKey => $invocationCode) {
    if ($aInvocationTags[$pluginKey] === false) {
        continue;
    }
    $aInvocations['items'][] = array(
        'type' => 'checkbox',
        'name' => $invocationCode,
        'text' => $aInvocationTags[$pluginKey]->getAllowInvocationTypeForSettings(),
    );
}

// sort invocationSettings by settings text
function MAX_sortSetting($a, $b)
{
   return strcmp($a['text'], $b['text']);
}
usort($aInvocations[0]['items'], 'MAX_sortSetting');



/////
include_once MAX_PATH . '/lib/max/Plugin/Translation.php';

$aOutputAdServers = &MAX_Plugin::getPlugins('3rdPartyServers');
foreach ($aOutputAdServers as $pluginKey => $outputAdServer) {
    if ($outputAdServer->hasOutputMacros) {
        $availableOutputAdServers[$pluginKey] = $outputAdServer;
        $availableOutputAdServerNames[$pluginKey] = $outputAdServer->getName();
    }
}
asort($availableOutputAdServerNames);
$availableOutputAdServerNames = $availableOutputAdServerNames = array(
    0 => $GLOBALS['strNo'],
    'generic' => $GLOBALS['strGenericOutputAdServer']
) + $availableOutputAdServerNames;

/////




$aSettings = array(
    $aInvocations
    ,
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
        'text'  => $strBannerDelivery,
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
      'text' 	=> $strIncovationDefaults,
      'items'	=> array (
        array(
          'type'  => 'select',
          'name'  => 'gui_invocation_3rdparty_default',
          'text'  => $strEnable3rdPartyTrackingByDefault,
          'items' => $availableOutputAdServerNames

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
    ),
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
    )
);

$oOptions->show($aSettings, $aErrormessage);
phpAds_PageFooter();

?>