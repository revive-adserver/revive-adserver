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


class Plugins_admin_apVideoUI_videoBannerChecker extends Plugins_admin_apVideoUI_CachingChecker
{
    protected function getCacheKey($oSection): string
    {
        return $GLOBALS['bannerid'];
    }

    public function _check($oSection, $key): bool
    {
        if (!AP_Video_Dal_Admin::isInlineVideoBanner($key)) {
            return false;
        }

        $oTrans = new OX_Translation($GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] . '/apVideoUI/_lang');
        $oSection->setNameKey($oTrans->translate('Alternate Media'));

        return true;
    }
}

class Plugins_admin_apVideoUI_videoTrackerChecker extends Plugins_admin_apVideoUI_CachingChecker
{
    protected function getCacheKey($oSection): string
    {
        return $GLOBALS['bannerid'];
    }

    public function _check($oSection, $key): bool
    {
        if (!AP_Video_Dal_Admin::isAnyVideoBanner($key)) {
            return false;
        }
        $oTrans = new OX_Translation($GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] . '/apVideoUI/_lang');
        $oSection->setNameKey($oTrans->translate('Additional Trackers'));

        return true;
    }
}
