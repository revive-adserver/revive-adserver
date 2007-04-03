<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: mysqlSplit.php 5503 2007-03-30 16:44:45Z andrew.hill@openads.org $
*/

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Tracker/pgsql.php';
require_once 'Date.php';

/**
 * The data access layer code for summarising raw data into statistics, for
 * the Tracker module, when split tables are in use.
 *
 * @package    OpenadsDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Dal_Maintenance_Statistics_Tracker_pgsqlSplit extends OA_Dal_Maintenance_Statistics_Tracker_pgsql
{

    /**
     * The constructor method.
     *
     * @uses OA_Dal_Maintenance_Statistics_Tracker_pgsql::OA_Dal_Maintenance_Statistics_Tracker_pgsql()
     */
    function OA_Dal_Maintenance_Statistics_Tracker_pgsqlSplit()
    {
        parent::OA_Dal_Maintenance_Statistics_Tracker_pgsql();
    }

}

?>