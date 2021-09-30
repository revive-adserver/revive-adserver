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
 * A class to display the dashboard iframe content
 *
 */
class OA_Dashboard_Widget_Grid extends OA_Dashboard_Widget
{
    /**
     * A method to launch and display the widget
     *
     */
    public function display($aParams = [])
    {
        $oTpl = new OA_Admin_Template('dashboard/grid.html');

        $oTpl->assign('dashboardURL', MAX::constructURL(MAX_URL_ADMIN, 'dashboard.php'));
        $oTpl->assign('cssURL', OX::assetPath() . "/css");
        $oTpl->assign('imageURL', OX::assetPath() . "/images");
        $oTpl->assign('jsURL', OX::assetPath() . "/js");

        $oTpl->display();
    }
}
