<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
$Id: market-preferences-website.php 31004 2009-01-16 10:42:22Z andrew.hill $
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
        MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css?v=' . htmlspecialchars($oMarketComponent->getPluginVersion())));
        
    
    phpAds_PageHeader("market-website-qualitytool",'','../../');
//    phpAds_PageHeader($pageId, new OA_Admin_UI_Model_PageHeaderModel($oCurrentSection->getName().': '.$pubconsolePageName, "iconMarketLarge"), '../../');
    
    $oTpl    = new OA_Plugin_Template('market-quality-tool.html','openXMarket');

    $oTpl->assign('affiliateId', $affiliateid);
    
    $pageUrl = 'http'.((isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) ? 's' : '').'://';
    $pageUrl .= OX_getHostNameWithPort().$_SERVER['REQUEST_URI'];
    $oTpl->assign('pageUrl', urlencode($pageUrl));
    $oTpl->assign('pubconsoleHost', $oMarketComponent->getConfigValue('marketHost'));
    $oTpl->assign('pubconsolePageId', "publisher/ad-quality");
    $oTpl->assign('pubconsoleAccountId', $oMarketComponent->getAccountId());
    $oTpl->assign('pubconsoleAccountIdParamName', $oMarketComponent->getConfigValue('marketAccountIdParamName'));
    $oTpl->assign('websiteMarketId', $oMarketComponent->getWebsiteId($affiliateid, false));
    
    $oTpl->display();

    phpAds_PageFooter();
}

?>