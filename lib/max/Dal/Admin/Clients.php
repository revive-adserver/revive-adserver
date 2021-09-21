<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/wact/db/db.inc.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Clients.php';

class MAX_Dal_Admin_Clients extends MAX_Dal_Common
{
    public $table = 'clients';

    public $orderListName = [
        'name' => 'clientname',
        'id' => 'clientid',
        'updated' => 'updated',
    ];

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
    public function getClientByKeyword($keyword, $agencyId = null, $aIncludeSystemTypes = [])
    {
        // always add default type
        $aIncludeSystemTypes = array_merge(
            [DataObjects_Clients::ADVERTISER_TYPE_DEFAULT],
            $aIncludeSystemTypes
        );
        foreach ($aIncludeSystemTypes as $k => $v) {
            $aIncludeSystemTypes[$k] = DBC::makeLiteral((int)$v);
        }

        $conf = $GLOBALS['_MAX']['CONF'];
        $whereClient = is_numeric($keyword) ? " OR c.clientid = $keyword" : '';
        $oDbh = OA_DB::singleton();
        $tableC = $oDbh->quoteIdentifier($this->getTablePrefix() . 'clients', true);


        $query = "
            SELECT
                c.clientid AS clientid,
                c.clientname AS clientname
            FROM
                {$tableC} AS c
            WHERE
                (
                    c.clientname LIKE " . DBC::makeLiteral('%' . $keyword . '%') . $whereClient . "
                )
                AND c.type IN (" . implode(',', $aIncludeSystemTypes) . ")";
        if ($agencyId !== null) {
            $query .= " AND c.agencyid=" . DBC::makeLiteral($agencyId);
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
    public function getAdvertiserDetails($advertiserId)
    {
        $doClients = OA_Dal::staticGetDO('clients', $advertiserId);
        if ($doClients) {
            return $doClients->toArray();
        }
        return null;
    }


    /**
     * A method to retrieve a list of all advertiser names. Can be limited to
     * just return the advertisers that are "owned" by an agency.
     *
     * @param string  $listorder      The column name to sort the agency names by. One of "name" or "id".
     * @param string  $orderdirection The sort oder for the sort column. One of "up" or "down".
     * @param integer $agencyId       Optional. The agency ID to limit results to.
     * @param array $aIncludeSystemTypes an array of system types to be
     *              included apart from default advertisers
     *
     * @return array
     *
     * @todo Consider removing order options (or making them optional)
     */
    public function getAllAdvertisers($listorder, $orderdirection, $agencyId = null, $aIncludeSystemTypes = [])
    {
        $aIncludeSystemTypes = array_merge(
            [DataObjects_Clients::ADVERTISER_TYPE_DEFAULT],
            $aIncludeSystemTypes
        );

        $doClients = OA_Dal::factoryDO('clients');
        if (!empty($agencyId) && is_numeric($agencyId)) {
            $doClients->agencyid = $agencyId;
        }
        $doClients->whereInAdd('type', $aIncludeSystemTypes);
        $doClients->orderBy('(type=' . DataObjects_Clients::ADVERTISER_TYPE_DEFAULT . ') ASC');
        $doClients->addListOrderBy($listorder, $orderdirection);
        return $doClients->getAll(['clientname', 'type', 'updated'], $indexWitkPk = true, $flatten = false);
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
    public function getAllAdvertisersForAgency($agency_id, $listorder = 'name', $orderdirection = 'up', $aIncludeSystemTypes = [])
    {
        return $this->getAllAdvertisers($listorder, $orderdirection, $agency_id, $aIncludeSystemTypes);
    }
}
