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

class postscript_tables_core_999100 extends script_tables_core_parent
{
    function postscript_tables_core_999100()
    {
    }

    function execute_constructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** constructive ****************');
        $result = $this->insertData();
        $this->_logActual();
        return $result;
    }

    function _logActual()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        $msg = $this->_testName('A');
        if (!in_array($prefix.'bender', $aExistingTables))
        {
            $this->_log($msg.' failed to create table '.$prefix.'bender');
        }
        else
        {
            $this->_log($msg.' created table '.$prefix.'bender defined as: [bender]');
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('bender');
            $this->_log(print_r($aDef['tables']['bender'],true));
        }
        $msg = $this->_testName('B');
        if (!in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log($msg.' failed to create table '.$prefix.'astro defined as: [astro]');
        }
        else
        {
            $this->_log($msg.' created table '.$prefix.'astro defined as: [astro]');
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('astro');
            $this->_log(print_r($aDef['tables']['astro'],true));

            $msg = $this->_testName('C');
            $query = 'SELECT COUNT(*) FROM '.$prefix.'astro';
            $result = $this->oDbh->queryOne($query);
            if (PEAR::isError($result))
            {
                $this->_log($msg.' : failed to insert records in table [astro]');
            }
            $this->_log($msg.' inserted '.$result.' records in table [astro]');
        }
    }

    function insertData()
    {
        $table = $this->oDbh->quoteIdentifier($this->oDBUpgrade->prefix.'astro',true);
        for ($i=1;$i<11;$i++)
        {
            $query = "INSERT INTO
                      {$table}
                      (
                        id_field,
                        desc_field
                      )
                       VALUES
                      (
                        {$i},
                        'desc {$i}'
                      )";
            $result = $this->oDbh->exec($query);
            if (PEAR::isError($result))
            {
                $this->_log($this->script.'::insertData failed: '.$result->getUserInfo());
                return false;
            }
        }
        $this->_log($this->script.'::insertData complete');
        return true;
    }

}

?>