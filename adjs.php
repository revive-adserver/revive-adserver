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



/*********************************************************/
/* Java-encodes text                                     */
/*********************************************************/

function enjavanate ($str, $limit = 60)
{
	$str   = str_replace("\r", '', $str);
	
	while (strlen($str) > 0)
	{
		$line = substr ($str, 0, $limit);
		$str  = substr ($str, $limit);
		
		$line = str_replace('\'', "\\'", $line);
		$line = str_replace("\n", "\\n", $line);
		
		print "document.write('$line');\n";
	}
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

header("Content-type: application/x-javascript");
require("lib-cache.inc.php");

if (!isset($what)) 		$what = '';
if (!isset($clientID)) 	$clientID = 0;
if (!isset($target)) 	$target = '';
if (!isset($source)) 	$source = '';
if (!isset($withText)) 	$withText = '';
if (!isset($context)) 	$context = '';

// Get the banner
$output = view_raw ($what, $clientID, $target, $source, $withText, $context);
enjavanate($output['html']);

?>
