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

class prescript_tables_core_999200 extends script_tables_core_parent
{
    function prescript_tables_core_999200()
    {
    }

    function execute_constructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** constructive ****************');
        $this->_logExpectedConstructive();
        return true;
    }

    function execute_destructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** destructive ****************');
        $this->_logExpectedDestructive();
        return true;
    }

    function _logExpectedConstructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        $msg = $this->_testName('A');
        if (!in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log($msg.' table '.$prefix.'astro does not exist in database therefore changes_tables_core_999200 will not be able to alter fields for table '.$prefix.'astro');
        }
        else
        {
            $this->_log($msg.' add (as part of rename) field to table '.$prefix.'astro defined as: [id_changed_field]');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro']['fields']['id_changed_field'];
            $this->_log(print_r($aDef,true));

            $msg = $this->_testName('B');
            $this->_log($msg.' add field to table '.$prefix.'astro defined as: [text_field]');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro']['fields']['text_field'];
            $this->_log(print_r($aDef,true));

            $msg = $this->_testName('C');
            $query = 'SELECT * FROM '.$prefix.'astro';
            $result = $this->oDbh->queryAll($query);
            if (PEAR::isError($result))
            {
                $this->_log($msg.' failed to locate data to migrate from [id_field, desc_field] to [id_changed_field, text_field]');
            }
            else
            {
                $this->_log($msg.' migrate data from [id_field, desc_field] to [id_changed_field, text_field] :');
                $this->_log('row =  id_field , desc_field');
                foreach ($result AS $k => $v)
                {
                    $this->_log('row '.$k .' = '. $v['id_field'] .' , '. $v['desc_field']);
                }
            }
        }
    }

    function _logExpectedDestructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        $msg = $this->_testName('D');
        if (!in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log($msg.' table '.$prefix.'astro does not exist in database therefore changes_tables_core_999200 will not be able to remove a field from table '.$prefix.'astro');
        }
        else
        {
            $this->_log($msg.' remove (as part of rename) field id_field from table '.$prefix.'astro defined as: [id_field]');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro']['fields']['id_field'];
            $this->_log(print_r($aDef,true));
        }
    }
}

?>