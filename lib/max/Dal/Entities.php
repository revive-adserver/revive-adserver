<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

/**
 * The non-DB specific Common Data Access Layer (DAL) class for getting
 * and setting entities data.
 *
 * @package    MaxDal
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Dal_Entities extends MAX_Dal_Common
{

    /**
     * The constructor method.
     *
     * @return MAX_Dal_Entities
     */
    function MAX_Dal_Entities()
    {
        parent::MAX_Dal_Common();
    }

    /*========== METHODS FOR DEALING WITH ADS ===============*/

    /**
     * A method to get the details of all ads (active or not) by their
     * parent placement ID.
     *
     * @param integer $placementId The parent placement ID.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by ad ID, of arrays containing the ad
     *               details, for example:
     *                  array(
     *                      1 => array(
     *                          'ad_id'  => 1
     *                          'active' => 't',
     *                          'type'   => 'sql',
     *                          'weight' => 1
     *                      )
     *                      .
     *                      .
     *                      .
     *                  )
     */
    function getAdsByPlacementId($placementId)
    {
        // Test the input values
        if (!is_numeric($placementId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['banners'];
        $query = "
            SELECT
                bannerid AS ad_id,
                active AS active,
                storagetype AS type,
                weight AS weight
            FROM
                $table
            WHERE
                campaignid = $placementId
            ORDER BY
                ad_id";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['ad_id']] = $aRow;
        }
        return $aResult;
    }

    /**
     * A method to get the IDs of all active ads linked to a list of zones IDs.
     *
     * @param array $aZoneIds An array of zone IDs.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by zone ID, of arrays, containing the
     *               ad IDs, in order.
     */
    function getLinkedActiveAdIdsByZoneIds($aZoneIds)
    {
        // Test the input values
        if (!is_array($aZoneIds)) {
            return null;
        }
        reset($aZoneIds);
        while (list($key, $zoneId) = each($aZoneIds)) {
            if (!is_numeric($zoneId)) {
                return null;
            }
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $adTable  = $conf['table']['prefix'] . $conf['table']['banners'];
        $azaTable = $conf['table']['prefix'] . $conf['table']['ad_zone_assoc'];
        $query = "
            SELECT
                aza.zone_id AS zone_id,
                a.bannerid AS ad_id
            FROM
                $adTable AS a,
                $azaTable AS aza
            WHERE
                a.active = 't'
                AND
                a.bannerid = aza.ad_id
                AND
                aza.link_type != 0
                AND
                aza.zone_id IN (" . implode(', ', $aZoneIds) . ")
            ORDER BY
                ad_id";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['zone_id']][] = $aRow['ad_id'];
        }
        return $aResult;
    }

    /**
     * A method to get the details of ads, including their delivery limitations,
     * where the ads are "owned" by a placement in a list of placement IDs.
     *
     * @param array $aPlacementIds An array of placement IDs.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by placement ID, then ad ID, of the
     *               ad details, including an array, indexed by execution
     *               order, of any delivery limitations the ad(s) may have.
     *               For example:
     *                  array(
     *                      1 => array(
     *                          2 => array(
     *                              'active' => 't',
     *                              'weight' => 1,
     *                              'deliveryLimitations' => array(
     *                                  0 => array(
     *                                      'logical'    => 'and',
     *                                      'type'       => 'Site:Channel',
     *                                      'comparison' => '==',
     *                                      'data'       => 12
     *                                  )
     *                              )
     *                          )
     *                      )
     *                  )
     */
    function getAllActiveAdsDeliveryLimitationsByPlacementIds($aPlacementIds)
    {
        // Test the input values
        if (!is_array($aPlacementIds)) {
            return null;
        }
        reset($aPlacementIds);
        while (list($key, $placementId) = each($aPlacementIds)) {
            if (!is_numeric($placementId)) {
                return null;
            }
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $adTable  = $conf['table']['prefix'] . $conf['table']['banners'];
        $dlTable  = $conf['table']['prefix'] . $conf['table']['acls'];
        $query = "
            SELECT
                a.bannerid AS ad_id,
                a.campaignid AS placement_id,
                a.active AS active,
                a.weight AS weight,
                dl.logical AS logical,
                dl.type AS type,
                dl.comparison AS comparison,
                dl.data AS data,
                dl.executionorder AS executionorder
            FROM
                $adTable AS a
            LEFT JOIN
                $dlTable AS dl
            ON
                (
                    a.bannerid = dl.bannerid
                )
            WHERE
                a.campaignid IN (" . implode(', ', $aPlacementIds) . ")
                AND
                a.active = 't'";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        $aAdIds = array();
        while ($aRow = $rc->fetchRow()) {
            if (is_null($aResult[$aRow['placement_id']][$aRow['ad_id']])) {
                $aResult[$aRow['placement_id']][$aRow['ad_id']]['active'] = $aRow['active'];
                $aResult[$aRow['placement_id']][$aRow['ad_id']]['weight'] = $aRow['weight'];
                $aResult[$aRow['placement_id']][$aRow['ad_id']]['deliveryLimitations'] = array();
            }
            if (!is_null($aRow['executionorder'])) {
                $aResult[$aRow['placement_id']][$aRow['ad_id']]['deliveryLimitations'][$aRow['executionorder']] =
                    array(
                        'logical'    => $aRow['logical'],
                        'type'       => $aRow['type'],
                        'comparison' => $aRow['comparison'],
                        'data'       => $aRow['data']
                    );
            }
            if (is_null($aAdIds[$aRow['ad_id']])) {
                $aAdIds[$aRow['ad_id']] = $aRow['ad_id'];
            }
        }
        return $aResult;
    }

    /**
     * A method to get the delivery limitation details of an ad, given an ad ID.
     *
     * @param integer $adId An ad ID.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by execution order, of the ad's delivery
     *               limitations. For example:
     *                  array(
     *                      0 => array(
     *                          'logical'    => 'and',
     *                          'type'       => 'Site:Channel',
     *                          'comparison' => '==',
     *                          'data'       => 12
     *                      )
     *                  )
     */
    function getDeliveryLimitationsByAdId($adId)
    {
        // Test the input values
        if (!is_numeric($adId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['acls'];
        $query = "
            SELECT
                logical AS logical,
                type AS type,
                comparison AS comparison,
                data AS data,
                executionorder AS executionorder
            FROM
                $table
            WHERE
                bannerid = $adId";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['executionorder']] = array(
                'logical'    => $aRow['logical'],
                'type'       => $aRow['type'],
                'comparison' => $aRow['comparison'],
                'data'       => $aRow['data']
            );
        }
        return $aResult;
    }

    /*========== METHODS FOR DEALING WITH AGENCIES ==========*/

    /**
     * A method to get the IDs of all active agencies.
     *
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array containing the agency IDs, in order.
     */
    function getAllActiveAgencyIds()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['agency'];
        $query = "
            SELECT
                agencyid AS agency_id
            FROM
                $table
            WHERE
                active = 1
            ORDER BY
                agencyid";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[] = $aRow['agency_id'];
        }
        return $aResult;
    }

    /*========== METHODS FOR DEALING WITH CHANNELS ==========*/

    /**
     * A method to get the IDs of all active channels "owned" by an agency.
     *
     * @param integer $agencyId The ID of the agency.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array containing the channel IDs, in order.
     */
    function getAllActiveChannelIdsByAgencyId($agencyId)
    {
        return $this->getAllActiveChannelIdsByAgencyPublisherId($agencyId, 0);
    }

    /**
     * A method to get the IDs of all active channels "owned" by an agency/publisher.
     *
     * @param inteter $agencyId The ID of the agency the publisher is in.
     * @param integer $publisherId The ID of the publisher, or 0 for channels that
     *                             are owned by the agency.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array containing the channel IDs, in order.
     */
    function getAllActiveChannelIdsByAgencyPublisherId($agencyId, $publisherId)
    {
        // Test the input values
        if (!is_numeric($agencyId)) {
            return null;
        }
        if (!is_numeric($publisherId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['channel'];
        $query = "
            SELECT
                channelid AS channel_id
            FROM
                $table
            WHERE
                agencyid = $agencyId
                AND affiliateid = $publisherId
                AND active = 1
            ORDER BY
                channelid";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[] = $aRow['channel_id'];
        }
        return $aResult;
    }

    /**
     * A method to get the delivery limitation details of a channel, given a channel ID.
     *
     * @param integer $channelId An ad ID.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by execution order, of the channel's
     *               delivery limitations. For example:
     *                  array(
     *                      0 => array(
     *                          'logical'    => 'and',
     *                          'type'       => 'Time:Hour',
     *                          'comparison' => '==',
     *                          'data'       => 12
     *                      )
     *                  )
     */
    function getDeliveryLimitationsByChannelId($channelId)
    {
        // Test the input values
        if (!is_numeric($channelId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['acls_channel'];
        $query = "
            SELECT
                logical AS logical,
                type AS type,
                comparison AS comparison,
                data AS data,
                executionorder AS executionorder
            FROM
                $table
            WHERE
                channelid = $channelId";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['executionorder']] = array(
                'logical'    => $aRow['logical'],
                'type'       => $aRow['type'],
                'comparison' => $aRow['comparison'],
                'data'       => $aRow['data']
            );
        }
        return $aResult;
    }

    /*========== METHODS FOR DEALING WITH PLACEMENTS ========*/

    /**
     * A method to get the details of all placements that are the
     * parent placements of a list of ad IDs, and which will be
     * active and expected to be active at some stage during a
     * given period.
     *
     * @param array $aAdIds An array of ad IDs.
     * @param arary $aPeriod An array of two PEAR::Date objects, indexed
     *                       by 'start' and 'end', giving the start and
     *                       end range of the period in which the placements
     *                       are expected to be active.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by placement ID, of arrays containing
     *               the following placement details:
     *                  placement_id,
     *                  placement_name,
     *                  active,
     *                  weight,
     *                  placement_start,
     *                  placement_end,
     *                  priority,
     *                  impression_target_total,
     *                  click_target_total,
     *                  conversion_target_total,
     *                  impression_target_daily,
     *                  click_target_daily,
     *                  conversion_target_daily
     */
    function getAllActivePlacementsByAdIdsPeriod($aAdIds, $aPeriod)
    {
        // Test the input values
        if (!is_array($aAdIds)) {
            return null;
        }
        reset($aAdIds);
        while (list($key, $adId) = each($aAdIds)) {
            if (!is_numeric($adId)) {
                return null;
            }
        }
        if (!is_a($aPeriod['start'], 'Date') || !is_a($aPeriod['end'], 'Date')) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $adTable        = $conf['table']['prefix'] . $conf['table']['banners'];
        $placementTable = $conf['table']['prefix'] . $conf['table']['campaigns'];
        $query = "
            SELECT
                p.campaignid AS placement_id,
                p.campaignname AS placement_name,
                p.active AS active,
                p.weight AS weight,
                p.activate AS placement_start,
                p.expire AS placement_end,
                p.priority AS priority,
                p.views AS impression_target_total,
                p.clicks AS click_target_total,
                p.conversions AS conversion_target_total,
                p.target_impression AS impression_target_daily,
                p.target_click AS click_target_daily,
                p.target_conversion AS conversion_target_daily
            FROM
                $placementTable AS p,
                $adTable AS a
            WHERE
                p.campaignid = a.campaignid
                AND
                a.bannerid IN (" . implode(', ', $aAdIds) . ")
                AND
                (
                    (p.active = 't' AND p.expire = {$this->oDbh->noDateString})
                    OR
                    (p.active = 't' AND p.expire != {$this->oDbh->noDateString} AND p.expire >= '" . $aPeriod['start']->format('%Y-%m-%d') . "')
                    OR
                    (p.active = 'f' AND p.activate != {$this->oDbh->noDateString} AND p.activate <= '" . $aPeriod['end']->format('%Y-%m-%d') . "' AND p.expire = {$this->oDbh->noDateString})
                    OR
                    (p.active = 'f' AND p.activate != {$this->oDbh->noDateString} AND p.activate <= '" . $aPeriod['end']->format('%Y-%m-%d') . "' AND p.expire != {$this->oDbh->noDateString} AND p.expire >= '" . $aPeriod['start']->format('%Y-%m-%d') . "')
                )
        ";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['placement_id']] = $aRow;
        }
        return $aResult;
    }

    /*========== METHODS FOR DEALING WITH PUBLISHERS ========*/

    /**
     * A method to get the IDs of all publishers "owned" by an agency.
     *
     * @param integer $agencyId The ID of the agency.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array containing the publisher IDs, in order.
     *
     * @TODO Does NOT test is the publisher is active or not, as (currently)
     *       there is no "active" field for publishers (affiliates) - will
     *       need to be updated if publishers can be disabled!
     */
    function getAllPublisherIdsByAgencyId($agencyId)
    {
        // Test the input values
        if (!is_numeric($agencyId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['affiliates'];
        $query = "
            SELECT
                affiliateid AS publisher_id
            FROM
                $table
            WHERE
                agencyid = $agencyId
            ORDER BY
                affiliateid";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[] = $aRow['publisher_id'];
        }
        return $aResult;
    }

    /*========== METHODS FOR DEALING WITH ZONES =============*/

    /**
     * A method to get zones, given an list of zone IDs.
     *
     * @param array $aZoneIds An array of zone IDs.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by zone ID, of the zone detials.
     */
    function getZonesByZoneIds($aZoneIds)
    {
        // Test the input values
        if (!is_array($aZoneIds)) {
            return null;
        }
        reset($aZoneIds);
        while (list($key, $zoneId) = each($aZoneIds)) {
            if (!is_numeric($zoneId)) {
                return null;
            }
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['zones'];
        $query = "
            SELECT
                zoneid AS zone_id,
                affiliateid AS publisher_id,
                zonename AS zonename,
                description AS description,
                delivery AS delivery,
                zonetype AS zonetype,
                category AS category,
                width AS width,
                height AS height,
                ad_selection AS ad_selection,
                chain AS chain,
                prepend AS prepend,
                append AS append,
                appendtype AS appendtype,
                forceappend AS forceappend,
                inventory_forecast_type AS inventory_forecast_type,
                comments AS comments,
                cost AS cost,
                cost_type AS cost_type,
                cost_variable_id AS cost_variable_id,
                technology_cost AS technology_cost,
                technology_cost_type AS technology_cost_type,
                updated AS updated,
                block AS block,
                capping AS capping,
                session_capping AS session_capping
            FROM
                $table
            WHERE
                zoneid IN (" . implode(', ', $aZoneIds) . ")";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['zone_id']] = $aRow;
        }
        return $aResult;
    }

    /**
     * A method to get the IDs of all zones "owned" by a publisher.
     *
     * @param integer $publisherId The ID of the publisher.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array containing the zone IDs, in order.
     *
     * @TODO Does NOT test is the zone is active or not, as (currently)
     *       there is no "active" field for zones - will need to be
     *       updated if zones can be disabled!
     */
    function getAllZonesIdsByPublisherId($publisherId)
    {
        // Test the input values
        if (!is_numeric($publisherId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['zones'];
        $query = "
            SELECT
                zoneid AS zone_id
            FROM
                $table
            WHERE
                affiliateid = $publisherId
            ORDER BY
                zoneid";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[] = $aRow['zone_id'];
        }
        return $aResult;
    }

    /**
     * A method to get the IDs of all "channel forecast" zones "owned" by
     * a publisher.
     *
     * Currently, the zones table's "inventory_forecast_type" field is a
     * bit-wise flag field, where the zone has been set to be channel
     * forecast if the 5th bit from the right is set (ie. decimal 8).
     * This is a hard-coded value.
     *
     * @param integer $publisherId The ID of the publisher.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array containing the zone IDs, in order.
     *
     * @TODO Does NOT test is the zone is active or not, as (currently)
     *       there is no "active" field for zones - will need to be
     *       updated if zones can be disabled!
     *
     * @TODO Eventually, the inventory_forecast_type field should be
     *       changed to "forecast", once channel forecasting is changed
     *       to be the ONLY forecasting type in Max.
     */
    function getAllChannelForecastZonesIdsByPublisherId($publisherId)
    {
        // Test the input values
        if (!is_numeric($publisherId)) {
            return null;
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['zones'];
        $query = "
            SELECT
                zoneid AS zone_id
            FROM
                $table
            WHERE
                affiliateid = $publisherId
                AND (inventory_forecast_type & 8) != 0
            ORDER BY
                zoneid";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[] = $aRow['zone_id'];
        }
        return $aResult;
    }

    /**
     * A method to get the IDs of all zones linked to a list of ad IDs.
     *
     * @param array $aAdIds An array of ad IDs.
     * @return mixed PEAR_Error on error, null on no values found, or an
     *               array, indexed by ad ID, of arrays, containing the
     *               currently linked zone IDs, in order.
     */
    function getLinkedZonesIdsByAdIds($aAdIds)
    {
        // Test the input values
        if (!is_array($aAdIds)) {
            return null;
        }
        reset($aAdIds);
        while (list($key, $adId) = each($aAdIds)) {
            if (!is_numeric($adId)) {
                return null;
            }
        }
        // Get the required data
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['ad_zone_assoc'];
        $query = "
            SELECT
                ad_id AS ad_id,
                zone_id AS zone_id
            FROM
                $table
            WHERE
                ad_id IN (" . implode(', ', $aAdIds) . ")
                AND
                link_type != 0
            ORDER BY
                ad_id, zone_id";
        $rc = $this->oDbh->query($query);
        if (PEAR::isError($rc)) {
            return MAX::raiseError($rc, MAX_ERROR_DBFAILURE);
        }
        if ($rc->numRows() < 1) {
            return null;
        }
        $aResult = array();
        while ($aRow = $rc->fetchRow()) {
            $aResult[$aRow['ad_id']][] = $aRow['zone_id'];
        }
        return $aResult;

    }

}