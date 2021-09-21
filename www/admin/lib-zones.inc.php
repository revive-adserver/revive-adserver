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

// Set define to prevent duplicate include
define('LIBZONES_INCLUDED', true);

// Define zonetypes
define("phpAds_ZoneBanners", 0);
define("phpAds_ZoneInteractive", 1);
define("phpAds_ZoneRaw", 2);
define("phpAds_ZoneCampaign", 3);

// delivery
define("phpAds_ZoneBanner", 0);
define("phpAds_ZoneInterstitial", 1);
define("phpAds_ZonePopup", 2);
define("phpAds_ZoneText", 3);
define("MAX_ZoneEmail", 4);
define("MAX_ZoneClick", 5);
define("MAX_ZoneMarketMigrated", 'market-zone-migrated');
define("OX_ZoneVideoInstream", 6);
define("OX_ZoneVideoOverlay", 7);

// Define appendtypes
define("phpAds_ZoneAppendRaw", 0);
define("phpAds_ZoneAppendZone", 1);

/*-------------------------------------------------------*/
/* Fetch parameters from append code                     */
/*-------------------------------------------------------*/

function phpAds_ZoneParseAppendCode($append)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $ret = [
        ['zoneid' => '', 'delivery' => phpAds_ZonePopup],
        []
    ];
    if (preg_match("/ad(popup|layer)\.php\?([^'\"]+)['\"]/D", $append, $match)) {
        if (!empty($match[2])) {
            $ret[0]['delivery'] = ($match[1] == 'popup') ? phpAds_ZonePopup : phpAds_ZoneInterstitial;
            $append = str_replace('&amp;', '&', $match[2]);
            if (preg_match('/[?&]what=zone:([0-9]+)(&|$)/D', $append, $match)) {
                $ret[0]['zoneid'] = $match[1];
                $append = explode('&', $append);
                foreach ($append as $v) {
                    $v = explode('=', $v);
                    if (count($v) == 2) {
                        $ret[1][urldecode($v[0])] = urldecode($v[1]);
                    }
                }
            }
        }
    }
    return $ret;
}
