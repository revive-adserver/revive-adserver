<?php
require_once("../xajax.inc.php");

// tests the select form
function testForm($formData)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAlert("formData: " . print_r($formData, true));
	$objResponse->addAssign("submittedDiv", "innerHTML", nl2br(print_r($formData, true)));
	return $objResponse->getXML();
}

// adds an option to the select 
function addInput($aInputData)
{
	$sId = $aInputData['inputId'];
	$sName = $aInputData['inputName'];
	$sType = $aInputData['inputType'];
	$sValue = $aInputData['inputValue'];
	
	$objResponse = new xajaxResponse();
	$objResponse->addAlert("inputData: " . print_r($aInputData, true));
	$objResponse->addCreateInput("testForm1", $sType, $sName, $sId);
	$objResponse->addAssign($sId, "value", $sValue);
	return $objResponse->getXML();
}

// adds an option to the select 
function insertInput($aInputData)
{
	$sId = $aInputData['inputId'];
	$sName = $aInputData['inputName'];
	$sType = $aInputData['inputType'];
	$sValue = $aInputData['inputValue'];
	$sBefore = $aInputData['inputBefore'];
	
	$objResponse = new xajaxResponse();
	$objResponse->addAlert("inputData: " . print_r($aInputData, true));
	$objResponse->addInsertInput($sBefore, $sType, $sName, $sId);
	$objResponse->addAssign($sId, "value", $sValue);
	return $objResponse->getXML();
}

// adds an option to the select 
function insertInputAfter($aInputData)
{
	$sId = $aInputData['inputId'];
	$sName = $aInputData['inputName'];
	$sType = $aInputData['inputType'];
	$sValue = $aInputData['inputValue'];
	$sAfter = $aInputData['inputAfter'];
	
	$objResponse = new xajaxResponse();
	$objResponse->addAlert("inputData: " . print_r($aInputData, true));
	$objResponse->addInsertInputAfter($sAfter, $sType, $sName, $sId);
	$objResponse->addAssign($sId, "value", $sValue);
	return $objResponse->getXML();
}

function removeInput($aInputData)
{
	$sId = $aInputData['inputId'];
	
	$objResponse = new xajaxResponse();
	
	$objResponse->addRemove($sId);

	return $objResponse->getXML();
}

$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("testForm");
$xajax->registerFunction("addInput");
$xajax->registerFunction("insertInput");
$xajax->registerFunction("insertInputAfter");
$xajax->registerFunction("removeInput");

$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Create Form Input Test| xajax Tests</title>
		<?php $xajax->printJavascript("../", "xajax_js/xajax_uncompressed.js") ?>
	</head>
	<body>
		<h2><a href="index.php">xajax Tests</a></h2>
		<h1>Create Form Input Test</h1>
		
		<div>
			<form id="testForm1" onsubmit="return false;">
				<div><input type="submit" value="submit" onclick="xajax_testForm(xajax.getFormValues('testForm1')); return false;" /></div>
			</form>
		</div>

		<div style="margin-top: 20px;">
			<form id="testForm2" onsubmit="return false;">
				<div>type:</div>
				<select id="inputType" name="inputType">
					<option value="text" selected="selected">text</option>
					<option value="password">password</option>
					<option value="hidden">hidden</option>
					<option value="radio">radio</option>
					<option value="checkbox">checkbox</option>
				</select>
				<div>Id:</div>
				<input type="text" id="inputId" name="inputId" value="input1" />
				<div>Name:</div>
				<input type="text" id="inputName" name="inputName" value="input1" />
				<div>Value:</div>
				<input type="text" id="inputValue" name="inputValue" value="1" />
				
				<div>
				<input type="submit" value="Add" onclick="xajax_addInput(xajax.getFormValues('testForm2')); return false;" />
				<input type="submit" value="Remove" onclick="xajax_removeInput(xajax.getFormValues('testForm2')); return false;" />
				<br />
				<input type="submit" value="Insert Before:" onclick="xajax_insertInput(xajax.getFormValues('testForm2')); return false;" /><input type="text" id="inputBefore" name="inputBefore" value="" />
				<br />
				<input type="submit" value="Insert After:" onclick="xajax_insertInputAfter(xajax.getFormValues('testForm2')); return false;" /><input type="text" id="inputAfter" name="inputAfter" value="" />				
				</div>
			</form>
		</div>

		<div id="submittedDiv" style="margin: 3px;"></div>
		
	</body>
</html>