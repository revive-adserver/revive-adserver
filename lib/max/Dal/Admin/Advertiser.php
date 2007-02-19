<?php
/**
 * @since Max v0.3.30 - 20-Nov-2006
 */

require_once MAX_PATH . '/lib/max/Dal/Common.php';

require_once MAX_PATH . '/lib/max/Dal/db/db.inc.php';

class MAX_Dal_Admin_Advertiser extends MAX_Dal_Common
{
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
     * @todo Consider removing order options (or making them optional)
     */
    function getAllAdvertisers($listorder, $orderdirection)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        
        $query =
        "SELECT clientid, clientname".
        " FROM ".$conf['table']['prefix'].$conf['table']['clients'];
        $query .= phpAds_getClientListOrder ($listorder, $orderdirection);
        
        $flat_advertiser_data = $this->dbh->getAll($query);
        $advertisers = $this->_rekeyClientsArray($flat_advertiser_data);
        return $advertisers;
    }
    
    /**
     * @param int $agency_id
     * @return array    An array of arrays, representing a list of displayable
     *                  advertisers.
     * 
     * @todo Update to MAX DB API
     * @todo Consider removing order options (or making them optional)
     */
    function getAllAdvertisersUnderAgency($agency_id, $listorder, $orderdirection)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        
        $query = 
        "SELECT clientid,clientname".
        " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
        " WHERE agencyid=".$agency_id;
        $query .=  phpAds_getClientListOrder ($listorder, $orderdirection);
        $flat_advertiser_data = $this->dbh->getAll($query);
        $advertisers = $this->_rekeyClientsArray($flat_advertiser_data);
        return $advertisers;
    }
    
    /**
     * Retrieve a single advertiser's details, in an iterable format.
     * 
     * @todo Consider whether this is actually needed
     * @todo Consider removing order options (or making them optional)
     */
    function getAllAdvertisersWithId($advertiser_id, $listorder, $orderdirection)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        
        $res_clients = phpAds_dbQuery(
            "SELECT clientid,clientname".
            " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
            " WHERE clientid=".$advertiser_id.
        phpAds_getClientListOrder ($listorder, $orderdirection)
        ) or phpAds_sqlDie();
        
        $clients = $this->_fillClientArrayFromDbResult($res_clients);
        return $clients;
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