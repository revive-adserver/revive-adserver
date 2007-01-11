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
define ('phpAds_invocationType', 'adframe');



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
					   'refresh', 'resize', 'rewrite');



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($clientID) && !isset($clientid))	$clientid = $clientID;
if (isset($withText) && !isset($withtext))  $withtext = $withText;

if (!isset($what)) 		$what = '';
if (!isset($clientid)) 	$clientid = 0;
if (!isset($target)) 	$target = '_blank';
if (!isset($source)) 	$source = '';
if (!isset($withtext)) 	$withtext = '';
if (!isset($context)) 	$context = '';
if (!isset($rewrite))	$rewrite = 1;

// Remove referer, to be sure it doesn't cause problems with limitations
if (isset($_SERVER['HTTP_REFERER'])) unset($_SERVER['HTTP_REFERER']);
if (isset($HTTP_REFERER)) unset($HTTP_REFERER);


// Get the banner
$banner = view_raw ($what, $clientid, $target, $source, $withtext, $context);

if (!is_array($banner))
{
	// No banner returned, set some default values and prevent resizing
	$banner = array('html' => '', 'alt' => '');
	unset($resize);
}

// Rewrite targets in HTML code to make sure they are 
// local to the parent and not local to the iframe
if (isset($rewrite) && $rewrite == 1)
{
	$banner['html'] = preg_replace('#target\s*=\s*([\'"])_parent\1#i', "target='_top'", $banner['html']);
	$banner['html'] = preg_replace('#target\s*=\s*([\'"])_self\1#i', "target='_parent'", $banner['html']);
}


// Build HTML
echo "<html>\n";
echo "<head>\n";
echo "<title>".($banner['alt'] ? $banner['alt'] : 'Advertisement')."</title>\n";

// Add refresh meta tag if $refresh is set and numeric
if (isset($refresh) && !preg_match('/[^\d]/', $refresh))
	echo "<meta http-equiv='refresh' content='".$refresh."'>\n";

if (isset($resize) && $resize == 1)
{
	echo "<script language='JavaScript'>\n";
	echo "<!--\n";
	echo "\tfunction phpads_adjustframe(frame) {\n";
	echo "\t\tif (document.all) {\n";
    echo "\t\t\tparent.document.all[frame.name].width = ".$banner['width'].";\n";
    echo "\t\t\tparent.document.all[frame.name].height = ".$banner['height'].";\n";
  	echo "\t\t}\n";
  	echo "\t\telse if (document.getElementById) {\n";
    echo "\t\t\tparent.document.getElementById(frame.name).width = ".$banner['width'].";\n";
    echo "\t\t\tparent.document.getElementById(frame.name).height = ".$banner['height'].";\n";
  	echo "\t\t}\n";
	echo "\t}\n";
	echo "// -->\n";
	echo "</script>\n";
}

echo "</head>\n";

if (isset($resize) && $resize == 1)
	echo "<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' style='background-color:transparent' onload=\"phpads_adjustframe(window);\">\n";
else
	echo "<body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' style='background-color:transparent'>\n";

echo $banner['html'];
echo "\n</body>\n";

echo "</html>\n";

?>