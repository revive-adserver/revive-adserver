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
    error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
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
