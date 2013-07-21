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
 * This script allows a delivery script to be included by the delivery engine
 * without requiring write access to be provided into the www/delivery folder
 *
 * The the plugin-component identifier should be passed into this script via the
 * ?script= $_GET parameter (along with any other $_GET values that may be
 * required for the script to execute)
 *
 */

if (empty($_GET['script'])) {
    // Don't generate any output when no script name is passed in, just silently fail
    exit(1);
}

// Require the initialisation file
include_once '../../init-delivery.php';

// Strip out any '../' from the passed in script value to try and prevent directory traversal attacks
$script = str_replace("\0", '', $_GET['script']);
$aPluginId = explode(':', $script);

$scriptFileName = MAX_PATH . rtrim($conf['pluginPaths']['plugins'], '/') . '/' . implode('/', $aPluginId) . '.delivery.php';

if (stristr($scriptFileName, '../') || stristr($scriptFileName, '..\\') || !is_readable($scriptFileName) || !is_file($scriptFileName)) {
    if (empty($conf['debug']['production'])) {
        echo "Unable to find delivery script ({$scriptFileName}) for specified plugin-component-identifier: {$script}";
    }
    exit(1);
}

// Include the delivery script for the specified plugin-component identifier
include $scriptFileName;
