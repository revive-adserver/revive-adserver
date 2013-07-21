<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Get userlog data and enforce it exists
$doUserLog = OA_Dal::staticGetDO('userlog', $userlogid);
OA_Permission::enforceTrue($doUserLog);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader('userlog-index');
phpAds_UserlogSelection("maintenance");

// Load the required language files
Language_Loader::load('userlog');

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if ($row = $doUserLog->toArray())
{
	echo "<br />";
	echo "<table cellpadding='0' cellspacing='0' border='0'>";

	echo "<tr height='20'><td><b>".$strDate."</b>:&nbsp;&nbsp;</td>";
	echo "<td>".strftime($date_format, $row['timestamp']).", ".strftime($minute_format, $row['timestamp'])."</td></tr>";

	echo "<tr height='20'><td><b>".$strUser."</b>:&nbsp;&nbsp;</td><td>";
	switch ($row['usertype'])
	{
		case phpAds_userDeliveryEngine:	echo "<img src='" . OX::assetPath() . "/images/icon-generatecode.gif' align='absmiddle'>&nbsp;".$strDeliveryEngine; break;
		case phpAds_userMaintenance:	echo "<img src='" . OX::assetPath() . "/images/icon-time.gif' align='absmiddle'>&nbsp;".$strMaintenance; break;
		case phpAds_userAdministrator:	echo "<img src='" . OX::assetPath() . "/images/icon-advertiser.gif' align='absmiddle'>&nbsp;".$strAdministrator; break;
	}
	echo "</td></tr>";

	$action = $strUserlog[$row['action']];
	$action = str_replace ('{id}', $row['object'], $action);
	echo "<tr height='20'><td><b>".$strAction."</b>:&nbsp;&nbsp;</td><td>".$action."</td></tr>";
	echo "</table>";

	phpAds_ShowBreak();

	echo "<br /><br />";
	echo "<pre>".$row['details']."</pre>";
	echo "<br /><br />";
}



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>