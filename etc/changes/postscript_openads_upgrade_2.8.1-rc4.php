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

$className = 'OA_UpgradePostscript_2_8_1_rc4';

require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';

class OA_UpgradePostscript_2_8_1_rc4
{
    /**
     * @var OA_Upgrade
     */
    var $oUpgrade;

    /**
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];

        $this->oDbh = &OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF']['table'];
        
        $prefix = $aConf['prefix'];
        $tblBanners = $prefix.($aConf['banners'] ? $aConf['banners'] : 'banners');
        $tblAza = $prefix.($aConf['ad_zone_assoc'] ? $aConf['ad_zone_assoc'] : 'ad_zone_assoc');

        $query = "
            SELECT
                bannerid,
                0 AS zoneid,
                ".MAX_AD_ZONE_LINK_DIRECT." AS link_type
            FROM
                ".$this->oDbh->quoteIdentifier($tblBanners, true)." b LEFT JOIN
                ".$this->oDbh->quoteIdentifier($tblAza, true)." aza ON (b.bannerid = aza.ad_id AND aza.zone_id = 0)
            WHERE
                aza.ad_id IS NULL
            ";

        $query = "
            INSERT INTO ".$this->oDbh->quoteIdentifier($tblAza, true)."
                (ad_id, zone_id, link_type)
            ".$query;

        $ret = $this->oDbh->exec($query);
        //check for error
        if (PEAR::isError($ret))
        {
            $this->logError($ret->getUserInfo());
            return false;
        }

        $this->logOnly("Added {$ret} missing banner links to zone 0");
        return true;
    }

    function logOnly($msg)
    {
        $this->oUpgrade->oLogger->logOnly($msg);
    }


    function logError($msg)
    {
        $this->oUpgrade->oLogger->logError($msg);
    }

}