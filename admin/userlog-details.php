<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("5.2.1");
phpAds_ShowSections(array("5.2.1"));

// Load translations
@include (phpAds_path.'/language/english/userlog.lang.php');
if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/userlog.lang.php'))
	@include (phpAds_path.'/language/'.$phpAds_config['language'].'/userlog.lang.php');



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$res = phpAds_dbQuery("
	SELECT
		*
	FROM 
		".$phpAds_config['tbl_userlog']."
	WHERE
		userlogid = '".$userlogid."'
");


if ($row = phpAds_dbFetchArray($res))
{
	echo "<br>";
	echo "<table cellpadding='0' cellspacing='0' border='0'>";
	
	echo "<tr height='20'><td><b>".$strDate."</b>:&nbsp;&nbsp;</td>";
	echo "<td>".strftime($date_format, $row['timestamp']).", ".strftime($minute_format, $row['timestamp'])."</td></tr>";
	
	echo "<tr height='20'><td><b>".$strUser."</b>:&nbsp;&nbsp;</td><td>";
	switch ($row['usertype'])
	{
		case phpAds_userDeliveryEngine:	echo "<img src='images/icon-generatecode.gif' align='absmiddle'>&nbsp;".$strDeliveryEngine; break;
		case phpAds_userMaintenance:	echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;".$strMaintenance; break;
		case phpAds_userAdministrator:	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".$strAdministrator; break;
	}
	echo "</td></tr>";
	
	$action = $strUserlog[$row['action']];
	$action = str_replace ('{id}', $row['object'], $action);
	echo "<tr height='20'><td><b>".$strAction."</b>:&nbsp;&nbsp;</td><td>".$action."</td></tr>";
	echo "</table>";
	
	phpAds_ShowBreak();
	
	echo "<br><br>";
	echo "<pre>".$row['details']."</pre>";
	echo "<br><br>";
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>