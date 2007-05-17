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
require_once MAX_PATH . '/lib/max/OperationInterval.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once 'Date.php';

class MAX_Dal_Admin_Campaigns extends MAX_Dal_Common
{
    var $table = 'campaigns';

	var $orderListName = array(
        'name' => 'campaignname',
        'id'   => array('clientid', 'campaignid'),
    );

    /**
     * A method to determine the lifetime ad impressions left before expiration.
     *
     * @param integer    $campaignId The campaign ID.
     * @param PEAR::Date $oDate      An optional date. If present, sets an upper
     *                               date boundary of the end of the operation
     *                               interval the date is in to limit the delivery
     *                               statistics used in determining how many
     *                               impressions have delivered. Can be used to
     *                               determine the the lifetime ad impressions left
     *                               before expiration at a previous time.
     * @return mixed The number of ad impressions remaining, or the
     *               string "unlimited".
     */
    function getAdImpressionsLeft($campaignId, $oDate = null)
    {
        global $strUnlimited;
        $prefix = $this->getTablePrefix();

        // Get the campaign info
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->selectAdd("views AS impressions");
        $doCampaigns->get($campaignId);
        $aData = $doCampaigns->toArray();
        if ($aData['impressions'] > 0) {
            // Get the campaign delivery info
            if (!is_null($oDate)) {
                // Get the end of operation interval the date represents
                $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                $oDate = $aDates['end'];
            }
            $dalDataIntermediateAd = OA_Dal::factoryDAL('data_intermediate_ad');
            $record = $dalDataIntermediateAd->getDeliveredByCampaign($campaignId, $oDate);
            $aDeliveryData = $record->toArray();
            return $aData['impressions'] - $aDeliveryData['impressions_delivered'];
        } else {
            return $strUnlimited;
        }
    }

    /**
     * A method to determine the lifetime ad clicks left before expiration.
     *
     * @param integer    $campaignId The campaign ID.
     * @param PEAR::Date $oDate      An optional date. If present, sets an upper
     *                               date boundary of the end of the operation
     *                               interval the date is in to limit the delivery
     *                               statistics used in determining how many
     *                               clicks have delivered. Can be used to
     *                               determine the the lifetime ad clicks left
     *                               before expiration at a previous time.
     * @return mixed The number of ad clicks remaining, or the
     *               string "unlimited".
     */
    function getAdClicksLeft($campaignId, $oDate = null)
    {
        global $strUnlimited;
        $prefix = $this->getTablePrefix();

        // Get the campaign info
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->get($campaignId);
        $aData = $doCampaigns->toArray();
        if ($aData['clicks'] > 0) {
            // Get the campaign delivery info
            if (!is_null($oDate)) {
                // Get the end of operation interval the date represents
                $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                $oDate = $aDates['end'];
            }
            $dalDataIntermediateAd = OA_Dal::factoryDAL('data_intermediate_ad');
            $record = $dalDataIntermediateAd->getDeliveredByCampaign($campaignId, $oDate);
            $aDeliveryData = $record->toArray();
            return $aData['clicks'] - $aDeliveryData['clicks_delivered'];
        } else {
            return $strUnlimited;
        }
    }

    /**
     * A method to determine the lifetime ad conversions left before expiration.
     *
     * @param integer    $campaignId The campaign ID.
     * @param PEAR::Date $oDate      An optional date. If present, sets an upper
     *                               date boundary of the end of the operation
     *                               interval the date is in to limit the delivery
     *                               statistics used in determining how many
     *                               conversions have delivered. Can be used to
     *                               determine the the lifetime ad conversions left
     *                               before expiration at a previous time.
     * @return mixed The number of ad conversions remaining, or the
     *               string "unlimited".
     */
    function getAdConversionsLeft($campaignId, $oDate = null)
    {
        global $strUnlimited;
        $prefix = $this->getTablePrefix();

        // Get the campaign info
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->get($campaignId);
        $aData = $doCampaigns->toArray();
        if ($aData['clicks'] > 0) {
            // Get the campaign delivery info
            if (!is_null($oDate)) {
                // Get the end of operation interval the date represents
                $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
                $oDate = $aDates['end'];
            }
            $dalDataIntermediateAd = OA_Dal::factoryDAL('data_intermediate_ad');
            $record = $dalDataIntermediateAd->getDeliveredByCampaign($campaignId, $oDate);
            $aDeliveryData = $record->toArray();
            return $aData['conversions'] - $aDeliveryData['conversions_delivered'];
        } else {
            return $strUnlimited;
        }
    }

