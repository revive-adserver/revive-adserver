<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/db/db.inc.php';

class MAX_Dal_Admin_Clients extends MAX_Dal_Common
{
    var $table = 'clients';
    
	/**
     * 
     * 
     * @param $keyword  string  Keyword to look for
     * @param $agencyId int  Agency Id
     * 
     * @return RecordSet
     * @access public
     */
    function getClientByKeyword($keyword, $agencyId = null)
    {
        $whereClient = is_numeric($keyword) ? " OR c.clientid=$keyword" : '';
        $prefix = $this->getTablePrefix();
        
        $query = "
            SELECT
                c.clientid AS clientid,
                c.clientname AS clientname
            FROM 
                {$prefix}clients AS c
            WHERE
                (
                c.clientname LIKE '%$keyword%'
                $whereClient
                )
        ";
        
        if($agencyId !== null) {
            $query .= " AND c.agencyid=".DBC::makeLiteral($agencyId);
        }
        
        return DBC::NewRecordSet($query);
    }
}

?>