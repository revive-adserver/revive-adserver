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
     *
     */
    function countAllAdvertisers()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_clients = "SELECT count(*) AS count".
        " FROM ".$conf['table']['prefix'].$conf['table']['clients'];
        $number_of_clients  = $this->dbh->getOne($query_clients);

        return $number_of_clients;
    }

    /**
     *
     * @return int Normally 1
     * @todo Consider returning hard-coded int 1
     */
    function countAdvertisersWithId($advertiser_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_clients = "SELECT count(*) AS count".
        " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
        " WHERE clientid=".$advertiser_id;
        $number_of_clients  = $this->dbh->getOne($query_clients);
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
    function getAllAdvertisers($listorder, $orderdirection)
    {
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->addListOrderBy($listorder, $orderdirection);
        $advertisers = $this->_rekeyClientsArray($doClients->getAll(array('clientname'), true));
        return $advertisers;
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
    function getAllAdvertisersUnderAgency($agency_id, $listorder, $orderdirection)
    {
        $doClients = MAX_DB::factoryDO('clients');
        $doClients->agencyid = $agency_id;
        $doClients->addListOrderBy($listorder, $orderdirection);
        $advertisers = $this->_rekeyClientsArray($doClients->getAll(array('clientname'), true));
        return $advertisers;
    }


    /**
     * @todo Verify SQL is ANSI compliant
     * @todo Consider moving to agency DAL
     */
    function countAdvertisersUnderAgency($agency_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query_clients = "SELECT count(*) AS count".
        " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
        " WHERE agencyid=".$agency_id;
        $number_of_clients  = $this->dbh->getOne($query_clients);
        return $number_of_clients;
    }

    /**
     * Converts a database result into an array keyed by ID.
     *
     * @param resource $res_clients A MySQL result resource
     * @return array An array of arrays, representing a list of advertisers.
     */
    function _fillClientArrayFromDbResult($res_clients)
    {
        $flat_advertiser_data = array();
        while ($row_clients = phpAds_dbFetchArray($res_clients)) {
            $flat_advertiser_data[] = $row_clients;
        }
        return $this->_rekeyClientsArray($flat_advertiser_data);
    }

    /**
     * @todo Consider removing (or moving) 'expand' -- it seems to be
     *       more  suited to the presentation-layer.
     */
    function _rekeyClientsArray($flat_advertiser_data)
    {
        $clients = array();
        foreach ($flat_advertiser_data as $row_clients) {
            $clients[$row_clients['clientid']]              = $row_clients;
            $clients[$row_clients['clientid']]['expand']    = false;
            unset($clients[$row_clients['clientid']]['clientid']);
        }
        return $clients;
    }
}

?>