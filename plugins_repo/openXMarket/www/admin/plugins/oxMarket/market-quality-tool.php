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
phpAds_registerGlobalUnslashed(
    'affiliateid',
    'types',
    'attributes',
    'categories',
    'update_website_mkt_preferences'
);

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);


$oMarketComponent = OX_Component::factory('admin', 'oxMarket');
//check if you can see this page
$oMarketComponent->checkActive();

displayPage($affiliateid, $oMarketComponent);



function displayPage($affiliateid, &$oMarketComponent)
{
    $oUI = OA_Admin_UI::getInstance();
    $oUI->registerStylesheetFile(MAX::constructURL(
        MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css.php?v=' . htmlspecialchars($oMarketComponent->getPluginVersion()) . '&b=' . $oMarketComponent->aBranding['key']));
        
    
    phpAds_PageHeader("market-website-qualitytool",'','../../');
//    phpAds_PageHeader($pageId, new OA_Admin_UI_Model_PageHeaderModel($oCurrentSection->getName().': '.$pubconsolePageName, "iconMarketLarge"), '../../');
    
    $oTpl    = new OA_Plugin_Template('market-quality-tool.html','openXMarket');

    $oTpl->assign('affiliateId', $affiliateid);
    
    $pageUrl = 'http'.((isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) ? 's' : '').'://';
    $pageUrl .= OX_getHostNameWithPort().$_SERVER['REQUEST_URI'];
    $oTpl->assign('pageUrl', urlencode($pageUrl));
    $oTpl->assign('pubconsoleHost', $oMarketComponent->getConfigValue('marketHost'));
    $oTpl->assign('pubconsolePageId', "publisher/ad-quality");
    $oTpl->assign('pubconsoleAccountId', $oMarketComponent->getPublisherConsoleApiClient()->getPcAccountId());
    $oTpl->assign('pubconsoleAccountIdParamName', $oMarketComponent->getConfigValue('marketAccountIdParamName'));
    $oTpl->assign('websiteMarketId', $oMarketComponent->getWebsiteManager()->getWebsiteId($affiliateid, false));
    
    $oTpl->display();

    phpAds_PageFooter();
}

?>