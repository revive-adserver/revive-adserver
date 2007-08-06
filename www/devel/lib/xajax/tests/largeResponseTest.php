<?php
require_once("../xajax.inc.php");

function largeResponse()
{
	$objResponse = new xajaxResponse();
	$myResponse = "";
	for ($i=0;$i<8000;$i++) {
		$myResponse .= "<p>Here is paragraph $i for your reading pleasure.</p>\n";
	}
	$objResponse->addAssign("submittedDiv", "innerHTML", $myResponse);
	return $objResponse;
}

$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("largeResponse");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Large Response Test | xajax Tests</title>
<?php $xajax->printJavascript("../") ?>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>Large Response Test</h1>

<form id="testForm1" onsubmit="return false;">
<p><input type="submit" value="Get Large Response" onclick="xajax_largeResponse(); return false;" /></p>
</form>

<div id="submittedDiv"></div>

</body>
</html>