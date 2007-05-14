<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

class MAX_Dal_Admin_Zones extends MAX_Dal_Common
{
    var $table = 'zones';

    var $orderListName = array(
        'name' => 'zonename',
        'id'   => 'zoneid'
    );

	function getZoneByKeyword($keyword, $agencyId = null, $affiliateId = null)
    {
        $whereZone = is_numeric($keyword) ? " OR z.zoneid=$keyword" : '';
        $prefix = $this->getTablePrefix();

        $query = "
        SELECT
            z.zoneid AS zoneid,
            z.zonename AS zonename,
            z.description AS description,
            a.affiliateid AS affiliateid
        FROM
            {$prefix}zones AS z,
            {$prefix}affiliates AS a
        WHERE
            (
            z.affiliateid=a.affiliateid
            AND (z.zonename LIKE "  . DBC::makeLiteral('%' . $keyword . '%') . "
            OR description LIKE "  . DBC::makeLiteral('%' . $keyword . '%') . "
            $whereZone)
            )
    ";

        if($agencyId !== null) {
            $query .= " AND a.agencyid=" . DBC::makeLiteral($agencyId);
        }
        if($affiliateId !== null) {
            $query .= " AND a.affiliateid=" . DBC::makeLiteral($affiliateId);
        }

        return DBC::NewRecordSet($query);
    }

    /**
     * Gets the details to for generating invocation code.
     *
     * @param int $zoneId  the zone ID.
     * @return array  zone details to be passed into MAX_Admin_Invocation::placeInvocationForm()
     *
     * @see MAX_Admin_Invocation::placeInvocationForm()
     */
    function getZoneForInvocationForm($zoneId)
    {
        $prefix = $this->getTablePrefix();

        $query = "
            SELECT
                z.affiliateid,
                z.width,
                z.height,
                z.delivery,
                af.website
            FROM
                {$prefix}zones AS z,
                {$prefix}affiliates AS af
            WHERE
                z.zoneid = " . DBC::makeLiteral($zoneId) . "
            AND af.affiliateid = z.affiliateid";

        $rsZone = DBC::FindRecord($query);
        return $rsZone->toArray();
    }
}

?>