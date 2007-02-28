<?php

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