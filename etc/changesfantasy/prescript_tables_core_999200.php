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

class prescript_tables_core_999200 extends script_tables_core_parent
{
    function __construct()
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