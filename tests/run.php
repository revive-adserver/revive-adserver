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
 * A script to call the TestRunner class, based on the $_GET parameters
 * passed via the web client, as well as perform timing of the tests,
 * etc.
 *
 * @package    OpenX
 * @subpackage TestSuite
 *
 * @todo Only show HTML when run from Web.
 */

require_once 'init.php';

// Mask strict errors. Simpletest is too old for that
error_reporting(error_reporting() & ~E_STRICT);

// Required files
require_once MAX_PATH . '/tests/testClasses/TestRunner.php';
require_once MAX_PATH . '/tests/testClasses/ErrorCatcher.php';

$runner = new TestRunner();
$runner->findDefaults();

$oErrorCatcher = new SimpletestErrorCatcher($runner);

/* TODO: Extract this to the paintHeader() method of a reporter */
if ($runner->output_format_name == 'html') {
    echo "<style type=\"text/css\">\n";
    echo file_get_contents(MAX_PATH . '/tests/testClasses/tests.css');
    echo "</style>\n";
}

/* TODO: Consider a non-Web environment */
if (defined('TEST_ENVIRONMENT_NO_CONFIG')) {
    echo "<h1>Cannot Run Tests</h1>\n";
    echo "<p>You have not copied the the test.conf.php file in the\n";
    echo "/etc directory into the /var directory, and edited the file,\n";
    echo "so that it contains your database server details.</p>\n";
    exit();
}

if (!empty($runner->host)) {
    // If host was set use it as a default one
    $_SERVER['SERVER_NAME'] = $runner->host;
}

// Ensure emails are not sent due to activation/deactivation effect
define('DISABLE_ALL_EMAILS', 1);
global $start;

$start = microtime();

// Store the type of test being run globally, to save passing
// about as a parameter all the time
$GLOBALS['_MAX']['TEST']['test_type'] = $_GET['type'];

if ($GLOBALS['_MAX']['TEST']['test_type'] == 'phpunit') {
    $dir = $_GET['dir'];
    if (empty($dir)) {
        echo 'Call was to run a PEAR PHPUnit test, but no test directory specified.';
    } else {
        // Copy over the PHPUnit CSS file
        $result = @copy($dir . '/tests.css', MAX_PATH . '/tests/tests.css');
        if (!$result) {
            $error = '<p><b>Unable to copy the CSS file for the PHPUnit test. Check that the PHPUnit ' .
            '\'test.css\' file exists, and that the web server process can write to the OpenX \'test\' '.
            'directory.</b></p><hr />';
            echo $error;
        }
        // Run the PHPUnit tests
        require_once $dir . '/test.php';
        // Remove the PHPUnit CSS file
        @unlink(MAX_PATH . '/tests/tests.css');
    }
    exit;
}

// Set longer time out
if (!ini_get('safe_mode')) {
    $conf = $GLOBALS['_MAX']['CONF'];
    @set_time_limit($conf['maintenance']['timeLimitScripts']);
}

$level = $_GET['level'];
if ($level == 'all') {
    $runner->runAll();
} elseif ($level == 'layer') {
    $layer = $_GET['layer'];
    $runner->runLayer($layer);
} elseif ($level == 'folder') {
    $layer = $_GET['layer'];
    $folder = $_GET['folder'];
    $runner->runFolder($layer, $folder);
} elseif ($level == 'file') {
    $layer = $_GET['layer'];
    $folder = $_GET['folder'];
    $file = $_GET['file'];
    $runner->runFile($layer, $folder, $file);
}

/* now in the paintFooter() method of a html reporter
// Display execution time
list ($endUsec, $endSec) = explode(" ", microtime());
$endTime = ((float) $endUsec + (float) $endSec);
list ($startUsec, $startSec) = explode(" ", $start);
$startTime = ((float) $startUsec + (float) $startSec);

if ($runner->output_format_name == 'html') {
    echo '<div align="right"><br/>Test Suite Execution Time ~ <b>';
    echo substr(($endTime - $startTime), 0, 6);
    echo '</b> seconds.</div>';
}
*/

$oErrorCatcher->deactivate();

$runner->exitWithCode();

?>
