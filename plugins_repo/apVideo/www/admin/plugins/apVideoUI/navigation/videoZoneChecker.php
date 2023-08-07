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

require_once MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php';
require_once MAX_PATH . '/plugins/apVideo/lib/Dal/Admin.php';


class Plugins_admin_apVideoUI_videoZoneChecker implements OA_Admin_Menu_IChecker
{
    public function check($oSection)
    {
        $affiliateId = (int) ($GLOBALS['affiliateid'] ?? 0);
        $zoneId = (int) ($GLOBALS['zoneid'] ?? 0);

        if (!AP_Video_Dal_Admin::isVideoZone($zoneId)) {
            // We don't want to disable the menu for non-video
            return true;
        }

        $oSection->setLink("plugins/apVideoUI/zone-invocation.php?affiliateid={$affiliateId}&zoneid={$zoneId}");
        $oSection->setNameKey('VAST2 Invocation Code');

        return true;
    }
}