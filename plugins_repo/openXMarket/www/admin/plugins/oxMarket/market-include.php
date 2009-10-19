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
$Id$
*/

require_once 'market-common.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/Form.php';
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';

// Security check
$oMarketComponent = OX_Component::factory('admin', 'oxMarket');
$oMarketComponent->enforceProperAccountAccess();

phpAds_registerGlobalUnslashed('p_url');

/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

//check if you can see this page
$oMarketComponent->checkActive();
$oMarketComponent->updateSSLMessage();


//retrieve menu from
$pubconsolePageName = $oMarketComponent->createMenuForPubconsolePage($p_url);

//header
$pageId = "openx-market";
$oUI = OA_Admin_UI::getInstance();
$oUI->registerStylesheetFile(MAX::constructURL(
    MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css?v=' . htmlspecialchars($oMarketComponent->getPluginVersion())));

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
$pageUrl .= OX_getHostNameWithPort().$_SERVER['REQUEST_URI'];

//get template and display form
$oTpl = new OA_Plugin_Template('market-include.html','openXMarket');
$oTpl->assign('pubconsoleHost', $oMarketComponent->getConfigValue('marketHost'));
$oTpl->assign('pubconsoleAccountId', $oMarketComponent->getPublisherConsoleApiClient()->getPcAccountId());
$oTpl->assign('pubconsoleAccountIdParamName', $oMarketComponent->getConfigValue('marketAccountIdParamName'));
$oTpl->assign('pubconsolePageId', htmlspecialchars($p_url));
$oTpl->assign('pageUrl', urlencode($pageUrl));

$oTpl->display();

//footer
phpAds_PageFooter();

?>
