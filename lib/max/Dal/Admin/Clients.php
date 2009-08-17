<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: Acls.dal.test.php 6032 2007-04-25 16:12:07Z aj@seagullproject.org $
*/

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/wact/db/db.inc.php';

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
        $oDbh = OA_DB::singleton();
        $tableC = $oDbh->quoteIdentifier($this->getTablePrefix().'clients',true);

        $query = "
            SELECT
                c.clientid AS clientid,
                c.clientname AS clientname
            FROM
                {$tableC} AS c
            WHERE
                (
                    c.clientname LIKE ". DBC::makeLiteral('%'. $keyword. '%') . $whereClient ."
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
     * @return array
     *
     * @todo Consider removing order options (or making them optional)
     */
    function getAllAdvertisers($listorder, $orderdirection, $agencyId = null)
    {
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->whereAdd('account_type <> '. DBC::makeLiteral(OA_ACCOUNT_SYSTEM));

        $doClients = OA_Dal::factoryDO('clients');
        $doClients->joinAdd($doAccounts);
        if (!empty($agencyId) && is_numeric($agencyId)) {
            $doClients->agencyid = $agencyId;
        }
        $doClients->addListOrderBy($listorder, $orderdirection);
        return $doClients->getAll(array('clientname', 'an_adnetwork_id'), $indexWitkPk = true, $flatten = false);
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