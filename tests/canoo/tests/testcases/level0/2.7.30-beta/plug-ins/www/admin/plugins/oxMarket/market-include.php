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

phpAds_registerGlobalUnslashed('p_url');

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

    $oMarketComponent = OX_Component::factory('admin', 'oxMarket');
    //check if you can see this page
    $oMarketComponent->checkActive();


    //retrieve menu from
    $pubconsolePageName = $oMarketComponent->createMenuForPubconsolePage($p_url);

    //header
    $pageId = "openx-market";
    if (!empty($pubconsolePageName)) {
        $oMenu = OA_Admin_Menu::singleton();
        //update page title
        $oCurrentSection = $oMenu->get($pageId);
        phpAds_PageHeader($pageId, new OA_Admin_UI_Model_PageHeaderModel($oCurrentSection->getName().': '.$pubconsolePageName, "iconMarketLarge"), '../../');
    }
    else {
        phpAds_PageHeader($pageId, null,'../../');
    }

    $pageUrl = 'http'.((isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) ? 's' : '').'://';
    $pageUrl .= getHostNameWithPort().$_SERVER['REQUEST_URI'];

    //get template and display form
    $oTpl = new OA_Plugin_Template('market-include.html','openXMarket');
    $oTpl->assign('pubconsoleHost', $oMarketComponent->getConfigValue('marketHost'));
    $oTpl->assign('pubconsoleURL', $oMarketComponent->getConfigValue('marketHost'));
    $oTpl->assign('pubconsoleAccountId', $oMarketComponent->getAccountId());
    $oTpl->assign('pubconsoleAccountIdParamName', $oMarketComponent->getConfigValue('marketAccountIdParamName'));
    $oTpl->assign('pubconsolePageId', htmlspecialchars($p_url));
    $oTpl->assign('pageUrl', urlencode($pageUrl));

    $oTpl->display();

    //footer
    phpAds_PageFooter();

?>
