<?php

require_once MAX_PATH . '/lib/max/Dal/Common.php';


class MAX_Dal_Admin_Data_intermediate_ad extends MAX_Dal_Common
{
    var $table = 'data_intermediate_ad';
	
    /**
     * @param int $campaignId
     * @return MDB2Record
     */
	function getDeliveredByCampaign($campaignId)
    {
        $prefix = $this->getTablePrefix();

        $query = "
            SELECT
                   SUM(dia.impressions) AS impressions_delivered,
                   SUM(dia.clicks) AS clicks_delivered,
                   SUM(dia.conversions) AS conversions_delivered
               FROM
                   {$prefix}banners AS b,
                   {$prefix}data_intermediate_ad AS dia
               WHERE
                   b.campaignid = ".DBC::makeLiteral($campaignId)."
                   AND b.bannerid = dia.ad_id
            ";

        return DBC::FindRecord($query);
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
        if ($operation != '+') {
            $operation = '-';
        }
        if ($table == null) {
            $table = $this->table;
        }

        $query = "
            UPDATE '.{$prefix}{$table}
                SET conversions=conversions'.$operation.'1, '
                    , total_basket_value=total_basket_value".$operation.DBC::makeLiteral($basketValue)."
                    , total_num_items=total_num_items".$operation.DBC::makeLiteral($numItems)."
                    , updated = '".date('Y-m-d H:i:s')."'
                WHERE
                       ad_id       = ".DBC::makeLiteral($ad_id)."
                   AND creative_id = ".DBC::makeLiteral($creative_id)."
                   AND zone_id     = ".DBC::makeLiteral($zone_id)."
                   AND day         = ".DBC::makeLiteral($day)."
                   AND hour        = ".DBC::makeLiteral($hour);

        return DBC::execute($query);
    }
}

?>
