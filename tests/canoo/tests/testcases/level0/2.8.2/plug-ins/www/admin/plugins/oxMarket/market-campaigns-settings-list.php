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
require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/UI/CampaignsSettings.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);

$handler = new OX_oxMarket_UI_CampaignsSettings();
$template = $handler->handle();

if ($template) {
    $template->display();
}
