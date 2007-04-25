<?php
/**
 * @since Openads v2.3.30-alpha - 20-Nov-2006
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
    
    /**
     * Gets the details to for generating invocation code.
     *
     * @param int $zoneId  the zone ID.
     * @return array  zone details to be passed into MAX_Admin_Invocation::placeInvocationForm()
     * 
     * @see MAX_Admin_Invocation::placeInvocationForm()
     */
    function getZoneForInvocationForm($zoneId)
    {
        $prefix = $this->getTablePrefix();
        
        $query = "
            SELECT
                z.affiliateid,
                z.width,
                z.height,
                z.delivery,
                af.website
            FROM
                {$prefix}zones AS z,
                {$prefix}affiliates AS af
            WHERE
                z.zoneid = " . DBC::makeLiteral($zoneId) . "
            AND af.affiliateid = z.affiliateid";
        
        $rsZone = DBC::FindRecord($query);
        return $rsZone->toArray();
    }
}

?>