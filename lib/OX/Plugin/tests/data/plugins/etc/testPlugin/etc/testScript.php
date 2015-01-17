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

$className = 'OX_testScript';


class OX_testScript
{
    function __construct()
    {

    }

    function execute($aParams='')
    {
        global $testScriptResult;
        $testScriptResult = true;
        return true;
    }

}