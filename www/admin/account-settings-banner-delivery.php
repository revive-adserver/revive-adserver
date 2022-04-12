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

// Prepare an array for storing error messages
$aErrormessage = [];

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = [];
    // Banner Delivery Cache Settings
    $aElements += [
        'delivery_cacheExpire' => ['delivery' => 'cacheExpire'],
        'delivery_cacheStorePlugin' => ['delivery' => 'cacheStorePlugin']
    ];

    // Banner Delivery Settings
    $aElements += [
        'delivery_acls' => [
            'delivery' => 'acls',
            'bool' => true
        ],
        'delivery_aclsDirectSelection' => [
            'delivery' => 'aclsDirectSelection',
            'bool' => true
        ],
        'delivery_obfuscate' => [
            'delivery' => 'obfuscate',
            'bool' => true
        ],
        'delivery_clickUrlValidity' => ['delivery' => 'clickUrlValidity'],
        'defaultBanner_relAttribute' => ['defaultBanner' => 'relAttribute'],
        'defaultBanner_invalidZoneHtmlBanner' => ['defaultBanner' => 'invalidZoneHtmlBanner'],
        'defaultBanner_suspendedAccountHtmlBanner' => ['defaultBanner' => 'suspendedAccountHtmlBanner'],
        'defaultBanner_inactiveAccountHtmlBanner' => ['defaultBanner' => 'inactiveAccountHtmlBanner'],
    ];
    // Invocation Defaults
    $aElements += [
        'delivery_clicktracking' => ['delivery' => 'clicktracking']
    ];
    // Privacy Settings
    $aElements += [
        'privacy_disableViewerId' => [
            'privacy' => 'disableViewerId',
            'bool' => true
        ],
        'privacy_anonymiseIp' => [
            'privacy' => 'anonymiseIp',
            'bool' => true
        ],
    ];
    // P3P Privacy Policies
    $aElements += [
        'p3p_policies' => [
            'p3p' => 'policies',
            'bool' => true
        ],
        'p3p_compactPolicy' => ['p3p' => 'compactPolicy'],
        'p3p_policyLocation' => ['p3p' => 'policyLocation']
    ];
    // OpenX Server Access Paths
    $aElements += [
        'webpath_admin' => [
            'webpath' => 'admin',
            'preg_match' => '#/$#',
            'preg_replace' => ''
        ],
        'webpath_delivery' => [
            'webpath' => 'delivery',
            'preg_match' => '#/$#',
            'preg_replace' => ''
        ],
        'webpath_deliverySSL' => [
            'webpath' => 'deliverySSL',
            'preg_match' => '#/$#',
            'preg_replace' => ''
        ],
        'webpath_images' => [
            'webpath' => 'images',
            'preg_match' => '#/$#',
            'preg_replace' => ''
        ],
        'webpath_imagesSSL' => [
            'webpath' => 'imagesSSL',
            'preg_match' => '#/$#',
            'preg_replace' => ''
        ]
    ];
    // Delivery File Names
    $aElements += [
        'file_click' => ['file' => 'click'],
        'file_signedClick' => ['file' => 'signedClick'],
        'file_conversionvars' => ['file' => 'conversionvars'],
        'file_content' => ['file' => 'content'],
        'file_conversion' => ['file' => 'conversion'],
        'file_conversionjs' => ['file' => 'conversionjs'],
        'file_frame' => ['file' => 'frame'],
        'file_image' => ['file' => 'image'],
        'file_js' => ['file' => 'js'],
        'file_layer' => ['file' => 'layer'],
        'file_log' => ['file' => 'log'],
        'file_popup' => ['file' => 'popup'],
        'file_view' => ['file' => 'view'],
        'file_xmlrpc' => ['file' => 'xmlrpc'],
        'file_local' => ['file' => 'local'],
        'file_frontcontroller' => ['file' => 'frontcontroller'],
        'file_singlepagecall' => ['file' => 'singlepagecall'],
        'file_spcjs' => ['file' => 'spcjs'],
        'file_asyncjsjs' => ['file' => 'asyncjsjs'],
        'file_asyncjs' => ['file' => 'asyncjs'],
        'file_asyncspc' => ['file' => 'asyncspc'],
    ];
    // Test the suitability of the cache store type, if required
    MAX_commonRegisterGlobalsArray(['delivery_cacheStorePlugin']);
    if (isset($delivery_cacheStorePlugin)) {
        // Check for problems in selected delivery store plugin
        $oDeliveryCacheStore = &OX_Component::factoryByComponentIdentifier($delivery_cacheStorePlugin);
        $result = $oDeliveryCacheStore->getStatus();
        if ($result !== true) {
            $aErrormessage[1][] = $oTranslation->translate(
                'ErrorInCacheStorePlugin',
                [$oDeliveryCacheStore->getName()]
            );
            foreach ($result as $error) {
                $aErrormessage[1][] = " - " . $error;
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

// This page depends on deliveryCacheStore plugins, so use the plugin
// information from earlier to generate the elements for the plugins
// which is required in the next section
$aCacheStoresSelect = [];
foreach ($aDeliveryCacheStores as $pluginKey => $oCacheStore) {
    $aCacheStoresSelect[$oCacheStore->getComponentIdentifier()] = $oCacheStore->getName();
}

$aDeliveryCacheSettings = [
    [
            'type' => 'text',
            'name' => 'delivery_cacheExpire',
            'text' => $strDeliveryCacheLimit,
            'check' => 'wholeNumber'
        ],
    [
            'type' => 'break',
            'visible' => !empty($aCacheStoresSelect)
        ],
    [
            'type' => 'select',
            'name' => 'delivery_cacheStorePlugin',
            'text' => $strDeliveryCacheStore,
            'items' => $aCacheStoresSelect,
            'visible' => !empty($aCacheStoresSelect)
        ]
];

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = [
    [
        'text' => $strDeliveryCaching,
        'items' => $aDeliveryCacheSettings
    ],
    [
        'text' => $strBannerDelivery,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'delivery_acls',
                'text' => $strDeliveryAcls
            ],
            [
                'type' => 'checkbox',
                'name' => 'delivery_aclsDirectSelection',
                'text' => $strDeliveryAclsDirectSelection
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'delivery_obfuscate',
                'text' => $strDeliveryObfuscate
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'delivery_clickUrlValidity',
                'text' => $strDeliveryClickUrlValidity,
                'check' => 'wholeNumber',
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'delivery_relAttribute',
                'text' => $strDeliveryRelAttribute,
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'textarea',
                'name' => 'defaultBanner_invalidZoneHtmlBanner',
                'text' => $strGlobalDefaultBannerInvalidZone,
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'textarea',
                'name' => 'defaultBanner_suspendedAccountHtmlBanner',
                'text' => $strGlobalDefaultBannerSuspendedAccount,
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'textarea',
                'name' => 'defaultBanner_inactiveAccountHtmlBanner',
                'text' => $strGlobalDefaultBannerInactiveAccount,
            ],
        ]
    ],
    [
        'text' => $strPrivacySettings,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'privacy_disableViewerId',
                'text' => $strDisableViewerId
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'checkbox',
                'name' => 'privacy_anonymiseIp',
                'text' => $strAnonymiseIp,
            ],
        ]
    ],
    [
        'text' => $strP3PSettings,
        'items' => [
            [
                'type' => 'checkbox',
                'name' => 'p3p_policies',
                'text' => $strUseP3P
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'p3p_compactPolicy',
                'text' => $strP3PCompactPolicy,
                'size' => 35,
                'depends' => 'p3p_policies==true'
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'p3p_policyLocation',
                'text' => $strP3PPolicyLocation,
                'size' => 35,
                'depends' => 'p3p_policies==true',
                'check' => 'url'
            ]
        ]
    ],
    [
        'text' => $strWebPath,
        'items' => [
            [
                'type' => 'url',
                'name' => 'webpath_admin',
                'text' => $strAdminUrlPrefix,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'urln',
                'name' => 'webpath_delivery',
                'text' => $strDeliveryUrlPrefix,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'urls',
                'name' => 'webpath_deliverySSL',
                'text' => $strDeliveryUrlPrefixSSL,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'urln',
                'name' => 'webpath_images',
                'text' => $strImagesUrlPrefix,
                'size' => 35
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'urls',
                'name' => 'webpath_imagesSSL',
                'text' => $strImagesUrlPrefixSSL,
                'size' => 35
            ]
        ]
    ],
    [
        'text' => $strDeliveryFilenames,
        'items' => [
            [
                'type' => 'text',
                'name' => 'file_click',
                'text' => $strDeliveryFilenamesAdClick,
                'req' => true
            ],
            [
                'type' => 'break'
            ], [
                'type' => 'text',
                'name' => 'file_signedClick',
                'text' => $strDeliveryFilenamesSignedAdClick,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_conversionvars',
                'text' => $strDeliveryFilenamesAdConversionVars,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_content',
                'text' => $strDeliveryFilenamesAdContent,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_conversion',
                'text' => $strDeliveryFilenamesAdConversion,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_conversionjs',
                'text' => $strDeliveryFilenamesAdConversionJS,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_frame',
                'text' => $strDeliveryFilenamesAdFrame,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_image',
                'text' => $strDeliveryFilenamesAdImage,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_js',
                'text' => $strDeliveryFilenamesAdJS,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_layer',
                'text' => $strDeliveryFilenamesAdLayer,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_log',
                'text' => $strDeliveryFilenamesAdLog,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_popup',
                'text' => $strDeliveryFilenamesAdPopup,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_view',
                'text' => $strDeliveryFilenamesAdView,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_xmlrpc',
                'text' => $strDeliveryFilenamesXMLRPC,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_local',
                'text' => $strDeliveryFilenamesLocal,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_frontcontroller',
                'text' => $strDeliveryFilenamesFrontController,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_singlepagecall',
                'text' => $strDeliveryFilenamesSinglePageCall,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_spcjs',
                'text' => $strDeliveryFilenamesSinglePageCallJS,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_asyncjsjs',
                'text' => $strDeliveryFilenamesAsyncJS,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_asyncjs',
                'text' => $strDeliveryFilenamesAsyncPHP,
                'req' => true
            ],
            [
                'type' => 'break'
            ],
            [
                'type' => 'text',
                'name' => 'file_asyncspc',
                'text' => $strDeliveryFilenamesAsyncSPC,
                'req' => true
            ],
        ]
    ]
];
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();
