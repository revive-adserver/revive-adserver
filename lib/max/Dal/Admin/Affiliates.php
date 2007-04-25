<?php
/**
 * @since Openads v2.3.30-alpah - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Affiliates extends MAX_Dal_Common
{
    var $table = 'affiliates';
    
    var $orderListName = array(
        'name' => 'name',
        'id'   => 'affiliateid'
    );
    
	function getAffiliateByKeyword($keyword, $agencyId = null)
    {
        $whereAffiliate = is_numeric($keyword) ? " OR a.affiliateid=$keyword" : '';
        $prefix = $this->getTablePrefix();
        
        $query = "
        SELECT
            a.affiliateid AS affiliateid,
            a.name AS name
        FROM
            {$prefix}affiliates AS a
        WHERE
            (
            a.name LIKE " . DBC::makeLiteral('%' . $keyword . '%') . "
            $whereAffiliate
            )
            
        ";
        
        if($agencyId !== null) {
            $query .= " AND a.agencyid=" . DBC::makeLiteral($agencyId);
        }
        
        return DBC::NewRecordSet($query);
    }
    
    function getPublishersByTracker($trackerid)
    {
        $prefix = $this->getTablePrefix();
        
        $query = "
            SELECT
                p.affiliateid AS affiliateid,
                p.name AS name
            FROM
                {$prefix}ad_zone_assoc aza
                JOIN {$prefix}zones z ON (aza.zone_id = z.zoneid)
                JOIN {$prefix}affiliates p USING (affiliateid)
                JOIN {$prefix}banners b ON (aza.ad_id = b.bannerid)
                JOIN {$prefix}campaigns_trackers ct USING (campaignid)
            WHERE
                ct.trackerid = ".DBC::makeLiteral($trackerid)."
            GROUP BY
                p.affiliateid,
                name
            ORDER BY
                name
        ";
        
        return DBC::NewRecordSet($query);
    }
}

?>