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

$className = 'RV_UpgradePostscript_3_2_1_rc1';

require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';

class RV_UpgradePostscript_3_2_1_rc1
{
    /**
     * @var OA_Upgrade
     */
    var $oUpgrade;


    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];

        $oDbh = OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF']['table'];

        $tblBanners = $aConf['prefix'].($aConf['banners'] ? $aConf['banners'] : 'banners');
        $qTblBanners = $oDbh->quoteIdentifier($tblBanners, true);

        $ret = $oDbh->query("UPDATE {$qTblBanners} SET iframe_friendly = 0 WHERE storagetype <> 'html'");

        if (PEAR::isError($ret))
        {
            $this->logError($ret->getUserInfo());
            return false;
        }

        $this->logOnly("Reset iframe friendliness for non-html banners");
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
