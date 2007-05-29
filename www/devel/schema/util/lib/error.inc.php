<?php

require_once(MAX_DEV.'/schema/util/lib/pear.inc.php');
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';

require_once MAX_PATH.'/lib/OA/DB.php';

function getSchemas()
{
    $opts = '';
    $dh = opendir(MAX_VAR);
    if ($dh) {
        while (false !== ($schema_file = readdir($dh)))
        {
            if (preg_match('/(\.xml)/', $schema_file))
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

function getChangesets()
{
    $opts = '';
    $dh = opendir(MAX_VAR);
    if ($dh) {
        while (false !== ($change_file = readdir($dh))) {
//            if (strpos($change_file, 'mdbc_')===0)
//            {
            if (preg_match('/(\.xml)/', $change_file))
            {
                $opts.= '<option value="'.$change_file.'">'.$change_file.'</option>';
            }
        }
        closedir($dh);
    }
    return $opts;
}
?>