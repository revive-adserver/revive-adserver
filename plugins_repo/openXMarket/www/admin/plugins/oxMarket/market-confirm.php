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


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

//check if you can see this page
$oMarketComponent->checkActive();
$oMarketComponent->updateSSLMessage();


//header
$oUI = OA_Admin_UI::getInstance();
$oUI->registerStylesheetFile(MAX::constructURL(
    MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css?v=' . htmlspecialchars($oMarketComponent->getPluginVersion())));
phpAds_PageHeader("openx-market",'','../../');

//check the type of the signup (exisitng OpenX account or new account)
phpAds_registerGlobalUnslashed('m');
if ($m == 'e') {
    $accountType = 'existing-sso';
}
else if ($m == 'n') {
    $accountType = 'new-sso';
}
else {
    $accountType = 'unspecified'; //for submissions with malformed m values (eg. modified by user)
}

$aContentKeys = $oMarketComponent->retrieveCustomContent('market-confirm');
if (!$aContentKeys) {
    $aContentKeys = array();
}
$trackerFrame = isset($aContentKeys['tracker-iframe'])
    ? str_replace('$ACCOUNT', $accountType, $aContentKeys['tracker-iframe'])
    : '';

$content = $aContentKeys['content']; 

//get template and display form
$oTpl = new OA_Plugin_Template('market-confirm.html','openXMarket');
$oTpl->assign('content', $content);
$oTpl->assign('trackerFrame', $trackerFrame);
$oTpl->assign('pluginVersion', $oMarketComponent->getPluginVersion());

$oTpl->display();

//footer
phpAds_PageFooter();
?>
