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

$className = 'OA_UpgradePrescript';

class OA_UpgradePrescript
{
    var $oUpgrade;

    function __construct()
    {
    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        $this->_log('OA_UpgradePrescript: Start Fantasy Upgrade');
        return true;
    }

    function _log($msg)
    {
        $logOld = $this->oUpgrade->oLogger->logFile;
        $this->oUpgrade->oLogger->setLogFile('fantasy.log');
        $this->oUpgrade->oLogger->logOnly($msg);
        $this->oUpgrade->oLogger->logFile = $logOld;
        return true;
    }

}