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



// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', substr(__FILE__, 0, (strlen(__FILE__) - strpos(strrev(__FILE__), strrev('admin')) - strlen('admin') - 1)));
else
    define ('phpAds_path', '..');


// Include default settings
require (phpAds_path.'/misc/config.template.php');

// Include config edit library
require ("lib-config.inc.php");
include ("../lib-db.inc.php");
include ("../lib-dbconfig.inc.php");

// Read the config file and overwrite default values
phpAds_ConfigFileUpdatePrepare();
phpAds_ConfigFileUpdateExport();


// Include needed libraries
require ("lib-permissions.inc.php");
require ("lib-gui.inc.php");
require ("lib-languages.inc.php");
require ("lib-install-db.inc.php");
require ("lib-statistics.inc.php");
require ("lib-storage.inc.php");
require ("lib-banner.inc.php");


// Turn off database compatibility mode
$phpAds_config['compatibility_mode'] = false;

// Open the database connection
$link = phpAds_dbConnect();
if (!$link)
{
	phpAds_PageHeader('');
	phpAds_Die ("A fatal error occurred", "phpAdsNew can't connect to the database, 
										   please make sure the database is working 
										   and phpAdsNew is configured correctly");
}
else
{
	// Load settings from the database
	// in case settings are stored in the database
	phpAds_LoadDbConfig();
}


// First thing to do is clear the $Session variable to
// prevent users from pretending to be logged in.
unset($Session);

// Authorize the user
phpAds_Start();

// Load language strings
include("../language/".$phpAds_config['language']."/default.lang.php");
include("../language/".$phpAds_config['language']."/settings.lang.php");

// Setup navigation
$phpAds_nav = array (
	"admin"	=> array (
		"1"					=>  array("javascript:;" => $strUpgrade)
	),
	"client" => array(
		"1"					=>  array("javascript:;" => $strUpgrade)
	)
);

// Security check
// Let client in only to tell him that the system is temporary
// unavailable if an upgrade is needed, otherwise redirect to the home page.
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



// Check for the need to upgrade
$upgrade = !isset($phpAds_config['config_version']) ||
	$phpAds_version > $phpAds_config['config_version'];



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	if (!$upgrade)
	{
		header("Location: index.php");
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, "<br>$strServiceUnavalable<br>&nbsp;");
	}
}


if (phpAds_isUser(phpAds_Admin))
{
	// Start with step 1
	if (!isset($step))
		$step = 1;
	
	// Repeat proceed request if config still not writeable
	if ($step == 2 && !phpAds_isConfigWritable())
		$step = 1;
	
	
	if ($upgrade && $step == 1)
	{
		// Print a proceed request if an upgrade is needed
		phpAds_PageHeader("1");
		echo "<br><br>";
		phpAds_ShowBreak();
		
		$message = $strSystemNeedsUpgrade;
		if (!phpAds_databaseUpgradeSupported) $message .= '<br><br><b>'.$strCantUpdateDB.'</b>';
		
		echo "<form name='upgrade' method='post' action='upgrade.php'>";
		echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
		echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
		echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
		echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
		echo "<span class='install'>".$message."</td></tr></table>";
		
		if (!phpAds_isConfigWritable())
		{
			echo "<br><br>";
			echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
			echo "<tr><td><img src='images/error.gif'>&nbsp;&nbsp;</td>";
			echo "<td width='100%'><span class='tab-r'>".$strMayNotFunction."</span></td></tr>";
			echo "<tr><td>&nbsp;</td><td><span class='install'>".$strConfigLockedDetected."</span></td></tr>";
			echo "</table>";
		}
		
		echo "<br><br>";
		phpAds_ShowBreak();
		echo "<br>";
		
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr><td align='right'>";
		echo "<input type='submit' name='proceed' value='".$strProceed."'>";
		echo "</td></tr></table>\n\n";
		
		echo "<input type='hidden' name='step' value='2'>";
		echo "</form>";
	}
	elseif ($upgrade && $step == 2)
	{
		// Setup busy indicator
		phpAds_PageHeader("1");
		echo "<br><br><img src='images/install-busy.gif' align='absmiddle'>&nbsp;";
		echo "<span class='install'>".$strSystemUpgradeBusy."</span>";
		phpAds_PageFooter();
		
		// Send the output to the browser
		flush();
		
		// Upgrade database
		if (phpAds_databaseUpgradeSupported)
			$result = phpAds_upgradeDatabase();
		else
			$result = phpAds_createDatabase();
		
		// Update config_version and write settings
		phpAds_SettingsWriteAdd('config_version', $phpAds_version);
		phpAds_ConfigFileUpdateFlush();
		
		// Go to the next step
		echo "<meta http-equiv='refresh' content='0;URL=upgrade.php?step=3'>";
		exit;
	}
	else
	{
		phpAds_PageHeader("1");
		echo "<br><br>";
		phpAds_ShowBreak();
		
		echo "<form name='upgrade' method='post' action='index.php'>";
		echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
		echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
		echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
		echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
		echo "<span class='install'>".$strSystemUpToDate."</td></tr></table>";
		
		echo "<br><br>";
		phpAds_ShowBreak();
		echo "<br>";
		
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr><td align='right'>";
		echo "<input type='submit' name='proceed' value='".$strProceed."'>";
		echo "</td></tr></table>\n\n";
		echo "</form>";
	}
}

echo "<br><br>";

phpAds_PageFooter();

?>
