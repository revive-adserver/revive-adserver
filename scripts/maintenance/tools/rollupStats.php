#!/usr/bin/php -q
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
 * @package    OpenXMaintenance
 * @subpackage Tools
 * @author     Chris Nutting <chris.nutting>
 *
 * A script that can be run to execute the stats rollup code indepenent of the core
 * maintenance script.
 *
 * @param string Requires the hostname to be passed in as a string, as per
 *               the standard maintenance CLI script.
 */

/***************************************************************************/

// Initialise the OpenX environment....
$path = dirname(__FILE__);
require_once $path . '/../../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Maintenance/RollupStats.php';

$matches = array();
if (empty($argv[2])) {
    echo "You must provide the date before which stats should be rolled up! (in YYYY-MM-DD format please)\n";
    exit;
} elseif (!preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/', $argv[2], $matches)) {
    echo "The date you passed in ({$argv[2]}) does not appear to be in YYYY-MM-DD format\n";
}
if ($matches[1] > 2032 || $matches[1] < 1970) {
    echo "Invalid year ({$matches[1]}) passed in\n";
    exit;
} else if ($matches[2] > 12) {
    echo "Invalid month ({$matches[2]}) passed in";
    exit;
} else if ($matches[3] > 31) {
    echo "Invalid date ({$matches[3]}) passed in\n";
    exit;
}

$oDate = new Date($argv[2]);

$oRollupStats = new OA_Maintenance_RollupStats();
$oRollupStats->run($oDate);

?>
