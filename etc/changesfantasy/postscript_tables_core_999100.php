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

require_once MAX_PATH.'/etc/changesfantasy/script_tables_core_parent.php';

class postscript_tables_core_999100 extends script_tables_core_parent
{
    function __construct()
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