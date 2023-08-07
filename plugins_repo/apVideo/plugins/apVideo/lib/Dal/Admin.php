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

class AP_Video_Dal_Admin
{
    private static $aInlineVideoBanners = [];
    private static $aAnyVideoBanners = [];
    private static $aVideoZones = [];

    /**
     * @param int $adId
     * @return bool
     */
    public static function isInlineVideoBanner($adId)
    {
        if (isset(self::$aInlineVideoBanners[$adId])) {
            return self::$aInlineVideoBanners[$adId];
        }

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->bannerid = $adId;
        $doBanners->width = $doBanners->height = -3;
        $doBanners->ext_bannertype = 'bannerTypeHtml:vastInlineBannerTypeHtml:vastInlineHtml';

        self::$aInlineVideoBanners[$adId] = (bool)$doBanners->find();
        return self::$aInlineVideoBanners[$adId];
    }

    /**
     * @param int $adId
     * @return bool
     */
    public static function isAnyVideoBanner($adId)
    {
        if (isset(self::$aAnyVideoBanners[$adId])) {
            return self::$aAnyVideoBanners[$adId];
        }

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->bannerid = $adId;
        $doBanners->whereAdd("width IN (-3, -2)");

        self::$aAnyVideoBanners[$adId] = (bool)$doBanners->find();
        return self::$aAnyVideoBanners[$adId];
    }

    /**
     * @param int $zoneId
     * @return bool
     */
    public static function isVideoZone($zoneId)
    {
        if (isset(self::$aVideoZones[$zoneId])) {
            return self::$aVideoZones[$zoneId];
        }

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->zoneid = $zoneId;
        $doZones->whereAdd("(width BETWEEN -3 AND -2 AND width = height)");

        self::$aVideoZones[$zoneId] = (bool)$doZones->find();
        return self::$aVideoZones[$zoneId];
    }
}
