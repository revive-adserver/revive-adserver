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
phpAds_registerGlobal ('dbhost', 'dbuser', 'dbpassword', 'dbname', 
					   'persistent_connections', 'insert_delayed', 
					   'compatibility_mode');


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($HTTP_POST_VARS) && count($HTTP_POST_VARS))
{
	if (isset($dbpassword) && ereg('^\*+$', $dbpassword))
		$dbpassword = $phpAds_config['dbpassword'];
	
	if (isset($dbhost) && isset($dbuser) && isset($dbpassword) && isset($dbname))
	{
		phpAds_dbClose();
		
		unset($phpAds_db_link);
		
		$phpAds_config['dbhost'] = $dbhost;
		$phpAds_config['dbuser'] = $dbuser;
		$phpAds_config['dbpassword'] = $dbpassword;
		$phpAds_config['dbname'] = $dbname;
		$phpAds_config['persistent_connections'] = isset($persistent_connections) ? true : false;
		
		if (!phpAds_dbConnect(true))
			$errormessage[0][] = $strCantConnectToDb;
		else
		{
			phpAds_SettingsWriteAdd('dbname', $dbhost);
			phpAds_SettingsWriteAdd('dbuser', $dbuser);
			phpAds_SettingsWriteAdd('dbpassword', $dbpassword);
			phpAds_SettingsWriteAdd('dbname', $dbname);
			
			phpAds_SettingsWriteAdd('persistent_connections', isset($persistent_connections));
		}
	}
	
	phpAds_SettingsWriteAdd('insert_delayed', isset($insert_delayed));
	phpAds_SettingsWriteAdd('compatibility_mode', isset($compatibility_mode));
	
	
	if (!count($errormessage))
	{
		if (phpAds_SettingsWriteFlush())
		{
			header("Location: settings-invocation.php");
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
phpAds_SettingsSelection("db");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

$settings = array (

array (
	'text' 	  => $strDatabaseServer,
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
			'text' 	  => $strDbPassword,
			'req'	  => true
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
	'text' 	  => $strDatabaseOptimalisations,
	'items'	  => array (
		array (
			'type'    => 'checkbox',
			'name'    => 'persistent_connections',
			'text'	  => $strPersistentConnections
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'insert_delayed',
			'text'	  => $strInsertDelayed
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'compatibility_mode',
			'text'	  => $strCompatibilityMode
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