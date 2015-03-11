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
    var $oDBUpgrade;
    var $oDbh;
    var $className;

    function __construct()
    {
    }

    function init($aParams)
    {
        $this->className = get_class($this);
        $this->oDBUpgrade = $aParams[0];
        $this->_log('****************************************');
        $this->oDbh = OA_DB::singleton(OA_DB::getDsn());
        return true;
    }

    function execute_constructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** constructive ****************');
        return true;
    }

    function execute_destructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** destructive ****************');
        return true;
    }

    function _log($msg)
    {
        $logOld = $this->oDBUpgrade->oLogger->logFile;
        $this->oDBUpgrade->oLogger->logFile = MAX_PATH.'/var/fantasy.log';
        $this->oDBUpgrade->oLogger->logOnly($msg);
        $this->oDBUpgrade->oLogger->logFile = $logOld;
        return true;
    }

    function _testName($id)
    {
        return "[$this->className::TEST *{$id}*] ";
    }


}

?>