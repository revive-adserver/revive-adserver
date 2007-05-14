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
$Id$
*/

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
        if ($operation != '-') {
            $operation = '+';
        }
        if ($table == null) {
            $table = $this->table;
        }

        $query = '
            UPDATE '.$prefix.$table
                .' SET conversions=conversions'.$operation.'1
                    , total_basket_value=total_basket_value'.$operation.DBC::makeLiteral($basketValue).'
                    , total_num_items=total_num_items'.$operation.DBC::makeLiteral($numItems).'
                    , updated = \''. OA::getNow() .'\'
                WHERE
                       ad_id       = '.DBC::makeLiteral($ad_id).'
                   AND creative_id = '.DBC::makeLiteral($creative_id).'
                   AND zone_id     = '.DBC::makeLiteral($zone_id).'
                   AND day         = '.DBC::makeLiteral($day).'
                   AND hour        = '.DBC::makeLiteral($hour);

        return DBC::execute($query);
    }
}

?>
