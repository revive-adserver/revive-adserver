<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer <niels@creatype.nl              */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-maintenance.inc.php");

if (!defined('LIBUPDATES_INCLUDED'))	require ("lib-updates.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

// Check for previously downloaded info
if ($Session['update_check'])
{
	phpAds_SessionDataRegister('maint_update', $Session['update_check']);
	phpAds_SessionDataRegister('update_check', false);

	phpAds_SessionDataStore();
}

phpAds_PageHeader("5.4");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2"));


/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (!isset($Session['maint_update']))
{
	// Show wait please text with rotating logo
	echo "<br><br>";
	echo "<table border='0' cellspacing='1' cellpadding='2'><tr><td>";
	echo "<img src='images/install-busy.gif' width='40' height='40'>";
	echo "</td><td class='install'>".$strSearchingUpdates."</td></tr></table>";
	
	phpAds_PageFooter();
	
	// Send the output to the browser
	flush();
	
	// Get updates info and store them into a session var
	$res = phpAds_checkForUpdates();

	phpAds_SessionDataRegister('maint_update', $res);
	phpAds_SessionDataStore();

	echo "<script language='JavaScript'>\n";
	echo "<!--\n";
	echo "document.location.replace('maintenance-updates.php');\n";
	echo "//-->\n";
	echo "</script>\n";

	exit;
}
else
{
	echo "<pre>";
	echo $Session['maint_update'][0]."\n\n";
	print_r($Session['maint_update'][1]);
	echo "</pre>";

	unset($Session['maint_update']);
	phpAds_SessionDataStore();
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
