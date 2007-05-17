<?php
// multiply.php, multiply.common.php, multiply.server.php
// demonstrate a very basic xajax implementation
// using xajax version 0.2
// http://xajaxproject.org

require_once ("../../xajax.inc.php");

$xajax = new xajax("multiply.server.php");
$xajax->registerFunction("multiply");
?>