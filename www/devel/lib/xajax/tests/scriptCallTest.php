<?php
require("../xajax.inc.php");

function callScript()
{
	$response = new xajaxResponse();
	$value2 = "this is a string";
	$response->addScriptCall("myJSFunction", "arg1", 9432.12, array("myKey" => "some value", "key2" => $value2));
	return $response;
}

$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("callScript");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>addScriptCall Test | xajax Tests</title>
	<?php $xajax->printJavascript("../") ?>
	<script type="text/javascript">
function myJSFunction(firstArg, numberArg, myArrayArg)
{
    var newString = firstArg + " and " + (+numberArg + 100) + "\n";
    newString += myArrayArg["myKey"] + " | " + myArrayArg.key2;
    alert(newString);
    xajax.$('myDiv').innerHTML = newString;
}
	</script>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>addScriptCall Test</h1>

<p>Howdy. <input type="button" value="Click Me" onclick="xajax_callScript()" /></p>

<p>Result:</p>

<pre id="myDiv">[blank]</pre>

<p>Expecting:</p>

<pre>arg1 and 9532.12
some value | this is a string</pre>

</body>
</html>
