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



// Set time limit
if (!get_cfg_var ('safe_mode')) 
	@set_time_limit (300);


// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', substr(__FILE__, 0, (strlen(__FILE__) - strpos(strrev(__FILE__), strrev('admin')) - strlen('admin') - 1)));
else
    define ('phpAds_path', '..');



include (phpAds_path."/libraries/lib-dbconfig.inc.php");
include (phpAds_path."/libraries/lib-revisions.inc.php");

if (!count($_POST) && !count($_GET))
{
	// Disable magic_quotes_runtime, otherwise we might get false 'changed files' warnings
	set_magic_quotes_runtime(0);

	// Before we do anything else we need to check the integerity of the uploaded files
	if ($result = phpAds_revisionCheck())
	{
		list ($rev_direct, $rev_fatal, $rev_message) = $result;
		
		if ($rev_direct)
		{
			// (no need for translation, because language file is not loaded yet)
			echo "<strong>The installer detected some problems which need to be fixed before you can continue:</strong><br>";
			echo '<ul><li>'.implode('<li>', $rev_message).'</ul>';
			exit;
		}
	}
}



// Include default settings
require (phpAds_path.'/libraries/defaults/config.template.php');


// Include config edit library
require ("lib-config.inc.php");
include ("../libraries/lib-db.inc.php");


// Read the config file and overwrite default values
phpAds_ConfigFileUpdatePrepare();
phpAds_ConfigFileUpdateExport();


// Register input variables
//
// Moved here because we need to know if pack cookies is enabled or not
//
require ("../libraries/lib-io.inc.php");
phpAds_registerGlobal ('step', 'ignore', 'retry');


// Exclude loading of js-form.php
define('phpAds_updating', 1);

// Include needed libraries
require ("lib-permissions.inc.php");
require ("lib-gui.inc.php");
require ("lib-languages.inc.php");
require ("lib-install-db.inc.php");


// Turn off database compatibility mode
$phpAds_config['compatibility_mode'] = false;

