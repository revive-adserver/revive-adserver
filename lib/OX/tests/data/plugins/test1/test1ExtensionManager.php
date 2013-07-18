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

require_once(LIB_PATH.'/Extension/ExtensionCommon.php');

class OX_Extension_foo extends OX_Extension_Common
{
    function __construct()
    {

    }

    function runTasksTestEvent()
    {
        return 'Test Task OK';
    }

}

?>