<?php

/* Some utility functions for the test scripts */

/**
 * this is used (with array filter) to filter out the test*
 * methods from a PHPUnit testcase
 */
function grepForTest($var)
{
    return preg_match('/\btest.*/', $var);
}

/**
 * given a class name it returns an array of test* methods
 *
 * @param $class text classname
 * @return array of methods beginning with test
 */
function getTests($class)
{
    $methods = array_map('strtolower', get_class_methods($class));
    return array_filter($methods, 'grepForTest');
}

/**
 * Little helper function that outputs check for boxes with suitable names
 */
function testCheck($testcase, $testmethod)
{
    return "<input type=\"checkbox\" name=\"testmethods[$testcase][$testmethod]\" value=\"1\">$testmethod <br>\n";
}

/**
 * Little helper function that gets a backtrace if available
 */
function getBacktrace()
{
    $message = '';
    if (!function_exists('debug_backtrace')) {
        $message.= 'function debug_backtrace does not exists'."\n";
    }

    $debug_backtrace = debug_backtrace();
    array_shift($debug_backtrace);
    $message.= 'Debug backtrace:'."\n";

    foreach ($debug_backtrace as $trace_item) {
        $message.= "\t" . '    @ ';
        if (array_key_exists('file', $trace_item)) {
            $message.= basename($trace_item['file']) . ':' . $trace_item['line'];
        } else {
            $message.= '- PHP inner-code - ';
        }
        $message.= ' -- ';
        if (array_key_exists('class', $trace_item)) {
            $message.= $trace_item['class'] . $trace_item['type'];
        }
        $message.= $trace_item['function'];

        if (!empty($trace_item['args']) && is_array($trace_item['args'])) {
            $message.= '('.@implode(', ', $trace_item['args']).')';
        } else {
            $message.= '()';
        }
        $message.= "\n";
    }

    return $message;
}

require_once 'PEAR.php';
function errorHandlerPEAR($error_obj)
{
    $message = "-- PEAR-Error --\n";
    $message.= $error_obj->getMessage().': '.$error_obj->getUserinfo()."\n";
    $message.= getBacktrace();

    print_r($message);
}

PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'errorHandlerPEAR');

$GLOBALS['_show_silenced'] = false;
function errorHandler($errno, $errstr, $errfile, $errline)
{
    if ((!$GLOBALS['_show_silenced'] && !error_reporting()) || $errno == 2048) {
        return;
    }
    $message = "\n";
    switch($errno) {
    case E_USER_ERROR:
        $message.= "FATAL [$errno] $errstr\n";
        $message.= "  Fatal error in line $errline of file $errfile";
        $message.= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")\n";
        $message.= "Aborting...\n";
        die($message);
        break;
    case E_USER_WARNING:
        $message.= "ERROR [$errno] $errstr in line $errline of file $errfile\n";
        break;
    case E_USER_NOTICE:
        $message.= "WARNING [$errno] $errstr in line $errline of file $errfile\n";
        break;
    default:
        $message.= "Unkown error type: [$errno] $errstr in line $errline of file $errfile\n";
        break;
    }

    $message.= getBacktrace();

    print_r($message);
}

set_error_handler('errorHandler');
if (function_exists('xdebug_disable')) {
    xdebug_disable();
}
?>