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



// Tell to all includes that we are installing
define('phpAds_installing', 1);

// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', substr(__FILE__, 0, strpos(__FILE__, 'admin') - 1));
else
    define ('phpAds_path', '.');




// Include config file
require ("../config.inc.php");

// Set URL prefix
$phpAds_config['url_prefix'] = strtolower(eregi_replace("^([a-z]+)/.*$", "\\1://",
	$SERVER_PROTOCOL)).$HTTP_HOST.
	ereg_replace("/admin/install.php(\?.*)?$", "", $REQUEST_URI);

// Overwrite settings with install vars
if (isset($installvars) && is_array($installvars))
	for (reset($installvars); $key=key($installvars); next($installvars))
		$phpAds_config[$key] = $installvars[$key];



// Load language strings
if (!isset($phpAds_config['language']))
	$phpAds_config['language'] = 'english';

include('../language/'.$phpAds_config['language'].'/default.lang.php');
include('../language/'.$phpAds_config['language'].'/settings.lang.php');



// Include other required files
require ("../lib-db.inc.php");
require ("../lib-dbconfig.inc.php");
require ("lib-install-db.inc.php");
require ("lib-permissions.inc.php");
require ("lib-gui.inc.php");
require ("lib-languages.inc.php");
require ("lib-install.inc.php");
require ("lib-settings.inc.php");




// If an old config.inc.php is present, upgrade!
if (!defined('phpAds_installed'))
{
	header("Location: upgrade.php");
	exit;
}




// GUI Settings
$phpAds_settings_sections = array(
	"0.1.1"		=> $strChooseInstallLanguage,
	"0.2.1"		=> $strDatabaseSettings,
	"0.2.2"		=> $strAdvancedSettings,
	"0.3.1"		=> $strAdminSettings,
	"0.3.2"		=> $strOtherSettings
);





/*********************************************************/
/* Begin of code                                         */
/*********************************************************/

// Check if already installed
if (phpAds_installed)
{
	phpAds_PageHeader('');
	phpAds_Die ($strFatalError, $strAlreadyInstalled);
}


// First thing to do is clear the $Session variable to
// prevent users from pretending to be logged in.
$Session = array('loggedin' => 't', 'usertype' => phpAds_Admin);
$phpAds_cookiecheck = $SessionID = 'install';


// Fake authorize the user and load user specific settings.
$phpAds_username = $phpAds_config['admin'];
$phpAds_password = $phpAds_config['admin_pw'];
phpAds_Start();


// Setup navigation
$phpAds_nav = array (
	"admin"	=> array (
		"1"					=>  array("install.php" => $strInstall)
	)
);


// Security check
phpAds_checkAccess(phpAds_Admin);


