<?php
// helloworld.php demonstrates a very basic xajax implementation
// using xajax version 0.1 beta4
// http://xajax.sourceforge.net

require ('../xajax.inc.php');

function helloWorld($isCaps)
{
	if ($isCaps)
		$text = "HELLO WORLD!";
	else
		$text = "Hello World!";
		
	$objResponse = new xajaxResponse();
	$objResponse->addAssign("div1","innerHTML",$text);
	
	return $objResponse;
}

function setColor($sColor)
{
	$objResponse = new xajaxResponse();
	$objResponse->addAssign("div1","style.color", $sColor);
	
	return $objResponse;
}

// Instantiate the xajax object.  No parameters defaults requestURI to this page, method to POST, and debug to off
$xajax = new xajax(); 

//$xajax->debugOn(); // Uncomment this line to turn debugging on

// Specify the PHP functions to wrap. The JavaScript wrappers will be named xajax_functionname
$xajax->registerFunction("helloWorld");
$xajax->registerFunction("setColor");

// Process any requests.  Because our requestURI is the same as our html page,
// this must be called before any headers or HTML output have been sent
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>xajax example</title>
	<?php $xajax->printJavascript('../'); // output the xajax javascript. This must be called between the head tags ?>
</head>
<body style="text-align:center;">
	<div id="div1" name="div1">&#160;</div>
	<br/>
	
	<button onclick="xajax_helloWorld(0)" >Click Me</button>
	<button onclick="xajax_helloWorld(1)" >CLICK ME</button>
	<select id="colorselect" name="colorselect" onchange="xajax_setColor(document.getElementById('colorselect').value);">
		<option value="black" selected="selected">Black</option>
		<option value="red">Red</option>
		<option value="green">Green</option>
		<option value="blue">Blue</option>
	</select>
	<script type="text/javascript">
	xajax_helloWorld(0); // call the helloWorld function to populate the div on load
	xajax_setColor(document.getElementById('colorselect').value); // call the setColor function on load
	</script>
</body>
</html>