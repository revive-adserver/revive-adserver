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

class prescript_tables_core_999200
{
    var $oDBUpgrade;

    function prescript_tables_core_999200()
    {

    }

    function execute_constructive($aParams)
    {
        $this->oDBUpgrade = $aParams[0];
        $this->_log('**********prescript_tables_core_999200::execute_constructive**********');
        $this->_logExpectedConstructive();
        return true;
    }

    function execute_destructive($aParams)
    {
        $this->oDBUpgrade = $aParams[0];
        $this->_log('**********prescript_tables_core_999200::execute_destructive**********');
        $this->_logExpectedDestructive();
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

    function _logExpectedConstructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (!in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log('Table '.$prefix.'astro does not exist in database therefore changes_tables_core_999200 will not be able to alter fields for table '.$prefix.'astro');
        }
        else
        {
            $this->_log('changes_tables_core_999200::TEST A : add (as part of rename) field to table '.$prefix.'astro defined as:');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro']['fields']['id_changed_field'];
            $this->_log(print_r($aDef,true));

            $this->_log('changes_tables_core_999200::TEST B : alter field in table '.$prefix.'astro defined as:');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro']['fields']['varchar_field'];
            $this->_log(print_r($aDef,true));

            $this->_log('changes_tables_core_999200::TEST C : add field to table '.$prefix.'astro defined as:');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro']['fields']['text_field'];
            $this->_log(print_r($aDef,true));
        }
    }

    function _logExpectedDestructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (!in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log('Table '.$prefix.'astro does not exist in database therefore changes_tables_core_999200 will not be able to remove a field from table '.$prefix.'astro');
        }
        else
        {
            $this->_log('changes_tables_core_999200::TEST D : remove (as part of rename) field from table '.$prefix.'astro defined as:');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro']['fields']['id_field'];
            $this->_log(print_r($aDef,true));

            $this->_log('changes_tables_core_999200::TEST E : remove (as part of rename) field from table '.$prefix.'astro defined as:');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro']['fields']['desc_field'];
            $this->_log(print_r($aDef,true));
        }
    }
}

?>