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
 *
 * I added the init.php script to gain access to MAX_PATH, however this now requires
 * that the application is installed, this may be
 *
 * @package    OpenXMaintenance
 * @subpackage Tools
 * @author     Heiko Weber <heiko@wecos.de>
 * @author     Chris Nutting <Chris.Nutting@openx.org>
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */

// protect this script to be used only from command-line
if (php_sapi_name() != 'cli') {
    echo "Sorry, this tool must be run from the command-line";
    exit;
}

// Set the MAX_PATH constant (this assumes that the script is located in MAX_PATH . '/scripts'
// Note we may change this to require(../../init.php) which would give access to installed $conf
// Which could be used to compile in the delivery engine Dal for this installation?
define('MAX_PATH', dirname(dirname(dirname(__FILE__))));
define('OX_PATH', dirname(dirname(dirname(__FILE__))));
define('LIB_PATH', MAX_PATH.'/lib/OX');

$ignored_files = array('template.php');

/**
 * I just wanted to track the exact time taken to recomplie the delivery engine
 *
 * On my laptop, this takes ~ 12.6s/6.8s (PHP4/PHP5)
 * interesting that PHP5 is so much faster (the resulting files are identical)
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
$header = preg_replace('#(.*)ant generate-delivery(.*)\n+\{TEMPLATE\}.*#is', "$1php " . $_SERVER['SCRIPT_FILENAME'] . "$2\n", $header);

require_once LIB_PATH . '/Util/CodeMunger.php';
$oCodeMunger = new OX_Util_CodeMunger();
$oCodeMunger->setHeader($header);

// Process all files in the www/delivery_dev folder (except those being explicitly ignored)
while (false !== ($file = readdir($DIR_INPUT))) {
    // Skip hidden file, directories, and ignored files
    if ((substr($file, 0, 1) == '.') || is_dir($input_dir . $file) || in_array($file, $ignored_files)) { continue; }
    $ext = substr($file, strrpos($file, '.'));

    // Switching on extension may be useful if we want to do other things (e.g. Recompress the fl.js file?)
    switch ($ext) {
        case '.php':
            $FILE_OUT = @fopen($output_dir . $file, 'w');
            if (!is_resource($FILE_OUT)) {
                echo "Unable to open output file for writing: {$output_dir}{$file}\n";
                continue;
            }
            echo "Processing php file: {$file}\n";
            $oCodeMunger->resetCounters();
            $code = $oCodeMunger->finalCleanup($oCodeMunger->flattenFile($input_dir . $file));
            fwrite($FILE_OUT, $code);
            fclose($FILE_OUT);
        break;
        default:
            echo "{$file} is not a php file, leaving untouched\n";
            continue;
        break;
    }
}
$end_time = get_microtime();

echo "Finished recompiling delivery engine (Time taken: " . ($end_time - $start_time) . "s)\n";

?>
