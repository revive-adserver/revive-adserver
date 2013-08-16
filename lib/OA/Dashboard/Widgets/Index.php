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

require_once MAX_PATH . '/lib/OA/Dashboard/Widget.php';

/**
 * A class to display the dashboard iframe container
 *
 */
class OA_Dashboard_Widget_Index extends OA_Dashboard_Widget
{
    /**
     * A method to launch and display the widget
     *
     */
    function display()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        phpAds_PageHeader(null, new OA_Admin_UI_Model_PageHeaderModel(), '', false, false);

        $oTpl = new OA_Admin_Template('dashboard/main.html');

        if (!$aConf['ui']['dashboardEnabled'] || !$aConf['sync']['checkForUpdates']) {
            $dashboardUrl = MAX::constructURL(MAX_URL_ADMIN, 'dashboard.php?widget=Disabled');
        } else {
            $dashboardUrl = MAX::constructURL(MAX_URL_ADMIN, 'dashboard.php?widget=Grid');
        }

        $oTpl->assign('dashboardURL', $dashboardUrl);

        $oTpl->display();

        phpAds_PageFooter('', true);
    }
}

?>
