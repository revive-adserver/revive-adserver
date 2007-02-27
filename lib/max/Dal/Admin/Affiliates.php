<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/db/db.inc.php';

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
}

?>