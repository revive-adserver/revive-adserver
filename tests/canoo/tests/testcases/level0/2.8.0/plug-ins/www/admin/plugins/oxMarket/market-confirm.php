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
    //check if you can see this page
    $oMarketComponent->checkActive();
    $oMarketComponent->updateSSLMessage();


    //header
    $oUI = OA_Admin_UI::getInstance();
    $oUI->registerStylesheetFile(MAX::constructURL(MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css'));
    phpAds_PageHeader("openx-market",'','../../');

    $aContentKeys = $oMarketComponent->retrieveCustomContent('market-confirm');
    if (!$aContentKeys) {
        $aContentKeys = array();
    }
    $trackerFrame = isset($aContentKeys['tracker-iframe'])
        ? $aContentKeys['tracker-iframe']
        : '';

    $content = $aContentKeys['content'];

    //get template and display form
    $oTpl = new OA_Plugin_Template('market-confirm.html','openXMarket');
    $oTpl->assign('content', $content);
    $oTpl->assign('trackerFrame', $trackerFrame);

    $oTpl->display();

    //footer
    phpAds_PageFooter();
?>
