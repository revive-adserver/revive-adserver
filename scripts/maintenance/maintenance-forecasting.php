#!/usr/bin/php -q
<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * A script file to run the Maintenance Forecasting Engine process.
 */

// Require the initialisation file
// Done differently from elsewhere so that it works in CLI MacOS X
$path = dirname(__FILE__);
require_once $path . '/../../init.php';

// Required files
require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting.php';
require_once MAX_PATH . '/lib/max/OperationInterval.php';
require_once 'Date.php';

MAX::debug('Running Maintenance Forecasting', PEAR_LOG_INFO);

// Record the current time, and register with the ServiceLocator
$oDate = new Date();
$oServiceLocator = &ServiceLocator::instance();
$oServiceLocator->register('now', $oDate);

// Check the operation interval is valid
$result = MAX_OperationInterval::checkOperationIntervalValue($conf['maintenance']['operationInterval']);
if (PEAR::isError($result)) {
    // Unable to continue!
    MAX::raiseError($result, null, PEAR_ERROR_DIE);
}

// Run the Maintenance Forecasting Engine (MFE) process
increaseMemoryLimit($GLOBALS['_MAX']['REQUIRED_MEMORY']['MAINTENANCE']);
MAX_Maintenance_Forecasting::run();

MAX::debug('Maintenance Forecasting Completed', PEAR_LOG_INFO);

?>
