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
require_once MAX_PATH .'/lib/OA/Admin/UI/component/rule/DecimalPlaces.php';
require_once MAX_PATH .'/lib/pear/HTML/QuickForm/Rule/Regex.php';
require_once MAX_PATH .'/lib/OA/Admin/UI/component/rule/Max.php';
require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/UI/CampaignsSettings.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);

$handler = new OX_oxMarket_UI_CampaignsSettings();
$template = $handler->handle();

if ($template) {
    // Header
    $oUI = OA_Admin_UI::getInstance();
    $oUI->registerStylesheetFile(MAX::constructURL(
        MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css.php?v=' . htmlspecialchars($handler->getPluginVersion()) . '&b=' . $oMarketComponent->aBranding['key']));
    
    $oMenu = OA_Admin_Menu::singleton();
    $oCurrentSection = $oMenu->get("market-campaigns-settings");
    phpAds_PageHeader("market-campaigns-settings", new OA_Admin_UI_Model_PageHeaderModel(
        $oCurrentSection->getName(), "iconMarketLarge"), '../../', true, true, true, false);
    
    $oMarketComponent = OX_Component::factory('admin', 'oxMarket');
    $template->assign('aBranding', $oMarketComponent->aBranding);
    
    // Content
    $template->display();
    
    //footer
    phpAds_PageFooter();
}





        
        

