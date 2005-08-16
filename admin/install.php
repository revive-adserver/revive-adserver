<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
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



include (phpAds_path."/libraries/lib-dbconfig.inc.php");
include (phpAds_path."/libraries/lib-revisions.inc.php");

if (!count($HTTP_POST_VARS) && !count($HTTP_GET_VARS))
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

	if (function_exists('version_compare') && version_compare(phpversion(), '5.0.0') >= 0 &&
		!ini_get('register_long_arrays'))
	{
		// (no need for translation, because language file is not loaded yet)
		echo "<strong>The installer detected some problems which need to be fixed before you can continue:</strong><br>";
		echo '<ul><li>The PHP configuration variable register_long_arrays needs to be turned on.</ul>';
		exit;
	}
}




// Include config file
require ("../config.inc.php");


// Register input variables
require ("../libraries/lib-io.inc.php");
phpAds_registerGlobal ('installvars', 'language', 'phase', 'dbhost', 'dbport', 'dbuser', 'dbpassword', 'dbname', 'table_prefix', 
					   'table_type', 'admin', 'admin_pw', 'admin_pw2', 'url_prefix', 'arraybugcheck', 'ignore', 'admin_fullname',
					   'company_name', 'admin_email');


// Set URL prefix
if (isset($HTTP_SERVER_VARS['HTTP_HOST']))
	$host = $HTTP_SERVER_VARS['HTTP_HOST'];
else
	$host = $HTTP_SERVER_VARS['SERVER_NAME'];

$phpAds_config['url_prefix'] = strtolower(eregi_replace("^([a-z]+)/.*$", "\\1://",
	$HTTP_SERVER_VARS['SERVER_PROTOCOL'])).$host.
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
unset($Session);

