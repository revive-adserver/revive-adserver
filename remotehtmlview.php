<?
require("config.inc.php");
require("view.inc.php");
require("acl.inc.php");
settype($clientID,"integer");
header("Content-type: application/x-javascript");
require("nocache.inc.php");
view_js("$what",$clientID,"$target","$source","$withText","$context");
?>
