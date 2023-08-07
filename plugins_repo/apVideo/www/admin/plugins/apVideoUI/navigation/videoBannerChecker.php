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


class Plugins_admin_apVideoUI_videoBannerChecker implements OA_Admin_Menu_IChecker
{
    public function check($oSection)
    {
        return AP_Video_Dal_Admin::isInlineVideoBanner($GLOBALS['bannerid']);
    }
}

class Plugins_admin_apVideoUI_videoVpaidChecker extends Plugins_admin_apVideoUI_videoBannerChecker
{
    public function check($oSection)
    {
        $url = $GLOBALS['_MAX']['CONF']['apVideo']['swfUrl'];
        return !empty($url) && $url != 'http://' && parent::check($oSection);
    }
}

class Plugins_admin_apVideoUI_videoTrackerChecker implements OA_Admin_Menu_IChecker
{
    public function check($oSection)
    {
        return AP_Video_Dal_Admin::isAnyVideoBanner($GLOBALS['bannerid']);
    }
}
