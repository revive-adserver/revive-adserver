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

class prescript_tables_core_999100 extends script_tables_core_parent
{
    function __construct()
    {
    }

    function execute_constructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** constructive ****************');
        $this->_logExpected();
        return true;
    }

    function _logExpected()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        $msg = $this->_testName('A');
        if (in_array($prefix.'bender', $aExistingTables))
        {
            $this->_log($msg.' table '.$prefix.'bender already exists in database therefore changes_tables_core_999100 will not be able to create table '.$prefix.'bender');
        }
        else
        {
            $this->_log($msg.' create table '.$prefix.'bender defined as: [bender]');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['bender'];
            $this->_log(print_r($aDef,true));

        }
        $msg = $this->_testName('B');
        if (in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log($msg.' table '.$prefix.'astro already exists in database therefore changes_tables_core_999100 will not be able to create table '.$prefix.'astro');
        }
        else
        {
            $this->_log($msg.' create table '.$prefix.'astro defined as: [astro]');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro'];
            $this->_log(print_r($aDef,true));

            $msg = $this->_testName('C');
            $this->_log($msg.' populate table '.$prefix.'astro with 10 records');
        }
    }

}

?>