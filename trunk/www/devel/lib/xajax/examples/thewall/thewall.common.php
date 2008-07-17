<?php
// thewall.php, thewall.common.php, thewall.server.php
// demonstrate a demonstrates a xajax implementation of a graffiti wall
// using xajax version 0.2
// http://xajaxproject.org

require_once ("../../xajax.inc.php");

$xajax = new xajax("thewall.server.php");
$xajax->registerFunction("scribble");
$xajax->registerFunction("updateWall");
?>