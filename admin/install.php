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

// Unserialize cookie stored settings
$installvars = isset($installvars) ?
	unserialize(stripslashes($installvars)) :
	array('install_phase' => 0, 'language' => 'english');
while(list($k, $v) = each($installvars))
	$phpAds_config[$k] = $v;



// Load language strings
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
		"1"					=>  array("install.php" => $strInstall),
		  "1.1"				=>	array("install.php?phase=1" => $strLanguageSelection),
		  "1.2"				=>  array("install.php?phase=2" => $strDatabaseSettings),
		  "1.3"				=>  array("install.php?phase=3" => $strAdminSettings),
		  "1.4"				=>  array("install.php?phase=4" => $strStartInstall)
	)
);


// Security check
phpAds_checkAccess(phpAds_Admin);


if (phpAds_isUser(phpAds_Admin))
{
	if (!isset($phase))
		$phase = 0;
	elseif ($phase > $phpAds_config['install_phase'])
		$phase = $phpAds_config['install_phase'];
	
	if ($phpAds_install_phase < 4)
	{
		$sections = array();
		for ($x = 1; $x <= $phpAds_config['install_phase'] && $x < 4; $x++)
			$sections[] = "1.$x";
	}
	else
		$sections = array('1.'.$phpAds_config['install_phase']);
	
	$errormessage = array();
	
	if (!phpAds_isConfigWritable())
		$errormessage[1][] = $strConfigNotWritable;	
	
	switch($phase)
	{
		case 1:
			
			if (isset($language))
			{
				if (!count($errormessage))
				{
					$installvars['language'] = $language;
					if ($phpAds_config['install_phase'] < 2)
						$installvars['install_phase'] = 2;
					setcookie('installvars', serialize($installvars));
					header("Location: $PHP_SELF?phase=2");
					exit;
				}
			}
			
			// Language selection and warnings
			phpAds_StartSettings();		
			phpAds_AddSettings('start_section', "0.1.1");
			phpAds_AddSettings('select', 'language',
				array($strLanguage, phpAds_AvailableLanguages()));
			phpAds_AddSettings('end_section', '');
			phpAds_EndSettings();		
			
			$header = "1.1";
			$phase = 1;
			
			break;
			
		case 2:
			
			if (isset($dbhost))
			{
				$phpAds_config['dbhost'] = $dbhost;
				$phpAds_config['dbuser'] = $dbuser;
				$phpAds_config['dbpassword'] = $dbpassword;
				$phpAds_config['dbname'] = $dbname;
				
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
						// Check if phpAdsNew can alter tables
						if (phpAds_dbQuery ("ALTER TALBE phpads_tmp_dbpriviligecheck CHANGE tmp tmp2 int"))
						{
							// Failed
							$errormessage[1][] = $strUpdateTableTestFailed;
						}
						else
						{
							// Passed all test, now drop the test table
							phpAds_dbQuery ("DROP TABLE phpads_tmp_dbpriviligecheck");
						}
					}
				}
				
				if (strlen($tbl_prefix) && !eregi("^[a-z][a-z0-9_]*$", $tbl_prefix))
					$errormessage[2][] = $strTablePrefixInvalid;
					
				if (!count($errormessage))
				{
					$installvars['dbhostname'] = $dbhost;
					$installvars['dbuser'] = $dbuser;
					$installvars['dbpassword'] = $dbpassword;
					$installvars['dbname'] = $dbname;
					$installvars['tbl_prefix'] = $tbl_prefix;
					$installvars['tabletype'] = $tabletype;
					
					// Create table names
					$installvars['tbl_clients'] = $tbl_prefix.'clients';
					$installvars['tbl_banners'] = $tbl_prefix.'banners';
					$installvars['tbl_adstats'] = $tbl_prefix.'adstats';
					$installvars['tbl_adviews'] = $tbl_prefix.'adviews';
					$installvars['tbl_adclicks'] = $tbl_prefix.'adclicks';
					$installvars['tbl_acls'] = $tbl_prefix.'acls';
					$installvars['tbl_session'] = $tbl_prefix.'session';
					$installvars['tbl_zones'] = $tbl_prefix.'zones';
					$installvars['tbl_config'] = $tbl_prefix.'config';
					
					if ($phpAds_config['install_phase'] < 3)
						$installvars['install_phase'] = 3;
					setcookie('installvars', serialize($installvars));
					header("Location: $PHP_SELF?phase=3");
					exit;
				}
			}
			
			// Database settings			
			if (!isset($phpAds_config['tbl_prefix']))
				$phpAds_config['tbl_prefix'] = "phpads_";
			
			$phpAds_config['dbpassword'] = '';
			
			phpAds_StartSettings();		
			phpAds_AddSettings('start_section', "0.2.1");
			phpAds_AddSettings('text', 'dbhost', $strDbHost);
			phpAds_AddSettings('break', '');
			phpAds_AddSettings('text', 'dbuser', $strDbUser);
			phpAds_AddSettings('break', '');
			phpAds_AddSettings('text', 'dbpassword',
				array($strDbPassword, 25, 'password'));
			phpAds_AddSettings('break', '');
			phpAds_AddSettings('text', 'dbname', $strDbName);
			phpAds_AddSettings('end_section', '');
			
			phpAds_AddSettings('start_section', "0.2.2");
			phpAds_AddSettings('text', 'tbl_prefix', $strTablesPrefix);
			
			if (phpAds_tableTypesSupported)
			{
				phpAds_AddSettings('break', '');
				phpAds_AddSettings('select', 'tabletype',
					array($strTablesType, phpAds_getTableTypes()));
			}
			
			phpAds_AddSettings('end_section', '');
			phpAds_EndSettings();
			
			$header = "1.2";
			$phase = 2;
			
			break;
			
		case 3:
						
			if (isset($admin))
			{
				$admin = trim(strtolower($admin));
				
				if (!strlen($admin) || !strlen($admin_pw))
					$errormessage[1][] = $strInvalidUserPwd;
				
				if (strlen($admin_pw) && $admin_pw != $admin_pw2)
					$errormessage[1][] = $strNotSamePasswords;
										
				if (!count($errormessage))
				{
					$installvars['admin'] = $admin;
					$installvars['admin_pw'] = $admin_pw;
					$installvars['url_prefix'] = $url_prefix;
					if ($phpAds_install_phase < 4)
						$installvars['install_phase'] = 4;
					setcookie('installvars', serialize($installvars));
					header("Location: $PHP_SELF?phase=4");
					exit;
				}
			}
			
			// Admin settings
			
			$phpAds_config['admin_pw'] = '';
			
			phpAds_StartSettings();
			phpAds_AddSettings('start_section', "0.3.1");
			phpAds_AddSettings('text', 'admin', $strUsername);
			phpAds_AddSettings('break', '');
			phpAds_AddSettings('text', 'admin_pw',
				array($strPassword, 25, 'password'));
			phpAds_AddSettings('break', '');
			phpAds_AddSettings('text', 'admin_pw2',
				array($strRepeatPassword, 25, 'password'));
			phpAds_AddSettings('end_section', '');
			
			phpAds_AddSettings('start_section', "0.3.2");
			phpAds_AddSettings('text', 'url_prefix',
				array($strUrlPrefix, 35));
			phpAds_AddSettings('end_section', '');
			phpAds_EndSettings();
			
			$header = "1.3";
			$phase = 3;
			
			break;
		
		case 4:
			
			if (count($errormessage))
			{
				phpAds_PageHeader(1);
				phpAds_Die($strFatalError, $strConfigNotWritable);
			}
			
			if (phpAds_dbConnect())
			{
				$message = phpAds_createDatabase($phpAds_config['tabletype']);
				
				phpAds_dbQuery("INSERT INTO ".$phpAds_config['tbl_config']." (
						config_version,
						admin,
						admin_pw,
						language)
					VALUES
						($phpAds_version,
						'".$phpAds_config['admin']."',
						'".$phpAds_config['admin_pw']."',
						'".$phpAds_config['language']."')") or phpAds_sqlDie();
				
				while (list($k, $v) = each($GLOBALS['phpAds_settings_information']))
				{
					if ($v['sql'])
						continue;
					
					phpAds_SettingsWriteAdd($k, $phpAds_config[$k]);
				}
				
				phpAds_ConfigFileClear();
				
				phpAds_SettingsWriteFlush();
				
				setcookie('installvars', '');
				
				phpAds_PageHeader("1.4");
				phpAds_ShowSections(array());
				
				echo '<form name="installform" method="post" action="install.php">';
				
				phpAds_InstallMessage($strInstallCompleted, "$message<br><br>$strInstallCompleted2");
				
				echo '<br>';
				echo '<input type="button" name="installredir" value="'.$strProceed.'" onClick="document.location = \'settings-index.php\'">';
				echo '</form>';
				echo '<br><br>';
				
				phpAds_PageFooter();
				
				exit;
			}
			
			phpAds_PageHeader(1);
			phpAds_Die($strFatalError, $strCantConnectToDb);
			
		default:
			
			if ($installvars['install_phase'] > 1)
			{
				header("Location: $PHP_SELF?phase=1");
				exit;
			}
			
			if (phpAds_isConfigWritable() && isset($proceed))
			{
				$installvars['install_phase'] = 1;
				setcookie('installvars', serialize($installvars));
				header("Location: $PHP_SELF?phase=1");
				exit;
			}
			
			$extra = '';
			$header = "1";
			$phase = 0;
			
			break;
	}
	
	
	if ($phase)
		phpAds_PrepareHelp();
	phpAds_PageHeader($header);
	phpAds_ShowSections($sections);
	
?>
<form name="installform" method="post" action="install.php">
<?php
	if ($phase)
	{
?>
<table border='0' width='100%' cellpadding='0' cellspacing='0'><tr><td height='35' align="right"><b><a href="javascript:toggleHelp();"><img src="images/help-book.gif" width="15" height="15" border="0" align="absmiddle">&nbsp;Help</a></b></td></tr></table>
<?php
		phpAds_FlushSettings();
	}
	else
	{
		$text = $strInstallMessage;
		if (!phpAds_isConfigWritable())
		{	
			$title = $strWarning;
			$text .= '<br><br>'.$strConfigLockedDetected;
		}
		else
			$title = $strInstall;
			
		phpAds_InstallMessage($title, $text);
		echo '<br><br>';
	}
?>
<input type="hidden" name="phase" value="<?php echo $phase;?>">
<input type="submit" name="proceed" value="<?php echo $strProceed;?>">
</form>
<?php
}

echo "<br><br>";

phpAds_PageFooter();

?>