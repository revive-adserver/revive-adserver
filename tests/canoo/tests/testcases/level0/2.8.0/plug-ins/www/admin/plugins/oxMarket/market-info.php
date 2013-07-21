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

require_once 'market-common.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

    $oMarketComponent = OX_Component::factory('admin', 'oxMarket');
    if (!$oMarketComponent->isSplashAlreadyShown()) {
        $oMarketComponent->setSplashAlreadyShown();
    }

    $pageUrl = 'http'.((isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) ? 's' : '').'://';
    $pageUrl .= OX_getHostNameWithPort().$_SERVER['REQUEST_URI'];

    //header
    phpAds_PageHeader("openx-market",'','../../');

    $aContentKeys = $oMarketComponent->retrieveCustomContent('market-info');
    if (!$aContentKeys) {
        $aContentKeys = array();
    }
    $content = $aContentKeys['content'];
    $iframeHeight = isset($aContentKeys['iframe-height'])
        ? $aContentKeys['iframe-height']
        : 260;
    $submitLabel = isset($aContentKeys['submit-field-label'])
        ? $aContentKeys['submit-field-label']
        : 'Get Started';
    $submitLabelRegistered = isset($aContentKeys['submit-field-label'])
        ? $aContentKeys['submit-field-label-registered']
        : 'Continue';
    $trackerFrame = isset($aContentKeys['tracker-iframe'])
        ? $aContentKeys['tracker-iframe']
        : '';

    //get template and display form
    $oTpl = new OA_Plugin_Template('market-info.html','openXMarket');
    $oTpl->assign('welcomeURL', $oMarketComponent->getConfigValue('marketWelcomeUrl'));
    $oTpl->assign('pubconsoleHost', $oMarketComponent->getConfigValue('marketHost'));
    $oTpl->assign('isRegistered', $oMarketComponent->isRegistered());
    $oTpl->assign('pageUrl', urlencode($pageUrl));
    $oTpl->assign('submitLabel', $submitLabel);
    $oTpl->assign('submitLabelRegistered', $submitLabelRegistered);
    $oTpl->assign('iframeHeight', $iframeHeight);
    $oTpl->assign('trackerFrame', $trackerFrame);
    $oTpl->assign('content', $content);

    $oTpl->display();

    //footer
    phpAds_PageFooter();
?>
