<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require("config.inc.php");
require("view.inc.php");
require("lib-acl.inc.php");

// Set header information
require("lib-cache.inc.php");


if (!isset($what)) 		$what = '';
if (!isset($clientID)) 	$clientID = 0;
if (!isset($target)) 	$target = '_top';
if (!isset($source)) 	$source = '';
if (!isset($withText)) 	$withText = '';
if (!isset($context)) 	$context = '';


// Get the banner
echo "<html>\n";

if (isset($refresh) && $refresh != '')
{
	echo "<head>\n";
	echo "<meta http-equiv='refresh' content='".$refresh."'>\n";
	echo "</head>\n";
}

echo "<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>\n";

view("$what",$clientID,"$target","$source","$withText","$context");

echo "\n</body>\n";
echo "</html>\n";

?> 
             