<?php
require_once("../xajax.inc.php");

function addHandler($sId,$sHandler)
{
	$objResponse = new xajaxResponse();
	$objResponse->addHandler($sId, "click", $sHandler);
	return $objResponse->getXML();
}

function removeHandler($sId,$sHandler)
{
	$objResponse = new xajaxResponse();
	$objResponse->addRemoveHandler($sId, "click", $sHandler);
	return $objResponse->getXML();
}

$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("addHandler");
$xajax->registerFunction("removeHandler");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Event Handler Test | xajax Tests</title>
<?php $xajax->printJavascript("../") ?>
<script type="text/javascript">
function clickHandler1()
{
	alert('Click Handler 1');
}
function clickHandler2()
{
	alert('Click Handler 2');
}
</script>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>Event Handler Test</h1>


<div id="myDiv" style="padding: 3px; display: table; border: 1px outset black; font-size: large; margin-bottom: 10px;">Click Me</div>

<form id="testForm1" onsubmit="return false;">
<div>
<input type="submit" value="Add Handler1 to Div" onclick="xajax_addHandler('myDiv','clickHandler1'); return false;" />
<input type="submit" value="Remove Handler1 from Div" onclick="xajax_removeHandler('myDiv','clickHandler1'); return false;" />
</div>
<div>
<input type="submit" value="Add Handler2 to Div" onclick="xajax_addHandler('myDiv','clickHandler2'); return false;" />
<input type="submit" value="Remove Handler2 from Div" onclick="xajax_removeHandler('myDiv','clickHandler2'); return false;" />
</div>

</form>

<div id="submittedDiv"></div>

</body>
</html>