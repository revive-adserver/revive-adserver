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



// Tell to all includes that we are installing
define('phpAds_installing', 1);


// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', substr(__FILE__, 0, (strlen(__FILE__) - strpos(strrev(__FILE__), strrev('admin')) - strlen('admin') - 1)));
else
    define ('phpAds_path', '..');


// Include config file
require ("../config.inc.php");


// Register input variables
require ("../libraries/lib-io.inc.php");
phpAds_registerGlobal ('installvars', 'language', 'phase', 'dbhost', 'dbuser', 'dbpassword', 'dbname', 'table_prefix', 
					   'table_type', 'admin', 'admin_pw', 'admin_pw2', 'url_prefix');


// Set URL prefix
$phpAds_config['url_prefix'] = strtolower(eregi_replace("^([a-z]+)/.*$", "\\1://",
	$HTTP_SERVER_VARS['SERVER_PROTOCOL'])).$HTTP_SERVER_VARS['HTTP_HOST'].
	ereg_replace("/admin/install.php(\?.*)?$", "", $HTTP_SERVER_VARS['PHP_SELF']);


// Overwrite settings with install vars
if (isset($installvars) && is_array($installvars))
	for (reset($installvars); $key=key($installvars); next($installvars))
		$phpAds_config[$key] = $installvars[$key];


// Overwrite language if not set
if (!isset($installvars['language']) && isset($language))
	$phpAds_config['language'] = $language;


// Load language strings
if (!isset($phpAds_config['language']))
	$phpAds_config['language'] = 'english';

