<?php

$className = 'prescript_tables_core_2';

class prescript_tables_core_2
{

    function prescript_tables_core_2()
    {

    }

    function execute_constructive($aParams='')
    {
        if (!is_array($aParams))
        {
            return false;
        }
        if (! count($aParams)==2)
        {
            return false;
        }
        if (!isset($aParams[0]))
        {
            return false;
        }
        if (!isset($aParams[1]))
        {
            return false;
        }
        if (!strtolower(get_class($aParams[0]))== 'oa_db_upgrade')
        {
            return false;
        }
        if (isset($aParams[1]))
        {
            return str_replace('sent', 'returned constructive', $aParams[1]);
        }
        return true;
    }

    function execute_destructive($aParams='')
    {
        if (!is_array($aParams))
        {
            return false;
        }
        if (! count($aParams)==2)
        {
            return false;
        }
        if (!isset($aParams[0]))
        {
            return false;
        }
        if (!isset($aParams[1]))
        {
            return false;
        }
        if (!strtolower(get_class($aParams[0]))== 'oa_db_upgrade')
        {
            return false;
        }
        if (isset($aParams[1]))
        {
            return str_replace('sent', 'returned destructive', $aParams[1]);
        }
        return true;
    }

}

?>