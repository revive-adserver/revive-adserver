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
include ("lib-settings.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($HTTP_POST_VARS) && count($HTTP_POST_VARS))
{
	if (isset($default_banner_url))
		phpAds_SettingsWriteAdd('default_banner_url', $default_banner_url);
	if (isset($default_banner_target))
		phpAds_SettingsWriteAdd('default_banner_target', $default_banner_target);
	
	if (isset($type_sql_allow))
		phpAds_SettingsWriteAdd('type_sql_allow', $type_sql_allow);
	if (isset($type_web_allow))
		phpAds_SettingsWriteAdd('type_web_allow', $type_web_allow);
	if (isset($type_url_allow))
		phpAds_SettingsWriteAdd('type_url_allow', $type_url_allow);
	if (isset($type_html_allow))
		phpAds_SettingsWriteAdd('type_html_allow', $type_html_allow);
	if (isset($type_txt_allow))
		phpAds_SettingsWriteAdd('type_txt_allow', $type_txt_allow);
	
	if (isset($type_web_mode))
		phpAds_SettingsWriteAdd('type_web_mode', $type_web_mode);
	if (isset($type_web_url))
		phpAds_SettingsWriteAdd('type_web_url', $type_web_url);
	if (isset($type_web_dir))
		phpAds_SettingsWriteAdd('type_web_dir', $type_web_dir);
	
	
	if (isset($type_web_ftp_host) && !empty($type_web_ftp_host))
	{
		// Include FTP compatibility library
		if (!function_exists("ftp_connect"))
			require ("lib-ftp.inc.php");
		
		
		if (isset($type_web_ftp_host) && $ftpsock = @ftp_connect($type_web_ftp_host))
		{
			if (@ftp_login($ftpsock, $type_web_ftp_user, $type_web_ftp_password))
			{
				if (empty($type_web_ftp_path) || @ftp_chdir($ftpsock, $type_web_ftp_path))
				{
					$type_web_ftp = 'ftp://'.$type_web_ftp_user.
						':'.$type_web_ftp_password.'@'.$type_web_ftp_host.'/'.$type_web_ftp_path;
					
					phpAds_SettingsWriteAdd('type_web_ftp', $type_web_ftp);
				}
				else
					$errormessage[2][] = "Wrong FTP path";
			}
			else
				$errormessage[2][] = "Wrong FTP login";
			
			@ftp_quit($ftpsock);
		}
		else
			$errormessage[2][] = "Wrong FTP host";
	}
/*	
	elseif (!isset($type_web_mode) && $phpAds_config['type_web_mode'] == 2 || $type_web_mode == 2)
		$errormessage[2][] = "FTP configuration wrong";
*/	
	
	if (isset($type_html_auto))
		phpAds_SettingsWriteAdd('type_html_auto', $type_html_auto);
	if (isset($type_html_php))
		phpAds_SettingsWriteAdd('type_html_php', $type_html_php);
	
	if (!count($errormessage))
	{
		if (phpAds_SettingsWriteFlush())
		{
			header("Location: settings-stats.php");
			exit;
		}
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2"));
phpAds_SettingsSelection("banner");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

// Split FTP settings
if (!empty($phpAds_config['type_web_ftp']))
{
	if ($ftpserver = @parse_url($phpAds_config['type_web_ftp']))
	{
		$phpAds_config['type_web_ftp_host'] = $ftpserver['host'].($ftpserver['port'] != '' ? ':'.$ftpserver['port'] : '');
		$phpAds_config['type_web_ftp_user'] = $ftpserver['user'];
		$phpAds_config['type_web_ftp_password'] = $ftpserver['pass'];
		$phpAds_config['type_web_ftp_path'] = ereg_replace("^/?(.*)/?$", "\\1", $ftpserver['path']);
	}
}

phpAds_StartSettings();

phpAds_AddSettings('start_section', "1.3.1");
phpAds_AddSettings('text', 'default_banner_url',
	array($strDefaultBannerUrl, 35, 'text'));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'default_banner_target', 
	array($strDefaultBannerTarget, 35, 'text'));
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "1.3.2");
phpAds_AddSettings('checkbox', 'type_sql_allow', $strTypeSqlAllow);
phpAds_AddSettings('checkbox', 'type_web_allow', $strTypeWebAllow);
phpAds_AddSettings('checkbox', 'type_url_allow', $strTypeUrlAllow);
phpAds_AddSettings('checkbox', 'type_html_allow', $strTypeHtmlAllow);
phpAds_AddSettings('checkbox', 'type_txt_allow', $strTypeTxtAllow);
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "1.3.3");
phpAds_AddSettings('select', 'type_web_mode',
	array($strTypeWebMode, array($strTypeWebModeLocal, $strTypeWebModeFtp)));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'type_web_url',
	array($strTypeWebUrl, 35, 'text'));
phpAds_AddSettings('break', 'full');
phpAds_AddSettings('text', 'type_web_dir',
	array($strTypeWebDir, 35, 'text'));
phpAds_AddSettings('break', 'full');
phpAds_AddSettings('text', 'type_web_ftp_host', $strTypeFTPHost);
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'type_web_ftp_path', $strTypeFTPDirectory);
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'type_web_ftp_user', $strTypeFTPUsername);
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'type_web_ftp_password',
	array($strTypeFTPPassword, 25, 'password'));
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "1.3.4");
phpAds_AddSettings('checkbox', 'type_html_auto', $strTypeHtmlAuto);
phpAds_AddSettings('checkbox', 'type_html_php', $strTypeHtmlPhp);
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
