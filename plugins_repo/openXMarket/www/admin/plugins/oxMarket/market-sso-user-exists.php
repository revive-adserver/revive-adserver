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

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);


/*-------------------------------------------------------*/
/* Display page                                          */
/*-------------------------------------------------------*/
$oMarketComponent = OX_Component::factory('admin', 'oxMarket');
//check if you can see this page
$oMarketComponent->checkRegistered(false);

$userName = $_REQUEST['userName'];

try {

    if ($oMarketComponent->getPublisherConsoleApiClient()->isSsoUserNameAvailable($userName)) {
        echo "available";
    }
    else {
        echo "taken";
    }
}
catch (Exception $exc) {
    header("HTTP/1.0 500 Server Error (Code: ".$exc->getCode().")");
    OA::debug('Error during retrieving custom content: ('.$exc->getCode().')'.$exc->getMessage());
}
 