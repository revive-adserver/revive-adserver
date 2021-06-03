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

class Plugins_testExtension1_testGroup1_testComponent1 extends OX_Component
{

    public static function staticMethod()
    {
        return 'staticMethodResult1';
    }

    public static function staticMethodWithParams($result)
    {
        return 'staticMethodWithParams1='.$result;
    }

    function hookHandler()
    {
        return 'testGroup1:testComponent1 hook handled';
    }


}

?>