    /**
     * A method to determine how long it will be until a campaign "expires".
     *
     * Returns the earliest possible date from the following values:
     *  - The campaign's expiration date, if set.
     *  - The extimated expiration date based on lifetime impression delivery
     *    rate, if applicable.
     *  - The extimated expiration date based on lifetime click delivery rate
     *    if applicable.
     *  - The extimated expiration date based on lifetime conversion rate,
     *    if applicable.
     *
     * Usage:
     *   list($desc,$endDate,$daysLeft) = $dalCampaigns->getDaysLeft($campaignid);
     *
     * Where:
     *   $desc is a string to display giving how the expiration was calculated
     *     (eg. "Estimated expiration"), or that there is no expiration date,
     *     in which date $endDate and $daysLeft are null.
     *   $endDate is a formatted date string, ready for display, of the expiration
     *     date, if applicable.
     *   $daysLeft is a formatted number string, ready for display, of the number
     *     of days until the campaign will end, if applicable.
     *
     * @param integer $campaignId The campaign ID.
     * @return array The result array, as described above.
     */
    function getDaysLeft($campaignId)
    {
        global $date_format, $strExpiration, $strNoExpiration, $strDaysLeft, $strEstimated;
        $prefix = $this->getTablePrefix();

        // Define array to store possible expiration date results
        $aExpiration = array();

        // Get the campaign target info
        $now = OA::getNow('Y-m-d');
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->selectAdd("views AS impressions");
        $doCampaigns->selectAdd("DATE_FORMAT(expire, '$date_format') as expire_f");
        $doCampaigns->selectAdd("TO_DAYS(expire) - TO_DAYS('$now') as days_left");
        $doCampaigns->get($campaignId);
        $aCampaignData = $doCampaigns->toArray();

        // Does the campaign have a set expiration date?
        if ($aCampaignData['expire'] != OA_Dal::noDateValue()) {
            // Store the campaign's set expiration date as a possible
            // date that may cause the campaign to expire
			$aExpiration[] = array(
				"daysLeft"  => round($aCampaignData['days_left']),
				"date"	  	=> $aCampaignData['expire_f'],
				"absolute"  => true
			);
        }

        // Does the campaign have lifetime impression targets?
        if ($aCampaignData['impressions'] > 0) {
           	$query = "
                SELECT
                    SUM(dia.impressions) AS delivered,
                    MIN(dia.day) AS day_of_first
                FROM
                    {$prefix}data_intermediate_ad AS dia,
                    {$prefix}banners AS b
                WHERE
                    dia.ad_id = b.bannerid
                    AND
                    b.campaignid = ". DBC::makeLiteral($campaignId);
           	$rsImpressions = DBC::FindRecord($query);
			if ($rsImpressions) {
			    $aImpressions = $rsImpressions->toArray();
			    // Get the number of days until the campaign will end
			    // based on the impression target delivery data
                $aExpiration[] = $this->_calculateRemainingDays($aImpressions, $aCampaignData['impressions']);
			}
        }

        // Does the campaign have lifetime click targets?
        if ($aCampaignData['clicks'] > 0) {
           	$query = "
                SELECT
                    SUM(dia.clicks) AS delivered,
                    MIN(dia.day) AS day_of_first
                FROM
                    {$prefix}data_intermediate_ad AS dia,
                    {$prefix}banners AS b
                WHERE
                    dia.ad_id = b.bannerid
                    AND
                    b.campaignid = ". DBC::makeLiteral($campaignId);
           	$rsClicks = DBC::FindRecord($query);
			if ($rsClicks) {
			    $aClicks = $rsClicks->toArray();
			    // Get the number of days until the campaign will end
			    // based on the click target delivery data
                $aExpiration[] = $this->_calculateRemainingDays($aClicks, $aCampaignData['clicks']);

			}
        }

        // Does the campaign have lifetime conversion targets?
        if ($aCampaignData['conversions'] > 0) {
           	$query = "
                SELECT
                    SUM(dia.conversions) AS delivered,
                    MIN(dia.day) AS day_of_first
                FROM
                    {$prefix}data_intermediate_ad AS dia,
                    {$prefix}banners AS b
                WHERE
                    dia.ad_id = b.bannerid
                    AND
                    b.campaignid = ". DBC::makeLiteral($campaignId);
           	$rsConversions = DBC::FindRecord($query);
			if ($rsConversions) {
			    $aConversions = $rsConversions->toArray();
			    // Get the number of days until the campaign will end
			    // based on the conversion target delivery data
                $aExpiration[] = $this->_calculateRemainingDays($aConversions, $aCampaignData['conversions']);
			}
        }

        $aReturn = array();
        // Is there a possible expiration date?
        if (empty($aExpiration) || count($aExpiration) == 0) {
            // No, so return the "no expiration date" value
    		$aReturn[] = $strExpiration.": ".$strNoExpiration;
    		$aReturn[] = '';
    		$aReturn[] = '';
        } else {
        	// Find the earliest expiration date
    		$aFinalExpiration = $aExpiration[0];
    		for ($i = 1; $i < count($aExpiration); $i++) {
    		    if ($aExpiration[$i]['daysLeft'] < $aFinalExpiration['daysLeft']) {
    		        $aFinalExpiration = $aExpiration[$i];
                }
    		}
    		// Format the days remaining
            $aFinalExpiration['daysLeft'] = phpAds_formatNumber($aFinalExpiration['daysLeft']);
            // Prepare the return value
    		if ($aFinalExpiration['absolute']) {
    			$aReturn[] = $strExpiration . ": " . $aFinalExpiration['date'] . " (" . $strDaysLeft . ": " . $aFinalExpiration['daysLeft'] . ")";
    		} else {
    			$aReturn[] = $strEstimated  . ": " . $aFinalExpiration['date'] . " (" . $strDaysLeft . ": " . $aFinalExpiration['daysLeft'] . ")";
    		}
    		$aReturn[] = $aFinalExpiration['date'];
    		$aReturn[] = $aFinalExpiration['daysLeft'];
        }
        return $aReturn;
    }


