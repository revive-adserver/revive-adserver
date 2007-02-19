<?php
require_once("../xajax.inc.php");

function testForm($formData)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert("formData: " . print_r($formData, true));
	$objResponse->addAssign("submittedDiv", "innerHTML", nl2br(print_r($formData, true)));
	return $objResponse->getXML();
}

$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("testForm");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Form Submission Test| xajax Tests</title>
<style type="text/css">
fieldset > div
{
	border: 1px solid gray;
	padding: 5px;
	background-color: white;
}
</style>
<?php $xajax->printJavascript("../") ?>
</head>
<body>
<h2><a href="index.php">xajax Tests</a></h2>
<h1>Form Submission Test</h1>

<div>
<form id="testForm1" onsubmit="return false;">
<fieldset style="display:inline; background-color: rgb(230,230,230);">
<legend>Test Form</legend>
<div style="margin: 3px;">
<div>Text Input</div>
<input type="text" id="textInput" name="textInput" value="text" />
</div>

<div style="margin: 3px;">
<div>Password Input</div>
<input type="password" id="textInput" name="passwordInput" value="2br!2b" />
</div>

<div style="margin: 3px;">
<div>Textarea</div>
<textarea id="textarea" name="textarea">text text</textarea>
</div>

<div style="margin: 3px;">
<div>
<input type="checkbox" id="checkboxInput1" name="checkboxInput[]" value="true" checked="checked" />
<label for="checkboxInput1">Checkbox Input 1</label>
</div>
<div>
<input type="checkbox" id="checkboxInput2" name="checkboxInput[]" value="true" checked="checked" />
<label for="checkboxInput2">Checkbox Input 2</label>
</div>
</div>

<div style="margin: 3px;">
<div>Radio Input</div>
<div>
<input type="radio" id="radioInput1" name="radioInput" value="1" checked="checked" />
<label for="radioInput1">One</label>
</div>
<div>
<input type="radio" id="radioInput2" name="radioInput" value="2" />
<label for="radioInput2">Two</label>
</div>
</div>

<div style="margin: 3px;">
<div>Select</div>
<select id="select" name="select">
<option value="1">One</option>
<option value="2">Two</option>
<option value="3">Three</option>
<option value="4">Four</option>
</select>
</div>

<div style="margin: 3px;">
<div>Multiple Select</div>
<select id="multipleSelect" name="multipleSelect[]" multiple="multiple" size=4>
<option value="1" selected="selected">One</option>
<option value="2">Two</option>
<option value="3">Three</option>
<option value="4">Four</option>
</select>
</div>
<span style="margin: 3px;">
<input type="submit" value="submit through xajax" onclick="xajax_testForm(xajax.getFormValues('testForm1')); return false;" />
</span>
</fieldset>
</form>
</div>

<div id="submittedDiv" style=" margin: 3px;"></div>

</body>
</html>