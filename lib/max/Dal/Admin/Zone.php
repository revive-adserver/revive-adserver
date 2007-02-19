<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/db/db.inc.php';

class MAX_Dal_Admin_Zone
{
    function getZoneByKeyword($keyword, $agencyId = null) 
    {
        $whereZone = is_numeric($keyword) ? " OR z.zoneid=$keyword" : '';

        $query = "
        SELECT
            z.zoneid AS zoneid,
            z.zonename AS zonename,
            z.description AS description,
            a.affiliateid AS affiliateid
        FROM
            zones AS z,
            affiliates AS a
        WHERE
            (
            z.affiliateid=a.affiliateid
            AND (z.zonename LIKE "  . DBC::makeLiteral('%' . $keyword . '%') . "
            OR description LIKE "  . DBC::makeLiteral('%' . $keyword . '%') . "
            $whereZone)
            )
    ";
        
        if($agencyId !== null) {
            $query .= " AND a.agencyid=" . DBC::makeLiteral($agencyId);
        }
        
        return DBC::NewRecordSet($query);
    }
}

class ZoneModel extends MAX_Dal_Admin_Zone {}

?>