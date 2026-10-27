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
$doApplicationVariable = OA_Dal::factoryDO('application_variable');
$doApplicationVariable->name = 'oa_version';
$doApplicationVariable->find();
$doApplicationVariable->fetch();

$current = $strCurrentlyUsing . ' ' . PRODUCT_NAME . '&nbsp;v' . VERSION . ' ' . ($doApplicationVariable->value != VERSION ? '(warning: database is stamped as v' . $doApplicationVariable->value . ') ' : '');
$current .= $strRunningOn . ' ' . str_replace('/', '&nbsp;', preg_replace("/ .*$/D", '', $_SERVER["SERVER_SOFTWARE"])) . ', ';
$current .= 'PHP&nbsp;' . phpversion() . ' ' . $strAndPlain . ' ' . phpAds_dbmsname;

// Get the database version number.
$connection = DBC::getCurrentConnection();
$connectionId = $connection->getConnectionId();
$aVersion = $connectionId->getServerVersion();
$current .= '&nbsp;' . $aVersion['major'] . '.' . $aVersion['minor'] . '.' . $aVersion['patch'] . '-' . $aVersion['extra'];

echo "<br />" . $current . ".<br /><br />";
phpAds_ShowBreak();

if (!isset($session['maint_update'])) {
    // Show wait please text with rotating logo
    echo "<br />";
    echo "<table border='0' cellspacing='1' cellpadding='2'><tr><td>";
    echo "<img src='" . OX::assetPath() . "/images/install-busy.gif' width='16' height='16'>";
    echo "</td><td class='install'>" . $strSearchingUpdates . "</td></tr></table>";
    // Send the output to the browser
    if (false !== ob_get_contents()) {
        ob_flush();
    }
    flush();

    // Get updates info and store them into a session var
    $oSync = RV_getContainer()->get(\RV\Sync::class);
    $res = $oSync->checkForUpdates();
    phpAds_SessionDataRegister('maint_update', $res);
    phpAds_SessionDataStore();

    echo "<script language='JavaScript'>\n";
    echo "<!--\n";
    echo "document.location.replace('updates-product.php');\n";
    echo "//-->\n";
    echo "</script>\n";
    exit();
}
$maint_update = $session['maint_update'];
unset($session['maint_update']);
phpAds_SessionDataStore();
if ($maint_update[0] > 0 && $maint_update[0] != 800) {
    $errorMessage = $strErrorOccurred . ": {$maint_update[1]} (code: {$maint_update[0]})";
    phpAds_Die(htmlentities($errorMessage), $strUpdateServerDown);
}
echo "<br /><br />";
if ($maint_update[0] == 800) {
    echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='24' valign='top'>";
    echo "<img src='" . OX::assetPath() . "/images/info.gif'>&nbsp;&nbsp;";
    echo "</td><td valign='top'><b>" . $strNoNewVersionAvailable . "</b>";
    echo "</td></tr></table><br />";
    phpAds_ShowBreak();
} elseif ($maint_update[0] == -1) {
    echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='24' valign='top'>";
    echo "<img src='" . OX::assetPath() . "/images/error.gif'>&nbsp;&nbsp;";
    echo "</td><td valign='top'><b>" . $strServerCommunicationError . "</b>";
    echo "</td></tr></table><br />";
    phpAds_ShowBreak();
} elseif ($maint_update[0] == -2) {
    echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='24' valign='top'>";
    echo "<img src='" . OX::assetPath() . "/images/error.gif'>&nbsp;&nbsp;";
    echo "</td><td valign='top'><b>" . $strCheckForUpdatesDisabled . "</b>";
    echo "</td></tr></table><br />";
    phpAds_ShowBreak();
} elseif (is_array($maint_update[1])) {
    echo "<table border='0' cellspacing='0' cellpadding='0'><tr><td width='24' valign='top'>";
    $updates = \RV\Sync::normalizeUpdates($maint_update[1]);
    $securityUpdates = array_filter($updates, static fn($update) => $update['security_fix'] == 1);
    if ($securityUpdates !== []) {
        $updates = array_values($securityUpdates);
    }
    if ($securityUpdates !== []) {
        echo "<img src='" . OX::assetPath() . "/images/error.gif'>&nbsp;&nbsp;";
        echo "</td><td valign='top'>" . $strSecurityUpdate;
    } else {
        echo "<img src='" . OX::assetPath() . "/images/info.gif'>&nbsp;&nbsp;";
        echo "</td><td valign='top'>" . $strNewVersionAvailable;
    }
    echo "</td></tr></table>";
    echo "<br />";
    phpAds_ShowBreak();
    echo "<br /><br />";
    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
    echo "<tr height='25'><td height='25'>&nbsp;&nbsp;<b>" . $strAvailableUpdates . "</b></td></tr>";
    echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
    $updateIndex = 0;
    foreach ($updates as $update) {
        echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' valign='top' nowrap>";
        echo "<br />&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-setup.gif' align='absmiddle'>&nbsp;";
        echo htmlspecialchars($update['product_name'], ENT_QUOTES) . " " . htmlspecialchars($update['config_readable'], ENT_QUOTES) . "</td>";
        echo "<td width='32'>&nbsp;</td>";
        echo "<td><br />" . $update['description'] . "<br /><br />";
        echo "</td>";
        echo "<td width='32'>&nbsp;</td>";
        echo "</tr>";
        if ($update['url_zip'] != '' || $update['url_tgz'] != '') {
            echo "<tr height='1'><td colspan='2' bgcolor='#F6F6F6'><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'>";
            echo "<td colspan='2' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%'></td></tr>";
            echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='2'>&nbsp;&nbsp;</td><td>";
            if ($update['url_zip'] != '') {
                echo "<img src='" . OX::assetPath() . "/images/icon-filetype-zip.gif' align='absmiddle'>&nbsp;";
                echo "<a href='" . htmlspecialchars($update['url_zip'], ENT_QUOTES) . "'>" . $strDownloadZip . "</a>";
                if ($update['url_tgz'] != '') {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }
            }
            if ($update['url_tgz'] != '') {
                echo "<img src='" . OX::assetPath() . "/images/icon-filetype-zip.gif' align='absmiddle'>&nbsp;";
                echo "<a href='" . htmlspecialchars($update['url_tgz'], ENT_QUOTES) . "'>" . $strDownloadGZip . "</a>";
            }
            echo "</td><td>&nbsp;</td></tr>";
        }
        echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
        if ($updateIndex === 0 && count($updates) > 1) {
            echo "<tr><td colspan='4' style='padding: 8px 10px;'>&nbsp;<br /><b>" . $strAlternativeUpdateOptions . "</b><br />&nbsp;</td></tr>";
            echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
        }
        ++$updateIndex;
    }
    echo "</table>";
} else {
    phpAds_Die($strErrorOccurred, $strUpdateServerDown);
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();
