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



// Set time limit
if (!get_cfg_var ('safe_mode')) 
	@set_time_limit (300);


// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', substr(__FILE__, 0, (strlen(__FILE__) - strpos(strrev(__FILE__), strrev('admin')) - strlen('admin') - 1)));
else
    define ('phpAds_path', '..');


// Include default settings
require (phpAds_path.'/libraries/defaults/config.template.php');


// Register input variables
require ("../libraries/lib-io.inc.php");
phpAds_registerGlobal ('step', 'ignore', 'retry');


// Include config edit library
require ("lib-config.inc.php");
include ("../libraries/lib-db.inc.php");
include ("../libraries/lib-dbconfig.inc.php");


// Read the config file and overwrite default values
phpAds_ConfigFileUpdatePrepare();
phpAds_ConfigFileUpdateExport();


// Exclude loading of js-form.php
define('phpAds_updating', 1);

// Include needed libraries
require ("lib-permissions.inc.php");
require ("lib-gui.inc.php");
require ("lib-languages.inc.php");
require ("lib-install-db.inc.php");
require ("lib-statistics.inc.php");
require ("lib-storage.inc.php");
require ("lib-banner.inc.php");
require ("lib-zones.inc.php");


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


// Disable GZIP compression
$phpAds_config['content_gzip_compression'] = false;


// First thing to do is clear the $Session variable to
// prevent users from pretending to be logged in.
unset($Session);

// Authorize the user
phpAds_Start();


