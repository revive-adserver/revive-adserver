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

require __DIR__ . '/data/res-iso3166-1.inc.php';
require __DIR__ . '/data/res-iso3166-2-S2.inc.php';

$res = [
    array_filter($RV_Geo_ISO3166_1, function ($code) use ($RV_Geo_ISO3166_2_S2) {
        return isset($RV_Geo_ISO3166_2_S2[$code]);
    }, ARRAY_FILTER_USE_KEY),
    $RV_Geo_ISO3166_2_S2,
];
