<?php

// uncomment this line if you want to run both MDB2 and MDB2_Schema from a CVS checkout
#ini_set('include_path', '../../MDB2/'.PATH_SEPARATOR.'..'.PATH_SEPARATOR.ini_get('include_path'));

function catchErrorHandlerPEAR($error_obj)
{

}

$testcases = array(
    'MDB2_Schema_testcase',
    'MDB2_Validate_testcase',
    'MDB2_Changes_testcase',
);

?>