<?php
// xulApplication.php demonstrates a XUL application with xajax
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

header("Content-Type: application/vnd.mozilla.xul+xml");
?>
<?xml version="1.0" encoding="utf-8"?>
<?xml-stylesheet href="chrome://global/skin/" type="text/css"?>
<window id="example-window" title="Exemple 2.2.1"
        xmlns:html="http://www.w3.org/1999/xhtml"
        xmlns="http://www.mozilla.org/keymaster/gatekeeper/there.is.only.xul">
    <script type="application/x-javascript">
		var xajaxRequestUri="xulServer.php";
		var xajaxDebug=false;
		var xajaxStatusMessages=false;
		var xajaxDefinedGet=0;
		var xajaxDefinedPost=1;
	</script>
	<script type="application/x-javascript" src="../../xajax_js/xajax.js"></script>
    <button id="testButton" oncommand="xajax.call('test',[]);" label="Test" />
</window>