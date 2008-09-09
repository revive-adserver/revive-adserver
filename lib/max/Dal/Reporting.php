<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id$
*/

require_once MAX_PATH.'/lib/max/Dal/Common.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * The non-DB specific Data Access Layer (DAL) class for the User Interface (Reporting).
 *
 * @package    MaxDal
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Robert Hunter <roh@m3.net>
 */
class MAX_Dal_Reporting extends MAX_Dal_Common
{
    function MAX_Dal_Reporting()
    {
        parent :: MAX_Dal_Common();
    }

    /**
     * @todo Handle situations where user is not Admin, Agency or Advertiser.
     */
    function phpAds_getAdvertiserArray($orderBy = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN))
        {
            $query =
                "SELECT clientid,clientname".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients'];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $query =
                "SELECT clientid,clientname".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
                " WHERE agencyid=".OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $query =
                "SELECT clientid,clientname".
                " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
                " WHERE clientid=".OA_Permission::getEntityId();
        }
        $orderBy ? $query .= " ORDER BY $orderBy ASC" : 0;

        $res = phpAds_dbQuery($query);

        while ($row = phpAds_dbFetchArray($res))
            $clientArray[$row['clientid']] = phpAds_buildName ($row['clientid'], $row['clientname']);

        return ($clientArray);
    }

    /**
     * @todo Handle cases where user is not Admin, Agency or Advertiser
     */
    function phpAds_getPublisherArray($orderBy = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $query =
                "SELECT affiliateid,name".
                " FROM ".$conf['table']['prefix'].$conf['table']['affiliates'];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $query =
                "SELECT affiliateid,name".
                " FROM ".$conf['table']['prefix'].$conf['table']['affiliates'].
                " WHERE agencyid=".OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $query =
                "SELECT affiliateid,name".
                " FROM ".$conf['table']['prefix'].$conf['table']['affiliates'].
                " WHERE affiliateid=".OA_Permission::getEntityId();
        }
        $orderBy ? $query .= " ORDER BY $orderBy ASC" : 0;

        $res = phpAds_dbQuery($query);

        while ($row = phpAds_dbFetchArray($res))
            $affiliateArray[$row['affiliateid']] = phpAds_buildAffiliateName ($row['affiliateid'], $row['name']);;

        return ($affiliateArray);
    }

    function phpAds_getTrackerArray()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $where = "c.clientid = t.clientid";

        if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $where .= " AND c.agencyid = " . OA_Permission::getEntityId();
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $where .= " AND t.clientid = " . OA_Permission::getEntityId();
        }

        $query = "
            SELECT
                c.clientname AS client_name,
                c.clientid AS client_id,
                t.trackername AS tracker_name,
                t.trackerid AS tracker_id
            FROM
                {$conf['table']['trackers']} AS t,
                {$conf['table']['clients']} AS c
            WHERE
                {$where}
            ORDER BY
                c.clientname,t.trackername
        ";
        $res = phpAds_dbQuery($query);

        while ($row = phpAds_dbFetchArray($res)) {
            $trackerArray[$row['tracker_id']] = "<span dir='".$GLOBALS['phpAds_TextDirection']."'>[id".$row['client_id']."] ".$row['client_name']." - [id".$row['tracker_id']."] ".$row['tracker_name']."</span> ";
        }

        return ($trackerArray);
    }


}