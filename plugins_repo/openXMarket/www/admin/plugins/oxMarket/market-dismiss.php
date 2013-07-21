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

$oMarketComponent->removeEarnMoreNotification(true);

?>
