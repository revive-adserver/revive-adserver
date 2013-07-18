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

require_once(MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php');

class Plugins_Admin_TestPlugin_TestPluginChecker 
    implements OA_Admin_Menu_IChecker
{
    public function check($oSection) 
    {
        return true;
    }
}

?>