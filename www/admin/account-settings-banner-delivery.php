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
require_once MAX_PATH . '/lib/OX/Plugin/Component.php';
require_once MAX_PATH . '/www/admin/config.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Load translation class
$oTranslation = new OX_Translation();

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');
$prefSection = "banner-delivery";

// This page depends on deliveryCacheStore plugins, so get the required
// information about all such plugins installed in this installation
$aDeliveryCacheStores = OX_Component::getComponents('deliveryCacheStore', null, false);

// This page depends on 3rdPartyServers plugins, so get the required
// information about all such plugins installed in this installation]
$a3rdPartyServers = &OX_Component::getComponents('3rdPartyServers');

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = array();
    // Banner Delivery Cache Settings
    $aElements += array(
        'delivery_cacheExpire' => array('delivery' => 'cacheExpire'),
        'delivery_cacheStorePlugin' => array('delivery' => 'cacheStorePlugin')
    );

    // Banner Delivery Settings
    $aElements += array(
        'delivery_acls' => array(
            'delivery' => 'acls',
            'bool'     => true
        ),
        'delivery_aclsDirectSelection' => array(
            'delivery' => 'aclsDirectSelection',
            'bool'     => true
        ),
        'delivery_obfuscate' => array(
            'delivery' => 'obfuscate',
            'bool'     => true
        ),
        'delivery_execPhp' => array(
            'delivery' => 'execPhp',
            'bool'     => true
        ),
        'delivery_ctDelimiter' => array('delivery' => 'ctDelimiter'),
        'defaultBanner_imageUrl' => array('defaultBanner' => 'imageUrl')
    );
    // Invocation Defaults
    $aElements += array(
        'delivery_clicktracking' => array('delivery' => 'clicktracking')
    );
    // P3P Privacy Policies
    $aElements += array(
        'p3p_policies' => array(
            'p3p'  => 'policies',
            'bool' => true
        ),
        'p3p_compactPolicy'  => array('p3p' => 'compactPolicy'),
        'p3p_policyLocation' => array('p3p' => 'policyLocation')
    );
    // OpenX Server Access Paths
    $aElements += array(
        'webpath_admin' => array(
            'webpath'      => 'admin',
            'preg_match'   => '#/$#',
            'preg_replace' => ''
        ),
        'webpath_delivery' => array(
            'webpath'      => 'delivery',
            'preg_match'   => '#/$#',
            'preg_replace' => ''
        ),
        'webpath_deliverySSL' => array(
            'webpath'      => 'deliverySSL',
            'preg_match'   => '#/$#',
            'preg_replace' => ''
        ),
        'webpath_images' => array(
            'webpath'      => 'images',
            'preg_match'   => '#/$#',
            'preg_replace' => ''
        ),
        'webpath_imagesSSL' => array(
            'webpath'      => 'imagesSSL',
            'preg_match'   => '#/$#',
            'preg_replace' => ''
        )
    );
    // Delivery File Names
    $aElements += array(
        'file_click'           => array('file' => 'click'),
        'file_conversionvars'  => array('file' => 'conversionvars'),
        'file_content'         => array('file' => 'content'),
        'file_conversion'      => array('file' => 'conversion'),
        'file_conversionjs'    => array('file' => 'conversionjs'),
        'file_frame'           => array('file' => 'frame'),
        'file_image'           => array('file' => 'image'),
        'file_js'              => array('file' => 'js'),
        'file_layer'           => array('file' => 'layer'),
        'file_log'             => array('file' => 'log'),
        'file_popup'           => array('file' => 'popup'),
        'file_view'            => array('file' => 'view'),
        'file_xmlrpc'          => array('file' => 'xmlrpc'),
        'file_local'           => array('file' => 'local'),
        'file_frontcontroller' => array('file' => 'frontcontroller'),
        'file_flash'           => array('file' => 'flash'),
        'file_singlepagecall'  => array('file' => 'singlepagecall'),
        'file_spcjs'           => array('file' => 'spcjs')
    );
    // Test the suitability of the cache store type, if required
    MAX_commonRegisterGlobalsArray(array('delivery_cacheStorePlugin'));
    if (isset($delivery_cacheStorePlugin)) {
        // Check for problems in selected delivery store plugin
        $oDeliveryCacheStore = &OX_Component::factoryByComponentIdentifier($delivery_cacheStorePlugin);
        $result = $oDeliveryCacheStore->getStatus();
        if ($result !== true) {
            $aErrormessage[1][] = $oTranslation->translate(
                'ErrorInCacheStorePlugin',
                array($oDeliveryCacheStore->getName())
            );
            foreach ($result as $error) {
                $aErrormessage[1][] = " - ".$error;
            }
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
            $translation = new OX_Translation ();
            $translated_message = $translation->translate($GLOBALS['strXSettingsHaveBeenUpdated'],
                array(htmlspecialchars($title)));
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

// This page depends on deliveryCacheStore plugins, so use the plugin
// information from earlier to generate the elements for the plugins
// which is required in the next section

$aCacheStoresSelect = array();
foreach ($aDeliveryCacheStores as $pluginKey => $oCacheStore) {
    $aCacheStoresSelect[$oCacheStore->getComponentIdentifier()] = $oCacheStore->getName();
}

$aDeliveryCacheSettings = array (
    array (
            'type'    => 'text',
            'name'    => 'delivery_cacheExpire',
            'text'    => $strDeliveryCacheLimit,
            'check'   => 'wholeNumber'
        ),
    array (
            'type'    => 'break'
        ),
    array (
            'type'  => 'select',
            'name'  => 'delivery_cacheStorePlugin',
            'text'  => $strDeliveryCacheStore,
            'items' => $aCacheStoresSelect
        )
);

// This page depends on 3rdPartyServers plugins, so use the plugin
// information from earlier to generate the elements for the plugins
// which is required in the next section
$availableOutputAdServerNames = array();
foreach ($a3rdPartyServers as $pluginKey => $outputAdServer) {
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

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array(
    array (
        'text'  => $strDeliveryCaching,
        'items' => $aDeliveryCacheSettings
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
                'type'    => 'checkbox',
                'name'    => 'delivery_aclsDirectSelection',
                'text'    => $strDeliveryAclsDirectSelection
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
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'defaultBanner_imageUrl',
                'text'    => $strGlobalDefaultBannerUrl,
                'check'   => 'url'
            )
        )
    ),
    array (
        'text' 	=> $strInvocationDefaults,
        'items'	=> array (
            array(
                'type'    => 'select',
                'name'    => 'delivery_clicktracking',
                'text'    => $strEnable3rdPartyTrackingByDefault,
                'items'   => $availableOutputAdServerNames
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
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_singlepagecall',
                'text'    => $strDeliveryFilenamesSinglePageCall,
                'req'     => true
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'file_spcjs',
                'text'    => $strDeliveryFilenamesSinglePageCallJS,
                'req'     => true
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>
