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
if (isset($Session['update_check']) && $Session['update_check'])
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
	echo "<br>";
	echo "<table border='0' cellspacing='1' cellpadding='2'><tr><td>";
	echo "<img src='images/install-busy.gif' width='16' height='16'>";
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
	$maint_update = $Session['maint_update'];
	unset($Session['maint_update']);
	phpAds_SessionDataStore();
	
	if ($maint_update[0] > 0 && $maint_update[0] != 800)
		phpAds_Die ($strErrorOccurred, $strUpdateServerDown);
	
	echo "<br><br>";
	
	if ($maint_update[0] == 800)
	{
		echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='24' valign='top'>";
		echo "<img src='images/info.gif'>&nbsp;&nbsp;";
		echo "</td><td valign='top'><b>".$strNoNewVersionAvailable."</b>";
		echo "</td></tr></table><br>";
		phpAds_ShowBreak();
	}
	elseif (is_array($maint_update[1]))
	{
		echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='24' valign='top'>";
		
		if ($maint_update[1]['security_fix'] == 1)
		{
			echo "<img src='images/error.gif'>&nbsp;&nbsp;";
			echo "</td><td valign='top'>".$strSecurityUpdate;
		}
		else
		{
			echo "<img src='images/info.gif'>&nbsp;&nbsp;";
			echo "</td><td valign='top'>".$strNewVersionAvailable;
		}
		
		echo "</td></tr></table>";
		echo "<br>";
		phpAds_ShowBreak();
		
		
		echo "<br><br>";
		echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
		echo "<tr height='25'><td height='25'>&nbsp;&nbsp;<b>".$strAvailableUpdates."</b></td></tr>";
		
		echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' valign='top' nowrap>";
		
		echo "<br>&nbsp;&nbsp;<img src='images/icon-setup.gif' align='absmiddle'>&nbsp;";
		echo $phpAds_productname." ".$maint_update[1]['config_readable']."</td>";
		
		echo "<td width='32'>&nbsp;</td>";
		echo "<td><br>".$maint_update[1]['description']."<br><br>";
		echo "</td>";
		
		echo "<td width='32'>&nbsp;</td>";
		echo "</tr>";
		
		if ($maint_update[1]['url_zip'] != '' || $maint_update[1]['url_tgz'] != '')
		{
			echo "<tr height='1'><td colspan='2' bgcolor='#F6F6F6'><img src='images/spacer.gif' height='1' width='100%'>";
			echo "<td colspan='2' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
			echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='2'>&nbsp;&nbsp;</td><td>";
			
			if ($maint_update[1]['url_zip'] != '')
			{
				echo "<img src='images/icon-filetype-zip.gif' align='absmiddle'>&nbsp;";
				echo "<a href='".$maint_update[1]['url_zip']."'>".$strDownloadZip."</a>";
				
				if ($maint_update[1]['url_tgz'] != '')
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
			if ($maint_update[1]['url_tgz'] != '')
			{
				echo "<img src='images/icon-filetype-zip.gif' align='absmiddle'>&nbsp;";
				echo "<a href='".$maint_update[1]['url_tgz']."'>".$strDownloadGZip."</a>";
			}
			
			echo "</td><td>&nbsp;</td></tr>";
		}
		
		echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "</table>";
	}
	else
		phpAds_Die ($strErrorOccurred, $strUpdateServerDown);
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>