<?
require("config.inc.php");
require("view.inc.php");
require("acl.inc.php");
settype($clientID,"integer");
header("Content-type: application/x-javascript");
require("nocache.inc.php");
view("$what",$clientID,"$target","$source","$withText","$context", 1);
?>
