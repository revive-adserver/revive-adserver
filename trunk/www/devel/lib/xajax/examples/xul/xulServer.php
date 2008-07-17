<?php
// xulServer.php demonstrates a XUL application with xajax
// XUL will only work in Mozilla based browsers like Firefox
// using xajax version 0.2
// http://xajaxproject.org

require_once("../../xajax.inc.php");

function test() {
        $objResponse = new xajaxResponse();
        $objResponse->addAlert("hallo");
        $objResponse->addAssign('testButton','label','Success!');
        return $objResponse->getXML();
}

$xajax = new xajax();
$xajax->registerFunction("test");
$xajax->processRequests();
?>