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

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Variables extends MAX_Dal_Common
{
    var $table = 'variables';

    function getTrackerVariables($zoneid, $affiliateid, $selectForAffiliate)
    {
        $prefix = $this->getTablePrefix();
        $whereZoneAffiliate = empty($zoneid) ?
            "z.affiliateid = ".DBC::makeLiteral($affiliateid) :
            "z.zoneid = ".DBC::makeLiteral($zoneid);

        $query = "
            SELECT DISTINCT
                v.variableid AS variable_id,
                v.name AS variable_name,
                v.description AS variable_description,
                t.trackerid AS tracker_id,
                t.trackername AS tracker_name,
                t.description AS tracker_description
            FROM
                {$prefix}ad_zone_assoc aza JOIN
                {$prefix}zones z ON (aza.zone_id = z.zoneid) JOIN
                {$prefix}banners b ON (aza.ad_id = b.bannerid) JOIN
                {$prefix}campaigns_trackers ct USING (campaignid) JOIN
                {$prefix}trackers t USING (trackerid) JOIN
                {$prefix}variables v USING (trackerid) LEFT JOIN
                {$prefix}variable_publisher vp ON (vp.variable_id = v.variableid AND vp.publisher_id = z.affiliateid)
            WHERE
                {$whereZoneAffiliate} AND
                v.datatype = 'numeric'
            ";

        if($selectForAffiliate) {
            $query .= " AND (v.hidden = 'f' OR vp.visible = 1)";
        }

        return DBC::NewRecordSet($query);
    }
}

?>