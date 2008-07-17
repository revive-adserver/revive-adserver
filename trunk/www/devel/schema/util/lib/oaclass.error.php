<?php

//require_once 'PEAR.php';

class OpenadsError extends PEAR
{

    function getErrorLevelString($code=0)
    {
        $error_levels = array(  E_USER_NOTICE  => 'NOTICE',
                                E_USER_WARNING => 'WARNING',
                                E_USER_ERROR   => 'ERROR');
        if ($code)
        {
            return $error_levels[$code];
        }
        else
        {
            return 'UNKNOWN';
        }
    }
}

?>