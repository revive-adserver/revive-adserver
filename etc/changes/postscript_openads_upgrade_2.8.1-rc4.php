<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: postscript_openads_upgrade_2.7.31-beta-rc4.php 34299 2009-03-25 16:17:24Z david.keen $
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