// Open the database connection
$link = phpAds_dbConnect();
if (!$link)
{
	phpAds_PageHeader('');
	phpAds_Die ("A fatal error occurred", $phpAds_productname." can't connect to the database, 
										   please make sure the database is working 
										   and ".$phpAds_productname." is configured correctly");
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
		
		
		// Check PHP version < 4.0.3
		if ($phpversion < 4003)
			$fatal[] = str_replace ('{php_version}', phpversion(), $strWarningPHPversion);
		
		// Check file_uploads
		if (ini_get ('file_uploads') != true)
			$fatal[] = $strWarningFileUploads;
		
		// Check magic_quotes_sybase
		if (ini_get ('magic_quotes_sybase') != false)
			$fatal[] = $strWarningMagicQuotesSybase;
		
		// Check for PREG extention
		if (!function_exists('preg_match'))
			$fatal[] = $strWarningPREG;
		
		
		// Check if config file is writable
		if (!phpAds_isConfigWritable())
			$fatal[] = $strConfigLockedDetected;
		
		
		// Check if the cache dir is writable, if needed
		if (isset($phpAds_config['delivery_caching']) && $phpAds_config['delivery_caching'] == 'file')
		{
			if ($fp = @fopen(phpAds_path.'/cache/available', 'wb'))
			{
				@fclose($fp);
				@unlink(phpAds_path.'/cache/available');
			}
			else
			{
				$fatal[] = $strCacheLockedDetected;
			}
		}
		
		
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
		

		// Check the integerity of the uploaded files
		if ($result = phpAds_revisionCheck())
			list ($rev_direct, $rev_fatal, $rev_message) = $result;

		
		// Repeat proceed request if config still not writeable
		if (count($fatal) || (isset($rev_direct) && !isset($ignore)))
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
		
		if (count($fatal) || isset($rev_direct))
		{
			echo "<br><br><div class='errormessage'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
			echo "<span class='tab-r'>".$strMayNotFunction."</span><br><br>".$strFixProblemsBefore."<ul>";
			
			for ($r=0;$r<count($fatal);$r++)
				echo "<li>".$fatal[$r]."</li>";
			
			if (isset($rev_direct))
				for ($r=0;$r<count($rev_message);$r++)
					echo "<li>".$rev_message[$r]."</li>";			
			
			echo "</ul>".$strFixProblemsAfter."<br><br></div>";
		}
		
		echo "</td></tr></table>";
		echo "<br><br>";
		phpAds_ShowBreak();
		echo "<br>";
		
		
		// Determine the text of the button
		$btn = $strProceed;											// Default to Proceed
		
		if (isset($fatal) && count($fatal))
			$btn = $GLOBALS['strRetry'];							// Configuration errors -> allow a retry
		
		if (isset($rev_message))
		{
			if ($rev_fatal)
				$btn = '';											// Fatal integrety error -> do not show
			else
				if (!isset($fatal) || !count($fatal))				// Unless configuration error
					$btn = $GLOBALS['strIgnoreWarnings'];			// Integrety warning -> ignore
		}
		
		if ($btn != '')
		{
			if ($btn == $GLOBALS['strIgnoreWarnings'])
				echo "<input type='hidden' name='ignore' value='true'>";
		
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr><td align='right'>";
			echo "<input type='submit' name='proceed' value='".$btn."'>";
			echo "</td></tr></table>\n\n";
		}

		echo "<input type='hidden' name='step' value='2'>";
		echo "</form>";
	}
	elseif ($upgrade && $step == 2)
	{
		require ("lib-statistics.inc.php");
		require ("lib-storage.inc.php");
		require ("lib-banner.inc.php");
		require ("lib-zones.inc.php");

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
		
		echo "<form name='upgrade' method='post' action='upgrade.php'>";
		echo "<input type='hidden' name='step' value='3'>";
		echo "<br><br><div class='errormessage'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
		echo "<span class='tab-r'>".$strUpdateError."</span><br><br>".$strUpdateDatabaseError."<br><br>";
		echo "<input type='submit' name='ignore' value='".$strIgnoreErrors."'>&nbsp;&nbsp;";
		echo "<input type='submit' name='retry' value='".$strRetryUpdate."'>";
		echo "<br><br></div></form>";
	}
	elseif ($step == 4)
	{
		require ("lib-statistics.inc.php");
		require ("lib-storage.inc.php");
		require ("lib-banner.inc.php");
		require ("lib-zones.inc.php");

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
		require ("lib-statistics.inc.php");
		require ("lib-storage.inc.php");
		require ("lib-banner.inc.php");
		require ("lib-zones.inc.php");

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
		
		// Force update check on dev builds if currently upgrading to a dev-build.
		if ($phpAds_version_development)
			phpAds_SettingsWriteAdd('updates_dev_builds', true);
		
		// Upgrade Geotargeting plugins
		if ($phpAds_config['config_version'] < 200.245 && $phpAds_config['geotracking_type'])
		{
			if (strpos($phpAds_config['geotracking_type'], 'geoip') === 0)
			{
				$phpAds_config['geotracking_type'] = 'geoip';
				phpAds_SettingsWriteAdd('geotracking_type', 'geoip');
			}
		}
		
		// Recreate geotargeting configuration
		if ($phpAds_config['geotracking_type'])
		{
			@include(phpAds_path.'/libraries/geotargeting/geo-'.$phpAds_config['geotracking_type'].'.inc.php');
						
			if (function_exists('phpAds_'.$phpAds_geoPluginID.'_getConf'))
				$geoconf = call_user_func('phpAds_'.$phpAds_geoPluginID.'_getConf', $phpAds_config['geotracking_location']);
			else
				$geoconf = '';
			
			phpAds_SettingsWriteAdd('geotracking_conf', $geoconf);
		}
		
		// Local socket connection do db
		if ($phpAds_config['config_version'] < 200.261 && $phpAds_config['dbhost']{0} == ':')
		{
			phpAds_SettingsWriteAdd('dblocal', true);
		}
		
		// MySQL 4 compatibility mode
		if ($phpAds_config['config_version'] < 200.281)
		{
			phpAds_SettingsWriteAdd('mysql4_compatibility', phpAds_dbQuery("SET SESSION sql_mode='MYSQL40'"));
		}
		
		// Instance ID
		if ($phpAds_config['config_version'] < 200.287 || empty($phpAds_config['instance_id']))
		{
			phpAds_SettingsWriteAdd('instance_id', phpAds_ConfigGenerateId());
		}

		phpAds_ConfigFileUpdateFlush();
		
		phpAds_PageHeader("1");
		echo "<br><br>";
		phpAds_ShowBreak();
		
		echo "<form name='upgrade' method='post' action='index.php'>";
		echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
		echo "<img src='images/install-success.gif'></td><td width='100%' valign='top'>";
		echo "<br><span class='tab-s'>".$strCongratulations."</span><br>";
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