if (phpAds_isUser(phpAds_Admin))
{
	if (isset($HTTP_POST_VARS['phase']))
		$phase = $HTTP_POST_VARS['phase'];
	else
		$phase = 0;
	
	
	
	// Process information
	switch($phase)
	{
		case 0:
			// Determine the PHP version
			ereg ("^([0-9]{1})\.([0-9]{1})\.([0-9]{1,2})", phpversion(), $matches);
			$phpversion = sprintf ("%01d%01d%02d", $matches[1], $matches[2], $matches[3]);
			
			// Store fatal errors
			$fatal = array();
			
			// Check PHP version
			if ($phpversion < 3008)
				$fatal[] = str_replace ('{php_version}', phpversion(), $strWarningPHPversion);
			
			// Config variables can only be checked with php 4
			if ($phpversion >= 4000)
			{
				// Check register_globals
				if (ini_get ('register_globals') != true)
					$fatal[] = $strWarningRegisterGlobals;
				
				// Check magic_quote_gpc
				if (ini_get ('magic_quotes_gpc') != true)
					$fatal[] = $strWarningMagicQuotesGPC;
				
				// Check magic_quotes_runtime
				if (ini_get ('magic_quotes_runtime') != false)
					$fatal[] = $strWarningMagicQuotesRuntime;
			}
			
			// Check if config file is writable
			if (!phpAds_isConfigWritable())
				$fatal[] = $strConfigLockedDetected;
			
			
			if (count($fatal) > 0)
				$phase = 0;
			else
				$phase = 1;
			
			break;
			
			
		case 1:
			// Set language
			$installvars['language'] = $language;
			
			// Go to next phase
			$phase = 2;
			break;
			
			
		case 2:
			// Setup database check
			$phpAds_config['compatibility_mode'] = false;
			$phpAds_config['dbhost'] 	 		 = $dbhost;
			$phpAds_config['dbuser'] 	 		 = $dbuser;
			$phpAds_config['dbpassword'] 		 = $dbpassword;
			$phpAds_config['dbname'] 	 		 = $dbname;
			
			if (!phpAds_dbConnect())
				$errormessage[1][] = $strCouldNotConnectToDB;
			else
			{
				// Drop test table if one exists
				phpAds_dbQuery ("DROP TABLE phpads_tmp_dbpriviligecheck");
				
				// Check if phpAdsNew can create tables
				if (!phpAds_dbQuery ("CREATE TABLE phpads_tmp_dbpriviligecheck (tmp int)"))
				{
					// Failed
					$errormessage[1][] = $strCreateTableTestFailed;
				}
				else
				{
					// Passed all test, now drop the test table
					phpAds_dbQuery ("DROP TABLE phpads_tmp_dbpriviligecheck");
				}
			}
			
			// Check table prefix
			if (strlen($table_prefix) && !eregi("^[a-z][a-z0-9_]*$", $table_prefix))
				$errormessage[2][] = $strTablePrefixInvalid;
			
			
			if (!count($errormessage))
			{
				$installvars['dbhost'] 	 = $dbhost;
				$installvars['dbuser'] 		 = $dbuser;
				$installvars['dbpassword'] 	 = $dbpassword;
				$installvars['dbname'] 		 = $dbname;
				$installvars['table_prefix'] 	 = $table_prefix;
				$installvars['tabletype'] 	 = $tabletype;
				
				// Create table names
				$installvars['tbl_clients']  = $table_prefix.'clients';
				$installvars['tbl_banners']  = $table_prefix.'banners';
				$installvars['tbl_adstats']  = $table_prefix.'adstats';
				$installvars['tbl_adviews']  = $table_prefix.'adviews';
				$installvars['tbl_adclicks'] = $table_prefix.'adclicks';
				$installvars['tbl_acls'] 	 = $table_prefix.'acls';
				$installvars['tbl_session']  = $table_prefix.'session';
				$installvars['tbl_zones'] 	 = $table_prefix.'zones';
				$installvars['tbl_config'] 	 = $table_prefix.'config';
				$installvars['tbl_affiliates'] 	 = $table_prefix.'affiliates';
				$installvars['tbl_images'] 	 = $table_prefix.'images';
				
				// Go to next phase
				$phase = 3;
			}
			
			break;
			
			
		case 3:
			// Setup username / password check
			$admin = trim(strtolower($admin));
			
			if (!strlen($admin) || !strlen($admin_pw))
				$errormessage[1][] = $strInvalidUserPwd;
			
			if (strlen($admin_pw) && $admin_pw != $admin_pw2)
				$errormessage[1][] = $strNotSamePasswords;
			
			
			if (!count($errormessage))
			{
				$installvars['admin'] 		 = $admin;
				$installvars['admin_pw'] 	 = $admin_pw;
				$installvars['url_prefix']   = $url_prefix;
				
				if (phpAds_isConfigWritable())
				{
					// Connect
					if (phpAds_dbConnect())
					{
						if (phpAds_createDatabase($phpAds_config['tabletype']))
						{
							// Insert basic settings into database and config file
							phpAds_SettingsWriteAdd('config_version', $phpAds_version);
							phpAds_SettingsWriteAdd('language', $installvars['language']);
							
							phpAds_SettingsWriteAdd('dbhost', $installvars['dbhost']);
							phpAds_SettingsWriteAdd('dbuser', $installvars['dbuser']);
							phpAds_SettingsWriteAdd('dbpassword', $installvars['dbpassword']);
							phpAds_SettingsWriteAdd('dbname', $installvars['dbname']);
							phpAds_SettingsWriteAdd('table_prefix', $installvars['table_prefix']);
							
							phpAds_SettingsWriteAdd('tbl_clients', $installvars['tbl_clients']);
							phpAds_SettingsWriteAdd('tbl_banners', $installvars['tbl_banners']);
							phpAds_SettingsWriteAdd('tbl_adstats', $installvars['tbl_adstats']);
							phpAds_SettingsWriteAdd('tbl_adviews', $installvars['tbl_adviews']);
							phpAds_SettingsWriteAdd('tbl_adclicks', $installvars['tbl_adclicks']);
							phpAds_SettingsWriteAdd('tbl_acls', $installvars['tbl_acls']);
							phpAds_SettingsWriteAdd('tbl_session', $installvars['tbl_session']);
							phpAds_SettingsWriteAdd('tbl_zones', $installvars['tbl_zones']);
							phpAds_SettingsWriteAdd('tbl_config', $installvars['tbl_config']);
							phpAds_SettingsWriteAdd('tbl_affiliates', $installvars['tbl_affiliates']);
							phpAds_SettingsWriteAdd('tbl_images', $installvars['tbl_images']);
							
							phpAds_SettingsWriteAdd('table_prefix', $installvars['table_prefix']);

							phpAds_SettingsWriteAdd('admin', $admin);
							phpAds_SettingsWriteAdd('admin_pw', $admin_pw);
							phpAds_SettingsWriteAdd('url_prefix', $url_prefix);
							
							phpAds_ConfigFileClear();
							
							if (!phpAds_SettingsWriteFlush())
								$fatal[] = $strErrorInstallConfig;
						}
						else
							$fatal[] = $strErrorInstallDatabase;
					}
					else
						$fatal[] = $strErrorInstallDbConnect;
				}
				else
					$fatal[] = $strConfigLockedDetected;
				
				$phase = 4;
			}
			
			break;
			
			
		default:
			break;
	}
	
	
	
	
	
	
	// Prepare helpsystem
	if ($phase > 0)
		phpAds_PrepareHelp();
	
	// Create GUI
	phpAds_PageHeader("1");
	
	// Prepare helpbutton
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'><tr><td height='20' align='right'>";
	if ($phase > 0) echo "<b><a href='javascript:toggleHelp();'><img src='images/help-book.gif' width='15' height='15' border='0' align='absmiddle'>&nbsp;Help</a></b>";
	echo "</td></tr></table>";
	
	phpAds_ShowBreak();
	
	
	
	
	
	switch($phase)
	{
		case 0:
			// Preconditions failed
			echo "<form name='installform' method='post' action='install.php'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>".$strInstallMessage."</td></tr></table>";
			
			if (count($fatal))
			{
				echo "<br><br>";
				echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
				echo "<tr><td><img src='images/error.gif'>&nbsp;&nbsp;</td>";
				echo "<td width='100%'><span class='tab-r'>".$strMayNotFunction."</span></td></tr>";
				for ($r=0;$r<count($fatal);$r++)
					echo "<tr><td>&nbsp;</td><td><span class='install'>".$fatal[$r]."</span></td></tr>";
				echo "</table>";
			}
			
			break;
			
			
		case 1:
			// Language selection
			echo "<form name='installform' method='post' action='install.php'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>".$strInstallMessage."</td></tr></table><br><br>";
			
			phpAds_ShowBreak();
			
			phpAds_StartSettings();
				phpAds_AddSettings('start_section', "0.1.1");
				phpAds_AddSettings('select', 'language', array($strLanguage, phpAds_AvailableLanguages()));
				phpAds_AddSettings('end_section', '');
			phpAds_EndSettings();
			phpAds_FlushSettings();
			break;
			
			
		case 2:
			// Database settings
			echo "<form name='installform' method='post' action='install.php'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>".$strInstallMessage."</td></tr></table><br><br>";
			
			phpAds_ShowBreak();
			
			$phpAds_config['dbpassword'] = '';
			
			phpAds_StartSettings();
				phpAds_AddSettings('start_section', "0.2.1");
				phpAds_AddSettings('text', 'dbhost', $strDbHost);
				phpAds_AddSettings('break', '');
				phpAds_AddSettings('text', 'dbuser', $strDbUser);
				phpAds_AddSettings('break', '');
				phpAds_AddSettings('text', 'dbpassword', array($strDbPassword, 25, 'password'));
				phpAds_AddSettings('break', '');
				phpAds_AddSettings('text', 'dbname', $strDbName);
				phpAds_AddSettings('end_section', '');
				
				phpAds_AddSettings('start_section', "0.2.2");
				phpAds_AddSettings('text', 'table_prefix', $strTablesPrefix);
				
				if (phpAds_tableTypesSupported)
				{
					phpAds_AddSettings('break', '');
					phpAds_AddSettings('select', 'tabletype', array($strTablesType, phpAds_getTableTypes()));
				}
				
				phpAds_AddSettings('end_section', '');
			phpAds_EndSettings();
			phpAds_FlushSettings();
			break;
			
			
		case 3:
			// Admin settings
			echo "<form name='installform' method='post' action='install.php'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>".$strInstallMessage."</td></tr></table><br><br>";
			
			phpAds_ShowBreak();
			
			$phpAds_config['admin_pw'] = '';
			
			phpAds_StartSettings();
				phpAds_AddSettings('start_section', "0.3.1");
				phpAds_AddSettings('text', 'admin', $strUsername);
				phpAds_AddSettings('break', '');
				phpAds_AddSettings('text', 'admin_pw', array($strPassword, 25, 'password'));
				phpAds_AddSettings('break', '');
				phpAds_AddSettings('text', 'admin_pw2',	array($strRepeatPassword, 25, 'password'));
				phpAds_AddSettings('end_section', '');
				
				phpAds_AddSettings('start_section', "0.3.2");
				phpAds_AddSettings('text', 'url_prefix', array($strUrlPrefix, 35));
				phpAds_AddSettings('end_section', '');
			phpAds_EndSettings();
			phpAds_FlushSettings();
			break;
			
			
		case 4:
			// Admin settings
			if (count($fatal) == 0)
			{
				echo "<form name='installform' method='post' action='settings-index.php'>";
				echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
				echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
				echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
				echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
				echo "<span class='install'>".$strInstallSuccess."</td></tr></table><br><br>";
			}
			else
			{
				echo "<form name='installform' method='post' action='settings-index.php'>";
				echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
				echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
				echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
				echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
				echo "<span class='install'>".$strInstallNotSuccessful."</td></tr></table><br><br>";
				
				echo "<br><br>";
				echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'>";
				echo "<tr><td><img src='images/error.gif'>&nbsp;&nbsp;</td>";
				echo "<td width='100%'><span class='tab-r'>".$strErrorOccured."</span></td></tr>";
				for ($r=0;$r<count($fatal);$r++)
					echo "<tr><td>&nbsp;</td><td><span class='install'>".$fatal[$r]."</span></td></tr>";
				echo "</table>";
			}
			
			break;
			
			
		default:
			break;
	}
	
	
	
	echo "<br><br>";
	phpAds_ShowBreak();
	echo "<br>";
	
	
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'><tr><td align='right'>";
	echo "<input type='submit' name='proceed' value='".$strProceed."'>";
	echo "</td></tr></table>\n\n";
	
	if (count($installvars))
		for (reset($installvars); $key=key($installvars); next($installvars))
			echo "<input type='hidden' name='installvars[".$key."]' value='".$installvars[$key]."'>\n";
	
	echo "<input type='hidden' name='phase' value='".$phase."'>\n";
	echo "</form>";
}

echo "<br><br>";

phpAds_PageFooter();

?>