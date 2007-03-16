<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
include ("lib-settings.inc.php");


// Register input variables
phpAds_registerGlobal ('save_settings', 'name', 'my_header', 'my_footer', 'client_welcome', 'client_welcome_msg', 'content_gzip_compression');


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($save_settings) && $save_settings != '')
{
	if (isset($name))
		phpAds_SettingsWriteAdd('name', $name);
	
	if (isset($my_header))
	{
		if (file_exists($my_header) || $my_header == '')
			phpAds_SettingsWriteAdd('my_header', $my_header);
		else
			$errormessage[0][] = $strMyHeaderError;
	}
	
	if (isset($my_footer))
	{
		if (file_exists($my_footer) || $my_footer == '')
			phpAds_SettingsWriteAdd('my_footer', $my_footer);
		else
			$errormessage[0][] = $strMyFooterError;
	}
	
	phpAds_SettingsWriteAdd('content_gzip_compression', isset($content_gzip_compression));
	
	
	phpAds_SettingsWriteAdd('client_welcome', isset($client_welcome));
	
	if (isset($client_welcome_msg))
		phpAds_SettingsWriteAdd('client_welcome_msg', $client_welcome_msg);
	
	
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

phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2"));
phpAds_SettingsSelection("interface");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

$settings = array (

array (
	'text' 	  => $strGeneralSettings,
	'items'	  => array (
		array (
			'type' 	  => 'text', 
			'name' 	  => 'name',
			'text' 	  => $strAppName,
			'size'	  => 35
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'my_header',
			'text' 	  => $strMyHeader,
			'size'	  => 35
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'text', 
			'name' 	  => 'my_footer',
			'text' 	  => $strMyFooter,
			'size'	  => 35
		),
		array (
			'type'    => 'break'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'content_gzip_compression',
			'text'	  => $strGzipContentCompression
		)
	)
),
array (
	'text' 	  => $strClientInterface,
	'items'	  => array (
		array (
			'type'    => 'checkbox',
			'name'    => 'client_welcome',
			'text'	  => $strClientWelcomeEnabled
		),
		array (
			'type'    => 'break'
		),
		array (
			'type' 	  => 'textarea', 
			'name' 	  => 'client_welcome_msg',
			'text' 	  => $strClientWelcomeText,
			'depends' => 'client_welcome==true'
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