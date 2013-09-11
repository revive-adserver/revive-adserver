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
 * @package    OpenXDelivery
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 *
 * A file to set up the environment for the delivery engine.
 *
 * Both opcode and PHP by itself slow things down when we require many
 * files. Therefore we gave up a little bit of maintainability in
 * order to speed up a delivery:
 * - We are not using classes (if possible) in delivery
 * - We have to use as few as possible includes and add new code into
 *   existing files
 */

require_once 'init-delivery-parse.php';
require_once 'memory.php';
require_once 'variables.php';

// Increase the PHP memory_limit value to the minimum required value, if necessery
OX_increaseMemoryLimit(OX_getMinimumRequiredMemory());

// PHP 5.3 compatibility
if (!defined('E_DEPRECATED')) {
    define('E_DEPRECATED', 0);
}

setupServerVariables();
setupDeliveryConfigVariables();
$conf = $GLOBALS['_MAX']['CONF'];

// Set this script's identifier (from the config file) in the global scope
$GLOBALS['_OA']['invocationType'] = array_search(basename($_SERVER['SCRIPT_FILENAME']), $conf['file']);

// Disable all notices and warnings,
// as some PAN code still generates PHP warnings in places
if (!empty($conf['debug']['production'])) {
    error_reporting(E_ALL & ~(E_NOTICE | E_WARNING | E_DEPRECATED | E_STRICT));
} else {
    // show all errors when developing
    error_reporting(E_ALL & ~(E_DEPRECATED | E_STRICT));
}

require_once MAX_PATH . '/lib/max/Delivery/common.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';

OX_Delivery_logMessage('starting delivery script: ' . basename($_SERVER['REQUEST_URI']), 7);
if (!empty($_REQUEST[$conf['var']['trace']])) {
    OX_Delivery_logMessage('trace enabled: ' . $_REQUEST[$conf['var']['trace']], 7);
}

// Set the viewer's remote information used in logging and delivery limitation evaluation
MAX_remotehostSetInfo();

// Set common delivery parameters in the global scope
MAX_commonInitVariables();

// Load cookie data from client/plugin
MAX_cookieLoad();

// Unpack the packed capping cookies
MAX_cookieUnpackCapping();

// Run any plugins which have registered themselves at postInit,
// with the exception of XML-RPC invocation that will call the hook
// explicitly after overriding the $_SERVER variables
if (empty($GLOBALS['_OA']['invocationType']) || $GLOBALS['_OA']['invocationType'] != 'xmlrpc') {
    OX_Delivery_Common_hook('postInit');
}

?>
