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
phpAds_registerGlobal ('allow_invocation_plain', 'allow_invocation_js', 'allow_invocation_frame', 
					   'allow_invocation_xmlrpc', 'allow_invocation_local', 'allow_invocation_interstitial', 
					   'allow_invocation_popup', 'con_key', 'mult_key', 'acl', 'delivery_caching', 
					   'p3p_policies', 'p3p_compact_policy', 'p3p_policy_location');


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($HTTP_POST_VARS) && count($HTTP_POST_VARS))
{
	if (isset($allow_invocation_plain))
		phpAds_SettingsWriteAdd('allow_invocation_plain', $allow_invocation_plain);
	if (isset($allow_invocation_js))
		phpAds_SettingsWriteAdd('allow_invocation_js', $allow_invocation_js);
	if (isset($allow_invocation_frame))
		phpAds_SettingsWriteAdd('allow_invocation_frame', $allow_invocation_frame);
	if (isset($allow_invocation_xmlrpc))
		phpAds_SettingsWriteAdd('allow_invocation_xmlrpc', $allow_invocation_xmlrpc);
	if (isset($allow_invocation_local))
		phpAds_SettingsWriteAdd('allow_invocation_local', $allow_invocation_local);
	if (isset($allow_invocation_interstitial))
		phpAds_SettingsWriteAdd('allow_invocation_interstitial', $allow_invocation_interstitial);
	if (isset($allow_invocation_popup))
		phpAds_SettingsWriteAdd('allow_invocation_popup', $allow_invocation_popup);
	
	if (isset($delivery_caching))
		phpAds_SettingsWriteAdd('delivery_caching', $delivery_caching);
	if (isset($acl))
		phpAds_SettingsWriteAdd('acl', $acl);
	if (isset($con_key))
		phpAds_SettingsWriteAdd('con_key', $con_key);
	if (isset($mult_key))
		phpAds_SettingsWriteAdd('mult_key', $mult_key);
	
	if (isset($p3p_policies))
		phpAds_SettingsWriteAdd('p3p_policies', $p3p_policies);
	if (isset($p3p_compact_policy))
		phpAds_SettingsWriteAdd('p3p_compact_policy', $p3p_compact_policy);
	if (isset($p3p_policy_location))
		phpAds_SettingsWriteAdd('p3p_policy_location', $p3p_policy_location);
	
	
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
phpAds_SettingsSelection("invocation");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

// Determine delivery cache methods
$delivery_cache_methods['db'] = 'Database';

if ($fp = @fopen(phpAds_path.'/cache/available', 'wb'))
{
	@fclose($fp);
	@unlink(phpAds_path.'/cache/available');
	
	$delivery_cache_methods['file'] = 'Files';
}

if (function_exists('shmop_open'))
	$delivery_cache_methods['shm'] = 'Shared memory (shmop)';




phpAds_StartSettings();
phpAds_AddSettings('start_section', "1.2.2");
phpAds_AddSettings('select', 'delivery_caching',
	array('Delivery cache type', $delivery_cache_methods));
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'acl', $strUseAcl);
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'con_key', $strUseConditionalKeys);
phpAds_AddSettings('checkbox', 'mult_key', $strUseMultipleKeys);
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "1.2.1");
phpAds_AddSettings('checkbox', 'allow_invocation_plain', $strAllowRemoteInvocation);
phpAds_AddSettings('checkbox', 'allow_invocation_js', $strAllowRemoteJavascript);
phpAds_AddSettings('checkbox', 'allow_invocation_frame', $strAllowRemoteFrames);
phpAds_AddSettings('checkbox', 'allow_invocation_xmlrpc', $strAllowRemoteXMLRPC);
phpAds_AddSettings('checkbox', 'allow_invocation_local', $strAllowLocalmode);
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'allow_invocation_interstitial', $strAllowInterstitial);
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'allow_invocation_popup', $strAllowPopups);
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "1.2.4");
phpAds_AddSettings('checkbox', 'p3p_policies',
	array($strUseP3P, array('p3p_compact_policy', 'p3p_policy_location')));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'p3p_compact_policy',
	array($strP3PCompactPolicy, 35, 'text', 0, 'p3p_policies'));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'p3p_policy_location',
	array($strP3PPolicyLocation, 35, 'text', 0, 'p3p_policies'));
phpAds_AddSettings('end_section', '');
phpAds_EndSettings();



/*********************************************************/
/* Main code                                             */
/*********************************************************/

?>
<form name="settingsform" method="post" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF'];?>">
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