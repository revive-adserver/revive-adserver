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
phpAds_registerGlobal ('ignore_hosts', 'warn_limit', 'admin_email_headers', 'log_beacon', 'compact_stats', 'log_adviews', 
					   'log_adclicks', 'block_adviews', 'block_adclicks', 'warn_admin', 'warn_client', 'qmail_patch', 
					   'auto_clean_tables', 'auto_clean_userlog', 'auto_clean_tables_interval', 
					   'auto_clean_userlog_interval', 'geotracking_stats', 'log_hostname', 'log_source', 'log_iponly');


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($HTTP_POST_VARS) && count($HTTP_POST_VARS))
{
	if (isset($compact_stats))
		phpAds_SettingsWriteAdd('compact_stats', ($compact_stats == '1'));
	
	phpAds_SettingsWriteAdd('log_adviews', isset($log_adviews));
	phpAds_SettingsWriteAdd('log_adclicks', isset($log_adclicks));
	
	phpAds_SettingsWriteAdd('log_source', isset($log_source));
	phpAds_SettingsWriteAdd('geotracking_stats', isset($geotracking_stats));
	phpAds_SettingsWriteAdd('log_hostname', isset($log_hostname));
	phpAds_SettingsWriteAdd('log_iponly', isset($log_iponly));
	
	phpAds_SettingsWriteAdd('log_beacon', isset($log_beacon));
	
	
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
	
	if (isset($block_adviews))
		phpAds_SettingsWriteAdd('block_adviews', $block_adviews);
	if (isset($block_adclicks))
		phpAds_SettingsWriteAdd('block_adclicks', $block_adclicks);
	
	
	
	phpAds_SettingsWriteAdd('warn_admin', isset($warn_admin));
	phpAds_SettingsWriteAdd('warn_client', isset($warn_client));
	
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
	
	phpAds_SettingsWriteAdd('qmail_patch', isset($qmail_patch));
	
	
	
	phpAds_SettingsWriteAdd('auto_clean_tables', isset($auto_clean_tables));
	phpAds_SettingsWriteAdd('auto_clean_userlog', isset($auto_clean_userlog));
	
	if (isset($auto_clean_tables_interval))
	{
		if (!is_numeric($auto_clean_tables_interval) || $auto_clean_tables_interval <= 2)
			$errormessage[3][] = $strAutoCleanErr;
		else
			phpAds_SettingsWriteAdd('auto_clean_tables_interval', $auto_clean_tables_interval);
	}
	
	if (isset($auto_clean_userlog_interval))
	{
		if (!is_numeric($auto_clean_userlog_interval) || $auto_clean_userlog_interval <= 2)
			$errormessage[3][] = $strAutoCleanErr;
		else
			phpAds_SettingsWriteAdd('auto_clean_userlog_interval', $auto_clean_userlog_interval);
	}
	
	if (!count($errormessage))
	{
		if (phpAds_SettingsWriteFlush())
		{
			header("Location: settings-banner.php");
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
phpAds_SettingsSelection("stats");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

// Change ignore_hosts into a string, so the function handles it good
$phpAds_config['ignore_hosts'] = join("\n", $phpAds_config['ignore_hosts']);



$settings = array (

array (
	'text' 	  => $strStatisticsFormat,
	'items'	  => array (
		array (
			'type' 	  => 'select', 
			'name' 	  => 'compact_stats',
			'text' 	  => $strCompactStats,
			'items'   => array($strVerbose, $strCompact)
		),
		array (
			'type'    => 'break'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'log_adviews',
			'text'	  => $strLogAdviews,
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'log_adclicks',
			'text'	  => $strLogAdclicks,
		),
		array (
			'type'    => 'break',
			'size'	  => 'large'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'log_source',
			'text'	  => $strLogSource,
			'depends' => 'log_adclicks==true || log_adviews==true'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'geotracking_stats',
			'text'	  => $strGeoLogStats,
			'visible' => $phpAds_config['geotracking_type'] > 0,
			'depends' => 'log_adclicks==true || log_adviews==true'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'log_hostname',
			'text'	  => $strLogHostnameOrIP,
			'visible' => isset($HTTP_SERVER_VARS['REMOTE_HOST']) || $phpAds_config['reverse_lookup'],
			'depends' => '(log_adclicks==true || log_adviews==true) && compact_stats==0'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'log_iponly',
			'text'	  => $strLogIPOnly,
			'indent'  => true,
			'visible' => isset($HTTP_SERVER_VARS['REMOTE_HOST']) || $phpAds_config['reverse_lookup'],
			'depends' => '(log_adclicks==true || log_adviews==true) && compact_stats==0 && log_hostname==true'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'log_hostname',
			'text'	  => $strLogIP,
			'visible' => !isset($HTTP_SERVER_VARS['REMOTE_HOST']) && !$phpAds_config['reverse_lookup'],
			'depends' => '(log_adclicks==true || log_adviews==true) && compact_stats==0'
		),
		array (
			'type'    => 'break',
			'size'	  => 'large'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'log_beacon',
			'text'	  => $strLogBeacon
		)
	)
),
array (
	'text' 	  => 'Prevent logging',
	'items'	  => array (
		array (
			'type' 	  => 'textarea', 
			'name' 	  => 'ignore_hosts',
			'text' 	  => $strIgnoreHosts
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'block_adviews',
			'text' 	  => $strBlockAdviews,
			'size'    => 12,
			'depends' => 'log_adviews==true',
			'check'	  => 'number+',
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'block_adclicks',
			'text' 	  => $strBlockAdclicks,
			'size'    => 12,
			'depends' => 'log_adclicks==true',
			'check'	  => 'number+',
		)
	)
),
array (
	'text' 	  => $strEmailWarnings,
	'items'	  => array (
		array (
			'type'    => 'checkbox',
			'name'    => 'warn_admin',
			'text'	  => $strWarnAdmin
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'warn_client',
			'text'	  => $strWarnClient
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'warn_limit',
			'text' 	  => $strWarnLimit,
			'size'    => 12,
			'depends' => 'warn_client==true || warn_admin==true',
			'check'	  => 'number+20',
			'req'	  => true
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'textarea', 
			'name' 	  => 'admin_email_headers',
			'text' 	  => $strAdminEmailHeaders
		),
		array (
			'type'    => 'break'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'qmail_patch',
			'text'	  => $strQmailPatch
		)
	)
),
array (
	'text' 	  => $strAutoCleanTables,
	'items'	  => array (
		array (
			'type'    => 'checkbox',
			'name'    => 'auto_clean_tables',
			'text'	  => $strAutoCleanStats
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'auto_clean_tables_interval',
			'text' 	  => $strAutoCleanStatsWeeks,
			'size'    => 25,
			'depends' => 'auto_clean_tables==true',
			'check'	  => 'number+3',
			'req'	  => true
		),
		array (
			'type'    => 'break',
			'size'	  => 'large'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'auto_clean_userlog',
			'text'	  => $strAutoCleanUserlog
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'auto_clean_userlog_interval',
			'text' 	  => $strAutoCleanUserlogWeeks,
			'size'    => 25,
			'depends' => 'auto_clean_userlog==true',
			'check'	  => 'number+3',
			'req'	  => true
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