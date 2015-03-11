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

class prescript_tables_core_999250 extends script_tables_core_parent
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
        if (!in_array($prefix.'astro', $aExistingTables))
        {
            $this->_log($msg.' table '.$prefix.'astro does not exist in database therefore changes_tables_core_999250 will not be able to add an autoincrement field for table '.$prefix.'astro');
        }
        else
        {
            $this->_log($msg.' add autoincrement field in table '.$prefix.'astro defined as: [auto_field]');
            $aDef = $this->oDBUpgrade->aDefinitionNew['tables']['astro']['fields']['auto_field'];
            $this->_log(print_r($aDef,true));
        }
    }

}

?>