    /**
     * A private method to caclucate the number of days left until a
     * campaign expires based on the impression, click or conversion
     * delivery targets & the delivery rate of the campaign to date.
     *
     * @param array $aDeliveryData An array of two items. "delivered":
     *                             the number of impressions, clicks or
     *                             conversions delivered so far; and
     *                             "day_of_first": a string in YYYY-MM-DD
     *                             format representing the day that the
     *                             first impression, click or conversion
     *                             was delivered.
     * @param integer $target      The total number of impressions, clicks
     *                             or conversions required to be delivered
     *                             by the campaign.
     * @return array An array of three items. "daysLeft": the estimated
     *               number of days remaining until the campaign ends;
     *               "date": the estimated date of expiration; and
     *               "absolute": the boolean "false", indicating that
     *               the date is an estimate.
     */
    function _calculateRemainingDays($aDeliveryData, $target)
    {
        global $date_format;
        $oNowDate = new Date();
        $aExpiration = array();
        // How many days since the first impression/click/conversion?
        if (!empty($aDeliveryData['day_of_first'])) {
            $oFirstDate = new Date($aDeliveryData['day_of_first']);
            $oSpan = new Date_Span();
            $oSpan->setFromDateDiff($oFirstDate, $oNowDate);
            $daysSinceFirst = ceil($oSpan->toDays());
        } else {
            $daysSinceFirst = 1;
        }
        // Have *any* impressions/clicks/conversions been delivered?
		if (!empty($aDeliveryData["delivered"]) && $aDeliveryData["delivered"] > 0) {
		    $targetRemaining = $target - $aDeliveryData["delivered"];
		    $deliveryRate = $aDeliveryData["delivered"] / $daysSinceFirst;
			$daysLeft = (int) round($targetRemaining / $deliveryRate);
		    $oSpan = new Date_Span();
		    $oSpan->setFromDays($daysLeft);
		    $oEstimatedEndDate = new Date();
            $oEstimatedEndDate->addSpan($oSpan);
            if ($oEstimatedEndDate->before($oNowDate)) {
                // Ooop! Wrapped into the past - get the biggest possible date
                $oEstimatedEndDate = new Date('1960-01-01 00:00:00');
                $oEstimatedEndDate->subtractSeconds(1);
            }
            $estimatedEndDate = $oEstimatedEndDate->format($date_format);
        	$aExpiration = array(
        		'daysLeft' => $daysLeft,
        		'date'     => $estimatedEndDate,
        		'absolute' => false
        	);
		} else {
		    // No impressions/clicks/conversions been delivered so far,
		    // so cannot estimate how long it will take to expire the
		    // campaign - estimate
		    $daysLeft = PHP_INT_MAX;
            $oEstimatedEndDate = new Date('1960-01-01 00:00:00');
            $oEstimatedEndDate->subtractSeconds(1);
            $estimatedEndDate = $oEstimatedEndDate->format($date_format);
        	$aExpiration = array(
        		'daysLeft' => $daysLeft,
        		'date'     => $estimatedEndDate,
        		'absolute' => true
        	);
		}
		return $aExpiration;
    }

