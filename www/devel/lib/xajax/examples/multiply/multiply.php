<?php
// multiply.php, multiply.common.php, multiply.server.php
// demonstrate a very basic xajax implementation
// using xajax version 0.2
// http://xajaxproject.org

require("multiply.common.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html> 
	<head>
		<title>xajax Multiplier</title> 
		<?php $xajax->printJavascript('../../'); ?> 
	</head> 
	<body> 
		<input type="text" name="x" id="x" value="2" size="3" /> * 
		<input type="text" name="y" id="y" value="3" size="3" /> = 
		<input type="text" name="z" id="z" value="" size="3" /> 
		<input type="button" value="Calculate" onclick="xajax_multiply(document.getElementById('x').value,document.getElementById('y').value);return false;" />
	</body> 
</html>