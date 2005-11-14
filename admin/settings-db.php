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



// Include required files
include ("lib-settings.inc.php");


// Register input variables
phpAds_registerGlobal ('save_settings', 'dblocal', 'dbhost', 'dbport', 'dbuser', 'dbpassword', 'dbname', 
					   'persistent_connections', 'insert_delayed', 
					   'compatibility_mode', 'auto_clean_tables_vacuum');


// Security check
phpAds_checkAccess(phpAds_Admin);


$errormessage = array();
$sql = array();

if (isset($save_settings) && $save_settings != '')
{
	if (isset($dbpassword) && ereg('^\*+$', $dbpassword))
		$dbpassword = $phpAds_config['dbpassword'];
	
	// Add starting ":" to host if not present
	if (isset($dblocal) && !ereg('^:', $dbhost))
		$dbhost = ':'.$dbhost;
	
	if (isset($dbhost) && isset($dbuser) && isset($dbpassword) && isset($dbname))
	{
		phpAds_dbClose();
		
		unset($phpAds_db_link);
		
		$phpAds_config['dblocal'] = isset($dblocal);
		$phpAds_config['dbhost'] = $dbhost;
		$phpAds_config['dbport'] = isset($dbport) && $dbport ? $dbport : 3306;;
		$phpAds_config['dbuser'] = $dbuser;
		$phpAds_config['dbpassword'] = isset($dbpassword) ? $dbpassword : '';
		$phpAds_config['dbname'] = $dbname;
		$phpAds_config['persistent_connections'] = isset($persistent_connections) ? true : false;
		
		if (!phpAds_dbConnect(true))
			$errormessage[0][] = $strCantConnectToDb;
		else
		{
			phpAds_SettingsWriteAdd('dblocal', $phpAds_config['dbhost']);
			phpAds_SettingsWriteAdd('dbname', $phpAds_config['dbhost']);
			phpAds_SettingsWriteAdd('dbport', $phpAds_config['dbport']);
			phpAds_SettingsWriteAdd('dbuser', $phpAds_config['dbuser']);
			phpAds_SettingsWriteAdd('dbpassword', $phpAds_config['dbpassword']);
			
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
			'type' 	  => 'checkbox', 
			'name' 	  => 'dblocal',
			'text' 	  => $strDbLocal,
			'req'	  => true
		),
		array (
			'type'    => 'break'
		),
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
			'text' 	  => $strDbPort,
			'req'	  => true,
			'depends' => 'dblocal==false'
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
			'text'	  => $strInsertDelayed,
			'visible' => $phpAds_productname == 'phpAdsNew' && $phpAds_config['table_type'] == 'MYISAM'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'compatibility_mode',
			'text'	  => $strCompatibilityMode,
			'visible' => $phpAds_productname == 'phpAdsNew'
		),
		array (
			'type'    => 'checkbox',
			'name'    => 'auto_clean_tables_vacuum',
			'text'	  => $strAutoCleanVacuum,
			'visible' => $phpAds_productname == 'phpPgAds'
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