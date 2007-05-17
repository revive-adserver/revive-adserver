<?php
// signup.php, signup.common.php, signup.server.php
// demonstrate a a simple implementation of a multipage signup form
// using xajax version 0.2
// http://xajaxproject.org

require_once ("../../xajax.inc.php");

session_start();

$xajax = new xajax("signup.server.php");
$xajax->registerFunction("processForm");
?>