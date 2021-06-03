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
 * @package    OpenX
 * @subpackage TestSuite
 */

// PSR Autoloader
require_once __DIR__.'/../lib/vendor/autoload.php';

define('TEST_ENVIRONMENT_RUNNING', true);
require_once '../init-parse.php';
require_once '../constants.php';
require_once '../memory.php';
require_once '../variables.php';
setupConstants();
setupConfigVariables();

if (!empty($GLOBALS['_MAX']['CONF'])) {
    // Override config defaults
    $GLOBALS['_MAX']['CONF']['store']['webDir'] = MAX_PATH.'/var';

    // Set up DI container
    $GLOBALS['_MAX']['DI'] = new \RV\Container($GLOBALS['_MAX']['CONF'], false, 'test');
}

/**
 * The environment initialisation function for the OpenX testing environment.
 */
function init()
{
    // Disable notices, but enable warnings
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
    // Always include the configuration file
    include_once MAX_PATH . '/tests/config.php';

}

// Run the init() function
init();

// Load PEAR
require_once 'PEAR.php';

// Set $conf and PREF
$conf = $GLOBALS['_MAX']['CONF'];
$GLOBALS['_MAX']['PREF'] = [];

?>