@include (phpAds_path.'/language/english/default.lang.php');
if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php'))
	@include (phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php');
else
	$phpAds_config['language'] = 'english';


// Include other required files
require ("../libraries/lib-db.inc.php");
require ("../libraries/lib-dbconfig.inc.php");
require ("lib-install-db.inc.php");
require ("lib-permissions.inc.php");
require ("lib-gui.inc.php");
require ("lib-languages.inc.php");


// Load settings/install language strings
@include (phpAds_path.'/language/english/settings.lang.php');
if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/settings.lang.php'))
	@include (phpAds_path.'/language/'.$phpAds_config['language'].'/settings.lang.php');


// Include other required files
require ("lib-settings.inc.php");


// If an old config.inc.php is present, upgrade!
if (!defined('phpAds_installed'))
{
	header("Location: upgrade.php");
	exit;
}



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
if (!isset($phpAds_config['admin']))
	$phpAds_username = $phpAds_config['admin'] = '';
else
	$phpAds_username = $phpAds_config['admin'];

if (!isset($phpAds_config['admin_pw']))
	$phpAds_password = $phpAds_config['admin_pw'] = '';
else
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
	if (!isset($phase))
		$phase = 0;
	
	$errormessage = array();
	
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
			if ($phpversion < 4000)
				$fatal[] = str_replace ('{php_version}', phpversion(), $strWarningPHPversion);
			
			// Check database extention
			if (!phpAds_dbAvailable())
				$fatal[] = $strWarningDBavailable;
			
			// Config variables can only be checked with php 4
			if ($phpversion >= 4000)
			{
				// Check file_uploads
				if (ini_get ('file_uploads') != true)
					  $fatal[] = $strWarningFileUploads;
				
				// Check track_vars
				if ($phpversion < 4030 &&
					ini_get ('track_vars') != true)
					$fatal[] = $strWarningTrackVars;
			}
			
			
			// Check for PREG extention
			if (!function_exists('preg_match'))
				$fatal[] = $strWarningPREG;
			
			
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
			if (isset($dbpassword) && ereg('^\*+$', $dbpassword))
				$dbpassword = $phpAds_config['dbpassword'];
			
			
			$phpAds_config['compatibility_mode'] = false;
			$phpAds_config['dbhost'] 	 		 = $dbhost;
			$phpAds_config['dbuser'] 	 		 = $dbuser;
			$phpAds_config['dbpassword'] 		 = $dbpassword;
			$phpAds_config['dbname'] 	 		 = $dbname;
			
			
			if (!phpAds_dbConnect())
				$errormessage[0][] = $strCouldNotConnectToDB;
			else
			{
				// Drop test table if one exists
				phpAds_dbQuery ("DROP TABLE phpads_tmp_dbpriviligecheck");
				
				// Check if phpAdsNew can create tables
				phpAds_dbQuery ("CREATE TABLE phpads_tmp_dbpriviligecheck (tmp int)");
				
				if (phpAds_dbAffectedRows() >= 0)
					phpAds_dbQuery ("DROP TABLE phpads_tmp_dbpriviligecheck");
				else
					$errormessage[0][] = $strCreateTableTestFailed;
				
				// Check table type
				if (phpAds_tableTypesSupported && !phpAds_checkTableType($table_type))
					$errormessage[1][] = $strTableWrongType
			}
			
			// Check table prefix
			if (strlen($table_prefix) && !eregi("^[a-z][a-z0-9_]*$", $table_prefix))
				$errormessage[1][] = $strTablePrefixInvalid;
			
			
			if (!isset($errormessage) || !count($errormessage))
			{
				$installvars['dbhost'] 	 	 = $dbhost;
				$installvars['dbuser'] 		 = $dbuser;
				$installvars['dbpassword'] 	 = $dbpassword;
				$installvars['dbname'] 		 = $dbname;
				$installvars['table_prefix'] = $table_prefix;
				$installvars['table_type'] 	 = $table_type;
				
				// Create table names
				$phpAds_config['tbl_clients'] 	 = $installvars['tbl_clients']    = $table_prefix.'clients';
				$phpAds_config['tbl_banners']    = $installvars['tbl_banners']    = $table_prefix.'banners';
				$phpAds_config['tbl_adstats']    = $installvars['tbl_adstats']    = $table_prefix.'adstats';
				$phpAds_config['tbl_adviews']    = $installvars['tbl_adviews']    = $table_prefix.'adviews';
				$phpAds_config['tbl_adclicks']   = $installvars['tbl_adclicks']   = $table_prefix.'adclicks';
				$phpAds_config['tbl_acls'] 	     = $installvars['tbl_acls'] 	  = $table_prefix.'acls';
				$phpAds_config['tbl_session']    = $installvars['tbl_session']    = $table_prefix.'session';
				$phpAds_config['tbl_zones'] 	 = $installvars['tbl_zones'] 	  = $table_prefix.'zones';
				$phpAds_config['tbl_config'] 	 = $installvars['tbl_config'] 	  = $table_prefix.'config';
				$phpAds_config['tbl_affiliates'] = $installvars['tbl_affiliates'] = $table_prefix.'affiliates';
				$phpAds_config['tbl_images'] 	 = $installvars['tbl_images'] 	  = $table_prefix.'images';
				$phpAds_config['tbl_userlog'] 	 = $installvars['tbl_userlog'] 	  = $table_prefix.'userlog';
				$phpAds_config['tbl_cache'] 	 = $installvars['tbl_cache'] 	  = $table_prefix.'cache';
				$phpAds_config['tbl_targetstats'] = $installvars['tbl_targetstats'] = $table_prefix.'targetstats';
				
				if (phpAds_checkDatabase())
				{
					$errormessage[1][] = $strTableInUse;
				}
				else
				{
					// Go to next phase
					$phase = 3;
				}
			}
			
			break;
			
			
		case 3:
			// Setup username / password check
			$admin = trim($admin);
			
			if (!strlen($admin) || !strlen($admin_pw))
				$errormessage[0][] = $strInvalidUserPwd;
			
			if (strlen($admin_pw) && $admin_pw != $admin_pw2)
				$errormessage[0][] = $strNotSamePasswords;
			
			
			if (!isset($errormessage) || !count($errormessage))
			{
				$installvars['admin'] 		 = $admin;
				$installvars['admin_pw'] 	 = $admin_pw;
				$installvars['url_prefix']   = $url_prefix;
				
				if (phpAds_isConfigWritable())
				{
					// Connect
					if (phpAds_dbConnect())
					{
						if (phpAds_createDatabase($phpAds_config['table_type']))
						{
							// Insert basic settings into database and config file
							phpAds_SettingsWriteAdd('config_version', $phpAds_version);
							phpAds_SettingsWriteAdd('language', $installvars['language']);
							
							phpAds_SettingsWriteAdd('dbhost', $installvars['dbhost']);
							phpAds_SettingsWriteAdd('dbuser', $installvars['dbuser']);
							phpAds_SettingsWriteAdd('dbpassword', $installvars['dbpassword']);
							phpAds_SettingsWriteAdd('dbname', $installvars['dbname']);
							phpAds_SettingsWriteAdd('table_prefix', $installvars['table_prefix']);
							phpAds_SettingsWriteAdd('table_type', $installvars['table_type']);
							
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
							phpAds_SettingsWriteAdd('tbl_userlog', $installvars['tbl_userlog']);
							phpAds_SettingsWriteAdd('tbl_cache', $installvars['tbl_cache']);
							phpAds_SettingsWriteAdd('tbl_targetstats', $installvars['tbl_targetstats']);
							
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
	if ($phase > 0) echo "<b><a href='javascript:toggleHelp();'><img src='images/help-book.gif' width='15' height='15' border='0' align='absmiddle'>&nbsp;".$strHelp."</a></b>";
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
			echo "<form name='installform' method='post' action='install.php' onSubmit='return phpAds_formCheck(this);'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>".$strInstallMessage."</td></tr></table><br><br>";
			
			phpAds_ShowBreak();
			
			phpAds_ShowSettings(array (
				array (
					'text' 	  => $strChooseInstallLanguage,
					'items'	  => array (
						array (
							'type' 	  => 'select', 
							'name' 	  => 'language',
							'text' 	  => $strLanguage,
							'items'   => phpAds_AvailableLanguages()
						)
					)
				)
			), $errormessage);
			
			break;
			
			
		case 2:
			// Database settings
			echo "<form name='installform' method='post' action='install.php' onSubmit='return phpAds_formCheck(this);'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>".$strInstallMessage."</td></tr></table><br><br>";
			
			phpAds_ShowBreak();
			
			phpAds_ShowSettings(array (
				array (
					'text' 	  => $strDatabaseSettings,
					'items'	  => array (
						array (
							'type' 	  => 'text', 
							'name' 	  => 'dbhost',
							'text' 	  => $strDbHost,
							'req'	  => true
						),
						array (
							'type'    => 'break'
						),
						array (
							'type' 	  => 'text', 
							'name' 	  => 'dbuser',
							'text' 	  => $strDbUser,
							'req'	  => true
						),
						array (
							'type'    => 'break'
						),
						array (
							'type' 	  => 'password', 
							'name' 	  => 'dbpassword',
							'text' 	  => $strDbPassword,
							'req'	  => true
						),
						array (
							'type'    => 'break'
						),
						array (
							'type' 	  => 'text', 
							'name' 	  => 'dbname',
							'text' 	  => $strDbName,
							'req'	  => true
						)
					)
				),
				array (
					'text' 	  => $strAdvancedSettings,
					'items'	  => array (
						array (
							'type' 	  => 'text', 
							'name' 	  => 'table_prefix',
							'text' 	  => $strTablesPrefix,
							'req'	  => true
						),
						array (
							'type'    => 'break',
							'visible' => phpAds_tableTypesSupported
						),
						array (
							'type' 	  => 'select', 
							'name' 	  => 'table_type',
							'text' 	  => $strTablesType,
							'items'   => phpAds_getTableTypes(),
							'visible' => phpAds_tableTypesSupported
						)
					)
				)
			), $errormessage);
			
			break;
			
			
		case 3:
			// Admin settings
			echo "<form name='installform' method='post' action='install.php' onSubmit='return phpAds_formCheck(this);'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>".$strInstallMessage."</td></tr></table><br><br>";
			
			$phpAds_config['admin_pw'] = '';
			
			phpAds_ShowBreak();
			
			phpAds_ShowSettings(array (
				array (
					'text' 	  => $strAdminSettings,
					'items'	  => array (
						array (
							'type' 	  => 'text', 
							'name' 	  => 'admin',
							'text' 	  => $strUsername,
							'size'	  => 25,
							'req'	  => true
						),
						array (
							'type'    => 'break'
						),
						array (
							'type' 	  => 'password', 
							'name' 	  => 'admin_pw',
							'text' 	  => $strNewPassword,
							'size'	  => 25,
							'req'	  => true
						),
						array (
							'type'    => 'break'
						),
						array (
							'type' 	  => 'password', 
							'name' 	  => 'admin_pw2',
							'text' 	  => $strRepeatPassword,
							'size'	  => 25,
							'check'	  => 'compare:admin_pw',
							'req'	  => true
						)
					)
				),
				array (
					'text' 	  => $strOtherSettings,
					'items'	  => array (
						array (
							'type' 	  => 'text', 
							'name' 	  => 'url_prefix',
							'text' 	  => $strUrlPrefix,
							'size'	  => 35,
							'check'	  => 'url',
							'req'	  => true
						)
					)
				)
			), $errormessage);
			
			break;
			
			
		case 4:
			// Admin settings
			if (!isset($fatal) || !count($fatal))
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
	
	if (isset($installvars) && count($installvars))
		for (reset($installvars); $key=key($installvars); next($installvars))
			echo "<input type='hidden' name='installvars[".$key."]' value='".$installvars[$key]."'>\n";
	
	echo "<input type='hidden' name='phase' value='".$phase."'>\n";
	echo "</form>";
}

echo "<br><br>";

phpAds_PageFooter();

?>