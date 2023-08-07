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

if (!function_exists('OA_Delivery_Cache_fetch')) {
    require_once MAX_PATH . '/lib/max/Delivery/cache.php';
}
if (!function_exists('_adRenderBuildImageUrlPrefix')) {
    require_once MAX_PATH . '/lib/max/Delivery/adRender.php';
}


class AP_Video_Dal_Delivery
{
    public static function getAdDetails($adId)
    {
        $adId = (int)$adId;
        $aResult = [
            'alt_media' => [],
            'impression_trackers' => [],
        ];

        $tableName = self::getQuotedTableName('ext_ap_video');
        $query = "
            SELECT *
            FROM {$tableName}
            WHERE ad_id = {$adId}
        ";

        $res = OA_Dal_Delivery_query($query);

        if ($res) {
            if ($row = OA_Dal_Delivery_fetchAssoc($res)) {
                foreach (['alt_media', 'impression_trackers'] as $k) {
                    $row[$k] = json_decode($row[$k], true);

                    if (!empty($row[$k]) && is_array($row[$k])) {
                        $aResult[$k] = $row[$k];
                    }
                }
            }
        }

        return $aResult;
    }

    protected static function getQuotedTableName($tableName)
    {
        return OX_escapeIdentifier($GLOBALS['_MAX']['CONF']['table']['prefix'] . $tableName);
    }

    public static function cacheGetAdDetails($adId, $cached = true)
    {
        $sName = OA_Delivery_Cache_getName(__METHOD__, $adId);
        if (!$cached || ($data = OA_Delivery_Cache_fetch($sName)) === false) {
            $data = self::getAdDetails($adId);
            $data = OA_Delivery_Cache_store_return($sName, $data);
        }

        return $data;
    }
}
