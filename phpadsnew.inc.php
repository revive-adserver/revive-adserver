<?php

// $ID$
///////////////////////////////////////////////////////////////////////////////////////////
//
// Include file required for use of the view() function, among others
// Your .php files should include this if you need to use the local ad view functions
//
// Like this:
//   require("phpAdsNew/phpAdsNew.inc.php");
//
// Then you can call the view function later in your php code like so:
//   view("486x60");
//
///////////////////////////////////////////////////////////////////////////////////////////

// First, let's figure out our location
$phpAds_path=substr(__FILE__, 0, strlen(__FILE__) - strlen(basename(__FILE__)));
// If this path doesn't work for you, customize it here like this
// $phpAds_path="/home/myname/www/phpAdsNew";       // Note: no trailing backslash


require("$phpAds_path/config.inc.php"); 
require("$phpAds_path/view.inc.php"); 
require("$phpAds_path/acl.inc.php"); 

?>    


