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
	if (isset($dbhost) && isset($dbuser) && isset($dbpassword) && isset($dbname) &&
		isset($persistent_connections) && 
		($phpAds_config['dbhost'] != $dbhost || $phpAds_config['dbuser'] != $dbuser ||
		$phpAds_config['dbpassword'] != $dbpassword || $phpAds_config['dbname'] != $dbname ||
		$phpAds_config['persistent_connections'] != ($persistent_connections == 't' ? true : false)))
	{
		phpAds_dbClose();
		
		unset($phpAds_db_link);
		
		$phpAds_config['dbhost'] = $dbhost;
		$phpAds_config['dbuser'] = $dbuser;
		$phpAds_config['dbpassword'] = $dbpassword;
		$phpAds_config['dbname'] = $dbname;
		$phpAds_config['persistent_connections'] = $persistent_connections;
		
		if (!phpAds_dbConnect(true))
			$errormessage[1][] = $strCantConnectToDb;
		else
		{
			phpAds_SettingsWriteAdd('dbname', $dbhost);
			phpAds_SettingsWriteAdd('dbuser', $dbuser);
			phpAds_SettingsWriteAdd('dbpassword', $dbpassword);
			phpAds_SettingsWriteAdd('dbname', $dbname);
			phpAds_SettingsWriteAdd('persistent_connections', $persistent_connections);
		}
	}
	
	if (isset($insert_delayed))
		phpAds_SettingsWriteAdd('insert_delayed', $insert_delayed);
	
	if (isset($compatibility_mode))
		phpAds_SettingsWriteAdd('compatibility_mode', $compatibility_mode);
	
	if (!count($errormessage))
	{
		if (phpAds_SettingsWriteFlush())
		{
			header("Location: $PHP_SELF");
			exit;
		}
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1"));
phpAds_SettingsSelection("db");



/*********************************************************/
/* Cache settings fields and get help HTML Code          */
/*********************************************************/

phpAds_StartSettings();
phpAds_AddSettings('start_section', "1.1.1");
phpAds_AddSettings('text', 'dbhost', $strDbHost);
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'dbuser', $strDbUser);
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'dbpassword',
	array($strDbPassword, 25, 'password'));
phpAds_AddSettings('break', '');
phpAds_AddSettings('text', 'dbname', $strDbName);
phpAds_AddSettings('end_section', '');

phpAds_AddSettings('start_section', "1.1.2");
phpAds_AddSettings('checkbox', 'persistent_connections', $strPersistentConnections);
phpAds_AddSettings('checkbox', 'insert_delayed', $strInsertDelayed);
phpAds_AddSettings('checkbox', 'compatibility_mode', $strCompatibilityMode);
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
