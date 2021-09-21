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

require_once MAX_PATH . '/lib/max/Dal/Common.php';

class MAX_Dal_Admin_Affiliates extends MAX_Dal_Common
{
    public $table = 'affiliates';

    public $orderListName = [
        'name' => 'name',
        'id' => 'affiliateid',
        'updated' => 'updated',
    ];

    public function getAffiliateByKeyword($keyword, $agencyId = null)
    {
        $whereAffiliate = is_numeric($keyword) ? " OR a.affiliateid=$keyword" : '';
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableA = $oDbh->quoteIdentifier($prefix . 'affiliates', true);
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

        if ($agencyId !== null) {
            $query .= " AND a.agencyid=" . DBC::makeLiteral($agencyId);
        }

        return DBC::NewRecordSet($query);
    }

    public function getWebsitesAndZonesByAgencyId($agencyId = null)
    {
        if (is_null($agencyId)) {
            $agencyId = OA_Permission::getAgencyId();
        }
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableW = $oDbh->quoteIdentifier($prefix . $this->table, true);
        $tableZ = $oDbh->quoteIdentifier($prefix . 'zones', true);
        
        // Select out websites only first (to ensure websites with no zones are included in the list)
        $aWebsitesAndZones = [];
        $query = "
            SELECT
                w.affiliateid AS website_id,
                w.website     AS website_url,
                w.name        AS website_name,
                w.updated     AS updated
            FROM
                {$tableW} AS w
            WHERE
                w.agencyid = " . DBC::makeLiteral($agencyId) . "
            ORDER BY w.name";
        $rsAffiliates = DBC::NewRecordSet($query);
        $rsAffiliates->find();
        while ($rsAffiliates->fetch()) {
            $aWebsiteZone = $rsAffiliates->toArray();
            $aWebsitesAndZones[$aWebsiteZone['website_id']]['name'] = $aWebsiteZone['website_name'];
            $aWebsitesAndZones[$aWebsiteZone['website_id']]['url'] = $aWebsiteZone['website_url'];
            $aWebsitesAndZones[$aWebsiteZone['website_id']]['updated'] = $aWebsiteZone['updated'];
            $aWebsitesAndZones[$aWebsiteZone['website_id']]['zones'] = [];
        }
        
        $query = "
        SELECT
            w.affiliateid AS website_id,
            w.website     AS website_url,
            w.name        AS website_name,
            z.zoneid      AS zone_id,
            z.zonename    AS zone_name,
            z.width       AS zone_width,
            z.height      AS zone_height
        FROM
            {$tableW} AS w,
            {$tableZ} AS z
        WHERE
            z.affiliateid = w.affiliateid
          AND w.agencyid = " . DBC::makeLiteral($agencyId) . "
        ORDER BY w.name";
        
        $rsAffiliatesAndZones = DBC::NewRecordSet($query);
        $rsAffiliatesAndZones->find();
        while ($rsAffiliatesAndZones->fetch()) {
            $aWebsiteZone = $rsAffiliatesAndZones->toArray();
            $aWebsitesAndZones[$aWebsiteZone['website_id']]['name'] = $aWebsiteZone['website_name'];
            $aWebsitesAndZones[$aWebsiteZone['website_id']]['url'] = $aWebsiteZone['website_url'];
            $aWebsitesAndZones[$aWebsiteZone['website_id']]['zones'][$aWebsiteZone['zone_id']] = [
                'name' => $aWebsiteZone['zone_name'],
                'width' => $aWebsiteZone['zone_width'],
                'height' => $aWebsiteZone['zone_height'],
            ];
        }
        return $aWebsitesAndZones;
    }
    
    public function getPublishersByTracker($trackerid)
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableAza = $oDbh->quoteIdentifier($prefix . 'ad_zone_assoc', true);
        $tableZ = $oDbh->quoteIdentifier($prefix . 'zones', true);
        $tableP = $oDbh->quoteIdentifier($prefix . 'affiliates', true);
        $tableB = $oDbh->quoteIdentifier($prefix . 'banners', true);
        $tableCt = $oDbh->quoteIdentifier($prefix . 'campaigns_trackers', true);

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
                ct.trackerid = " . DBC::makeLiteral($trackerid) . "
            GROUP BY
                p.affiliateid,
                name
            ORDER BY
                name
        ";

        return DBC::NewRecordSet($query);
    }
}
