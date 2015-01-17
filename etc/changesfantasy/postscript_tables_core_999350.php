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

class postscript_tables_core_999350 extends script_tables_core_parent
{
    function __construct()
    {
    }

    function execute_destructive($aParams)
    {
        $this->init($aParams);
        $this->_log('*********** destructive ****************');
        $this->_logActualDestructive();
        return true;
    }

    function _logActualDestructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (in_array($prefix.'astro', $aExistingTables))
        {
            $msg = $this->_testName('A');
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('astro');
            if (!isset($aDef['tables']['astro']['fields']['auto_renamed_field']))
            {
                $this->_log($msg.' removed autoincrement field from table '.$prefix.'astro');
            }
            else
            {
                $this->_log($msg.' failed to remove autoincrement field from table '.$prefix.'astro defined as: [auto_renamed_field]');
            }
        }
    }
}

?>