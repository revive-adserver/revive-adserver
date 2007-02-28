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
}

?>
