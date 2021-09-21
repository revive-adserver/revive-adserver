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

$className = 'RV_UpgradePostscript_4_0_0_beta_rc2';

require_once MAX_PATH . '/lib/OA/DB/Table.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';

class RV_UpgradePostscript_4_0_0_beta_rc2
{
    /**
     * @var OA_Upgrade
     */
    public $oUpgrade;


    public function execute($aParams)
    {
        $this->oUpgrade = &$aParams[0];

        $oDbh = OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF']['table'];

        $tblBanners = $aConf['prefix'] . ($aConf['banners'] ? $aConf['banners'] : 'banners');
        $qTblBanners = $oDbh->quoteIdentifier($tblBanners, true);

        $ret = $oDbh->query("UPDATE {$qTblBanners} SET adserver = '' WHERE adserver IN ('3rdPartyServers:ox3rdPartyServers:google', '3rdPartyServers:ox3rdPartyServers:ypn')");

        if (PEAR::isError($ret)) {
            $this->logError($ret->getUserInfo());
            return false;
        }

        $this->logOnly("Remove google/ypn 3rd party click tracking");
        return true;
    }

    public function logOnly($msg)
    {
        $this->oUpgrade->oLogger->logOnly($msg);
    }


    public function logError($msg)
    {
        $this->oUpgrade->oLogger->logError($msg);
    }
}
