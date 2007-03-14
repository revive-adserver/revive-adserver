<?php

error_reporting(E_USER_ERROR | E_USER_WARNING
   | E_USER_NOTICE);

define('MAX_PEAR', MAX_PATH.'/lib/pear/');
define('MAX_SCHEMA_LOG', MAX_PATH.'/var/schema.log');

ini_set('include_path', MAX_PEAR.PATH_SEPARATOR
                        .MAX_PEAR.'/Log/'.PATH_SEPARATOR
                        .MAX_PEAR.'/MDB2/'.PATH_SEPARATOR
                        .MAX_PEAR.'/MDB2/Schema/Reserved/'.PATH_SEPARATOR
                        .ini_get('include_path'));

$error_levels = array(  E_USER_NOTICE  => 'NOTICE',
                        E_USER_WARNING => 'WARNING',
                        E_USER_ERROR   => 'ERROR');

// our very own pear class
// empty, but allows us to slot an alternative error handler if we want to
require_once 'oaclass.error.php';

// set up logging to file
require_once 'Log.php';
require_once 'file.php';

$conf = array('append'=>false);
//    $logger = &Log::singleton('file',
//                              MAX_PATH . '/var/upgrade.log',
//                              'upgrade_mdb2');
$logger = & new Log_file(MAX_SCHEMA_LOG,'schema_mdb2', $conf);
$logger->debug('========================INITIALISED=============================================');

// assign the callback function that will actually handle the error
OpenadsError::setErrorHandling(PEAR_ERROR_CALLBACK, 'handle_error');

/**
 * @param $error_obj pear error object
 *
 */
function handle_error ($error_obj)
{
    global $logger, $dsn, $mdb;
    global $error_message;
    $error_message = $error_obj->getUserInfo();
//    $logger->debug($error_obj->toString());
    $logger->debug('MESSAGE: '.$error_obj->getMessage());
    $logger->debug('INFO: '.$error_obj->getUserinfo());
    $logger->debug('CODE: '.$error_obj->getCode());
    $logger->debug('LEVEL: '.OpenadsError::getErrorLevelString($error_obj->level));
    foreach ($error_obj->backtrace AS $k => $v)
    {
        if (!strpos($v['function'],"Error"))
        {
            $pre = str_repeat('-',$k);
            $logger->debug("BACKTRACE {$k}:");
            $logger->debug("{$pre}LINE: {$v['line']}");
            $logger->debug("{$pre}FILE: {$v['file']}");
            $logger->debug("{$pre}CLASS: {$v['class']}");
            $logger->debug("{$pre}METHOD: {$v['function']}");
            $logger->debug("{$pre}OBJECT: ");
            if ($v['object'])
            {
                $logger->debug($pre.print_r($v['object'],true));
            }
        }
    }

    if ($error_obj->getMode() !== PEAR_ERROR_RETURN
        && isset($mdb->nested_transaction_counter) && !$mdb->has_transaction_error) {
        $mdb->has_transaction_error =& $error_obj;
    }

    $err = file_get_contents(MAX_SCHEMA_LOG);
    //print_r($err);
    //die();
}

?>