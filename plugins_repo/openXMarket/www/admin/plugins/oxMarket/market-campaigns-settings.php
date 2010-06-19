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





        
        