// Load language strings
@include (phpAds_path.'/language/english/default.lang.php');
if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php'))
	@include (phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php');
else
	$phpAds_config['language'] = 'english';

@include (phpAds_path.'/language/english/settings.lang.php');
if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/settings.lang.php'))
	@include (phpAds_path.'/language/'.$phpAds_config['language'].'/settings.lang.php');


// Setup navigation
$phpAds_nav = array (
	"admin"	=> array (
		"1"					=>  array("javascript:;" => $strUpgrade)
	),
	"client" => array(
		"1"					=>  array("javascript:;" => $strUpgrade)
	),
	"affiliate" => array(
		"1"					=>  array("javascript:;" => $strUpgrade)
	)
);

// Security check
// Let client in only to tell him that the system is temporary
// unavailable if an upgrade is needed, otherwise redirect to the home page.
phpAds_checkAccess(phpAds_Admin+phpAds_Client+phpAds_Affiliate);



// Check for the need to upgrade
$upgrade = !isset($phpAds_config['config_version']) ||
	$phpAds_version > $phpAds_config['config_version'];



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client) || phpAds_isUser(phpAds_Affiliate))
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
	
	
	// Adjust step based on feedback after error
	if ($step == 3 && isset($retry))  $step = 2;
	if ($step == 3 && isset($ignore)) $step = 4;
	
	
	// Check privileges and writability of config file
	if ($upgrade && ($step == 1 || $step == 2))
	{
		// Determine the PHP version
		ereg ("^([0-9]{1})\.([0-9]{1})\.([0-9]{1,2})", phpversion(), $matches);
		$phpversion = sprintf ("%01d%01d%02d", $matches[1], $matches[2], $matches[3]);
		
		
		// Store fatal errors
		$fatal = array();
		
		
		// Check PHP version < 4.0.1
		if ($phpversion < 4001)
			$fatal[] = str_replace ('{php_version}', phpversion(), $strWarningPHPversion);
		
		
		// Config variables can only be checked with php 4
		if ($phpversion >= 4000)
		{
			// Check file_uploads
			if (ini_get ('file_uploads') != true)
				  $fatal[] = $strWarningFileUploads;
			
			// Check track_vars
			if ($phpversion < 4003 &&
				ini_get ('track_vars') != true)
				$fatal[] = $strWarningTrackVars;
		}
		
		
		// Check for PREG extention
		if (!function_exists('preg_match'))
			$fatal[] = $strWarningPREG;
		
		
		// Check if config file is writable
		if (!phpAds_isConfigWritable())
			$fatal[] = $strConfigLockedDetected;
		
		
		// Drop test table if one exists
		phpAds_dbQuery ("DROP TABLE phpads_tmp_dbpriviligecheck");
		
		// Try to create a new table
		phpAds_dbQuery ("CREATE TABLE phpads_tmp_dbpriviligecheck (tmp int)");
		
		// Check if phpAdsNew can create tables
		if (phpAds_dbAffectedRows() >= 0)
		{
			phpAds_dbQuery ("ALTER TABLE phpads_tmp_dbpriviligecheck MODIFY COLUMN tmp int");
			
			if (phpAds_dbAffectedRows() < 0)
				$fatal[] = $strUpdateTableTestFailed;
			
			// Passed all test, now drop the test table
			phpAds_dbQuery ("DROP TABLE phpads_tmp_dbpriviligecheck");
		}
		else
			$fatal[] = $strUpdateTableTestFailed;
		
		
		// Repeat proceed request if config still not writeable
		if (count($fatal))
			$step = 1;
	}
	
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
		echo "<span class='install'>".$message;
		
		if (count($fatal))
		{
			echo "<br><br><div class='errormessage'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
			echo "<span class='tab-r'>".$strMayNotFunction."</span><br><br>".$strFixProblemsBefore."<ul>";
			
			for ($r=0;$r<count($fatal);$r++)
				echo "<li>".$fatal[$r]."</li>";
			
			echo "</ul>".$strFixProblemsAfter."<br><br></div>";
		}
		
		echo "</td></tr></table>";
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
		
		
		// Determine table type
		$table_type = isset($phpAds_config['table_type']) ? $phpAds_config['table_type'] : '';
		
		// Upgrade database
		if (phpAds_databaseUpgradeSupported)
			$result = phpAds_upgradeDatabase($table_type);
		else
			$result = phpAds_createDatabase($table_type);
		
		// Check if database is valid
		if (phpAds_databaseCheckSupported)
			$continue = phpAds_checkDatabaseValid();
		else
			$continue = true;
		
		
		if ($continue)
		{
			phpAds_upgradeData();
			
			// Go to the next step
			echo "<meta http-equiv='refresh' content='0;URL=upgrade.php?step=5'>";
			exit;
		}
		else
		{
			// Raise error
			echo "<meta http-equiv='refresh' content='0;URL=upgrade.php?step=3'>";
			exit;
		}
	}
	elseif ($step == 3)
	{
		// Show error message
		phpAds_PageHeader("1");
		echo "<br><br>";
		phpAds_ShowBreak();
		
		echo "<form name='upgrade' method='post' action='upgrade.php'>";
		echo "<input type='hidden' name='step' value='3'>";
		echo "<br>";
		echo "<span class='tab-r'><img src='images/error.gif'>&nbsp;&nbsp;".$strUpdateError."</span><br><br>";
		echo "<span class='install'>".$strUpdateDatabaseError."</span>";
		
		echo "<br><br>";
		phpAds_ShowBreak();
		echo "<br>";
		
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr><td align='right'>";
		echo "<input type='submit' name='ignore' value='".$strIgnoreErrors."'>&nbsp;&nbsp;";
		echo "<input type='submit' name='retry' value='".$strRetryUpdate."'>";
		echo "</td></tr></table>\n\n";
		echo "</form>";
	}
	elseif ($step == 4)
	{
		// Setup busy indicator
		phpAds_PageHeader("1");
		echo "<br><br><img src='images/install-busy.gif' align='absmiddle'>&nbsp;";
		echo "<span class='install'>".$strSystemUpgradeBusy."</span>";
		phpAds_PageFooter();
		
		// Send the output to the browser
		flush();
		
		phpAds_upgradeData();
		
		// Go to the next step
		echo "<meta http-equiv='refresh' content='0;URL=upgrade.php?step=5'>";
		exit;
	}
	elseif ($step == 5)
	{
		// Setup busy indicator
		phpAds_PageHeader("1");
		echo "<br><br><img src='images/install-busy.gif' align='absmiddle'>&nbsp;";
		echo "<span class='install'>".$strSystemRebuildingCache."</span>";
		phpAds_PageFooter();
		
		// Update banner cache of all banners
		phpAds_upgradeHTMLCache();
		
 		// Update compiled limitation of all banners
 		phpAds_compileLimitation();
		
		// Rebuild cache
		if (!defined('LIBVIEWCACHE_INCLUDED'))
			include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');
		
		phpAds_cacheDelete();
		
		
		// Check if priority recalculation is needed
		list($banners, $priority_sum) = phpAds_dbFetchRow(phpAds_dbQuery("
			SELECT
				COUNT(bannerid),
				SUM(priority)
			FROM
				".$phpAds_config['tbl_banners']."
		"));
		
		if ($banners && !$priority_sum)
		{
			// Recalculate priority
			include ("../libraries/lib-priority.inc.php");
			
			phpAds_PriorityCalculate();
		}
		
		// Send the output to the browser
		flush();
		
		// Go to the next step
		echo "<meta http-equiv='refresh' content='0;URL=upgrade.php?step=6'>";
		exit;
	}
	elseif ($step == 6)
	{
		// Update config_version and write settings
		phpAds_SettingsWriteAdd('config_version', $phpAds_version);
		phpAds_SettingsWriteAdd('language', $phpAds_config['language']);
		phpAds_ConfigFileUpdateFlush();
		
		phpAds_PageHeader("1");
		echo "<br><br>";
		phpAds_ShowBreak();
		
		echo "<form name='upgrade' method='post' action='index.php'>";
		echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
		echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
		echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
		echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
		echo "<span class='install'>".$strUpdateSuccess."</td></tr></table>";
		
		echo "<br><br>";
		phpAds_ShowBreak();
		echo "<br>";
		
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr><td align='right'>";
		echo "<input type='submit' name='proceed' value='".$strProceed."'>";
		echo "</td></tr></table>\n\n";
		echo "</form>";
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