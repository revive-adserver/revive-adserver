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

/**
 * An acceptor that can be used to filter out sections from collections.
 * For every section it invokes its related checker and returns the result of the check.
 */
class OA_Admin_SectionCheckerFilter
{
    function __construct()
    {
    }


    function accept($oSection)
    {
        return $oSection->check();
    }
}
?>