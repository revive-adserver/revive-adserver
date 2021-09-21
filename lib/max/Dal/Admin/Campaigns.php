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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Campaigns.php';

require_once LIB_PATH . '/OperationInterval.php';

require_once OX_PATH . '/lib/pear/Date.php';

/**
 * The Entity Service class for the "campaigns" table.
 *
 * @package    MaxDal
 */
class MAX_Dal_Admin_Campaigns extends MAX_Dal_Common
{
    public $table = 'campaigns';

    public $orderListName = [
        'name' => 'campaignname',
        'id' => ['clientid', 'campaignid'],
        'status' => 'status',
    // hack to sort by type asc first (non default campaigns always on top)
    // DataObjects_Campaigns::CAMPAIGN_TYPE_DEFAULT = 0
        'type+name' => "(type=0) ASC, campaignname",
        'type+id' => ['(type=0) ASC, clientid', 'campaignid'],
        'type+status' => '(type=0) ASC, status',
        'updated' => 'updated',
    ];

    /**
     * Changes priority in campaigns belonging to a given agency.
     *
     * @param integer $agencyId
     * @param integer $priorityUpdateFrom
     * @param integer $priorityUpdateTo
     * @return array  Array of campaigns which priority was changed
     */
    public function updateCampaignsPriorityByAgency($agencyId, $priorityUpdateFrom, $priorityUpdateTo)
    {
        $aUpdatedCampaigns = [];
        $aCampaigns = $this->getAllCampaignsUnderAgency($agencyId, 'name', 'up');
        foreach ($aCampaigns as $campaignId => $aCampaign) {
            $aCampaign['status_changed'] = false;
            if ($aCampaign['priority'] != $priorityUpdateFrom
                || $aCampaign['priority'] == $priorityUpdateTo) {
                continue;
            }
            $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
            if ($doCampaigns) {
                $oldStatus = $doCampaigns->status;
                $doCampaigns->priority = $priorityUpdateTo;
                $doCampaigns->update();
                $aCampaign['status_changed'] = ($doCampaigns->status != $oldStatus);
                $aCampaign['status'] = $doCampaigns->status;
                $aUpdatedCampaigns[$campaignId] = $aCampaign;
                $doCampaigns->free();
            }
        }
        return $aUpdatedCampaigns;
    }

    /**
     * Sets ecpm_enabled in campaigns belonging to a given agency.
     *
     * @param integer $agencyId
     * @return array  Array of campaigns which ecpm_enabled was changed
     */
    public function updateEcpmEnabledByAgency($agencyId)
    {
        $do = OA_Dal::factoryDO('Campaigns');
        $aUpdatedCampaigns = [];
        $aCampaigns = $this->getAllCampaignsUnderAgency($agencyId, 'name', 'up');
        foreach ($aCampaigns as $campaignId => $aCampaign) {
            $aCampaign['status_changed'] = false;
            $doCampaigns = OA_Dal::staticGetDO('campaigns', $campaignId);
            if ($doCampaigns) {
                $oldStatus = $doCampaigns->status;
                $doCampaigns->setEcpmEnabled();
                $doCampaigns->update();
                $aCampaign['status_changed'] = ($doCampaigns->status != $oldStatus);
                $aCampaign['status'] = $doCampaigns->status;
                $aUpdatedCampaigns[$campaignId] = $aCampaign;
                $doCampaigns->free();
            }
        }
        return $aUpdatedCampaigns;
    }

