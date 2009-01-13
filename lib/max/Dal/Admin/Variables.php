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

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Variables extends MAX_Dal_Common
{
    var $table = 'variables';

    function getTrackerVariables($zoneid, $affiliateid, $selectForAffiliate)
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableZ = $oDbh->quoteIdentifier($prefix.'zones',true);
        $tableAza = $oDbh->quoteIdentifier($prefix.'ad_zone_assoc',true);
        $tableB = $oDbh->quoteIdentifier($prefix.'banners',true);
        $tableCt = $oDbh->quoteIdentifier($prefix.'campaigns_trackers',true);
        $tableT = $oDbh->quoteIdentifier($prefix.'trackers',true);
        $tableV = $oDbh->quoteIdentifier($prefix.'variables',true);
        $tableVp = $oDbh->quoteIdentifier($prefix.'variable_publisher',true);


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
                {$tableAza} aza JOIN
                {$tableZ} z ON (aza.zone_id = z.zoneid) JOIN
                {$tableB} b ON (aza.ad_id = b.bannerid) JOIN
                {$tableCt} ct USING (campaignid) JOIN
                {$tableT} t USING (trackerid) JOIN
                {$tableV} v USING (trackerid) LEFT JOIN
                {$tableVp} vp ON (vp.variable_id = v.variableid AND vp.publisher_id = z.affiliateid)
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