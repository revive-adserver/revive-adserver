<?php
require_once("../xajax.inc.php");

function test2ndFunction($formData, $objResponse)
{
	$objResponse->addAlert("formData: " . print_r($formData, true));
	$objResponse->addAssign("submittedDiv", "innerHTML", nl2br(print_r($formData, true)));
	return $objResponse->getXML();
}

function myCatchAllFunction($funcName, $args)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert("This is from the catch all function");
//	return $objResponse;
	return test2ndFunction($args[0], $objResponse);
}

function testForm($formData)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert("This is from the regular function");
	return test2ndFunction($formData, $objResponse);
}
$xajax = new xajax();
$xajax->registerCatchAllFunction("myCatchAllFunction");
//$xajax->registerFunction("testForm");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Catch-all Function Test | xajax Tests</title>
<?php $xajax->printJavascript("../") ?>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>Catch-all Function Test</h1>

<form id="testForm1" onsubmit="return false;">
<p><input type="text" id="textBox1" name="textBox1" value="This is some text" /></p>
<p><input type="submit" value="Submit Normal" onclick="xajax.call('testForm', [xajax.getFormValues('testForm1')]); return false;" /></p>
</form>

<div id="submittedDiv"></div>

</body>
</html>