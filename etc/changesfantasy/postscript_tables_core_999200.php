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

class postscript_tables_core_999200 extends script_tables_core_parent
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
            $msg = $this->_testName('A');
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('astro');
            if (isset($aDef['tables']['astro']['fields']['id_changed_field']))
            {
                $this->_log($msg.' added (as part of rename) field to table '.$prefix.'astro defined as: [id_changed_field]');
                $this->_log(print_r($aDef['tables']['astro']['fields']['id_changed_field'],true));
            }
            else
            {
                $this->_log($msg.'failed to add (as part of rename) field to table '.$prefix.'astro defined as: [id_changed_field]');
            }

            $msg = $this->_testName('B');
            if (isset($aDef['tables']['astro']['fields']['text_field']))
            {
                $this->_log($msg.' add field to table '.$prefix.'astro defined as: [text_field]');
                $this->_log(print_r($aDef['tables']['astro']['fields']['text_field'],true));
            }
            else
            {
                $this->_log($msg.' failed to add field to table '.$prefix.'astro defined as: [text_field]');
            }

            $msg = $this->_testName('C');
            $query = 'SELECT * FROM '.$prefix.'astro';
            $result = $this->oDbh->queryAll($query);
            if (PEAR::isError($result))
            {
                $this->_log($msg.'failed to migrate data from [id_field, desc_field] to [id_changed_field, text_field]');
            }
            else
            {
                $this->_log($msg.' migrate data from [id_field, desc_field] to [id_changed_field, text_field] :');
                $this->_log('row =  id_changed_field , desc_field, text_field');
                foreach ($result AS $k => $v)
                {
                    $this->_log('row '.$k .' = '. $v['id_changed_field'] .' , '. $v['desc_field'] .' , '. $v['text_field']);
                }
            }
        }
    }

    function _logActualDestructive()
    {
        $aExistingTables = $this->oDBUpgrade->_listTables();
        $prefix = $this->oDBUpgrade->prefix;
        if (in_array($prefix.'astro', $aExistingTables))
        {
            $msg = $this->_testName('D');
            $aDef = $this->oDBUpgrade->_getDefinitionFromDatabase('astro');
            if (!isset($aDef['tables']['astro']['fields']['id_field']))
            {
                $this->_log($msg.' removed (as part of rename) field from table '.$prefix.'astro defined as: [id_field]');
                $this->_log(print_r($aDef['tables']['astro']['fields']['id_field'],true));
            }
            else
            {
                $this->_log($msg.' failed to remove (as part of rename) field from table '.$prefix.'astro defined as: [id_field]');
            }
        }
    }
}

?>