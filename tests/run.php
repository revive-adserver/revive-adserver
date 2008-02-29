<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * A script to call the TestRunner class, based on the $_GET parameters
 * passed via the web client, as well as perform timing of the tests,
 * etc.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 *
 * @todo Only show HTML when run from Web.
 */

require_once 'init.php';

// Required files
require_once MAX_PATH . '/tests/testClasses/TestRunner.php';

$runner = new TestRunner();
$runner->findDefaults();

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

$runner->exitWithCode();

?>