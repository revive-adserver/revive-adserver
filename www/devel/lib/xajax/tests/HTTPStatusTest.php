<?php
require_once("../xajax.inc.php");

function returnStatus($number)
{
	if ($number == 500) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "Testing a server error...";
	}
	if ($number == 404) {
		header("HTTP/1.1 404 Not Found");
		echo "Testing an unknown URL...";
	}
	exit;
}
$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("returnStatus");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>HTTP Status Test | xajax Tests</title>
<?php $xajax->printJavascript("../") ?>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>HTTP Status Test</h1>

<form id="testForm1" onsubmit="return false;">
<p><input type="submit" value="Return a 500 Internal Server Error" onclick="xajax_returnStatus(500); return false;" /></p>
<p><input type="submit" value="Return a 404 Not Found Error" onclick="xajax_returnStatus(404); return false;" /></p>
</form>

<div id="submittedDiv"></div>

</body>
</html>