<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 5003-5007 Openads Limited                                   |
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

class prescript_tables_core_999500
{
    var $oDBUpgrade;

    function prescript_tables_core_999500()
    {

    }

    function execute_constructive($aParams)
    {
        $this->oDBUpgrade = $aParams[0];
        $this->_log('**********prescript_tables_core_999500**********');
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
        if (!in_array($prefix.'klapaucius', $aExistingTables))
        {
            $this->_log('Table '.$prefix.'klapaucius does not exist in database therefore changes_tables_core_999500 will not be able to alter table '.$prefix.'klapaucius');
        }
        else
        {
            $this->_log('changes_tables_core_999500::TEST A : remove field from '.$prefix.'klapaucius defined as:');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['klapaucius']['fields'];
            $this->_log(print_r($aDef,true));

            $this->_log('changes_tables_core_999500::TEST B : remove primary key constraint '.$prefix.'klapaucius defined as:');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['klapaucius']['indexes'];
            $this->_log(print_r($aDef,true));
        }
    }

}

?>