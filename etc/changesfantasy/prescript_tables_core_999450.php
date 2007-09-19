<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 4503-4507 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

class prescript_tables_core_999450
{
    var $oDBUpgrade;

    function prescript_tables_core_999450()
    {

    }

    function execute_constructive($aParams)
    {
        $this->oDBUpgrade = $aParams[0];
        $this->_log('**********prescript_tables_core_999450**********');
        $this->_logExpected();
        return true;
    }

    function execute_destructive($aParams)
    {
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

    function _logExpected()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (!in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log('Table '.$prefix.'astro does not exist in database therefore changes_tables_core_999450 will not be able to rename table '.$prefix.'astro');
        }
        else
        {
            $this->_log('changes_tables_core_999450::TEST A : rename table '.$prefix.'astro defined as:');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro'];
            $this->_log(print_r($aDef,true));
        }
    }

}

?>