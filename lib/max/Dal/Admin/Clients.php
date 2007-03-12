<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/db/db.inc.php';

class MAX_Dal_Admin_Clients extends MAX_Dal_Common
{
    var $table = 'clients';
    
    var $orderListName = array(
        'name' => 'clientname',
        'id'   => 'clientid'
    );
    
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
    
    /**
     * Retrieve all information about one advertiser from the database.
     *
     * @param int $advertiser_id
     * @return array An associative array with a key for each database field.
     *
     * @todo Consider deprecating this method in favour of an object approach.
     */
    function getAdvertiserDetails($advertiser_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query = "SELECT *".
            " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
            " WHERE clientid=?";
        $query_params = array($advertiser_id);
        $advertiser_details = $this->dbh->getRow($query, $query_params, DB_FETCHMODE_ASSOC);
        if (PEAR::isError($advertiser_details)) {
            MAX::raiseError($advertiser_details);
            return array();
        }

        return $advertiser_details;
    }

    /**
     * Gets a list of all advertisers.
     * 
     * @param string $listorder
     * @param string $orderdirection
     * @return array
     *  
     * @todo Consider removing order options (or making them optional)
     */
    function getAllAdvertisers($listorder, $orderdirection, $agencyId = null)
    {
        $doClients = MAX_DB::factoryDO('clients');
        if (!empty($agencyId) && is_numeric($agencyId)) {
            $doClients->agencyid = $agencyId;
        }
        $doClients->addListOrderBy($listorder, $orderdirection);
        return $doClients->getAll(array('clientname'), $indexWitkPk = true, $flatten = false);
}

    /**
     * @param int $agency_id
     * @param string $listorder
     * @param string $orderdirection
     * @return array    An array of arrays, representing a list of displayable
     *                  advertisers.
     *
     * @todo Update to MAX DB API
     * @todo Consider removing order options (or making them optional)
     */
    function getAllAdvertisersForAgency($agency_id, $listorder, $orderdirection)
    {
        return $this->getAllAdvertisers($listorder, $orderdirection, $agency_id);
    }
}

?>