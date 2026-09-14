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

function phpAds_getPref($page_name, $var)
{
    global $session;

    return $session['prefs'][$page_name][$var] ?? '';
}

function phpAds_getPrefArray($page_name, $var)
{
    global $session;

    if (isset($session['prefs'][$page_name][$var])) {
        return explode(",", $session['prefs'][$page_name][$var]);
    }

    return [];
}

function phpAds_updateExpandArray($expand_arr, $expand, $collapse)
{
    if (!in_array($expand, [null, 'none', 'all']) && !in_array($expand, $expand_arr)) {
        $expand_arr[] = $expand;
    }

    $index = array_search($collapse, $expand_arr);
    if (is_int($index)) {
        unset($expand_arr[$index]);
    }

    $index = array_search('', $expand_arr);
    if (is_int($index)) {
        unset($expand_arr[$index]);
    }

    return $expand_arr;
}

function phpAds_setPref($page_name, $var, $value)
{
    global $session;

    $session['prefs'][$page_name][$var] = $value;
}
