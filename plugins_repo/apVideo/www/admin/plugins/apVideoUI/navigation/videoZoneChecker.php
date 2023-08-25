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

require_once __DIR__ . '/CachingChecker.php';
require_once MAX_PATH . '/plugins/apVideo/lib/Dal/Admin.php';


class Plugins_admin_apVideoUI_videoZoneChecker extends Plugins_admin_apVideoUI_CachingChecker
{
    protected function getCacheKey($oSection): string
    {
        return join(',', [
            (int) ($GLOBALS['affiliateid'] ?? 0),
            (int) ($GLOBALS['zoneid'] ?? 0),
        ]);
    }

    protected function _check($oSection, $key): bool
    {
        [$affiliateId, $zoneId] = explode(',', $key);

        if (!AP_Video_Dal_Admin::isVideoZone($zoneId)) {
            // We don't want to disable the menu for non-video
            return true;
        }

        $oTrans = new OX_Translation($GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] . '/apVideoUI/_lang');

        $oSection->setLink("plugins/apVideoUI/zone-invocation.php?affiliateid={$affiliateId}&zoneid={$zoneId}");
        $oSection->setNameKey($oTrans->translate('VAST2 Invocation Code'));

        return true;
    }
}
