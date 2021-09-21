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
 * Various array utilities.
 *
 */
class ArrayUtils
{
    /**
     * Searches the $aValues for the first occurence of $oValue. If the value
     * is found and its key is numeric, it is unset from the array. The array
     * is passed as reference.
     *
     * @param array $aValues
     * @param object $value
     */
    public static function unsetIfKeyNumeric(&$aValues, $oValue)
    {
        $key = array_search($oValue, $aValues);
        if (is_numeric($key)) {
            unset($aValues[$key]);
        }
    }
}
