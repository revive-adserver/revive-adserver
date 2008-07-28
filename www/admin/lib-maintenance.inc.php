<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Required files
require_once MAX_PATH . '/lib/max/language/Loader.php';

// Load the required language files
Language_Loader::load('maintenance');

function phpAds_MaintenanceSelection($subSection, $mainSection='maintenance')
{
    global
         $phpAds_TextDirection
        ,$strBanners
        ,$strCache
        ,$strChooseSection
        ,$strPriority
        ,$strSourceEdit
        ,$strStats
        ,$strStorage
        ,$strMaintenance
        ,$strCheckForUpdates
        ,$strViewPastUpdates
        ,$strEncoding
        ,$strDeliveryLimitations
        ,$strAppendCodes
        ,$strMenus
        ,$strPlugins
    ;

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
    $conf =& $GLOBALS['_MAX']['CONF'];
    $pref =& $GLOBALS['_MAX']['PREF'];

    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
    echo "<tr><form name='maintenance_selection'><td height='35'>";
    echo "<b>".$strChooseSection.":&nbsp;</b>";
    echo "<select name='section' onChange='maintenance_goto_section();'>";

    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
        if ($mainSection == 'updates') {
            echo "<option value='product'".($subSection == 'product' ? ' selected' : '').">".$strCheckForUpdates."</option>";
            echo "<option value='history'".($subSection == 'history' ? ' selected' : '').">".$strViewPastUpdates."</option>";
        } else {
            echo "<option value='maintenance'".($subSection == 'maintenance' ? ' selected' : '').">".$strMaintenance."</option>";
            echo "<option value='banners'".($subSection == 'banners' ? ' selected' : '').">".$strBanners."</option>";
            echo "<option value='priority'".($subSection == 'priority' ? ' selected' : '').">".$strPriority."</option>";

            $login = 'ftp://' . $conf['store']['ftpUsername'] . ':' . $conf['store']['ftpPassword'] . '@' .
                     $conf['store']['ftpHost'] . '/' . $conf['store']['ftpPath'];
            if ($conf['allowedBanners']['web'] == true && (($conf['store']['mode'] == 0 &&
                $conf['store']['webDir'] != '') || ($conf['store']['mode'] == 1 &&
                $login != '')) && $conf['webpath']['images'] != '')
                echo "<option value='storage'".($subSection == 'storage' ? ' selected' : '').">".$strStorage."</option>";

//            if (!isset($conf['delivery']['cache']) || $conf['delivery']['cache'] != 'none')
//                echo "<option value='cache'".($subSection == 'zones' ? ' selected' : '').">".$strCache."</option>";

            if ($conf['delivery']['acls']) {
                echo "<option value='acls'".($subSection == 'acls' ? ' selected' : '').">".$strDeliveryLimitations."</option>";
            }

            echo "<option value='appendcodes'".($subSection == 'appendcodes' ? ' selected' : '').">".$strAppendCodes."</option>";
            echo "<option value='encoding'".($subSection == 'encoding' ? ' selected' : '').">$strEncoding</option>";
            echo "<option value='menus'".($subSection == 'menus' ? ' selected' : '').">".$strMenus."</option>";
            echo "<option value='plugins'".($subSection == 'plugins' ? ' selected' : '').">".$strPlugins."</option>";
        }
    }

    // Switched off
    // echo "<option value='finance'".($subSection == 'finance' ? ' selected' : '').">Finance</option>";

    echo "</select>&nbsp;<a href='javascript:void(0)' onClick='maintenance_goto_section();'>";
    echo "<img src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/go_blue.gif' border='0'></a>";
    echo "</td></form></tr>";
      echo "</table>";

    phpAds_ShowBreak();
}

?>
