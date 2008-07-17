<?php
require_once("../xajax.inc.php");

function redirect()
{
	$objResponse = new xajaxResponse();
	$objResponse->addRedirect("http://www.xajaxproject.org");
	return $objResponse;
}
$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("redirect");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Redirect Test | xajax Tests</title>
<?php $xajax->printJavascript("../") ?>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>Redirect Test</h1>

<form id="testForm1" onsubmit="return false;">
<p><input type="submit" value="Test xajax redirect" onclick="xajax_redirect(); return false;" /></p>
</form>

<div id="submittedDiv"></div>

</body>
</html>