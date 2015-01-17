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

class postscript_tables_core_999250 extends script_tables_core_parent
{
    function __construct()
    {
    }

    function execute_constructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** constructive ****************');
        $this->_logActual();
        return true;
    }

    function _logActual()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (in_array($prefix.'astro', $aExistingTables))
        {
            $msg = $this->_testName('A');
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('astro');
            if (isset($aDef['tables']['astro']['fields']['auto_field']))
            {
                $this->_log($msg.' added autoincrement field for table '.$prefix.'astro defined as:[auto_field]');
                $this->_log(print_r($aDef['tables']['astro']['fields']['auto_field'],true));

                $query = 'SELECT * FROM '.$prefix.'astro';
                $result = $this->oDbh->queryAll($query);
                if (PEAR::isError($result))
                {
                    $this->_log($msg.'failed to retrieve data from '.$prefix.'astro');
                }
                else
                {
                    $this->_log($msg.' auto-increment field auto_field data:');
                    $this->_log('row =  auto_field, id_changed_field , desc_field');
                    foreach ($result AS $k => $v)
                    {
                        $this->_log('row '.$k .' = '.$v['auto_field'] .', '. $v['id_changed_field'] .' , '. $v['desc_field']);
                    }

                }
            }
            else
            {
                $this->_log($msg.' failed to add autoincrement field auto_field for table '.$prefix.'astro');
            }
        }
    }
}

?>