<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

###START_STRIP_DELIVERY
OA::debug('starting delivery script '.__FILE__);
###END_STRIP_DELIVERY

// Strip out any '../' from the passed in script value to try and prevent directory traversal attacks
$script = str_replace("\0", '', $_GET['script']);
$aPluginId = explode(':', $script);

$scriptFileName = MAX_PATH . rtrim($conf['pluginPaths']['extensions'], '/') . '/' . implode('/', $aPluginId) . '.delivery.php';

if (stristr($scriptFileName, '../') || !is_readable($scriptFileName) || !is_file($scriptFileName)) {
    if (empty($conf['debug']['production'])) {
        echo "Unable to find delivery script ({$scriptFileName}) for specified plugin-component-identifier: {$script}";
    }
    exit(1);
}

// Include the delivery script for the specified plugin-component identifier
include $scriptFileName;

?>
