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


// Register input variables
phpAds_registerGlobal ('default_banner_url', 'default_banner_target', 'type_sql_allow', 'type_web_allow', 'type_url_allow',
					   'type_html_allow', 'type_txt_allow', 'type_web_mode', 'type_web_url', 'type_web_dir', 'type_web_ftp_user',
					   'type_web_ftp_password', 'type_web_ftp_host', 'type_web_ftp_path', 'type_html_auto', 'type_html_php');


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
	
	
	phpAds_SettingsWriteAdd('type_sql_allow', isset($type_sql_allow));
	phpAds_SettingsWriteAdd('type_web_allow', isset($type_web_allow));
	phpAds_SettingsWriteAdd('type_url_allow', isset($type_url_allow));
	phpAds_SettingsWriteAdd('type_html_allow', isset($type_html_allow));
	phpAds_SettingsWriteAdd('type_txt_allow', isset($type_txt_allow));
	
	
	if (isset($type_web_mode))
		phpAds_SettingsWriteAdd('type_web_mode', $type_web_mode);
	if (isset($type_web_url))
		phpAds_SettingsWriteAdd('type_web_url', $type_web_url);
	
	
	if (isset($type_web_dir))
	{
		if (@file_exists($type_web_dir) || empty($type_web_dir))
			phpAds_SettingsWriteAdd('type_web_dir', $type_web_dir);
		else
			$errormessage[2][] = $strTypeDirError;
	}
	
	if (isset($type_web_ftp_host))
	{
		if (empty($type_web_ftp_host))
		{
			phpAds_SettingsWriteAdd('type_web_ftp', '');
		}
		else
		{
			// Include FTP compatibility library
			if (!function_exists("ftp_connect"))
				require ("lib-ftp.inc.php");
			
			// Set current password if a new one is not supplied
			if (isset($type_web_ftp_password) && ereg('^\*+$', $type_web_ftp_password))
			{
				if ($ftpserver = @parse_url($phpAds_config['type_web_ftp']))
				{
					$type_web_ftp_password = $ftpserver['pass'];
				}
			}
			
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
						$errormessage[2][] = $strTypeFTPErrorDir;
				}
				else
					$errormessage[2][] = $strTypeFTPErrorConnect;
				
				@ftp_quit($ftpsock);
			}
			else
				$errormessage[2][] = $strTypeFTPErrorHost;
		}
	}
	
	phpAds_SettingsWriteAdd('type_html_auto', isset($type_html_auto));
	phpAds_SettingsWriteAdd('type_html_php', isset($type_html_php));
	
	
	if (!count($errormessage))
	{
		if (phpAds_SettingsWriteFlush())
		{
			header("Location: settings-admin.php");
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
		$ftpserver['path'] = ereg_replace('^/', '', $ftpserver['path']);
		$ftpserver['path'] = ereg_replace('/$', '', $ftpserver['path']);
		
		$phpAds_config['type_web_ftp_host'] = $ftpserver['host'].(isset($ftpserver['port']) && $ftpserver['port'] != '' ? ':'.$ftpserver['port'] : '');
		$phpAds_config['type_web_ftp_user'] = $ftpserver['user'];
		$phpAds_config['type_web_ftp_password'] = $ftpserver['pass'];
		$phpAds_config['type_web_ftp_path'] = $ftpserver['path'];
	}
}





$settings = array (

array (
	'text' 	  => $strDefaultBanners,
	'items'	  => array (
		array (
			'type' 	  => 'text', 
			'name' 	  => 'default_banner_url',
			'text' 	  => $strDefaultBannerUrl,
			'size'	  => 35,
			'check'	  => 'url'
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'default_banner_target',
			'text' 	  => $strDefaultBannerTarget,
			'size'	  => 35,
			'check'	  => 'url'
		)
	)
),
array (
	'text' 	  => $strAllowedBannerTypes,
	'items'	  => array (
		array (
			'type'    => 'checkbox',
			'name'    => 'type_sql_allow',
			'text'	  => $strTypeSqlAllow
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'type_web_allow',
			'text'	  => $strTypeWebAllow
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'type_url_allow',
			'text'	  => $strTypeUrlAllow
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'type_html_allow',
			'text'	  => $strTypeHtmlAllow
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'type_txt_allow',
			'text'	  => $strTypeTxtAllow
		)
	)
),
array (
	'text' 	  => $strTypeWebSettings,
	'items'	  => array (
		array (
			'type' 	  => 'select', 
			'name' 	  => 'type_web_mode',
			'text' 	  => $strTypeWebMode,
			'items'   => array($strTypeWebModeLocal, $strTypeWebModeFtp),
			'depends' => 'type_web_allow==true'
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'type_web_url',
			'text' 	  => $strTypeWebUrl,
			'size'	  => 35,
			'check'	  => 'url',
			'depends' => 'type_web_allow==true'
		),
		array (
			'type'    => 'break',
			'size'	  => 'full'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'type_web_dir',
			'text' 	  => $strTypeWebDir,
			'size'	  => 35,
			'depends' => 'type_web_allow==true && type_web_mode==0'
		),
		array (
			'type'    => 'break',
			'size'	  => 'full'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'type_web_ftp_host',
			'text' 	  => $strTypeFTPHost,
			'size'	  => 35,
			'depends' => 'type_web_allow==true && type_web_mode==1'
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'type_web_ftp_path',
			'text' 	  => $strTypeFTPDirectory,
			'size'	  => 35,
			'depends' => 'type_web_allow==true && type_web_mode==1'
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'type_web_ftp_user',
			'text' 	  => $strTypeFTPUsername,
			'size'	  => 35,
			'depends' => 'type_web_allow==true && type_web_mode==1'
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'password', 
			'name' 	  => 'type_web_ftp_password',
			'text' 	  => $strTypeFTPPassword,
			'size'	  => 35,
			'depends' => 'type_web_allow==true && type_web_mode==1'
		)
	)
),
array (
	'text' 	  => $strTypeHtmlSettings,
	'items'	  => array (
		array (
			'type'    => 'checkbox',
			'name'    => 'type_html_auto',
			'text'	  => $strTypeHtmlAuto,
			'depends' => 'type_html_allow==true'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'type_html_php',
			'text'	  => $strTypeHtmlPhp,
			'depends' => 'type_html_allow==true'
		)
	)
));



/*********************************************************/
/* Main code                                             */
/*********************************************************/

phpAds_ShowSettings($settings, $errormessage);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>