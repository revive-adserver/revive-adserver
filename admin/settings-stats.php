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


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($HTTP_POST_VARS) && count($HTTP_POST_VARS))
{
	if (isset($ignore_hosts))
	{
		if (trim($ignore_hosts) != '')
		{
			$ignore_hosts = explode("\n",
				trim(ereg_replace("[[:blank:]\n\r]+", "\n",
				stripslashes($ignore_hosts))));
			
			phpAds_SettingsWriteAdd('ignore_hosts', $ignore_hosts);
		}
		else
			phpAds_settingsWriteAdd('ignore_hosts', array());
	}
	
	
	
	if (isset($warn_limit))
	{
		if (!is_numeric($warn_limit) || $warn_limit <= 0)
			$errormessage[2][] = $strWarnLimitErr;
		else
			phpAds_SettingsWriteAdd('warn_limit', $warn_limit);
	}
	
	if (isset($admin_email_headers))
	{
		$admin_email_headers = trim(ereg_replace("\r?\n", "\\r\\n", $admin_email_headers));
		phpAds_SettingsWriteAdd('admin_email_headers', $admin_email_headers);
	}
	
	if (isset($log_beacon))
		phpAds_SettingsWriteAdd('log_beacon', $log_beacon);
	if (isset($compact_stats))
		phpAds_SettingsWriteAdd('compact_stats', $compact_stats);
	if (isset($log_adviews))
		phpAds_SettingsWriteAdd('log_adviews', $log_adviews);
	if (isset($log_adclicks))
		phpAds_SettingsWriteAdd('log_adclicks', $log_adclicks);
	if (isset($block_adviews))
		phpAds_SettingsWriteAdd('block_adviews', $block_adviews);
	if (isset($block_adclicks))
		phpAds_SettingsWriteAdd('block_adclicks', $block_adclicks);
	if (isset($reverse_lookup))
		phpAds_SettingsWriteAdd('reverse_lookup', $reverse_lookup);
	if (isset($proxy_lookup))
		phpAds_SettingsWriteAdd('proxy_lookup', $proxy_lookup);
	if (isset($warn_admin))
		phpAds_SettingsWriteAdd('warn_admin', $warn_admin);
	if (isset($warn_client))
		phpAds_SettingsWriteAdd('warn_client', $warn_client);
	
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
phpAds_ShowSections(array("5.1", "5.2"));
phpAds_SettingsSelection("stats");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

// Change ignore_hosts into a string, so the function handles it good
$phpAds_config['ignore_hosts'] = join("\n", $phpAds_config['ignore_hosts']);

phpAds_StartSettings();
phpAds_AddSettings('start_section', "1.4.1");
phpAds_AddSettings('checkbox', 'log_beacon', $strLogBeacon);
phpAds_AddSettings('checkbox', 'compact_stats', $strCompactStats);
phpAds_AddSettings('break', 'full');
phpAds_AddSettings('checkbox', 'log_adviews',
	array($strLogAdviews, array('block_adviews')));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'block_adviews',
	array($strBlockAdviews, 12, 'text', 5, 'log_adviews'));
phpAds_AddSettings('break', 'large');
phpAds_AddSettings('checkbox', 'log_adclicks',
	array($strLogAdclicks, array('block_adclicks')));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'block_adclicks',
	array($strBlockAdclicks, 12, 'text', 5, 'log_adclicks'));
phpAds_AddSettings('end_section', '');

$extra = phpAds_AddSettings('start_section', "1.4.2");
phpAds_AddSettings('text', 'admin_email_headers',
	array($strAdminEmailHeaders, 35, 'textarea', 5));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'warn_limit',
	array($strWarnLimit, 12));
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'warn_admin', $strWarnAdmin);
phpAds_AddSettings('checkbox', 'warn_client', $strWarnClient);
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "1.4.3");
phpAds_AddSettings('text', 'ignore_hosts',
	array($strIgnoreHosts, 35, 'textarea'));
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'reverse_lookup', $strReverseLookup);
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'proxy_lookup', $strProxyLookup);
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
