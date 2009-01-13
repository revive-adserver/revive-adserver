<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
require_once MAX_PATH.'/etc/changesfantasy/script_tables_core_parent.php';

class postscript_tables_core_999400 extends script_tables_core_parent
{
    function postscript_tables_core_999400()
    {
    }

    function execute_constructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** constructive ****************');
        $this->_logActualConstructive();
        return true;
    }

    function execute_destructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** destructive ****************');
        $this->_logActualDestructive();
        return true;
    }

    function _logActualConstructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (in_array($prefix.'astro', $aExistingTables))
        {
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('astro');
            $msg = $this->_testName('A');
            if (isset($aDef['tables']['astro']['indexes']['astro_pkey']))
            {
                $this->_log($msg.' added primary key constraint to table '.$prefix.'astro defined as: [astro_pkey]');
                $this->_log(print_r($aDef['tables']['astro']['indexes']['astro_pkey'],true));
            }
            else
            {
                $this->_log($msg.' failed to add primary key constraint [astro_pkey] to table '.$prefix.'astro');
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
            $msg = $this->_testName('B');
            if (!isset($aDef['tables']['astro']['indexes']['id_field']))
            {
                $this->_log($msg,' removed index from table '.$prefix.'astro defined as [id_field]');
            }
            else
            {
                $this->_log($msg.' failed to remove index [id_field] from table '.$prefix.'astro');
            }
        }
    }
}

?>