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
require_once MAX_PATH .'/lib/OX/Admin/Redirect.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/

    $oMarketComponent = OX_Component::factory('admin', 'oxMarket');
    //check if you can see this page (pluigin should be inactive in this case)
    $oMarketComponent->checkRegistered();
    $oMarketComponent->checkActive(false);

    //header
    phpAds_PageHeader("openx-market",'','../../');

    //get template and display form
    $oTpl = new OA_Plugin_Template('market-inactive.html','openXMarket');

    $aDeactivationStatus = $oMarketComponent->getInactiveStatus();
    $oTpl->assign('deactivationStatus', $aDeactivationStatus['code']);
    $oTpl->assign('deactivationStatusMessage', $aDeactivationStatus['message']);

    $oTpl->assign('publisherSupportEmail', $oMarketComponent->getConfigValue('publisherSupportEmail'));

    $oTpl->display();

    //footer
    phpAds_PageFooter();

?>
