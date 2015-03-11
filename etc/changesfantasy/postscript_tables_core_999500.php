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

class postscript_tables_core_999500 extends script_tables_core_parent
{
    function __construct()
    {
    }

    function execute_destructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** destructive ****************');
        $this->_logActual();
        return true;
    }

    function _logActual()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (in_array($prefix.'klapaucius', $aExistingTables))
        {
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('klapaucius');
            $msg = $this->_testName('A');
            if (!isset($aDef['tables']['klapaucius']['fields']['text_field']))
            {
                $this->_log($msg.' removed field text_field from table '.$prefix.'klapaucius');
            }
            else
            {
                $this->_log($msg.' failed to remove field text_field from table'.$prefix.'klapaucius');
            }
            $msg = $this->_testName('B');
            if (!isset($aDef['tables']['klapaucius']['indexes']['klapaucius_pkey']))
            {
                $this->_log($msg.' removed primary key constraint klapaucius_pkey from table '.$prefix.'klapaucius');
            }
            else
            {
                $this->_log($msg.' failed to remove primary key constraint klapaucius_pkey from table'.$prefix.'klapaucius');
            }
        }
    }
}

?>