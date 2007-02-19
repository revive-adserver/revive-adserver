


<?php
require_once("../xajax.inc.php");

function showOutput()
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert("Hello");
	return $objResponse;
}
$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("showOutput");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PHP Whitespace Test | xajax Tests</title>
<?php $xajax->printJavascript("../") ?>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>PHP Whitespace Test</h1>

<p><em>This tests what happens when there's whitespace before the &lt;?php token in the PHP file (thus possibly causing the XML response to be invalid).</p>

<form id="testForm1" onsubmit="return false;">
<p><input type="submit" value="Test Whitespace" onclick="xajax_showOutput(); return false;" /></p>
</form>

<div id="submittedDiv"></div>

</body>
</html>