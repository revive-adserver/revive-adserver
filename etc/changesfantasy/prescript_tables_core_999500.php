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

class prescript_tables_core_999500 extends script_tables_core_parent
{
    function __construct()
    {
    }

    function execute_destructive($aParams)
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
        if (!in_array($prefix.'klapaucius', $aExistingTables))
        {
            $this->_log($msg.' table '.$prefix.'klapaucius does not exist in database therefore changes_tables_core_999500 will not be able to alter table '.$prefix.'klapaucius');
        }
        else
        {
            $this->_log($msg.' remove field text_field from '.$prefix.'klapaucius');

            $msg = $this->_testName('B');
            $this->_log($msg.' remove primary key constraint klapaucius_pkey '.$prefix.'klapaucius');
        }
    }

}

?>