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

class script_tables_core_parent
{
    public $oDBUpgrade;
    public $oDbh;
    public $className;

    public function __construct()
    {
    }

    public function init($aParams)
    {
        $this->className = get_class($this);
        $this->oDBUpgrade = $aParams[0];
        $this->_log('****************************************');
        $this->oDbh = OA_DB::singleton(OA_DB::getDsn());
        return true;
    }

    public function execute_constructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** constructive ****************');
        return true;
    }

    public function execute_destructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** destructive ****************');
        return true;
    }

    public function _log($msg)
    {
        $logOld = $this->oDBUpgrade->oLogger->logFile;
        $this->oDBUpgrade->oLogger->logFile = MAX_PATH . '/var/fantasy.log';
        $this->oDBUpgrade->oLogger->logOnly($msg);
        $this->oDBUpgrade->oLogger->logFile = $logOld;
        return true;
    }

    public function _testName($id)
    {
        return "[$this->className::TEST *{$id}*] ";
    }
}
