<?
require("config.inc.php");
require("view.inc.php");
require("acl.inc.php");
settype($clientID,"integer");
header("Content-type: application/x-javascript");
header("Pragma: no-cache");
print "document.writeln('";
view("$what",$clientID,"$target","$source","$withText","$context");
print "');";
?>
