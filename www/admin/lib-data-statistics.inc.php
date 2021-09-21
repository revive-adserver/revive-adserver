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

function phpAds_sortArray(&$array, $column = 0, $ascending = true)
{
    for ($i = 0; $i < sizeof($array); $i++) {
        if (isset($array[$i]['children']) && is_array($array[$i]['children'])) {
            phpAds_sortArray($array[$i]['children'], $column, $ascending);
        }
    }

    phpAds_qsort($array, $column, $ascending);
}

function phpAds_qsort(&$array, $column = 0, $ascending = true, $first = 0, $last = 0)
{
    if ($last == 0) {
        $last = count($array) - 1;
    }

    if ($last > $first) {
        $alpha = $first;
        $omega = $last;
        $mid = floor(($alpha + $omega) / 2);
        $guess = $array[$mid][$column];

        while ($alpha <= $omega) {
            if ($ascending) {
                while (($array[$alpha][$column] < $guess) && ($alpha < $last)) {
                    $alpha++;
                }
                while (($array[$omega][$column] > $guess) && ($omega > $first)) {
                    $omega--;
                }
            } else {
                while (($array[$alpha][$column] > $guess) && ($alpha < $last)) {
                    $alpha++;
                }
                while (($array[$omega][$column] < $guess) && ($omega > $first)) {
                    $omega--;
                }
            }

            if ($alpha <= $omega) {
                $temp = $array[$alpha];
                $array[$alpha] = $array[$omega];
                $array[$omega] = $temp;

                $alpha++;
                $omega--;
            }
        }

        if ($first < $omega) {
            phpAds_qsort($array, $column, $ascending, $first, $omega);
        }
        if ($alpha < $last) {
            phpAds_qsort($array, $column, $ascending, $alpha, $last);
        }
    }
}
