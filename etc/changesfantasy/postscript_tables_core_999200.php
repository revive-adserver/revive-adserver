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

class postscript_tables_core_999200
{
    var $oDBUpgrade;
    var $oDbh;

    function postscript_tables_core_999200()
    {

    }

    function execute_constructive($aParams)
    {
        $this->oDBUpgrade = $aParams[0];
        $this->oDbh = OA_DB::singleton(OA_DB::getDsn());
        $this->_log('**********postscript_tables_core_999200::execute_constructive**********');
        $this->_logActualConstructive();
        return true;
    }

    function execute_destructive($aParams)
    {
        $this->oDBUpgrade = $aParams[0];
        $this->oDbh = OA_DB::singleton(OA_DB::getDsn());
        $this->_log('**********postscript_tables_core_999200::execute_destructive**********');
        $this->_logActualConstructive();
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

    function _logActualConstructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (in_array($prefix.'astro', $aExistingTables))
        {
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('astro');
            if (isset($aDef['tables']['astro']['fields']['id_changed_field']))
            {
                $this->_log('changes_tables_core_999200::TEST A : added (as part of rename) field to table '.$prefix.'astro defined as:');
                $this->_log(print_r($aDef['tables']['astro']['fields']['id_changed_field'],true));
            }
            else
            {
                $this->_log('changes_tables_core_999200::TEST A : add (as part of rename) field to table '.$prefix.'astro');
            }
            if (isset($aDef['tables']['astro']['fields']['varchar_field']))
            {
                $this->_log('changes_tables_core_999200::TEST B : alter field in table '.$prefix.'astro defined as:');
                $this->_log(print_r($aDef['tables']['astro']['fields']['varchar_field'],true));
            }
            else
            {
                $this->_log('changes_tables_core_999200::TEST B : failed to alter field in table '.$prefix.'astro');
            }
            if (isset($aDef['tables']['astro']['fields']['text_field']))
            {
                $this->_log('changes_tables_core_999200::TEST C : add field to table '.$prefix.'astro defined as:');
                $this->_log(print_r($aDef['tables']['astro']['fields']['text_field'],true));
            }
            else
            {
                $this->_log('changes_tables_core_999200::TEST C : failed to add field to table '.$prefix.'astro');
            }
        }
    }

    function _logActualDestructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (in_array($prefix.'astro', $aExistingTables))
        {
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('astro');
            if (!isset($aDef['tables']['astro']['fields']['id_field']))
            {
                $this->_log('changes_tables_core_999200::TEST D : removed (as part of rename) field from table '.$prefix.'astro defined as:');
                $this->_log(print_r($aDef['tables']['astro']['fields']['id_field'],true));
            }
            else
            {
                $this->_log('changes_tables_core_999200::TEST D : failed to remove (as part of rename) field to table '.$prefix.'astro');
            }
            if (!isset($aDef['tables']['astro']['fields']['desc_field']))
            {
                $this->_log('changes_tables_core_999200::TEST E : removed (as part of rename) field from table '.$prefix.'astro defined as:');
                $this->_log(print_r($aDef['tables']['astro']['fields']['desc_field'],true));
            }
            else
            {
                $this->_log('changes_tables_core_999200::TEST E : failed to remove (as part of rename) field to table '.$prefix.'astro');
            }
        }
    }
}

?>