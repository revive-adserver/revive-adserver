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

class postscript_tables_core_999450 extends script_tables_core_parent
{
    function __construct()
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
        $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('klapaucius');
        $msg = $this->_testName('B');
        if (isset($aDef['tables']['klapaucius']))
        {
            $this->_log($msg.' added (as part of rename) table '.$prefix.'klapaucius defined as: [klapaucius]');
            $this->_log(print_r($aDef['tables']['klapaucius'],true));
        }
        else
        {
            $this->_log($msg.' failed to add (as part of rename) table '.$prefix.'klapaucius');
        }
    }

    function _logActualDestructive()
    {
        $msg = $this->_testName('C');
        $aExistingTables = $this->oDBUpgrade->_listTables();
        if (!in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log($msg.' removed (as part of rename) table '.$prefix.'astro');
        }
        else
        {
            $this->_log($msg.' failed to removed (as part of rename) table '.$prefix.'astro');
        }

        $msg = $this->_testName('A');
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;

        if (!in_array($prefix.'klapaucius', $aExistingTables))
        {
            $this->_log($msg.' table '.$prefix.'klapaucius does not exist in database therefore changes_tables_core_999450 was not able to rename table '.$prefix.'astro');
        }
        else
        {
            $query = 'SELECT * FROM '.$prefix.'klapaucius';
            $result = $this->oDbh->queryAll($query);
            if (PEAR::isError($result))
            {
                $this->_log($msg.'failed to retrieve data from '.$prefix.'klapaucius');
            }
            else
            {
                $this->_log($msg.' : confirmed rename table '.$prefix.'astro to '.$prefix.' klapaucius');
                $this->_log('row =  id_changed_field , desc_field, text_field');
                foreach ($result AS $k => $v)
                {
                    $this->_log('row '.$k .' = '.$v['id_changed_field'] .', '. $v['desc_field'] .' , '. $v['text_field']);
                }

            }
        }
    }
}

?>