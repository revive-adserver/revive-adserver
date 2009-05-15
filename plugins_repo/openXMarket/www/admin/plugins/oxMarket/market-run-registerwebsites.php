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
 * A script file to run register websites.
 */

// Send headers to the client before proceeding
flush();

// Prevent output
ob_start();

require_once 'market-common.php';

// Set longer time out, and ignore user abort
if (!ini_get('safe_mode')) {
    @set_time_limit($GLOBALS['_MAX']['CONF']['maintenance']['timeLimitScripts']);
    @ignore_user_abort(true);
}

$oMaintenaceUpdateWebsites = OX_Component::factory(
                                'maintenanceStatisticsTask', 
                                'oxMarketMaintenance', 
                                'oxMarketMaintenanceUpdateWebsites');
$oUpdtateWebsitesTask = $oMaintenaceUpdateWebsites->addMaintenanceStatisticsTask();
$oUpdtateWebsitesTask->run();

// Get and clean output buffer
$buffer = ob_get_clean();

// Flush output buffer, stripping the
echo preg_replace('/^#!.*\n/', '', $buffer);
