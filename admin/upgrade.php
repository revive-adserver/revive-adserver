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
    define ('phpAds_path', substr(__FILE__, 0, strpos(__FILE__, 'admin') - 1));
else
    define ('phpAds_path', '.');


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
require ("lib-install.inc.php");
require ("lib-languages.inc.php");
require ("lib-install-db.inc.php");



// Open the database connection
$link = phpAds_dbConnect();
if (!$link)
{
	phpAds_PageHeader('');
	phpAds_Die ("A fatal error occurred", "phpPgAds can't connect to the database, 
										   please make sure the database is working 
										   and phpPgAds is configured correctly");
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








/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	if (empty($upgrade))
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
	
	
	if ($step == 1)
	{
		// Print a proceed request if an upgrade is needed
		phpAds_PageHeader("1");
		
		$message = $strSystemNeedsUpgrade;
		
		if (!phpAds_databaseUpgradeSupported)
			$message .= '<br><br>'.$strCantUpdateDB;
		
		if (!phpAds_isConfigWritable())
			$message .= '<br><br>'.$strConfigLockedDetected;
		
		phpAds_InstallMessage($strUpgrade, $message);
		
		echo "<br><br>";
		echo "<form name='upgrade' action='upgrade.php' method='post'>";
		echo "<input type='hidden' name='step' value='2'>";
		echo "<input type='submit' name='proceed' value='$strProceed'>";
		echo "</form>";
	}
	elseif ($step == 2)
	{
		// Upgrade database
		if (phpAds_databaseUpgradeSupported)
			$result = phpAds_upgradeDatabase();
		else
			$result = phpAds_createDatabase();
		
		// Update config_version and write settings
		phpAds_SettingsWriteAdd('config_version', $phpAds_version);
		phpAds_ConfigFileUpdateFlush();
		
		// Go to the next step
		header ("Location: upgrade.php?step=3");
		exit;
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_InstallMessage($strUpgrade, $strSystemUpToDate);
	}
}

echo "<br><br>";

phpAds_PageFooter();

?>
