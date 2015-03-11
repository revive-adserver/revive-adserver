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

class postscript_tables_core_999400 extends script_tables_core_parent
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
        if (in_array($prefix.'astro', $aExistingTables))
        {
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('astro');
            $msg = $this->_testName('A');
            if (isset($aDef['tables']['astro']['indexes']['astro_pkey']))
            {
                $this->_log($msg.' added primary key constraint to table '.$prefix.'astro defined as: [astro_pkey]');
                $this->_log(print_r($aDef['tables']['astro']['indexes']['astro_pkey'],true));
            }
            else
            {
                $this->_log($msg.' failed to add primary key constraint [astro_pkey] to table '.$prefix.'astro');
            }
        }
    }

    function _logActualDestructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (in_array($prefix.'astro', $aExistingTables))
        {
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('astro');
            $msg = $this->_testName('B');
            if (!isset($aDef['tables']['astro']['indexes']['id_field']))
            {
                $this->_log($msg,' removed index from table '.$prefix.'astro defined as [id_field]');
            }
            else
            {
                $this->_log($msg.' failed to remove index [id_field] from table '.$prefix.'astro');
            }
        }
    }
}

?>