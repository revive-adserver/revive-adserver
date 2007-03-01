<?php

define('MAX_PATH', dirname(__FILE__).'/../..');
define('MAX_VAR', MAX_PATH.'/var');

require_once('pear.inc.php');
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';


function getSchemas()
{
    $opts = '';
    $dh = opendir(MAX_VAR);
    if ($dh) {
        while (false !== ($schema_file = readdir($dh))) {
            if (strpos($schema_file, 'mdbs_')===0)
            {
                $opts.= '<option value="'.$schema_file.'">'.$schema_file.'</option>';
            }
        }
        closedir($dh);
    }
    return $opts;
//
//    $aDir = scandir(MAX_VAR);
//    $opts = '';
//    foreach ($aDir AS $schema_file)
//    {
//        if (strpos($schema_file, 'mdbs_')===0)
//        {
//            $opts.= '<option value="'.$schema_file.'">'.$schema_file.'</option>';
//        }
//    }
//    return $opts;
}


?>