    /**
     * Gets campaign Id and name and client Id by keyword and agency Id
     * matched by keyword and either client name or client id.
     *
     * @param $keyword  string  Keyword to look for
     * @param $agencyId int  Agency Id
     *
     * @return RecordSet
     * @access public
     */
    function getCampaignAndClientByKeyword($keyword, $agencyId = null)
    {
        $whereCampaign = is_numeric($keyword) ? " OR m.campaignid=". DBC::makeLiteral($keyword) : '';
        $prefix = $this->getTablePrefix();

        $query = "
        SELECT
            m.campaignid AS campaignid,
            m.campaignname AS campaignname,
            m.clientid AS clientid
        FROM
            {$prefix}campaigns AS m,
            {$prefix}clients AS c
        WHERE
            (
            m.clientid=c.clientid
            AND (m.campaignname LIKE ".DBC::makeLiteral('%'.$keyword.'%')."
                $whereCampaign)
            )
        ";

        if($agencyId !== null) {
            $query .= " AND c.agencyid=".DBC::makeLiteral($agencyId);
        }

        return DBC::NewRecordSet($query);
    }

    /**
     * @todo Consider removing order options (or making them optional)
     */
    function getAllCampaigns($listorder, $orderdirection)
    {
        $prefix = $this->getTablePrefix();

        $query = "
            SELECT
                campaignid,
                clientid,
                campaignname,
                active
            FROM
                {$prefix}campaigns " .
            $this->getSqlListOrder($listorder, $orderdirection)
        ;

        $rsCampaigns = DBC::NewRecordSet($query);
        $aCampaigns = $rsCampaigns->getAll(array('campaignid', 'clientid', 'campaignname', 'active'));
        $aCampaigns = $this->_rekeyCampaignsArray($aCampaigns);
        return $aCampaigns;
    }

    /**
     * @param int $agency_id
     * @return array    An array of arrays, representing a list of campaigns.
     *
     * @todo Consider removing order options (or making them optional)
     */
    function getAllCampaignsUnderAgency($agency_id, $listorder, $orderdirection)
    {
        $prefix = $this->getTablePrefix();

        $query = "
            SELECT
                m.campaignid as campaignid,
                m.clientid as clientid,
                m.campaignname as campaignname,
                m.active as active
            FROM
                {$prefix}campaigns AS m,
                {$prefix}clients AS c
            WHERE
                c.clientid=m.clientid
                AND c.agencyid=". DBC::makeLiteral($agency_id) .
            $this->getSqlListOrder($listorder, $orderdirection)
        ;

        $rsCampaigns = DBC::NewRecordSet($query);
        $aCampaigns = $rsCampaigns->getAll(array('campaignid', 'clientid', 'campaignname', 'active'));
        $aCampaigns = $this->_rekeyCampaignsArray($aCampaigns);
        return $aCampaigns;
    }

    function countActiveCampaigns()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_active_campaigns = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." WHERE active='t'";
        return $this->oDbh->queryOne($query_active_campaigns);
    }

    /**
     * @todo Verify that SQL is ANSI-compliant
     * @todo Consider reducing duplication with countCampaignsUnderAgency()
     * @todo Consider moving to Agency DAL
     */
    function countActiveCampaignsUnderAgency($agency_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $query_active_campaigns = "SELECT count(*) AS count".
            " FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
            ",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
            " WHERE m.clientid=c.clientid".
            " AND c.agencyid=". DBC::makeLiteral($agency_id) .
            " AND m.active='t'";
        return $this->oDbh->queryOne($query_active_campaigns);
    }

    /**
     * Converts a database result into an array keyed by campaign ID.
     * @param array $flat_campaign_data An flat array of campaign field arrays
     * @return array An array of arrays, representing a list of campaigns.
     */
    function _rekeyCampaignsArray($flat_campaign_data)
    {
        $campaigns = array();
        foreach ($flat_campaign_data as $row_campaign) {
            $campaigns[$row_campaign['campaignid']] = $row_campaign;
            $campaigns[$row_campaign['campaignid']]['expand'] = false;
            unset($campaigns[$row_campaign['campaignid']]['campaignid']);
        }
        return $campaigns;
    }
}

?>