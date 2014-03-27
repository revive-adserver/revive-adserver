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
 * @author     Andrew Hill <andrew.hill@openx.org>
 */

define('TEST_ENVIRONMENT_RUNNING', true);
require_once '../init-parse.php';
require_once '../constants.php';
require_once '../memory.php';
require_once '../variables.php';
setupConstants();
setupConfigVariables();

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

// Set $conf
$conf = $GLOBALS['_MAX']['CONF'];

?>
