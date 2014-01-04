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
require_once MAX_PATH . '/lib/RV/Sync.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("updates-index");
phpAds_MaintenanceSelection("product", "updates");


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Determine environment
$doApplicationVariable          = OA_Dal::factoryDO('application_variable');
$doApplicationVariable->name    = 'oa_version';
$doApplicationVariable->find();
$doApplicationVariable->fetch();

$current  = $strCurrentlyUsing.' '.MAX_PRODUCT_NAME.'&nbsp;v'.OA_VERSION.' '.($doApplicationVariable->value!=OA_VERSION ? '(warning: database is stamped as v'.$doApplicationVariable->value.') ' : '');
$current .= $strRunningOn.' '.str_replace('/', '&nbsp;', ereg_replace(" .*$", '', $_SERVER["SERVER_SOFTWARE"])).', ';
$current .= 'PHP&nbsp;'.phpversion().' '.$strAndPlain.' '.phpAds_dbmsname;

// Get the database version number.
$connection = DBC::getCurrentConnection();
$connectionId = $connection->getConnectionId();
$aVersion = $connectionId->getServerVersion();
$current .= '&nbsp;' . $aVersion['major'] . '.' . $aVersion['minor'] . '.' . $aVersion['patch'] . '-' . $aVersion['extra'];

echo "<br />".$current.".<br /><br />";
phpAds_ShowBreak();

if (!isset($session['maint_update'])) {
    if (function_exists('xml_parser_create')) {
        // Show wait please text with rotating logo
        echo "<br />";
        echo "<table border='0' cellspacing='1' cellpadding='2'><tr><td>";
        echo "<img src='" . OX::assetPath() . "/images/install-busy.gif' width='16' height='16'>";
        echo "</td><td class='install'>".$strSearchingUpdates."</td></tr></table>";
        // Send the output to the browser
        if (false !== ob_get_contents()) {
          ob_flush();
        }
        flush();

        // Get updates info and store them into a session var
        $oSync = new RV_Sync();
        $res = $oSync->checkForUpdates();
        phpAds_SessionDataRegister('maint_update', $res);
        phpAds_SessionDataStore();

        echo "<script language='JavaScript'>\n";
        echo "<!--\n";
        echo "document.location.replace('updates-product.php');\n";
        echo "//-->\n";
        echo "</script>\n";
        exit();
    } else {
        echo "<br />".$strNotAbleToCheck."<br /><br />";
        echo "<br /><br />".$strForUpdatesLookOnWebsite."<br /><br />";
        echo "<b><img src='" . OX::assetPath() . "/images/caret-r.gif'>&nbsp;<a href='http://".$phpAds_producturl."' target='_blank'>".$strClickToVisitWebsite."</a></b>";
    }
} else {
    $maint_update = $session['maint_update'];
    unset($session['maint_update']);
    phpAds_SessionDataStore();

    if ($maint_update[0] > 0 && $maint_update[0] != 800) {
        $errorMessage = $strErrorOccurred.": {$maint_update[1]} (code: {$maint_update[0]})";
        phpAds_Die (htmlentities($errorMessage), $strUpdateServerDown);
    }
    echo "<br /><br />";
    if ($maint_update[0] == 800) {
        echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='24' valign='top'>";
        echo "<img src='" . OX::assetPath() . "/images/info.gif'>&nbsp;&nbsp;";
        echo "</td><td valign='top'><b>".$strNoNewVersionAvailable."</b>";
        echo "</td></tr></table><br />";
        phpAds_ShowBreak();

    } elseif ($maint_update[0] == -1) {
        echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='24' valign='top'>";
        echo "<img src='" . OX::assetPath() . "/images/error.gif'>&nbsp;&nbsp;";
        echo "</td><td valign='top'><b>".$strServerCommunicationError."</b>";
        echo "</td></tr></table><br />";
        phpAds_ShowBreak();

    } elseif ($maint_update[0] == -2) {
        echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='24' valign='top'>";
        echo "<img src='" . OX::assetPath() . "/images/error.gif'>&nbsp;&nbsp;";
        echo "</td><td valign='top'><b>".$strCheckForUpdatesDisabled."</b>";
        echo "</td></tr></table><br />";
        phpAds_ShowBreak();

    } elseif (is_array($maint_update[1])) {
        echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='24' valign='top'>";
        if ($maint_update[1]['security_fix'] == 1) {
            echo "<img src='" . OX::assetPath() . "/images/error.gif'>&nbsp;&nbsp;";
            echo "</td><td valign='top'>".$strSecurityUpdate;
        } else {
            echo "<img src='" . OX::assetPath() . "/images/info.gif'>&nbsp;&nbsp;";
            echo "</td><td valign='top'>".$strNewVersionAvailable;
        }
        echo "</td></tr></table>";
        echo "<br />";
        phpAds_ShowBreak();
        echo "<br /><br />";
        echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        echo "<tr height='25'><td height='25'>&nbsp;&nbsp;<b>".$strAvailableUpdates."</b></td></tr>";
        echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
        echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' valign='top' nowrap>";
        echo "<br />&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-setup.gif' align='absmiddle'>&nbsp;";
        echo $maint_update[1]['product_name']." ".$maint_update[1]['config_readable']."</td>";
        echo "<td width='32'>&nbsp;</td>";
        echo "<td><br />".$maint_update[1]['description']."<br /><br />";
        echo "</td>";
        echo "<td width='32'>&nbsp;</td>";
        echo "</tr>";
        if ($maint_update[1]['url_zip'] != '' || $maint_update[1]['url_tgz'] != '') {
            echo "<tr height='1'><td colspan='2' bgcolor='#F6F6F6'><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'>";
            echo "<td colspan='2' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%'></td></tr>";
            echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='2'>&nbsp;&nbsp;</td><td>";
            if ($maint_update[1]['url_zip'] != '') {
                echo "<img src='" . OX::assetPath() . "/images/icon-filetype-zip.gif' align='absmiddle'>&nbsp;";
                echo "<a href='".$maint_update[1]['url_zip']."'>".$strDownloadZip."</a>";
                if ($maint_update[1]['url_tgz'] != '') {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }
            }
            if ($maint_update[1]['url_tgz'] != '') {
                echo "<img src='" . OX::assetPath() . "/images/icon-filetype-zip.gif' align='absmiddle'>&nbsp;";
                echo "<a href='".$maint_update[1]['url_tgz']."'>".$strDownloadGZip."</a>";
            }
            echo "</td><td>&nbsp;</td></tr>";
        }
        echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
        echo "</table>";

    } else {
        phpAds_Die($strErrorOccurred, $strUpdateServerDown);
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