// Authorize the user
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
			// Go to next step, nothing to do here
			break;
		
		case 1:
			// Go to next step, nothing to do here
			break;
		
		case 2:
			// Determine the PHP version
			ereg ("^([0-9]{1})\.([0-9]{1})\.([0-9]{1,2})(.*)$", phpversion(), $matches);
			$phpversion = sprintf ("%01d%01d%02d", $matches[1], $matches[2], $matches[3]);
			
			// Store fatal and non-fatal errors
			$fatal	= array();
			$warn	= array();
			
			// Check PHP version < 4.0.3
			if ($phpversion < 4003)
				$fatal[] = str_replace ('{php_version}', phpversion(), $strWarningPHPversion);
			elseif ($phpversion == 5000 && isset($matches[4]) && $matches[4])
				$warn[] = $strWarningPHP5beta;
			
			// Check database extention
			if (!phpAds_dbAvailable())
				$fatal[] = $strWarningDBavailable;
			
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
			
			
			// Check the integerity of the uploaded files
			if ($result = phpAds_revisionCheck())
				list ($rev_direct, $rev_fatal, $rev_message) = $result;
			
			
			if (count($fatal) > 0 || count($warn) > 0 || (isset($rev_direct) && !isset($ignore)))
				$phase = 2;
			else
				$phase = 3;
			
			break;
			
			
		case 3:
			// Set language
			$admin = trim($admin);
			
			if (!strlen($admin) || !strlen($admin_pw))
				$errormessage[0][] = $strInvalidUserPwd;
			
			if (strlen($admin_pw) && $admin_pw != $admin_pw2)
				$errormessage[0][] = $strNotSamePasswords;

			if (!isset($errormessage) || !count($errormessage))
			{
				$installvars['admin_fullname'] 	= $admin_fullname;
				$installvars['company_name'] 	= $company_name;
				$installvars['admin_email'] 	= $admin_email;
				$installvars['language'] 	 	= $language;
				$installvars['admin'] 		 	= $admin;
				$installvars['admin_pw'] 	 	= md5($admin_pw);
				$installvars['url_prefix']   	= $url_prefix;
			}
			
			
			// Check for PHP bug #20144
			if (!(isset($arraybugcheck) && is_array($arraybugcheck) && isset($arraybugcheck[0]) && strlen($arraybugcheck[0]) == 4))
			{
				if (preg_match('/^5/', phpversion()))
				{
					// PHP5 beta1 bug (#24652) which is different, but makes php get in there...
					$fatal[] = $strPhpBug24652;
					$phase = 5;
					break;
				}
				else
				{
					$fatal[] = $strPhpBug20144;
					$phase = 5;
					break;
				}
			}

			// Go to next phase
			$phase = 4;
			break;
			
			
		case 4:
			// Setup database check
			if (isset($dbpassword) && ereg('^\*+$', $dbpassword))
				$dbpassword = $phpAds_config['dbpassword'];
			
			
			$phpAds_config['compatibility_mode'] = false;
			$phpAds_config['dbhost'] 	 		 = $dbhost;
			$phpAds_config['dbport'] 	 		 = isset($dbport) && $dbport ? $dbport : 3306;
			$phpAds_config['dbuser'] 	 		 = $dbuser;
			$phpAds_config['dbpassword'] 		 = isset($dbpassword) ? $dbpassword : '';
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
					$errormessage[1][] = $strTableWrongType;
			}
			
			// Check table prefix
			if (strlen($table_prefix) && !eregi("^[a-z][a-z0-9_]*$", $table_prefix))
				$errormessage[1][] = $strTablePrefixInvalid;
			
			
			if (!isset($errormessage) || !count($errormessage))
			{
				$installvars['dbhost'] 	 	 = $phpAds_config['dbhost'];
				$installvars['dbport'] 	 	 = $phpAds_config['dbport'];
				$installvars['dbuser'] 		 = $phpAds_config['dbuser'];
				$installvars['dbpassword'] 	 = $phpAds_config['dbpassword'];
				$installvars['dbname'] 		 = $phpAds_config['dbname'];
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
				
				if (phpAds_checkDatabaseExists())
				{
					$errormessage[1][] = $strTableInUse;
				}
				else
				{
					if (phpAds_isConfigWritable())
					{
						// Connect
						if (phpAds_dbConnect())
						{
							if (phpAds_createDatabase($phpAds_config['table_type']))
							{
								// Insert basic settings into database and config file
								phpAds_SettingsWriteAdd('config_version', $phpAds_version);
								
								phpAds_SettingsWriteAdd('dbhost', $installvars['dbhost']);
								phpAds_SettingsWriteAdd('dbport', $installvars['dbport']);
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
								
								phpAds_SettingsWriteAdd('admin_fullname', $installvars['admin_fullname']);
								phpAds_SettingsWriteAdd('company_name', $installvars['company_name']);
								phpAds_SettingsWriteAdd('admin_email', $installvars['admin_email']);
								phpAds_SettingsWriteAdd('language', $installvars['language']);
								
								phpAds_SettingsWriteAdd('admin', $installvars['admin']);
								phpAds_SettingsWriteAdd('admin_pw', $installvars['admin_pw']);
								phpAds_SettingsWriteAdd('url_prefix', $installvars['url_prefix']);
								
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
											
					$phase = 5;
				}
			}
			
			break;
			
		default:
			break;
	}
	
	
	
	
	
	
	// Prepare helpsystem
	if ($phase > 2)
		phpAds_PrepareHelp();
	
	// Create GUI
	phpAds_PageHeader("1");
	
	// Prepare helpbutton
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'><tr><td height='20' align='right'>";
	if ($phase > 2) echo "<b><a href='javascript:toggleHelp();'><img src='images/help-book.gif' width='15' height='15' border='0' align='absmiddle'>&nbsp;".$strHelp."</a></b>";
	echo "</td></tr></table>";
	
	phpAds_ShowBreak();
	
	
	$displayed_phase = $phase;
	$next_phase 	 = $phase;
	
	switch($phase)
	{
		case 0:
			// Welcome text
			echo "<form name='settingsform' method='post' action='install.php'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-welcome.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strInstallWelcome." ".$phpAds_version_readable."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>";

			echo "We have tried to make the installation of ".$phpAds_productname." as easy as possible, but
				  keep in mind that setting up an ad server is not trivial. If you haven't read the manual at
				  this point, we <strong>strongly recommend</strong> that you do so before you proceed with the installation. The
				  manual will help you avoid potential problems in the future and will guide you through the following steps.";
					
			echo "<p><b>If you are trying to upgrade an existing installation of ".$phpAds_productname." you probably did not follow the
				  instructions given in the manual. If you continue, ".$phpAds_productname." will try to do a clean install and all your
					existing settings, inventory and statistics will be lost. If you want to upgrade an existing installation, please close this
					window, read the manual and follow the instructions carefully.</b></p>";  
			
			echo "<p>The manual is included in every download of ".$phpAds_productname." and can be found in the <em>misc/documentation</em>
				  directory. For information about installing, updating and configuring ".$phpAds_productname.", please read the
				  <a href='../misc/documentation/administrator-guide.pdf' target='_blank'>Administrator guide</a>. For information
				  about managing your inventory and placing banners on your website, please read the <a href='../misc/documentation/user-guide.pdf' 
				  target='_blank'>User guide</a>. To view both guides you need Adobe Acrobat, which can be downloaded for free from 
				  <a href='http://www.adobe.com/products/acrobat/readstep2.html' target='_blank'>Adobe</a>.</p>";
			
			echo "<p>If you still have questions <strong>after reading the manual</strong>, do not hesitate to use our forum. 
				  But please keep in mind that we, the developers, provide this service for free and in our own free time. We might not
				  be able to respond to you questions immediately.</p>";
				  
			echo "</span>";
			echo "</td></tr></table>";
			
			$next_phase++;
			break;
			

		case 1:
			// Welcome text
			echo "<form name='settingsform' method='post' action='install.php'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-license.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strLicenseInformation."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>";
			
			echo $phpAds_productname." is a free and open source ad server, distributed under the GPL license. This means you will
				  have some extra rights, that would not have with commericial software, including the right to modify and distribute
				  copies of your modifications, or even distribute ".$phpAds_productname." verbatim. If you want to use these rights,
				  you also have some obligations to the original creators of ".$phpAds_productname.". All your rights and obligations
				  are described in the GPL license, printed below. If you want to read this text later on, you can find another copy
				  in the ".$phpAds_productname." directory and at the end of the Administrator guide.";
			
			echo "<p><textarea class='code' style='width: 100%; height: 200px;' wrap='off' readonly>";
			include ("../LICENSE");
			echo "</textarea></p>";
			
			echo "</span>";
			echo "</td></tr></table>";
			
			$next_phase++;
			break;
			

		case 2:
			// Preconditions failed
			echo "<form name='settingsform' method='post' action='install.php'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-warning.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strInstallWarning."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>".$strInstallMessageCheck;
			
			if (count($fatal) || count($warn) || isset($rev_direct))
			{
				echo "<br><br><div class='errormessage'><img class='errormessage' src='images/errormessage.gif' align='absmiddle'>";
				echo "<span class='tab-r'>".$strMayNotFunction."</span><br><br>".$strFixProblemsBefore."<ul>";
				
				if (count($fatal))
					for ($r=0;$r<count($fatal);$r++)
						echo "<li>".$fatal[$r]."</li>";
				
				if (count($warn))
					for ($r=0;$r<count($warn);$r++)
						echo "<li>".$warn[$r]."</li>";
				
				if (isset($rev_direct))
					for ($r=0;$r<count($rev_message);$r++)
						echo "<li>".$rev_message[$r]."</li>";
				
				echo "</ul>".$strFixProblemsAfter."<br><br></div>";
			}
			
			echo "</td></tr></table>";
			
			break;
			
			
		case 3:
			// Administrator account
			echo "<form name='settingsform' method='post' action='install.php' onSubmit='return phpAds_formCheck(this);'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-admin.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strAdministratorAccount."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>".$strInstallMessageAdmin."</td></tr></table><br><br>";
			
			phpAds_ShowBreak();
			
			phpAds_ShowSettings(array (
				array (
					'text' 	  => $strSpecifyAdmin,
					'items'	  => array (
						array (
							'type' 	  => 'text', 
							'name' 	  => 'admin_fullname',
							'text' 	  => $strAdminFullName,
							'size'	  => 35,
							'req'	  => true
						),
						array (
							'type'    => 'break'
						),
						array (
							'type' 	  => 'text', 
							'name' 	  => 'company_name',
							'text' 	  => $strCompanyName,
							'size'	  => 35
						),
						array (
							'type'    => 'break'
						),
						array (
							'type' 	  => 'text', 
							'name' 	  => 'admin_email',
							'text' 	  => $strAdminEmail,
							'size'	  => 35,
							'check'	  => 'email',
							'req'	  => true
						),
						array (
							'type'    => 'break'
						),
						array (
							'type' 	  => 'select', 
							'name' 	  => 'language',
							'text' 	  => $strLanguage,
							'items'   => phpAds_AvailableLanguages()
						),
						array (
							'type'    => 'break',
							'size'	  => 'full'
						),
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
					'text' 	  => $strSpecifyLocaton,
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
			// Database settings
			echo "<form name='settingsform' method='post' action='install.php' onSubmit='return phpAds_formCheck(this);'>";
			echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
			echo "<img src='images/install-database.gif'></td><td width='100%' valign='top'>";
			echo "<br><span class='tab-s'>".$strDatabasePage."</span><br>";
			echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
			echo "<span class='install'>".$strInstallMessageDatabase."</td></tr></table><br><br>";
			
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
							'name' 	  => 'dbport',
							'text' 	  => $strDbPort
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
							'text' 	  => $strDbPassword
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
			
			
		case 5:
			// Admin settings
			if (!isset($fatal) || !count($fatal))
			{
				echo "<form name='settingsform' method='post' action='settings-index.php'>";
				echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
				echo "<img src='images/install-success.gif'></td><td width='100%' valign='top'>";
				echo "<br><span class='tab-s'>".$strCongratulations."</span><br>";
				echo "<img src='images/break-el.gif' width='100%' height='1' vspace='8'>";
				echo "<span class='install'>".$strInstallSuccess."</td></tr></table><br><br>";
			}
			else
			{
				echo "<form name='settingsform' method='post' action='settings-index.php'>";
				echo "<br><br><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top'>";
				echo "<img src='images/install-error.gif'></td><td width='100%' valign='top'>";
				echo "<br><span class='tab-s'>".$strInstallFailed."</span><br>";
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
	

	// Determine the text of the button
	$btn = $strProceed;											// Default to Proceed
	
	if (isset($fatal) && count($fatal))
		$btn = $GLOBALS['strRetry'];							// Configuration errors -> allow a retry
	
	if (isset($rev_message) && $displayed_phase == 2)
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
	
	
	if (isset($installvars) && count($installvars))
		for (reset($installvars); $key=key($installvars); next($installvars))
			echo "<input type='hidden' name='installvars[".$key."]' value='".$installvars[$key]."'>\n";
	
	echo "<input type='hidden' name='phase' value='".$next_phase."'>\n";
	
	// Check for PHP bug #20144
	echo "<input type='hidden' name='arraybugcheck[0]' value='xxxx'>\n";

	echo "</form>";
}

echo "<br><br>";

phpAds_PageFooter();

?>
