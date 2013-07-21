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
    MAX_URL_ADMIN, 'plugins/oxMarket/css/ox.market.css.php?v=' . htmlspecialchars($oMarketComponent->getPluginVersion()) . '&b=' . $oMarketComponent->aBranding['key']));
phpAds_PageHeader("market",'','../../');

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
$oTpl->assign('aBranding', $oMarketComponent->aBranding);

$oTpl->display();

//footer
phpAds_PageFooter();
?>
