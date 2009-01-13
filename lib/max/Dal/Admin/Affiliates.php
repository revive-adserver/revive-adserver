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
        $oDbh = OA_DB::singleton();
        $tableA     = $oDbh->quoteIdentifier($prefix.'affiliates',true);
        $query = "
        SELECT
            a.affiliateid AS affiliateid,
            a.name AS name
        FROM
            {$tableA} AS a
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
        $oDbh = OA_DB::singleton();
        $tableAza   = $oDbh->quoteIdentifier($prefix.'ad_zone_assoc',true);
        $tableZ     = $oDbh->quoteIdentifier($prefix.'zones',true);
        $tableP     = $oDbh->quoteIdentifier($prefix.'affiliates',true);
        $tableB     = $oDbh->quoteIdentifier($prefix.'banners',true);
        $tableCt    = $oDbh->quoteIdentifier($prefix.'campaigns_trackers',true);

        $query = "
            SELECT
                p.affiliateid AS affiliateid,
                p.name AS name
            FROM
                {$tableAza} aza
                JOIN {$tableZ} z ON (aza.zone_id = z.zoneid)
                JOIN {$tableP} p USING (affiliateid)
                JOIN {$tableB} b ON (aza.ad_id = b.bannerid)
                JOIN {$tableCt} ct USING (campaignid)
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