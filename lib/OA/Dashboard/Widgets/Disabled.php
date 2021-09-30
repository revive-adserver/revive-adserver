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

require_once LIB_PATH . '/Admin/Redirect.php';

/**
 * A class to display the disabled dashboard iframe content
 *
 */
class OA_Dashboard_Widget_Disabled extends OA_Dashboard_Widget
{
    /**
     * A method to launch and display the widget
     *
     */
    public function display($aParams = [])
    {
        $oTpl = new OA_Admin_Template('dashboard/disabled.html');
        $oTpl->assign('isAdmin', OA_Permission::isAccount(OA_ACCOUNT_ADMIN));

        $oTpl->display();
    }
}
