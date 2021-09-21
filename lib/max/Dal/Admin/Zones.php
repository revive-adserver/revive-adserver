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
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Zone.php';

class MAX_Dal_Admin_Zones extends MAX_Dal_Common
{
    public $table = 'zones';

    public $orderListName = [
        'name' => 'zonename',
        'id' => 'zoneid',
        'size' => ['width', 'height'],
        'updated' => 'updated',
    ];

    public function getZoneByKeyword($keyword, $agencyId = null, $affiliateId = null)
    {
        $whereZone = is_numeric($keyword) ? " OR z.zoneid=$keyword" : '';
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableZ = $oDbh->quoteIdentifier($prefix . 'zones', true);
        $tableA = $oDbh->quoteIdentifier($prefix . 'affiliates', true);

        $query = "
        SELECT
            z.zoneid AS zoneid,
            z.zonename AS zonename,
            z.description AS description,
            a.affiliateid AS affiliateid
        FROM
            {$tableZ} AS z,
            {$tableA} AS a
        WHERE
            (
            z.affiliateid=a.affiliateid
            AND (z.zonename LIKE " . DBC::makeLiteral('%' . $keyword . '%') . "
            OR description LIKE " . DBC::makeLiteral('%' . $keyword . '%') . "
            $whereZone)
            )
    ";

        if ($agencyId !== null) {
            $query .= " AND a.agencyid=" . DBC::makeLiteral($agencyId);
        }
        if ($affiliateId !== null) {
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
    public function getZoneForInvocationForm($zoneId)
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableZ = $oDbh->quoteIdentifier($prefix . 'zones', true);
        $tableAf = $oDbh->quoteIdentifier($prefix . 'affiliates', true);

        $query = "
            SELECT
                z.affiliateid,
                z.width,
                z.height,
                z.delivery,
                af.website
            FROM
                {$tableZ} AS z,
                {$tableAf} AS af
            WHERE
                z.zoneid = " . DBC::makeLiteral($zoneId) . "
            AND af.affiliateid = z.affiliateid";

        $rsZone = DBC::FindRecord($query);
        return $rsZone->toArray();
    }

    /**
     * Function returns an array of websites, and each website has (not empty!) array of zones
     * All returned zones are linked to given agency.
     * Addational returned array contains iformation if zone is linked to given campaign.
     * Output can be limited to linked or avaliable (not linked) zones
     *
     * Returned array structure:
     * array (
     *   (int) affiliateId =>
     *   array (
     *     'name'            => 'website name',
     *     'linked'          => (boolean or null),
     *     'zones' =>
     *        array (
     *          (int) zoneId =>
     *             array ( 'name'            => 'zone name',
     *                     'campaign_stats'  => (boolean), // true if ecp, cr, ctr are statistics calculated for given campaign
     *                     'ecpm'            => 'zone eCPM',
     *                     'cr'              => 'zone CR',
     *                     'ctr'             => 'zone CTR',
     *                     'linked'          => (boolean or null)
     *                   )
     *             ...
     *             )
     *        )
     *   )
     *   ...
     * }
     *
     * If campaign is null isLinked is set to null as well
     *
     * @param int $agencyId   agency Id.
     * @param int $campaignId campaign Id.
     * @param boolean $returnLinked true - returns linked zones to campaign, false - returns avaliable zones, null - return all zones
     * @param string $searchPhrase A part of website name or zone name
     * @param boolean $includeEmailZones false (default) - don't include Email/Newsletter zone, true - include Email/Newsletter in result
     * @return array  of websites including array of zones
     */
    public function getWebsitesAndZonesList($agencyId, $campaignId = null, $returnLinked = null, $searchPhrase = null, $includeEmailZones = false)
    {
        $aZones = $this->getZonesList($agencyId, $campaignId, $returnLinked, $searchPhrase, $includeEmailZones);
        if (PEAR::isError($aZones)) {
            return $aZones;
        }

        // Convert 'flat' array of zones to 'tree like' array of websites and zones and add statistics
        $aWebsitesAndZones = [];
        foreach ($aZones as $aZone) {
            if (!array_key_exists($aZone['affiliateid'], $aWebsitesAndZones)) {
                $aWebsitesAndZones[$aZone['affiliateid']] =
                    [
                      'name' => $aZone['affiliatename'],
                      'linked' => null
                    ];
            }
            $aWebsitesAndZones[$aZone['affiliateid']]['zones'][$aZone['zoneid']] =
                   [
                     'name' => $aZone['zonename'],
                     'linked' => $aZone['islinked'] ?? false,
                   ];
        }

        return $aWebsitesAndZones;
    }

    /**
     * Function returns an array of zones linked to given agency.
     * Additionally returned array contains information if zone is linked to given campaign.
     * Output can be limited to linked or avaliable (not linked) zones
     *
     * Returned array structure:
     * array (
     *   0 => array (
     *          'zoneid'                    => (int) zoneId
     *          'zonename'                  => 'zone name'
     *          'affiliateid'               => (int) affiliateId (website Id)
     *          'affiliatename'             => 'website name'
     *          'islinked'                  => (boolean or null) iformation if zone is linked to given campaign
     *        )
     *   ...
     * )
     *
     * If campaign is null isLinked is set to null
     *
     * @param int $agencyId   agency Id.
     * @param int $campaignId campaign Id.
     * @param boolean $returnLinked true - returns linked zones to campaign, false - returns avaliable zones, null - return all zones
     * @param string $searchPhrase A part of website name or zone name
     * @param boolean $includeEmailZones false (default)- don't include Email/Newsletter zone, true - include Email/Newsletter in result
     * @return array of zones
     */
    public function getZonesList($agencyId, $campaignId = null, $returnLinked = null, $searchPhrase = null, $includeEmailZones = false)
    {
        if (empty($agencyId) ||
            (is_null($campaignId) && $returnLinked === true)) {
            return [];
        }

        $aQuery = $this->_prepareGetZonesQuery($agencyId, $campaignId, $returnLinked, $searchPhrase, $includeEmailZones);
        $query = $aQuery['select'] . $aQuery['from'] . $aQuery['where'] . $aQuery['order by'];

        $rsZones = DBC::NewRecordSet($query);
        if (PEAR::isError($rsZones)) {
            return $rsZones;
        }

        $aZones = $rsZones->getAll();
        // If campaignId wasn't given we leave null values in islinked row
        if (!empty($campaignId)) {
            // Change null values in islinked row to false and others values to true
            foreach ($aZones as $key => $aZone) {
                if (is_null($aZone['islinked'])) {
                    $aZones[$key]['islinked'] = false;
                } else {
                    $aZones[$key]['islinked'] = true;
                }
            }
        }

        return $aZones;
    }

    /**
     * Function returns number of zones for a given agency.
     * Output can be limited to linked or avaliable (not linked) zones
     *
     * @param int $agencyId   agency Id.
     * @param int $campaignId campaign Id.
     * @param boolean $returnLinked true - counts linked zones, false - counts avaliable zones, null - counts all zones
     * @param string $searchPhrase A part of website name or zone name
     * @param boolean $includeEmailZones false (default)- don't include Email/Newsletter zone, true - include Email/Newsletter in result
     * @return int number of zones thats match to given conditions
     */
    public function countZones($agencyId, $campaignId = null, $returnLinked = null, $searchPhrase = null, $includeEmailZones = false)
    {
        if (empty($agencyId) ||
            (is_null($campaignId) && $returnLinked === true)) {
            return 0;
        }
        $aQuery = $this->_prepareGetZonesQuery($agencyId, $campaignId, $returnLinked, $searchPhrase, $includeEmailZones);
        $aQuery['select'] = "
            Select
                count(z.zoneid) as zones";
        $query = $aQuery['select'] . $aQuery['from'] . $aQuery['where'];
        $rsZones = DBC::NewRecordSet($query);
        if (PEAR::isError($rsZones)) {
            return $rsZones;
        }
        $aZones = $rsZones->getAll();
        return $aZones[0];
    }
    /**
     * Bulid query for getZonesList
     * this function is also used by countZones
     *
     * @param int $agencyId   agency Id.
     * @param int $campaignId campaign Id.
     * @param boolean $returnLinked true - query will return linked zones to campaign, false - query will return avaliable zones, null - return all zones
     * @param string $searchPhrase A part of website name or zone name
     * @param boolean $includeEmailZones false (default)- don't include Email/Newsletter zone, true - include Email/Newsletter in result
     * @return array of strings - Returned query is divided to part (keys in array) 'select', 'from', 'where', 'order by'
     * @see getZonesList
     */
    public function _prepareGetZonesQuery($agencyId, $campaignId = null, $returnLinked = null, $searchPhrase = null, $includeEmailZones = false)
    {
        $prefix = $this->getTablePrefix();
        $aQuery['select'] = "
            SELECT
                z.zoneid,
                z.zonename,
                a.affiliateid,
                a.name as affiliatename";
        $aQuery['from'] = "
            FROM
                {$prefix}zones AS z
                JOIN {$prefix}affiliates AS a ON (z.affiliateid = a.affiliateid)";

        $aQuery['where'] = "
            WHERE
                a.agencyid = " . DBC::makeLiteral($agencyId);

        if (!$includeEmailZones) {
            $aQuery['where'] .= "
                AND
                z.delivery <> " . MAX_ZoneEmail;
        }
        if (!empty($searchPhrase)) {
            $aQuery['where'] .= "
                AND
                ( UPPER(z.zonename) like(UPPER(" . DBC::makeLiteral("%" . $searchPhrase . "%") . "))
                  OR
                  UPPER(a.name) like(UPPER(" . DBC::makeLiteral("%" . $searchPhrase . "%") . "))
                )";
        }

        if (!empty($campaignId)) {
            $aQuery['from'] .= "
                LEFT JOIN {$prefix}placement_zone_assoc AS pza
                    ON ( z.zoneid = pza.zone_id
                         AND
                         pza.placement_id = " . DBC::makeLiteral($campaignId) . "
                       )";
            $aQuery['select'] .= ",
                pza.placement_id AS islinked";
            if ($returnLinked === true) {
                $aQuery['where'] .= "
                    AND pza.placement_id IS NOT NULL
                    ";
            } elseif ($returnLinked === false) {
                $aQuery['where'] .= "
                    AND pza.placement_id IS NULL
                    ";
            }
        } else {
            $aQuery['select'] .= ",
                null AS islinked";
        }

        $aQuery['order by'] = "
            ORDER BY a.name, z.zonename
            ";
        return $aQuery;
    }


    /**
     * Adds statistics data to array of websites and zones ($aWebsitesAndZones)
     *
     * @param array &$aZones array of websites and zones - result of getWebsitesAndZonesList
     * @param int $campaignId campaign Id.
     */
    public function mergeStatistics(&$aWebsitesAndZones, $campaignId)
    {
        // Get list of zones IDs
        $aZonesIDs = [];
        $aZonesWebsite = [];
        foreach ($aWebsitesAndZones as $websiteId => $aWebsite) {
            foreach (array_keys($aWebsite['zones']) as $zoneId) {
                $aZonesIDs[] = $zoneId;
                $aZonesWebsite[$zoneId] = $websiteId;
            }
        }
        // Get statistics for zones for this campaign
        $oOaDalStatisticsZone = new OA_Dal_Statistics_Zone();
        $aZoneCampaignStatistics = $oOaDalStatisticsZone->getZonesPerformanceStatistics($aZonesIDs, $campaignId);
        if (isset($campaignId)) {
            // If there are zones that have no statistics for campaign, calculate overall statistics
            $aZoneWithMissingStatsIds = [];
            foreach ($aZonesIDs as $zoneId) {
                if (!isset($aZoneCampaignStatistics[$zoneId]['CTR']) &&
                    !isset($aZoneCampaignStatistics[$zoneId]['CR']) &&
                    !isset($aZoneCampaignStatistics[$zoneId]['eCPM'])
                   ) {
                    $aZoneWithMissingStatsIds[] = $zoneId;
                }
            }
            $aZoneGlobalStatistics = $oOaDalStatisticsZone->getZonesPerformanceStatistics($aZoneWithMissingStatsIds);
        } else {
            // If campaign ID isn't given it means, that overall statistics was calculated
            $aZoneGlobalStatistics = $aZoneCampaignStatistics;
            $aZoneCampaignStatistics = [];
        }

        foreach ($aZonesWebsite as $zoneId => $websiteId) {
            if (isset($aZoneGlobalStatistics[$zoneId])) {
                $aWebsitesAndZones[$websiteId]['zones'][$zoneId]['campaign_stats'] = false;
                $aWebsitesAndZones[$websiteId]['zones'][$zoneId]['ecpm'] = $aZoneGlobalStatistics[$zoneId]['eCPM'];
                $aWebsitesAndZones[$websiteId]['zones'][$zoneId]['cr'] = $aZoneGlobalStatistics[$zoneId]['CR'];
                $aWebsitesAndZones[$websiteId]['zones'][$zoneId]['ctr'] = $aZoneGlobalStatistics[$zoneId]['CTR'];
            } else {
                $aWebsitesAndZones[$websiteId]['zones'][$zoneId]['campaign_stats'] = true;
                $aWebsitesAndZones[$websiteId]['zones'][$zoneId]['ecpm'] = $aZoneCampaignStatistics[$zoneId]['eCPM'];
                $aWebsitesAndZones[$websiteId]['zones'][$zoneId]['cr'] = $aZoneCampaignStatistics[$zoneId]['CR'];
                $aWebsitesAndZones[$websiteId]['zones'][$zoneId]['ctr'] = $aZoneCampaignStatistics[$zoneId]['CTR'];
            }
        }
    }


    /**
     * Batch linking list of zones to campaign
     *
     * @param array $aZonesIds array of zones IDs
     * @param int $campaignId  the campaign ID.
     * @return int number of linked zones , -1 if invalid parameters was detected, PEAR:Errors on DB errors
     */
    public function linkZonesToCampaign($aZonesIds, $campaignId)
    {
        // Check realm of given zones and campaign
        $checkResult = $this->_checkZonesRealm($aZonesIds, $campaignId);
        if ($checkResult == false) {
            return -1;
        } elseif (PEAR::isError($checkResult)) {
            MAX::raiseError($checkResult, MAX_ERROR_DBFAILURE);
            return -1;
        }

        // Call sql queries to link zones and banners to campaign
        $linkedZones = $this->_linkZonesToCampaign($aZonesIds, $campaignId);
        if (PEAR::isError($linkedZones)) {
            return $linkedZones;
        }
        $linkedBanners = $this->_linkZonesToCampaignsBannersOrSingleBanner($aZonesIds, $campaignId);
        if (PEAR::isError($linkedBanners)) {
            return $linkedBanners;
        }

        return $linkedZones;
    }

    /**
     * Batch linking list of zones to banner
     *
     * @param array $aZonesIds array of zones IDs
     * @param int $bannerId  the banner ID.
     * @return int number of linked zones , -1 if invalid parameters was detected, PEAR:Errors on DB errors
     */
    public function linkZonesToBanner($aZonesIds, $bannerId)
    {
        // Check realm of given zones and campaign
        $checkResult = $this->_checkZonesRealm($aZonesIds, null, $bannerId);
        if ($checkResult == false) {
            return -1;
        } elseif (PEAR::isError($checkResult)) {
            MAX::raiseError($checkResult, MAX_ERROR_DBFAILURE);
            return -1;
        }

        // Call sql queries to link zones to banners
        $linkedZones = $this->_linkZonesToCampaignsBannersOrSingleBanner($aZonesIds, null, $bannerId);
        if (PEAR::isError($linkedZones)) {
            return $linkedZones;
        }

        return $linkedZones;
    }

    /**
     * Batch linking list of zones to campaign
     * This is a sub-function of linkZonesToCampaigns.
     *
     * Function don't link zones to campaign if:
     *  -link already exists
     *  -zone has type = Email
     *
     * @param array $aZonesIds array of zones IDs
     * @param int $campaignId  the campaign ID.
     * @return int number of linked zones
     */
    public function _linkZonesToCampaign($aZonesIds, $campaignId)
    {
        $prefix = $this->getTablePrefix();
        $fromWhereClause =
            " FROM
                {$prefix}campaigns AS c
                CROSS JOIN
                {$prefix}zones AS z
                LEFT JOIN {$prefix}placement_zone_assoc AS pza ON (pza.zone_id = z.zoneid AND pza.placement_id = c.campaignid)
            WHERE
                c.campaignid = " . DBC::makeLiteral($campaignId) . "
                AND
                z.zoneid IN (" . implode(",", array_map('intval', $aZonesIds)) . ")
                AND
                z.delivery <> " . MAX_ZoneEmail . "
                AND
                pza.placement_zone_assoc_id IS NULL";

        $fastLinking = !$GLOBALS['_MAX']['CONF']['audit']['enabledForZoneLinking'];
        if ($fastLinking) {
            $query = "INSERT INTO {$prefix}placement_zone_assoc (placement_id, zone_id)
                      SELECT c.campaignid, z.zoneid
                      $fromWhereClause";
            return $this->oDbh->exec($query);
        } else {
            $query = "
                SELECT c.campaignid AS campaignid,
                       z.zoneid AS zoneid
               $fromWhereClause
            ";
            $rsCampZones = DBC::NewRecordSet($query);
            if (PEAR::isError($rsCampZones)) {
                return $rsCampZones;
            }
            $aCampZones = $rsCampZones->getAll();
            $doPlacementZoneAssoc = OA_Dal::factoryDO('placement_zone_assoc');
            foreach ($aCampZones as $aCampZone) {
                $doPlacementZoneAssoc->zone_id = $aCampZone['zoneid'];
                $doPlacementZoneAssoc->placement_id = $aCampZone['campaignid'];
                $doPlacementZoneAssoc->insert();
            }
            return count($aCampZones);
        }
    }

    /**
     * Batch linking list of zones to campaign's banners or a specific banner
     * This is a sub-function of linkZonesToCampaigns and linkZonesToBanner.
     *
     * Banners are linked when:
     *  - text text banner and text zone (ignore width/height)
     *  - link non text banners when matching width/height to non text zone
     * Don't link banners to zone if that link already exists
     * Don't link Email zones
     *
     * @param array $aZonesIds array of zones IDs
     * @param int $campaignId  the campaign ID.
     * @param int $bannerId    the banner ID.
     * @return int number of linked banners
     */
    public function _linkZonesToCampaignsBannersOrSingleBanner($aZonesIds, $campaignId, $bannerId = null)
    {
        $prefix = $this->getTablePrefix();

        $rsEmailZones = DBC::NewRecordSet("SELECT zoneid FROM {$prefix}zones WHERE delivery = " . MAX_ZoneEmail . " AND zoneid IN (" . implode(',', array_map('intval', $aZonesIds)) . ")");
        $aEmailZoneIds = $rsEmailZones->getAll();

        $fastLinking = !$GLOBALS['_MAX']['CONF']['audit']['enabledForZoneLinking'];
        $fromWhereClause =
            " FROM
                {$prefix}banners AS b
                CROSS JOIN
                {$prefix}zones AS z
                LEFT JOIN {$prefix}ad_zone_assoc AS aza ON (aza.ad_id = b.bannerid AND aza.zone_id = z.zoneid)
            WHERE";
        if (!empty($campaignId)) {
            $fromWhereClause .= "
                b.campaignid = " . DBC::makeLiteral($campaignId) . "
                AND";

            foreach ($aEmailZoneIds as $zoneId) {
                $okToLink = Admin_DA::_checkEmailZoneAdAssoc($zoneId, $campaignId);
                if (PEAR::isError($okToLink)) {
                    $aZonesIds = array_diff($aZonesIds, [$zoneId]);
                }
            }
        }
        if (!empty($bannerId)) {
            $fromWhereClause .= "
                b.bannerid = " . DBC::makeLiteral($bannerId) . "
                AND";

            // Remove any zoneids which this banner cannot be linked to due to
            // email zone restrictions
            foreach ($aEmailZoneIds as $zoneId) {
                $aAd = Admin_DA::getAd($bannerId);
                $okToLink = Admin_DA::_checkEmailZoneAdAssoc($zoneId, $aAd['placement_id']);
                if (PEAR::isError($okToLink)) {
                    $aZonesIds = array_diff($aZonesIds, [$zoneId]);
                }
            }
        }
        if (empty($aZonesIds)) {
            return $okToLink;
        }

        $fromWhereClause .= "
                z.zoneid IN (" . implode(",", array_map('intval', $aZonesIds)) . ")
                AND
                (
                    (
                        b.storagetype = 'txt'
                        AND
                        z.delivery = " . phpAds_ZoneText . "
                    )
                    OR
                    (
                        z.delivery <> " . phpAds_ZoneText . "
                        AND
                        b.storagetype <> 'txt'
                        AND
                        (
                          (
                            ( z.width = -1
                              OR
                              z.width = b.width
                            )
                            AND
                            ( z.height = -1
                              OR
                              z.height = b. height
                            )
                          )
                          OR
                          (
                            b.height = -1 AND b.width = -1
                          )
                        )
                    )
                )
                AND
                aza.ad_zone_assoc_id IS NULL
        ";

        // if only one zone is selected and this zone is an email zone
        // we only link it if it was not previously linked to any banner (email zones can be linked to one banner only)

        if ($fastLinking) {
            $query = "INSERT INTO {$prefix}ad_zone_assoc (zone_id, ad_id, priority_factor)
                SELECT z.zoneid, b.bannerid, 1
                $fromWhereClause
            ";
            return $this->oDbh->exec($query);
        } else {
            $query = "
                SELECT z.zoneid AS zoneid,
                       b.bannerid AS bannerid
                $fromWhereClause
            ";
            $rsAdZones = DBC::NewRecordSet($query);
            if (PEAR::isError($rsAdZones)) {
                return $rsAdZones;
            }
            $aAdZones = $rsAdZones->getAll();
            $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
            foreach ($aAdZones as $aAdZone) {
                $doAdZoneAssoc->zone_id = $aAdZone['zoneid'];
                $doAdZoneAssoc->ad_id = $aAdZone['bannerid'];
                $doAdZoneAssoc->priority_factor = 1;
                $doAdZoneAssoc->insert();
            }
            return count($aAdZones);
        }
    }

    /**
     * Check if given zones are under the same agency as given campaign or banner
     *
     * @param array $aZonesIds array of zones IDs
     * @param int $campaignId  the campaign ID.
     * @param int $bannerId    the banner ID.
     * @return boolean true if all zones are in the same realm as banner, false otherwise
     */
    public function _checkZonesRealm($aZonesIds, $campaignId = null, $bannerId = null)
    {
        if (!is_array($aZonesIds) || count($aZonesIds) == 0) {
            return false;
        }
        if (empty($campaignId) && empty($bannerId)) {
            return false;
        }

        $doZones = OA_Dal::factoryDO('zones');
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAgency = OA_Dal::factoryDO('agency');
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doClients = OA_Dal::factoryDO('clients');

        if (!empty($bannerId)) {
            $doBanners = OA_Dal::factoryDO('banners');
            $doBanners->bannerid = (int)$bannerId;
            $doCampaigns->joinAdd($doBanners);
        }
        if (!empty($campaignId)) {
            $doCampaigns->campaignid = (int)$campaignId;
        }
        $doClients->joinAdd($doCampaigns);
        $doAgency->joinAdd($doClients);
        $doAffiliates->joinAdd($doAgency);
        $doZones->joinAdd($doAffiliates);
        $doZones->whereAdd("zoneid IN (" . implode(',', array_map('intval', $aZonesIds)) . ")");
        $doZones->selectAdd();
        $doZones->selectAdd('count( zoneid ) as zones');
        $doZones->groupBy($doAgency->tableName() . '.agencyid');

        $doZones->find();
        if ($doZones->fetch() === false) {
            return false;
        }
        $aZonesCount = $doZones->toArray();
        if ($aZonesCount['zones'] != count($aZonesIds)) {
            return false;
        }
        return true;
    }

    /**
     * Batch unlinking zones from campaign
     *
     * @param array $aZonesIds array of zones IDs
     * @param int $campaignId  the campaign ID.
     * @return int number of unlinked zones, -1 on parameters error, PEAR:Errors on DB errors
     */
    public function unlinkZonesFromCampaign($aZonesIds, $campaignId)
    {
        if (!is_array($aZonesIds)) {
            return -1;
        } elseif (count($aZonesIds) == 0) {
            return 0;
        }
        $prefix = $this->getTablePrefix();

        $doBanner = OA_Dal::factoryDO('banners');
        $doBanner->campaignid = $campaignId;
        $doBanner->find();
        $aBannersIds = [];
        while ($doBanner->fetch()) {
            $aBannersIds[] = $doBanner->bannerid;
        }

        $fastLinking = !$GLOBALS['_MAX']['CONF']['audit']['enabledForZoneLinking'];
        if ($fastLinking) {
            if (count($aBannersIds) != 0) {
                // Delete ad_zone_assoc
                $query = "
                   DELETE
                   FROM {$prefix}ad_zone_assoc
                   WHERE
                       ad_id IN (" . implode(',', array_map('intval', $aBannersIds)) . ")
                       AND
                       zone_id IN (" . implode(",", array_map('intval', $aZonesIds)) . ")
               ";

                $unlinkedBanners = $this->oDbh->exec($query);
                if (PEAR::isError($unlinkedBanners)) {
                    return $unlinkedBanners;
                }
            }

            // Delete placement_zone_assoc
            $query = "
               DELETE
               FROM {$prefix}placement_zone_assoc
               WHERE
                   placement_id = " . DBC::makeLiteral($campaignId) . "
                   AND
                   zone_id IN (" . implode(",", array_map('intval', $aZonesIds)) . ")
           ";
            return $this->oDbh->exec($query);
        } else { //slow - uses audit trail
            if (count($aBannersIds) != 0) {
                // Do a iteration to add all deleted ad_zone_assoc to audit log
                // it doesn't log all deleted rows when using
                // $doAdZoneAssoc->addWhere(
                //      ad_id IN (" . implode(',', $aBannersIds) . ")
                //      AND
                //      zone_id IN (" . implode(",",$aZonesIds) . ")
                //
                $doAdZoneAssocEmpty = OA_Dal::factoryDO('ad_zone_assoc');
                foreach ($aBannersIds as $bannerId) {
                    foreach ($aZonesIds as $zonesId) {
                        $doAdZoneAssoc = clone($doAdZoneAssocEmpty);  // Every delete have to be done on separate object
                        $doAdZoneAssoc->zone_id = $zonesId;
                        $doAdZoneAssoc->ad_id = $bannerId;
                        $doAdZoneAssoc->delete();
                    }
                }
            }
            $doPlacementZoneAssocEmpty = OA_Dal::factoryDO('placement_zone_assoc');
            foreach ($aZonesIds as $zonesId) {
                $doPlacementZoneAssoc = clone($doPlacementZoneAssocEmpty);  // Every delete have to be done on separate object
                $doPlacementZoneAssoc->zone_id = $zonesId;
                $doPlacementZoneAssoc->placement_id = $campaignId;
                $doPlacementZoneAssoc->delete();
            }

            return count($aZonesIds);
        }
    }

    /**
     * Batch unlinking zones from banner
     *
     * @param array $aZonesIds array of zones IDs
     * @param int $bannerId  the banner ID.
     * @return int number of unlinked zones, -1 on parameters error, PEAR:Errors on DB errors
     */
    public function unlinkZonesFromBanner($aZonesIds, $bannerId)
    {
        if (!is_array($aZonesIds)) {
            return -1;
        } elseif (count($aZonesIds) == 0) {
            return 0;
        }
        $prefix = $this->getTablePrefix();

        $fastLinking = !$GLOBALS['_MAX']['CONF']['audit']['enabledForZoneLinking'];
        if ($fastLinking) {
            // Delete ad_zone_assoc
            $query = "
               DELETE
               FROM {$prefix}ad_zone_assoc
               WHERE
                   ad_id = " . DBC::makeLiteral($bannerId) . "
                   AND
                   zone_id IN (" . implode(",", array_map('intval', $aZonesIds)) . ")
           ";

            return $this->oDbh->exec($query);
        } else { //slow - uses audit trail
            // Do a iteration to add all deleted ad_zone_assoc to audit log
            // it doesn't log all deleted rows when using
            // $doAdZoneAssoc->addWhere(
            //      ad_id IN (" . implode(',', $aBannersIds) . ")
            //      AND
            //      zone_id IN (" . implode(",",$aZonesIds) . ")
            //
            $doAdZoneAssocEmpty = OA_Dal::factoryDO('ad_zone_assoc');
            foreach ($aZonesIds as $zonesId) {
                $doAdZoneAssoc = clone($doAdZoneAssocEmpty);  // Every delete have to be done on separate object
                $doAdZoneAssoc->zone_id = $zonesId;
                $doAdZoneAssoc->ad_id = $bannerId;
                $doAdZoneAssoc->delete();
            }

            return count($aZonesIds);
        }
    }

    /**
     * Method checked if zone linked to active campaign
     *
     * @param int $zoneId
     * @return boolean  true if zone is connect to active campaign, false otherwise
     */
    public function checkZoneLinkedToActiveCampaign($zoneId)
    {
        $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
        $doBanner = OA_Dal::factoryDO('banners');
        $doCampaign = OA_Dal::factoryDO('campaigns');
        $doCampaign->whereAdd($doCampaign->tableName() . ".status <> " . OA_ENTITY_STATUS_EXPIRED);
        $doCampaign->whereAdd($doCampaign->tableName() . ".status <> " . OA_ENTITY_STATUS_REJECTED);
        $doAdZone->zone_id = $zoneId;
        $doBanner->joinAdd($doCampaign);
        $doAdZone->joinAdd($doBanner);

        $result = $doAdZone->count();

        $doPlacementZone = OA_Dal::factoryDO('placement_zone_assoc');
        $doCampaign = OA_Dal::factoryDO('campaigns');
        $doCampaign->whereAdd("status <> " . OA_ENTITY_STATUS_EXPIRED);
        $doCampaign->whereAdd("status <> " . OA_ENTITY_STATUS_REJECTED);
        $doPlacementZone->zone_id = $zoneId;
        $doPlacementZone->joinAdd($doCampaign);

        $result += $doPlacementZone->count();

        if ($result > 0) {
            return true;
        }
        return false;
    }
}
