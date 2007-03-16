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
     * A method to retrieve all advertisers where the advertiser name
     * contains a given string. Also returns any advertiser where the
     * advertiser ID equals the given keyword, should the keyword be
     * numeric.
     *
     * @param $keyword  string  Keyword to look for
     * @param $agencyId integer Limit results to advertisers owned by a given Agency ID
     * @return RecordSet
     */
    function getClientByKeyword($keyword, $agencyId = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $whereClient = is_numeric($keyword) ? " OR c.clientid = $keyword" : '';
        $query = "
            SELECT
                c.clientid AS clientid,
                c.clientname AS clientname
            FROM
                {$conf['table']['prefix']}{$conf['table']['clients']} AS c
            WHERE
                (
                    c.clientname LIKE '%$keyword%' $whereClient
                )";
        if ($agencyId !== null) {
            $query .= " AND c.agencyid=".DBC::makeLiteral($agencyId);
        }
        return DBC::NewRecordSet($query);
    }

    /**
     * A method to retrieve all information about one advertiser from the database.
     *
     * @param int $advertiserId The advertiser ID.
     * @return mixed An associative array with a key for each database field,
     *               or null if no result found.
     *
     * @todo Consider deprecating this method in favour of an object approach.
     */
    function getAdvertiserDetails($advertiserId)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['clients']}
            WHERE
                clientid = ?";
        $aQueryParams = array($advertiserId);
        $aAdvertiserDetails = $this->dbh->getRow($query, $aQueryParams, DB_FETCHMODE_ASSOC);
        if (PEAR::isError($aAdvertiserDetails)) {
            MAX::raiseError($aAdvertiserDetails);
            return array();
        }
        return $aAdvertiserDetails;
    }

    /**
     * A method to retrieve a list of all advertiser names. Can be limited to
     * just return the advertisers that are "owned" by an agency.
     *
     * @param string  $listorder      The column name to sort the agency names by. One of "name" or "id".
     * @param string  $orderdirection The sort oder for the sort column. One of "up" or "down".
     * @param integer $agencyId       Optional. The agency ID to limit results to.
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