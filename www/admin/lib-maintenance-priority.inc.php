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

function OA_runMPE()
{
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("run-mpe", "innerHTML", "<img src='run-mpe.php' />");
    return $objResponse;
}

require_once MAX_PATH .'/lib/Max.php';
require_once MAX_PATH .'/lib/xajax/xajax.inc.php';
$xajax = new xajax(MAX::constructURL(MAX_URL_ADMIN,'run-mpe-xajax.php'));
$xajax->registerFunction("OA_runMPE");
$xajax->processRequests();

?>
