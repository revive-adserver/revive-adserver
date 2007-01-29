<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Figure out our location
define ('phpAds_path', '.');


// Set invocation type
define ('phpAds_invocationType', 'popup');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/libraries/lib-io.inc.php");
require (phpAds_path."/libraries/lib-db.inc.php");

if (($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon']) || $phpAds_config['acl'])
{
	require (phpAds_path."/libraries/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon'])
		require (phpAds_path."/libraries/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/libraries/lib-limitations.inc.php");
}

require	(phpAds_path."/libraries/lib-view-main.inc.php");
require (phpAds_path."/libraries/lib-cache.inc.php");



/*********************************************************/
/* Register input variables                              */
/*********************************************************/

phpAds_registerGlobal ('what', 'clientid', 'clientID', 'context',
					   'target', 'source', 'withtext', 'withText',
					   'left', 'top', 'popunder', 'timeout', 'delay',
					   'toolbars', 'location', 'menubar', 'status',
					   'resizable', 'scrollbars');



/*********************************************************/
/* Set default values for input variables                */
/*********************************************************/

if (isset($clientID) && !isset($clientid))	$clientid = $clientID;
if (isset($withText) && !isset($withtext))  $withtext = $withText;

if (!isset($what)) 		 $what = '';
if (!isset($clientid)) 	 $clientid = 0;
if (!isset($target)) 	 $target = '_new';
if (!isset($source)) 	 $source = '';
if (!isset($withtext)) 	 $withtext = '';
if (!isset($context)) 	 $context = '';

if (!isset($timeout))    $timeout    = 0;

if (!isset($toolbars))   $toolbars   = 0;
if (!isset($location))	 $location   = 0;
if (!isset($menubar))	 $menubar    = 0;
if (!isset($status))	 $status     = 0;
if (!isset($resizable))  $resizable  = 0;
if (!isset($scrollbars)) $scrollbars = 0;

// Save referrer as current URL for the URL limitation
if (isset($_SERVER['HTTP_REFERER']))
	$phpAds_CurrentURL = $_SERVER['HTTP_REFERER'];

// Make sure that no referrer is set
$phpAds_CurrentReferrer = '';



/*********************************************************/
/* Determine which banner we are going to show           */
/*********************************************************/

$found = false;
	
// Reset followed zone chain
$phpAds_followedChain = array();
	
$first = true;
	
while (($first || $what != '') && $found == false)
{
	$first = false;
	if (substr($what,0,5) == 'zone:')
	{
		if (!defined('LIBVIEWZONE_INCLUDED'))
			require (phpAds_path.'/libraries/lib-view-zone.inc.php');
		
		$row = phpAds_fetchBannerZone($what, $clientid, $context, $source, true);
	}
	else
	{
		if (!defined('LIBVIEWDIRECT_INCLUDED'))
			require (phpAds_path.'/libraries/lib-view-direct.inc.php');
		
		$row = phpAds_fetchBannerDirect($what, $clientid, $context, $source, true);
	}
	
	if (is_array ($row))
		$found = true;
	else
		$what  = $row;
}

// Do not pop a window if not banner was found..
if (!$found)
	exit;
		
	
$contenturl  = $phpAds_config['url_prefix']."/adcontent.php?bannerid=".$row['bannerid'];
$contenturl .= "&zoneid=".$row['zoneid'];
$contenturl .= "&source=".urlencode($source)."&timeout=".$timeout;
	
	
	
/*********************************************************/
/* Build the code needed to pop up a window              */
/*********************************************************/

header("Content-type: application/x-javascript");
		

echo "var phpads_errorhandler = null;\n\n";

echo "if (window.captureEvents && Event.ERROR)\n";
echo "\twindow.captureEvents (Event.ERROR);\n\n";

// Error handler to prevent 'Access denied' errors
echo "function phpads_onerror(e) {\n";
echo "\twindow.onerror = phpads_errorhandler;\n";
echo "\treturn true;\n";
echo "}\n\n";

echo "function phpads_".$row['bannerid']."_pop() {\n";
echo "\tphpads_errorhandler = window.onerror;\n";
echo "\twindow.onerror = phpads_onerror;\n\n";

// Determine the size of the window
echo "\tvar X = ".$row['width'].";\n";
echo "\tvar Y = ".$row['height'].";\n\n";

// If Netscape 3 is used add 20 to the size because it doesn't support a margin of 0
echo "\tif(!window.resizeTo) {\n";
echo "\t\tX = X + 20;\n";
echo "\t\tY = Y + 20;\n";
echo "\t}\n\n";

// Open the window if needed
echo "\twindow.phpads_".$row['bannerid']." =  window.open('', 'phpads_".$row['bannerid']."', 'height=' + Y + ',width=' + X + ',toolbar=".($toolbars == 1 ? 'yes' : 'no').",location=".($location == 1 ? 'yes' : 'no').",menubar=".($menubar == 1 ? 'yes' : 'no').",status=".($status == 1 ? 'yes' : 'no').",resizable=".($resizable == 1 ? 'yes' : 'no').",scrollbars=".($scrollbars == 1 ? 'yes' : 'no')."');\n";
echo "\tif (window.phpads_".$row['bannerid'].".document.title == '' || window.phpads_".$row['bannerid'].".location == 'about:blank' || window.phpads_".$row['bannerid'].".location == '') {\n";

// Resize window to correct size, determine outer width and height
echo "\t\tif (window.resizeTo) {\n";
echo "\t\t\tif(phpads_".$row['bannerid'].".innerHeight) {\n";
echo "\t\t\t\tvar diffY = phpads_".$row['bannerid'].".outerHeight - Y;\n";
echo "\t\t\t\tvar diffX = phpads_".$row['bannerid'].".outerWidth - X;\n";
echo "\t\t\t\tvar outerX = X + diffX;\n";
echo "\t\t\t\tvar outerY = Y + diffY;\n";
echo "\t\t\t} else {\n";
echo "\t\t\t\tphpads_".$row['bannerid'].".resizeTo(X, Y);\n";
echo "\t\t\t\tvar diffY = phpads_".$row['bannerid'].".document.body.clientHeight - Y;\n";
echo "\t\t\t\tvar diffX = phpads_".$row['bannerid'].".document.body.clientWidth - X;\n";
echo "\t\t\t\tvar outerX = X - diffX;\n";
echo "\t\t\t\tvar outerY = Y - diffY;\n";
echo "\t\t\t}\n";
echo "\t\t\tphpads_".$row['bannerid'].".resizeTo(outerX, outerY);\n";
echo "\t\t}\n";

if (isset($left) && isset($top))
{
	echo "\t\tif (window.moveTo) {\n";
	
	if ($left == 'center')  
		echo "\t\t\tvar posX = parseInt((screen.width / 2) - (outerX / 2));\n";
	elseif ($left >= 0) 
		echo "\t\t\tvar posX = ".$left.";\n";
	elseif ($left < 0)  
		echo "\t\t\tvar posX = screen.width - outerX + ".$left.";\n";
	
	if ($top == 'center')
		echo "\t\t\tvar posY = parseInt((screen.height / 2) - (outerY / 2));\n";
	elseif ($top  >= 0) 
		echo "\t\t\tvar posY = ".$top.";\n";
	elseif ($top  < 0)  
		echo "\t\t\tvar posY = screen.height - outerY + ".$top.";\n";
	
	echo "\t\t\tphpads_".$row['bannerid'].".moveTo (posX, posY);\n";
	echo "\t\t}\n";
}

// Set the actual location after resize otherwise we might get 'access denied' errors
echo "\t\tphpads_".$row['bannerid'].".location = '".$contenturl."';\n";

// Move main window to the foreground if we are dealing with a popunder
if (isset($popunder) && $popunder == '1')
	echo "\t\twindow.focus();\n";

echo "\t}\n";
echo "\twindow.onerror = phpads_errorhandler;\n";
echo "\treturn true;\n";
echo "}\n\n";



if (isset($delay) && $delay == 'exit')
{
	echo "if (window.captureEvents && Event.UNLOAD)\n";
	echo "\twindow.captureEvents (Event.UNLOAD);\n\n";
	echo "window.onunload = phpads_".$row['bannerid']."_pop;\n";
}
elseif (isset($delay) && $delay > 0) 
{
	echo "window.setTimeout(\"phpads_".$row['bannerid']."_pop();\", ".($delay * 1000).");\n";
}
else
{
	echo "phpads_".$row['bannerid']."_pop();\n";
}