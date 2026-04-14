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

if (!function_exists('each')) {
    function each(&$array)
    {
        $key = key($array);

        if (null === $key) {
            return false;
        }

        $value = current($array);
        next($array);

        return [
            0 => $key,
            1 => $value,
            'key' => $key,
            'value' => $value,
        ];
    }
}
