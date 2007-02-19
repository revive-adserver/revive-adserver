<?php
require_once("../xajax.inc.php");

function showOutput()
{
	$testResponse = new xajaxResponse();
	$testResponse->addAlert("Hello");
//	$testResponseOutput = htmlspecialchars($testResponse->getXML());
	
	$testResponse2 = new xajaxResponse();
	$testResponse2->loadXML($testResponse->getXML());
	$testResponse2->addReplace("this", "is", "a", "replacement");
	$testResponseOutput = htmlspecialchars($testResponse2->getXML());	
	
	$objResponse = new xajaxResponse();
	$objResponse->addAssign("submittedDiv", "innerHTML", $testResponseOutput);
	return $objResponse;
}
$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("showOutput");
$xajax->processRequests();
$xajax->autoCompressJavascript("../xajax_js/xajax.js");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>xajaxResponse Test | xajax Tests</title>
<?php $xajax->printJavascript("../") ?>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>xajaxResponse Test</h1>

<form id="testForm1" onsubmit="return false;">
<p><input type="submit" value="Show Response XML" onclick="xajax_showOutput(); return false;" /></p>
</form>

<div id="submittedDiv"></div>

</body>
</html>