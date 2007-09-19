<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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

class prescript_tables_core_999100
{
    var $oDBUpgrade;

    function prescript_tables_core_999100()
    {

    }

    function execute_constructive($aParams)
    {
        $this->oDBUpgrade = $aParams[0];
        $this->_log('**********prescript_tables_core_999100**********');
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
        if (in_array($prefix.'bender', $aExistingTables))
        {
            $this->_log('Table '.$prefix.'bender already exists in database therefore changes_tables_core_999100 will not be able to create table '.$prefix.'bender');
        }
        else
        {
            $this->_log('changes_tables_core_999100::TEST A : create table '.$prefix.'bender defined as:');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['bender'];
            $this->_log(print_r($aDef,true));

        }
        if (in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log('Table '.$prefix.'astro already exists in database therefore changes_tables_core_999100 will not be able to create table '.$prefix.'astro');
        }
        else
        {
            $this->_log('changes_tables_core_999100::TEST B : create table '.$prefix.'astro defined as:');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro'];
            $this->_log(print_r($aDef,true));
            $this->_log('changes_tables_core_999100::TEST C : populate table '.$prefix.'astro with 10 records');
        }
    }

}

?>