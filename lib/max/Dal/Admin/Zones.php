<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Zones extends MAX_Dal_Common
{
    var $table = 'zones';
    
    var $orderListName = array(
        'name' => 'zonename',
        'id'   => 'zoneid'
    );
    
	function getZoneByKeyword($keyword, $agencyId = null, $affiliateId = null) 
    {
        $whereZone = is_numeric($keyword) ? " OR z.zoneid=$keyword" : '';
        $prefix = $this->getTablePrefix();

        $query = "
        SELECT
            z.zoneid AS zoneid,
            z.zonename AS zonename,
            z.description AS description,
            a.affiliateid AS affiliateid
        FROM
            {$prefix}zones AS z,
            {$prefix}affiliates AS a
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
        if($affiliateId !== null) {
            $query .= " AND a.affiliateid=" . DBC::makeLiteral($affiliateId);
        }
        
        return DBC::NewRecordSet($query);
    }
}

?>