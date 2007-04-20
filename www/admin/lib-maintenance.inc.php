<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
require_once MAX_PATH . '/lib/max/language/Maintenance.php';

// Load the required language files
Language_Maintenance::load();

function phpAds_MaintenanceSelection($section)
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
    ;

?>
<script language="JavaScript">
<!--
function maintenance_goto_section()
{
    s = document.maintenance_selection.section.selectedIndex;

    s = document.maintenance_selection.section.options[s].value;
    document.location = 'maintenance-' + s + '.php';
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

    if (phpAds_isUser(phpAds_Admin)) {
        echo "<option value='maintenance'".($section == 'maintenance' ? ' selected' : '').">".$strMaintenance."</option>";
        echo "<option value='banners'".($section == 'banners' ? ' selected' : '').">".$strBanners."</option>";
        echo "<option value='priority'".($section == 'priority' ? ' selected' : '').">".$strPriority."</option>";

        $login = 'ftp://' . $conf['store']['ftpUsername'] . ':' . $conf['store']['ftpPassword'] . '@' .
                 $conf['store']['ftpHost'] . '/' . $conf['store']['ftpPath'];
        if ($pref['type_web_allow'] == true && (($conf['store']['mode'] == 0 &&
            $conf['store']['webDir'] != '') || ($conf['store']['mode'] == 1 &&
            $login != '')) && $conf['webpath']['images'] != '')
            echo "<option value='storage'".($section == 'storage' ? ' selected' : '').">".$strStorage."</option>";

        if (!isset($conf['delivery']['cache']) || $conf['delivery']['cache'] != 'none')
            echo "<option value='cache'".($section == 'zones' ? ' selected' : '').">".$strCache."</option>";

        if ($conf['delivery']['acls']) {
            echo "<option value='acls'".($section == 'acls' ? ' selected' : '').">Delivery Limitations</option>";
        }

        echo "<option value='appendcodes'".($section == 'appendcodes' ? ' selected' : '').">Append codes</option>";
    }

    echo "<option value='finance'".($section == 'finance' ? ' selected' : '').">Finance</option>";

    echo "</select>&nbsp;<a href='javascript:void(0)' onClick='maintenance_goto_section();'>";
    echo "<img src='images/".$phpAds_TextDirection."/go_blue.gif' border='0'></a>";
    echo "</td></form></tr>";
      echo "</table>";

    phpAds_ShowBreak();
}

?>
