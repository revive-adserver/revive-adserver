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

// Required files
require_once MAX_PATH . '/lib/max/language/Loader.php';

// Load the required language files
Language_Loader::load('maintenance');

function phpAds_MaintenanceSelection($subSection, $mainSection = 'maintenance')
{
    ?>
<script language="JavaScript">
<!--
function maintenance_goto_section()
{
    s = document.maintenance_selection.section.selectedIndex;

    s = document.maintenance_selection.section.options[s].value;
    document.location = '<?php echo $mainSection; ?>-' + s + '.php';
}
// -->
</script>
<?php
    $conf = &$GLOBALS['_MAX']['CONF'];
    $pref = &$GLOBALS['_MAX']['PREF'];

    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
    echo "<tr><form name='maintenance_selection'><td height='35'>";
    echo "<b>" . $GLOBALS['strChooseSection'] . ":&nbsp;</b>";
    echo "<select name='section' onChange='maintenance_goto_section();'>";

    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
        if ($mainSection == 'updates') {
            echo "<option value='product'" . ($subSection == 'product' ? ' selected' : '') . ">" . $GLOBALS['strCheckForUpdates'] . "</option>";
            echo "<option value='history'" . ($subSection == 'history' ? ' selected' : '') . ">" . $GLOBALS['strViewPastUpdates'] . "</option>";
        } else {
            echo "<option value='maintenance'" . ($subSection == 'maintenance' ? ' selected' : '') . ">" . $GLOBALS['strMaintenance'] . "</option>";
            echo "<option value='banners'" . ($subSection == 'banners' ? ' selected' : '') . ">" . $GLOBALS['strBanners'] . "</option>";
            echo "<option value='priority'" . ($subSection == 'priority' ? ' selected' : '') . ">" . $GLOBALS['strPriority'] . "</option>";

            $login = 'ftp://' . $conf['store']['ftpUsername'] . ':' . $conf['store']['ftpPassword'] . '@' .
                     $conf['store']['ftpHost'] . '/' . $conf['store']['ftpPath'];
            if ($conf['allowedBanners']['web'] == true && (($conf['store']['mode'] == 0 &&
                $conf['store']['webDir'] != '') || ($conf['store']['mode'] == 1 &&
                $login != '')) && $conf['webpath']['images'] != '') {
                echo "<option value='storage'" . ($subSection == 'storage' ? ' selected' : '') . ">" . $GLOBALS['strStorage'] . "</option>";
            }

//            if (!isset($conf['delivery']['cache']) || $conf['delivery']['cache'] != 'none')
//                echo "<option value='cache'".($subSection == 'zones' ? ' selected' : '').">".$GLOBALS['strCache']."</option>";

            if ($conf['delivery']['acls']) {
                echo "<option value='acls'" . ($subSection == 'acls' ? ' selected' : '') . ">" . $GLOBALS['strDeliveryLimitations'] . "</option>";
            }

            echo "<option value='appendcodes'" . ($subSection == 'appendcodes' ? ' selected' : '') . ">" . $GLOBALS['strAppendCodes'] . "</option>";
            echo "<option value='encoding'" . ($subSection == 'encoding' ? ' selected' : '') . ">" . $GLOBALS['strEncoding'] . "</option>";
            echo "<option value='menus'" . ($subSection == 'menus' ? ' selected' : '') . ">" . $GLOBALS['strMenus'] . "</option>";
            echo "<option value='plugins'" . ($subSection == 'plugins' ? ' selected' : '') . ">" . $GLOBALS['strPlugins'] . "</option>";
            echo "<option value='security'" . ($subSection == 'security' ? ' selected' : '') . ">" . $GLOBALS['strSecurity'] . "</option>";
            echo "<option value='user-passwords'" . ($subSection == 'user-passwords' ? ' selected' : '') . ">" . $GLOBALS['strUserPasswords'] . "</option>";
        }
    }

    // Switched off
    // echo "<option value='finance'".($subSection == 'finance' ? ' selected' : '').">Finance</option>";

    echo "</select>&nbsp;<a href='javascript:void(0)' onClick='maintenance_goto_section();'>";
    echo "<img src='" . OX::assetPath() . "/images/" . $GLOBALS['phpAds_TextDirection'] . "/go_blue.gif' border='0'></a>";
    echo "</td></form></tr>";
    echo "</table>";

    phpAds_ShowBreak();
}

?>
