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

require_once LIB_PATH.'/Plugin/Component.php';

class Plugins_Admin_TestPlugin_TestPlugin extends OX_Component
{

    function afterLogin()
    {
        global $userLoggedIn;
        $userLoggedIn = true;
        return true;
    }

}

?>