    /**
     * A method to determine if a campaign is targeted - that is, if the
     * campaign as any child ads that have delivery limitations.
     *
     * @param integer $campaignId The campaign ID.
     * @return boolean True if the campaign is targeted, false otherwise.
     */
    public function isTargeted($campaignId)
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->campaignid = $campaignId;
        $doBanners->whereAdd("compiledlimitation NOT IN ('', 'true')");
        $doBanners->find();
        if ($doBanners->getRowCount() > 0) {
            // There are banners in the campaign with delivery limitations
            return true;
        }
        return false;
    }

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
    public function getAdImpressionsLeft($campaignId, $oDate = null)
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
                $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
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
    public function getAdClicksLeft($campaignId, $oDate = null)
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
                $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
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
    public function getAdConversionsLeft($campaignId, $oDate = null)
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
                $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
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
     *  - The eStimated expiration date based on lifetime impression delivery
     *    rate, if applicable.
     *  - The eStimated expiration date based on lifetime click delivery rate
     *    if applicable.
     *  - The eStimated expiration date based on lifetime conversion rate,
     *    if applicable.
     *
     * Usage:
     *   $desc = $dalCampaigns->getDaysLeftString($campaignid);
     *
     * Where:
     *   $desc is a string to display giving how the expiration was calculated
     *     eg. "Estimated expiration", or that there is no expiration date
     *
     * @param integer $campaignId The campaign ID.
     * @return string
     */
    public function getDaysLeftString($campaignId)
    {
        global $date_format, $strNoExpiration, $strDaysLeft, $strEstimated,
               $strExpirationDate, $strNoExpirationEstimation, $strDaysAgo,
               $strCampaignStop;

        $prefix = $this->getTablePrefix();

        // Define array to store possible expiration date results
        $aExpiration = [];

        // Get the campaign target info
        $now = OA::getNow('Y-m-d');
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->selectAdd("views AS impressions");
        $doCampaigns->get($campaignId);
        $aCampaignData = $doCampaigns->toArray();

        if (!empty($aCampaignData['expire_time'])) {
            $oNow = new Date($now);
            $oNow->setHour(0);
            $oNow->setMinute(0);
            $oNow->setSecond(0);

            $oDate = new Date($aCampaignData['expire_time']);
            $oDate->setTZbyID('UTC');
            $oDate->convertTZ($oNow->tz);
            $oDate->setHour(0);
            $oDate->setMinute(0);
            $oDate->setSecond(0);

            $oSpan = new Date_Span();
            $oSpan->setFromDateDiff($oNow, $oDate);

            $aCampaignData['expire_f'] = $oDate->format($date_format);
            $aCampaignData['days_left'] = $oSpan->toDays() * ($oDate->before($oNow) ? -1 : 1);
        }

        $oDbh = OA_DB::singleton();
        $tableB = $oDbh->quoteIdentifier($prefix . 'banners', true);
        $tableD = $oDbh->quoteIdentifier($prefix . 'data_intermediate_ad', true);

        // Define array to return the expiration dates (if they exist)
        $aReturn = [
                         'estimatedExpiration' => '',
                         'campaignExpiration' => ''
                         ];

        // Does the campaign have lifetime impression targets?
        // If yes, try to get a stimated expiration date
        if ($aCampaignData['impressions'] > 0) {
            $query = "
        	    SELECT
        	        SUM(dia.impressions) AS delivered,
        	        DATE_FORMAT(MIN(dia.date_time), '%Y-%m-%d') AS day_of_first
        	    FROM
        	        {$tableD} AS dia,
        	        {$tableB} AS b
        	    WHERE
        	        dia.ad_id = b.bannerid
        	        AND
        	        b.campaignid = " . DBC::makeLiteral($campaignId);
            $rsImpressions = DBC::FindRecord($query);
            if ($rsImpressions) {
                $aImpressions = $rsImpressions->toArray();
                // Get the number of days until the campaign will end
                // based on the impression target delivery data
                $aExpiration = $this->_calculateRemainingDays($aImpressions, $aCampaignData['impressions']);
            }
        }
        // Does the campaign have lifetime click targets?
        // If yes, try to get a stimated expiration date
        elseif ($aCampaignData['clicks'] > 0) {
            $query = "
        	    SELECT
        	        SUM(dia.clicks) AS delivered,
        	        DATE_FORMAT(MIN(dia.date_time), '%Y-%m-%d') AS day_of_first
        	    FROM
        	        {$tableD} AS dia,
        	        {$tableB} AS b
        	    WHERE
        	        dia.ad_id = b.bannerid
        	        AND
        	        b.campaignid = " . DBC::makeLiteral($campaignId);
            $rsClicks = DBC::FindRecord($query);
            if ($rsClicks) {
                $aClicks = $rsClicks->toArray();
                // Get the number of days until the campaign will end
                // based on the click target delivery data
                $aExpiration = $this->_calculateRemainingDays($aClicks, $aCampaignData['clicks']);
            }
        }
        // Does the campaign have lifetime conversion targets?
        // If yes, try to get a stimated expiration date
        elseif ($aCampaignData['conversions'] > 0) {
            $query = "
        	    SELECT
        	        SUM(dia.conversions) AS delivered,
        	        DATE_FORMAT(MIN(dia.date_time), '%Y-%m-%d') AS day_of_first
        	    FROM
        	        {$tableD} AS dia,
        	        {$tableB} AS b
        	    WHERE
        	        dia.ad_id = b.bannerid
        	        AND
        	        b.campaignid = " . DBC::makeLiteral($campaignId);
            $rsConversions = DBC::FindRecord($query);
            if ($rsConversions) {
                $aConversions = $rsConversions->toArray();
                // Get the number of days until the campaign will end
                // based on the conversion target delivery data
                $aExpiration = $this->_calculateRemainingDays($aConversions, $aCampaignData['conversions']);
            }
        }

        // flags to control if the campaign expiration date and
        // the estimated expiration date are going to be showed
        $existExpirationDate = false;
        $showEtimatedDate = false;

        // is there a expiration date?
        if (!empty($aCampaignData['expire_time'])) {
            $existExpirationDate = true;
        }

        if ($existExpirationDate) {
            // has the expiration date been reached?
            if ((int)$aCampaignData['days_left'] < 0) {
                $aReturn['campaignExpiration'] = $strCampaignStop . ": " .
                                                 $aCampaignData['expire_f'];
                $aReturn['campaignExpiration'] = $aReturn['campaignExpiration'] .
                                                 " (" . abs((int)round($aCampaignData['days_left'])) .
                                                 " $strDaysAgo)";
            } else {
                $aReturn['campaignExpiration'] = $strExpirationDate . ": " .
                                                 $aCampaignData['expire_f'];
                $aReturn['campaignExpiration'] = $aReturn['campaignExpiration'] .
                                                 " (" . $strDaysLeft . ": " .
                                                 round($aCampaignData['days_left']) . ")";
            }
        } else {
            $aReturn['campaignExpiration'] = $strNoExpiration;
        }

        // There is a estimated expiration date?
        // If yes, check if the campaign expiration date is set up and compare
        // both expiration dates to show only relevant estimated expiration dates
        if (!empty($aExpiration)) {
            if ($existExpirationDate == true) {
                if (round($aCampaignData['days_left']) >= 0) {
                    $campaignExpirationDate = new Date($aCampaignData['expire_time']);
                    $aExpiration['date']->hour = 0;
                    $aExpiration['date']->minute = 0;
                    $aExpiration['date']->second = 0;
                    $aExpiration['date']->partsecond = 0;
                    $compareDate = Date::compare($aExpiration['date'], $campaignExpirationDate);
                    // the estimated expiration date is previous or equal to the
                    // campaign expiration date and hasn't the expiration date been reached?
                    if (($compareDate <= 0) && ((int)$aCampaignData['days_left'] >= 0)) {
                        $showEtimatedDate = true;
                    }
                }
            } else {
                $showEtimatedDate = true;
            }
        } elseif (($existExpirationDate && round($aCampaignData['days_left']) >= 0) ||
                  (!$existExpirationDate)) {
            $aReturn['estimatedExpiration'] = $strEstimated . ": " .
                                              $strNoExpirationEstimation;
        }

        if ($showEtimatedDate) {
            $aExpiration['daysLeft'] = phpAds_formatNumber($aExpiration['daysLeft']);
            $aReturn['estimatedExpiration'] = $strEstimated . ": " .
                                              $aExpiration['date_f'] . " (" .
                                              $strDaysLeft . ": " .
                                              $aExpiration['daysLeft'] . ")";
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
         *               "date": the estimated date of expiration; and "date_f"
         */
    public function _calculateRemainingDays($aDeliveryData, $target)
    {
        global $date_format;
        $oNowDate = new Date();
        $aExpiration = [];
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
            $estimatedEndDateFormat = $oEstimatedEndDate->format($date_format);
            $aExpiration = [
                'daysLeft' => $daysLeft,
                'date_f' => $estimatedEndDateFormat,
                'date' => $oEstimatedEndDate
            ];
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
    public function getCampaignAndClientByKeyword($keyword, $agencyId = null, $aIncludeSystemTypes = [])
    {
        // always add default type
        $aIncludeSystemTypes = array_merge(
            [DataObjects_Campaigns::CAMPAIGN_TYPE_DEFAULT],
            $aIncludeSystemTypes
        );
        foreach ($aIncludeSystemTypes as $k => $v) {
            $aIncludeSystemTypes[$k] = DBC::makeLiteral((int)$v);
        }

        $whereCampaign = is_numeric($keyword) ? " OR m.campaignid=" . DBC::makeLiteral($keyword) : '';
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableM = $oDbh->quoteIdentifier($prefix . 'campaigns', true);
        $tableC = $oDbh->quoteIdentifier($prefix . 'clients', true);

        $query = "
        SELECT
            m.campaignid AS campaignid,
            m.campaignname AS campaignname,
            m.clientid AS clientid
        FROM
            {$tableM} AS m,
            {$tableC} AS c
        WHERE
            (
            m.clientid=c.clientid
            AND (m.campaignname LIKE " . DBC::makeLiteral('%' . $keyword . '%') . "
                $whereCampaign)
            AND m.type IN (" . implode(',', $aIncludeSystemTypes) . ")
            )
        ";

        if ($agencyId !== null) {
            $query .= " AND c.agencyid=" . DBC::makeLiteral($agencyId);
        }

        return DBC::NewRecordSet($query);
    }


    /**
     * Get list of campaigns for a given advertiser.
     *
     * @param int $clientid
     * @param string $listorder Column name to use for sorting
     * @param string $orderdirection soring direction 'up'/'down'
     * @param array $aIncludeSystemTypes an array of system types to be
     *              included apart from default campaigns
     * @return array associative array $campaignId => array of campaign details
     */
    public function getClientCampaigns($clientid, $listorder = null, $orderdirection = null, $aIncludeSystemTypes = [])
    {
        $aIncludeSystemTypes = array_merge(
            [DataObjects_Campaigns::CAMPAIGN_TYPE_DEFAULT],
            $aIncludeSystemTypes
        );

        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->clientid = $clientid;
        $doCampaigns->selectAs(['campaignid'], 'placement_id');
        $doCampaigns->selectAs(['campaignname'], 'name');
        $doCampaigns->whereInAdd('type', $aIncludeSystemTypes);
        $doCampaigns->orderBy('(type=' . DataObjects_Campaigns::CAMPAIGN_TYPE_DEFAULT . ') ASC');
        $doCampaigns->addListOrderBy($listorder, $orderdirection);

        $doCampaigns->find();

        $aCampaigns = [];
        while ($doCampaigns->fetch() && $row_campaigns = $doCampaigns->toArray()) {
            // mask campaign name if anonymous campaign
            $row_campaigns['campaignname'] = MAX_getPlacementName($row_campaigns);
            $row_campaigns['name'] = $row_campaigns['campaignname'];
            $aCampaigns[$row_campaigns['campaignid']] = $row_campaigns;
        }

        return $aCampaigns;
    }


    /**
     * @todo Consider removing order options (or making them optional)
     */
    public function getAllCampaigns($listorder, $orderdirection, $aIncludeSystemTypes = [])
    {
        $aIncludeSystemTypes = $this->_prepareIncludeSystemTypes($aIncludeSystemTypes);
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableM = $oDbh->quoteIdentifier($prefix . 'campaigns', true);

        $query = "
            SELECT
                campaignid,
                clientid,
                campaignname,
                status,
                priority AS priority,
                revenue AS revenue
            FROM
                {$tableM}
            WHERE
                type IN (" . implode(',', $aIncludeSystemTypes) . ") " .
            $this->getSqlListOrder('type+' . $listorder, $orderdirection) // sort by type first
        ;

        $rsCampaigns = DBC::NewRecordSet($query);
        $aCampaigns = $rsCampaigns->getAll(['campaignid', 'clientid', 'campaignname', 'status', 'priority', 'revenue']);
        $aCampaigns = $this->_rekeyCampaignsArray($aCampaigns);
        return $aCampaigns;
    }

    /**
     * @param int $agency_id
     * @return array    An array of arrays, representing a list of campaigns.
     *
     * @todo Consider removing order options (or making them optional)
     */
    public function getAllCampaignsUnderAgency($agency_id, $listorder, $orderdirection, $aIncludeSystemTypes = [])
    {
        $aIncludeSystemTypes = $this->_prepareIncludeSystemTypes($aIncludeSystemTypes);
        $prefix = $this->getTablePrefix();
        $oDbh = OA_DB::singleton();
        $tableM = $oDbh->quoteIdentifier($prefix . 'campaigns', true);
        $tableC = $oDbh->quoteIdentifier($prefix . 'clients', true);

        $query = "
            SELECT
                m.campaignid as campaignid,
                m.clientid as clientid,
                m.campaignname as campaignname,
                m.status as status,
                m.priority AS priority,
                revenue AS revenue
            FROM
                {$tableM} AS m,
                {$tableC} AS c
            WHERE
                c.clientid=m.clientid
                AND c.agencyid=" . DBC::makeLiteral($agency_id) . "
                AND m.type IN (" . implode(',', $aIncludeSystemTypes) . ") " .
            $this->getSqlListOrder('type+' . $listorder, $orderdirection) // sort by type first
        ;

        $rsCampaigns = DBC::NewRecordSet($query);
        $aCampaigns = $rsCampaigns->getAll(['campaignid', 'clientid', 'campaignname', 'status', 'priority', 'revenue']);
        $aCampaigns = $this->_rekeyCampaignsArray($aCampaigns);
        $aRetCampaigns = [];
        foreach ($aCampaigns as $campaignId => $aCampaign) {
            $aRetCampaigns[$campaignId]['status_changed'] = $aCampaign['status_changed'] ?? false;
            $aRetCampaigns[$campaignId]['status'] = $aCampaign['status'];
            $aRetCampaigns[$campaignId]['clientid'] = $aCampaign['clientid'];
            $aRetCampaigns[$campaignId]['campaignname'] = $aCampaign['campaignname'];
            $aRetCampaigns[$campaignId]['priority'] = $aCampaign['priority'];
        }
        return $aRetCampaigns;
    }


    public function countActiveCampaigns()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $tableM = $oDbh->quoteIdentifier($this->getTablePrefix() . 'campaigns', true);

        $query_active_campaigns = "SELECT count(*) AS count" .
            " FROM " . $tableM . " WHERE status=" . OA_ENTITY_STATUS_RUNNING;
        return $this->oDbh->queryOne($query_active_campaigns);
    }

    /**
     * @todo Verify that SQL is ANSI-compliant
     * @todo Consider reducing duplication with countCampaignsUnderAgency()
     * @todo Consider moving to Agency DAL
     */
    public function countActiveCampaignsUnderAgency($agency_id)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $tableM = $oDbh->quoteIdentifier($this->getTablePrefix() . 'campaigns', true);
        $tableC = $oDbh->quoteIdentifier($this->getTablePrefix() . 'clients', true);

        $query_active_campaigns = "SELECT count(*) AS count" .
            " FROM " . $tableM . " AS m" .
            "," . $tableC . " AS c" .
            " WHERE m.clientid=c.clientid" .
            " AND c.agencyid=" . DBC::makeLiteral($agency_id) .
            " AND m.status=" . OA_ENTITY_STATUS_RUNNING;
        return $this->oDbh->queryOne($query_active_campaigns);
    }

    /**
     * Converts a database result into an array keyed by campaign ID.
     * @param array $flat_campaign_data An flat array of campaign field arrays
     * @return array An array of arrays, representing a list of campaigns.
     */
    public function _rekeyCampaignsArray($flat_campaign_data)
    {
        $campaigns = [];
        foreach ($flat_campaign_data as $row_campaign) {
            $campaigns[$row_campaign['campaignid']] = $row_campaign;
            $campaigns[$row_campaign['campaignid']]['expand'] = false;
            unset($campaigns[$row_campaign['campaignid']]['campaignid']);
        }
        return $campaigns;
    }

    /**
     * A method to locate all "email" type zones that are linked
     * to a given campaign, via the campaign's children banners
     * (as campaigns cannot be linked to email zones directly).
     *
     * @param integer $campaignId The ID of the campaign.
     * @return mixed An array of "email" type zone IDs found linked
     *               to the given campaign, an empry array if no
     *               such zones were found, or an MDB2_Error object
     *               on any kind of database error.
     */
    public function getLinkedEmailZoneIds($campaignId)
    {
        // Test input
        if (!is_integer($campaignId) || $campaignId <= 0) {
            // Not a valid campaign ID, return no found zones
            $aResult = [];
            return $aResult;
        }
        // Prepare and execute query
        $prefix = $this->getTablePrefix();
        $sQuery = "
            SELECT
                {$prefix}zones.zoneid AS zone_id
            FROM
                {$prefix}banners,
                {$prefix}ad_zone_assoc,
                {$prefix}zones
            WHERE
                {$prefix}banners.campaignid = " . $this->oDbh->quote($campaignId, 'integer') . "
                AND
                {$prefix}banners.bannerid = {$prefix}ad_zone_assoc.ad_id
                AND
                {$prefix}ad_zone_assoc.zone_id = {$prefix}zones.zoneid
                AND
                {$prefix}zones.delivery = " . $this->oDbh->quote(MAX_ZoneEmail, 'integer') . "
            ORDER BY
                zone_id";
        RV::disableErrorHandling();
        $rsResult = $this->oDbh->query($sQuery);
        RV::enableErrorHandling();
        if (PEAR::isError($rsResult)) {
            return $rsResult;
        }
        $aResult = [];
        while ($aRow = $rsResult->fetchRow()) {
            $aResult[] = $aRow['zone_id'];
        }
        $rsResult->free();
        return $aResult;
    }


    /**
     * Prepare array of include system types for campaigns, include ADVERTISER_TYPE_DEFAULT
     * All values are prepared by DBC::makeLiteral
     *
     * @param array $aIncludeSystemTypes input array
     * @return array prepared array
     */
    private function _prepareIncludeSystemTypes($aIncludeSystemTypes)
    {
        $aIncludeSystemTypes = array_merge(
            [DataObjects_Campaigns::CAMPAIGN_TYPE_DEFAULT],
            $aIncludeSystemTypes
        );
        foreach ($aIncludeSystemTypes as $k => $v) {
            $aIncludeSystemTypes[$k] = DBC::makeLiteral((int)$v);
        }
        return $aIncludeSystemTypes;
    }
}
