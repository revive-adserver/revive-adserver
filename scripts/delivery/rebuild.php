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

/**
 * This script will parse the files in www/delivery_dev and save the compiled
 * delivery engine files in the www/delivery folder
 */

// Protect this script to be used only from command-line
if (php_sapi_name() != 'cli') {
    echo "Sorry, this script must be run from the command-line";
    exit;
}

error_reporting(E_ALL & ~(E_NOTICE | E_WARNING | E_DEPRECATED | E_STRICT));

echo "=> STARTING TO RE-COMPILE THE DELIVERY ENGINE FILES\n";

// Set the MAX_PATH constant (this assumes that the script is located in
// MAX_PATH . '/scripts'
define('MAX_PATH', dirname(dirname(dirname(__FILE__))));
define('OX_PATH',  dirname(dirname(dirname(__FILE__))));
define('LIB_PATH', MAX_PATH.'/lib/OX');
define('RV_PATH', MAX_PATH);

$ignored_files = array('template.php');

/**
 * Function to get values for timing the compilation
 *
 * @return float MicroTime in milliseconds
 */
function get_microtime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

// Source folder for the file to be processed
$input_dir  = MAX_PATH . '/www/delivery_dev/';
// Destination folder for the compiled scripts
$output_dir = MAX_PATH . '/www/delivery/';

$start_time = get_microtime();

$DIR_INPUT  = opendir($input_dir);
$DIR_OUTPUT = opendir($output_dir);

$header = file_get_contents($input_dir . 'template.php');

require_once LIB_PATH . '/Util/CodeMunger.php';
$oCodeMunger = new OX_Util_CodeMunger();
$oCodeMunger->setHeader($header);

$blacklist = array(
    'asyncjs.php',
);

// Process all files in the www/delivery_dev folder (except those being
// explicitly ignored)
while (false !== ($file = readdir($DIR_INPUT))) {
    // Skip hidden file, directories, and ignored files
    if (
        (substr($file, 0, 1) == '.')
        || is_dir($input_dir . $file)
        || in_array($file, $ignored_files)
    ) {
        continue;
    }

    $ext = substr($file, strrpos($file, '.'));

    if ($ext == '.js') {
        echo "  => {$file} is a javascript file, leaving untouched\n";
        @touch($output_dir . $file);
        continue;
    }

    $FILE_OUT = @fopen($output_dir . $file, 'w');
    if (!is_resource($FILE_OUT)) {
        echo "  => Unable to open output file for writing: {$output_dir}{$file}\n";
        continue;
    }

    $munge = false;
    if ($ext != '.php') {
        echo "  => {$file} is not a php file, copying as-is\n";
    } elseif (in_array($file, $blacklist)) {
        echo "  => {$file} blacklisted, copying as-is\n";
    } else {
        echo "  => Processing php file: {$file}\n";
        $munge = true;
    }

    if ($munge) {
        $oCodeMunger->resetCounters();
        $code = $oCodeMunger->finalCleanup($oCodeMunger->flattenFile($input_dir . $file));
    } else {
        $code = file_get_contents($input_dir . $file);
    }
    fwrite($FILE_OUT, $code);
    fclose($FILE_OUT);
}
$end_time = get_microtime();

echo "  => Time taken: " . ($end_time - $start_time) . " s\n";
echo "=> FINISHED RE-COMPILING THE DELIVERY ENGINE FILES\n\n";

?>