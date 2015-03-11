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

class prescript_tables_core_999450 extends script_tables_core_parent
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
        $msg = $this->_testName('A');
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;

        if (!in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log($msg.' table '.$prefix.'astro does not exist in database therefore changes_tables_core_999450 will not be able to rename table '.$prefix.'astro');
        }
        else
        {
            $query = 'SELECT * FROM '.$prefix.'astro';
            $result = $this->oDbh->queryAll($query);
            if (PEAR::isError($result))
            {
                $this->_log($msg.'failed to retrieve data from '.$prefix.'astro');
            }
            else
            {
                $this->_log($msg.' : rename table '.$prefix.'astro to '.$prefix.' klapaucius');
                $this->_log('row =  id_changed_field , desc_field, text_field');
                foreach ($result AS $k => $v)
                {
                    $this->_log('row '.$k .' = '.$v['id_changed_field'] .', '. $v['desc_field'] .' , '. $v['text_field']);
                }

            }
        }

        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        $msg = $this->_testName('B');
        if (in_array($prefix.'klapaucius', $aExistingTables))
        {
            $this->_log($msg.' table '.$prefix.'klapaucius already exists in database therefore changes_tables_core_999450 will not be able to add table '.$prefix.'klapaucius');
        }
        else
        {
            $this->_log($msg.' add (as part of rename) table '.$prefix.'klapaucius defined as: [klapaucius]');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['klapaucius'];
            $this->_log(print_r($aDef,true));
        }
    }

    function _logExpectedDestructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        $msg = $this->_testName('C');
        if (!in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log($msg.' table '.$prefix.'astro does not exist in database therefore changes_tables_core_999450 will not be able to remove table '.$prefix.'astro');
        }
        else
        {
            $this->_log($msg.' remove (as part of rename) table '.$prefix.'astro');
        }
    }
}

?>