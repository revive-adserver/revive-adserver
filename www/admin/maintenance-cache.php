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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
$file = MAX_PATH . '/lib/max/deliverycache/cache-file.inc.php';
if (file_exists($file)) {
    include_once $file;
}

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.5");
phpAds_ShowSections(array("5.1", "5.2", "5.3", "5.5", "5.6", "5.4"));
phpAds_MaintenanceSelection("zones");



/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

function phpAds_showCache ()
{
	$conf = $GLOBALS['_MAX']['CONF'];
	global $strSize, $strKiloByte;
	global $phpAds_TextDirection;

	$rows = phpAds_cacheInfo();

	if (is_array($rows)) {
		$i=0;

		// Header
		echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
		echo "<tr height='25'>";
		echo "<td height='25'><b>".$strSize."</b></td>";
		echo "</tr>";

		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";

		foreach (array_keys($rows) as $key) {
			strtok($key, "=");
			$what = strtok("&");

			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td></tr>";

	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";

			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";

			// Icon
			if (substr($what,0,5) == 'zone:')
				echo "<img src='" . OX::assetPath() . "/images/icon-zone.gif' align='absmiddle'>&nbsp;";
			else
				echo "<img src='" . OX::assetPath() . "/images/icon-generatecode.gif' align='absmiddle'>&nbsp;";


			// Name
			echo $what;
			echo "</td>";

			echo "<td height='25'>".round ($rows[$key] / 1024)." ".$strKiloByte."</td>";

			echo "</tr>";
			$i++;
		}

		// Footer
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
		echo "</table>";
	}
}


echo "<br />".$strDeliveryCacheExplaination;

if (!empty($conf['delivery']['cache'])) {
    switch ($conf['delivery']['cache'])
    {
    	case 'shm': 		echo $strDeliveryCacheSharedMem; break;
    	case 'sysvshm': 	echo $strDeliveryCacheSharedMem; break;
    	case 'file': 		echo $strDeliveryCacheFiles; break;
    	default:    		echo $strDeliveryCacheDatabase; break;
    }
} else {
    echo $strDeliveryCacheDatabase;
}
echo "<br /><br />";

phpAds_ShowBreak();

echo "<img src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='maintenance-cache-rebuild.php'>$strRebuildDeliveryCache</a>&nbsp;&nbsp;";
phpAds_ShowBreak();

echo "<br /><br />";
phpAds_showCache();
echo "<br /><br />";



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
