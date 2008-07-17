<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id$
*/

class script_tables_core_parent
{
    var $oDBUpgrade;
    var $oDbh;
    var $className;

    function script_tables_core_parent()
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