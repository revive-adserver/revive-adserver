<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Figure out our location
define ('phpAds_path', '.');



/*********************************************************/
/* Include required files                                */
/*********************************************************/

require	(phpAds_path."/config.inc.php"); 
require (phpAds_path."/lib-io.inc.php");
require (phpAds_path."/lib-db.inc.php");

if (($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon']) || $phpAds_config['acl'])
{
	require (phpAds_path."/lib-remotehost.inc.php");
	
	if ($phpAds_config['log_adviews'] && !$phpAds_config['log_beacon'])
		require (phpAds_path."/lib-log.inc.php");
	
	if ($phpAds_config['acl'])
		require (phpAds_path."/lib-acl.inc.php");
}

require	(phpAds_path."/lib-view-main.inc.php");
require (phpAds_path."/lib-cache.inc.php");



/*********************************************************/
/* Register input variables                              */
/*********************************************************/

phpAds_registerGlobal ('what', 'clientid', 'clientID', 'context',
					   'target', 'source', 'withtext', 'withText',
					   'refresh', 'resize');



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($clientID) && !isset($clientid))	$clientid = $clientID;
if (isset($withText) && !isset($withtext))  $withtext = $withText;

if (!isset($what)) 		$what = '';
if (!isset($clientid)) 	$clientid = 0;
if (!isset($target)) 	$target = '_top';
if (!isset($source)) 	$source = '';
if (!isset($withtext)) 	$withtext = '';
if (!isset($context)) 	$context = '';


// Get the banner
$banner = view_raw ($what, $clientid, $target, $source, $withtext, $context);


// Build HTML
echo "<html>\n";
echo "<head>\n";
echo "<title>".($banner['alt'] ? $banner['alt'] : 'Advertisement')."</title>\n";

if (isset($refresh) && $refresh != '')
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