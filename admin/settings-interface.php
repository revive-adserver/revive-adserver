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
phpAds_registerGlobal ('name', 'my_header', 'my_footer', 'client_welcome', 'client_welcome_msg', 'content_gzip_compression');


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($HTTP_POST_VARS) && count($HTTP_POST_VARS))
{
	if (isset($name))
		phpAds_SettingsWriteAdd('name', $name);
	if (isset($my_header))
		phpAds_SettingsWriteAdd('my_header', $my_header);
	if (isset($my_footer))
		phpAds_SettingsWriteAdd('my_footer', $my_footer);
	if (isset($client_welcome))
		phpAds_SettingsWriteAdd('client_welcome', $client_welcome);
	if (isset($client_welcome_msg))
		phpAds_SettingsWriteAdd('client_welcome_msg', $client_welcome_msg);
	
	if (isset($content_gzip_compression))
		phpAds_SettingsWriteAdd('content_gzip_compression', $content_gzip_compression);
	
	if (!count($errormessage))
	{
		if (phpAds_SettingsWriteFlush())
		{
			header("Location: settings-defaults.php");
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
phpAds_SettingsSelection("interface");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

phpAds_StartSettings();
phpAds_AddSettings('start_section', "2.2.1");
phpAds_AddSettings('text', 'name',
	array($strAppName, 35));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'my_header',
	array($strMyHeader, 35));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'my_footer',
	array($strMyFooter, 35));
phpAds_AddSettings('break', '');
phpAds_AddSettings('checkbox', 'content_gzip_compression', $strGzipContentCompression);
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "2.2.2");
phpAds_AddSettings('checkbox', 'client_welcome',
	array($strClientWelcomeEnabled, array('client_welcome_msg')));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'client_welcome_msg',
	array($strClientWelcomeText, 35, 'textarea', 5, 'client_welcome'));
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