<?php
require_once("../xajax.inc.php");

function includeScript($sFilename)
{
	$objResponse = new xajaxResponse();
	$objResponse->addIncludeScript($sFilename);
	return $objResponse->getXML();
}

$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("includeScript");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Include External Javascript Test | xajax Tests</title>
<?php $xajax->printJavascript("../") ?>
<script type="text/javascript">
function externalFunction()
{
	try
	{
		myFunction();
	}
	catch(e)
	{
		alert(e);
	}
}
</script>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>Include External Javascript Test</h1>

<div id="myDiv"" style="padding: 3px; display: table; border: 1px outset black; font-size: large; margin-bottom: 10px;" onclick="externalFunction()">Click Me</div>

<form id="testForm1" onsubmit="return false;">
<input type="submit" value="Include myFunction.js" onclick="xajax_includeScript('myExternalFunction.js'); return false;" />
</body>
</html>