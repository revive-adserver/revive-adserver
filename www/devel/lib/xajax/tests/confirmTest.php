<?php
require_once("../xajax.inc.php");

function confirmTest()
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert("Here is an alert.");
	$objResponse->addConfirmCommands(2, "Are you sure you want to show two (2) more alerts?");
	$objResponse->addAlert("This will only happen if the user presses OK.");
	$objResponse->addAlert("This also will only happen if the user presses OK.");
	$objResponse->addAlert("This will always happen.");
	return $objResponse->getXML();
}

$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("confirmTest");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Confirm Commands Test | xajax Tests</title>
<?php $xajax->printJavascript("../") ?>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>Confirm Commands Test</h1>

<form id="testForm1" onsubmit="return false;">
<p><input type="submit" value="Perform Test" onclick="xajax_confirmTest(); return false;" /></p>
</form>

</body>
</html>