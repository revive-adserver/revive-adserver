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



// Include required files
include ("lib-settings.inc.php");
include ("lib-languages.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($HTTP_POST_VARS) && count($HTTP_POST_VARS))
{
	if (isset($admin))
	{
		$admin = strtolower($admin);
		
		if (!strlen($admin))
			$errormessage[1][] = $strInvalidUsername;
		elseif (phpAds_dbNumRows(phpAds_dbQuery("SELECT * FROM ".$phpAds_config['tbl_clients']." WHERE clientusername = '$admin'")))
			$errormessage[1][] = $strDuplicateClientName;
		else
			phpAds_SettingsWriteAdd('admin', $admin);
	}
	
	if (isset($pwold) && strlen($pwold) ||
		isset($pw) && strlen($pw) ||
		isset($pw2) && strlen($pw2))
	{
		if ($pwold != $phpAds_config['admin_pw'])
			$errormessage[1][] = $strPasswordWrong;
		elseif (!strlen($pw)  || strstr("\\", $pw))
			$errormessage[1][] = $strInvalidPassword;
		elseif (strcmp($pw, $pw2))
			$errormessage[1][] = $strNotSamePasswords;
		else
		{
			$admin_pw = $pw;
			phpAds_SettingsWriteAdd('admin_pw', $admin_pw);
		}
	}
	
	if (isset($admin_fullname))
		phpAds_SettingsWriteAdd('admin_fullname', $admin_fullname);
	if (isset($admin_email))
		phpAds_SettingsWriteAdd('admin_email', $admin_email);
	if (isset($company_name))
		phpAds_SettingsWriteAdd('company_name', $company_name);
	if (isset($language))
		phpAds_SettingsWriteAdd('language', $language);
	if (isset($pg_timezone))
		phpAds_SettingsWriteAdd('pg_timezone', $pg_timezone);
	if (isset($admin_novice))
		phpAds_SettingsWriteAdd('admin_novice', $admin_novice);
	
	if (isset($userlog_email))
		phpAds_SettingsWriteAdd('userlog_email', $userlog_email);
	if (isset($userlog_priority))
		phpAds_SettingsWriteAdd('userlog_priority', $userlog_priority);
	
	if (!count($errormessage))
	{
		if (phpAds_SettingsWriteFlush())
		{
			header("Location: settings-interface.php");
			exit;
		}
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PrepareHelp();
if (isset($message))
	phpAds_ShowMessage($message);
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.2"));
phpAds_SettingsSelection("admin");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

phpAds_StartSettings();
phpAds_AddSettings('start_section', "2.1.1");
phpAds_AddSettings('text', 'admin',
	$strAdminUsername);
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'pwold',
	array($strOldPassword, 25, 'password'));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'pw',
	array($strNewPassword, 25, 'password'));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'pw2',
	array($strRepeatPassword, 25, 'password'));
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "2.1.2");
phpAds_AddSettings('text', 'admin_fullname',
	array($strAdminFullName, 35));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'admin_email',
	array($strAdminEmail, 35));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'company_name',
	array($strCompanyName, 35));
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "2.1.3");
phpAds_AddSettings('select', 'language',
	array($strLanguage, phpAds_AvailableLanguages()));
phpAds_AddSettings('break', '');
//phpAds_AddSettings('select', 'pg_timezone',
//	array($strTimeZone, phpAds_AvailableTZ()));
//phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'admin_novice', $strAdminNovice);
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'userlog_email', $strUserlogEmail);
phpAds_AddSettings('checkbox', 'userlog_priority', $strUserlogPriority);
phpAds_AddSettings('end_section', '');
phpAds_EndSettings();



/*********************************************************/
/* Main code                                             */
/*********************************************************/

?>
<form name="settingsform" method="post" action="<?php echo $PHP_SELF;?>">
<?php

phpAds_FlushSettings();

?>
</form>
<?php



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
