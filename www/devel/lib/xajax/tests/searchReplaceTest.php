<?php
require_once("../xajax.inc.php");

function replace($aForm)
{
	$objResponse = new xajaxResponse();
	$objResponse->addReplace('content', "innerHTML", $aForm['search'], $aForm['replace']);
	return $objResponse->getXML();
}

$xajax = new xajax();
//$xajax->debugOn();
$xajax->registerFunction("replace");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Search and Replace Test | xajax Tests</title>
<?php $xajax->printJavascript("../") ?>
</head>
<body>

<h2><a href="index.php">xajax Tests</a></h2>
<h1>Search and Replace Test</h1>

<div id="content"" style="border: 1px solid gray">
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi fermentum. 
Phasellus non nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. 
Nulla id ligula sit amet purus tristique dictum. Fusce at arcu. Maecenas ipsum leo, tincidunt eu, vehicula id, 
elementum feugiat, enim. Nam fringilla mi ac ligula. Quisque tempus, 
lacus ut molestie dignissim, massa ipsum sodales arcu, eget rhoncus sapien diam at velit. 
Morbi fermentum, dui vel tempus vestibulum, diam metus nonummy ligula, ac ultrices lacus est ac sapien. 
Pellentesque luctus dictum massa. Cras ullamcorper ullamcorper massa. Etiam erat odio, gravida eget, ornare vitae, 
dapibus nec, nunc. Phasellus ligula arcu, rutrum at, pellentesque et, varius feugiat, velit. 
Etiam erat magna, eleifend vel, vulputate eget, dignissim non, lectus. Nam at metus. Aenean mollis ligula viverra ipsum.
</div>

<form id="testForm1" onsubmit="return false;">
<div>
Search:<input id="search" name="search" value="" />
</div>
<div>
Replace:<input id="replace" name="replace" value="" />
</div>
<div><input type="submit" value="Search & Replace" onclick="xajax_replace(xajax.getFormValues('testForm1')); return false;" /></div>
</form>

<div id="submittedDiv"></div>

</body>
</html>