<?php

class prescript_tables_core_2
{

    function prescript_tables_core_2()
    {

    }

    function execute_constructive($aParams='')
    {
        if (is_array($aParams) && (strtolower(get_class($aParams[0])) == 'oa_db_upgrade'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function execute_destructive($aParams='')
    {
        if (is_array($aParams) && (strtolower(get_class($aParams[0])) == 'oa_db_upgrade'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}

?>