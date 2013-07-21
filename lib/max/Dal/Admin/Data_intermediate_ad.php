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

class MAX_Dal_Admin_Data_intermediate_ad extends MAX_Dal_Common
{
    var $table = 'data_intermediate_ad';

    /**
     * A method to determine the number of impressions, clicks and conversions
     * delivered by a given campaign to date.
     *
     * Can also determine the delivery information up to a given operation
     * interval end date.
     *
     * @param integer    $campaignId The campaign ID.
     * @param PEAR::Date $oDate      An optional date. If present, limits
     *                               delivery information to that which is
     *                               in or before this maximum possible
     *                               operation interval end date.
     * @return MDB2Record
     */
	function getDeliveredByCampaign($campaignId, $oDate = null)
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix.'banners',true);
        $tableD = $oDbh->quoteIdentifier($prefix.'data_intermediate_ad',true);
        $query = "
            SELECT
                SUM(dia.impressions) AS impressions_delivered,
                SUM(dia.clicks) AS clicks_delivered,
                SUM(dia.conversions) AS conversions_delivered
            FROM
                {$tableB} AS b,
                {$tableD} AS dia
            WHERE
                b.campaignid = " . DBC::makeLiteral($campaignId) . "
                AND
                b.bannerid = dia.ad_id";
        if (!is_null($oDate)) {
            $query .= "
                AND
                dia.interval_end <= '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'";
        }
        return DBC::FindRecord($query);
    }

    /**
     * A method to determine the number of impressions, clicks and conversions
     * delivered by a given ecpm campaign to date.
     *
     * Can also determine the delivery information up to a given operation
     * interval end date.
     *
     * @param integer    $agencyId The agency ID.
     * @param PEAR::Date $oDate      Limits delivery information to that which is
     *                               after this date.
     * @param integer    $priority Campaign priority (by default eCPM priority).
     * @return array
     */
	function getDeliveredEcpmCampainImpressionsByAgency($agencyId, $oDate, $priority = null)
    {
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        if (is_null($priority)) {
            $priority = DataObjects_Campaigns::PRIORITY_ECPM;
        }
        $query = "
            SELECT
                c.campaignid AS campaignid,
                SUM(dia.impressions) AS impressions_delivered
            FROM
                {$oDbh->quoteIdentifier($prefix.'clients',true)} AS cl,
                {$oDbh->quoteIdentifier($prefix.'campaigns',true)} AS c,
                {$oDbh->quoteIdentifier($prefix.'banners',true)} AS b,
                {$oDbh->quoteIdentifier($prefix.'data_intermediate_ad',true)} AS dia
            WHERE
                cl.agencyid = " . DBC::makeLiteral($agencyId) . "
                AND c.status = ".OA_ENTITY_STATUS_RUNNING."
                AND c.priority = ".$priority."
                AND cl.clientid = c.clientid
                AND b.bannerid = dia.ad_id
                AND b.campaignid = c.campaignid
                AND dia.interval_end >= '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
            GROUP BY
                c.campaignid";
        $rs = DBC::NewRecordSet($query);
        if (PEAR::isError($rs)) {
            return false;
        }
        return $rs->getAll(array(), 'campaignid');
    }

    /**
     * TODO: Should we refactor this method in more general one?
     * (maybe by creating common abstract class for all summary tables?)
     *
     * @param string $operation  Either + or -
     * @param int $basketValue
     * @param int $numItems
     * @param int $ad_id
     * @param int $creative_id
     * @param int $zone_id
     * @param strin $day
     * @param string $hour
     * @return unknown
     */
	function addConversion($operation, $basketValue, $numItems,
	                       $ad_id, $creative_id, $zone_id, $day, $hour,
	                       $table = null)
    {
        $prefix = $this->getTablePrefix();
        if ($operation != '-') {
            $operation = '+';
        }
        if ($table == null) {
            $table = $this->table;
        }
        $oDbh = OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($prefix.$table,true);
        $query = '
            UPDATE '.$table
                .' SET conversions=conversions'.$operation.'1
                    , total_basket_value=total_basket_value'.$operation.DBC::makeLiteral($basketValue).'
                    , total_num_items=total_num_items'.$operation.DBC::makeLiteral($numItems).'
                    , updated = \''. OA::getNow() .'\'
                WHERE
                       ad_id       = '.DBC::makeLiteral($ad_id).'
                   AND creative_id = '.DBC::makeLiteral($creative_id).'
                   AND zone_id     = '.DBC::makeLiteral($zone_id).'
                   AND date_time   = '.DBC::makeLiteral(sprintf("%s %02d:00:00", $day, $hour));

        return DBC::execute($query);
    }
}

?>
