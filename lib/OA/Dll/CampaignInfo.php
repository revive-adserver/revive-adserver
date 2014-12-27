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

/**
 * @package    OpenXDll
 */

// Require the base Info class.
require_once MAX_PATH . '/lib/OA/Info.php';

/**
 * The OA_Dll_CampaignInfo class extends the base OA_Info class and contains
 * information about the campaign.
 *
 */

class OA_Dll_CampaignInfo extends OA_Info
{
    /**
     * This field provides the ID of the campaign.
     *
     * @var integer $campaignId
     */
    var $campaignId;

    /**
     * This field provides the ID of the advertiser to associate with the campaign.
     *
     * @var integer $advertiserId
     */
    var $advertiserId;

    /**
     * This field provides the name of the campaign.
     *
     * @var string $campaignName
     */
    var $campaignName;

    /**
     * This field provides the date to start the campaign.
     *
     * @var date $startDate
     */
    var $startDate;

    /**
     * This field provides the date to end the campaign.
     *
     * @var date $endDate
     */
    var $endDate;

    /**
     * This field provides the number of impressions booked for the campaign.
     *
     * @var integer $impressions
     */
    var $impressions;

    /**
     * This field provides the number of clicks booked for the campaign.
     *
     * @var integer $clicks
     */
    var $clicks;

    /**
     * This field provides the priority level for the campaign.
     *
     * @var integer $priority
     */
    var $priority;

    /**
     * This field provides the priority weight of this campaign.
     *
     * @var integer $weight
     */
    var $weight;

    /**
     *
     * @var integer $targetImpressions
     */
    var $targetImpressions;

    /**
     *
     * @var integer $targetClick
     */
    var $targetClicks;

    /**
     *
     * @var integer $targetConversions
     */
    var $targetConversions;

    /**
     * Revenue amount, eg 1.55.
     *
     * @var double $revenue
     */
    var $revenue;

    /**
     * Revenue type (CPM, CPA, etc) as defined in constants.php.
     * Eg, define('MAX_FINANCE_CPM',    1);
     *
     * @var integer $revenueType
     */
    var $revenueType;

    /**
     * Frequency capping: total views per user.
     *
     * @var integer $capping
     */
    var $capping;

    /**
     * Frequency capping: total views per period.
     * (defined in seconds by "block").
     *
     * @var integer $sessionCapping
     */
    var $sessionCapping;

    /**
     * Frequency capping: reset period, in seconds.
     *
     * @var integer $block
     */
    var $block;

    /**
     * This field provides any additional comments to be stored.
     *
     * @var string $comments
     */
    var $comments;

    var $viewWindow;
    var $clickWindow;

    /**
     * This method sets all default values when adding a new campaign.
     *
     * @access public
     *
     */
    function setDefaultForAdd() {
        // Default to 'no date'
        if (is_null($this->startDate)) {
            // It's ok to be NULL.  Don't worry about it.
        }

        // Default to 'no date'
        if (is_null($this->endDate)) {
            // Nothing to see here...
        }

        if (is_null($this->impressions)) {
            $this->impressions = -1;
        }

        if (is_null($this->clicks)) {
            $this->clicks = -1;
        }

        if (is_null($this->priority)) {
            $this->priority = 0;
        }

        if (is_null($this->weight)) {
            $this->weight = 1;
        }

        if (is_null($this->targetImpressions)) {
            $this->targetImpressions = 0;
        }

        if (is_null($this->targetClicks)) {
            $this->targetClicks = 0;
        }

        if (is_null($this->targetConversions)) {
            $this->targetConversions = 0;
        }

        if (is_null($this->revenue)) {
            // Leave null
        }

        if (is_null($this->revenueType)) {
            // Leave null
        }

        if (is_null($this->capping)) {
            // Leave null
        }

        if (is_null($this->sessionCapping)) {
            // Leave null
        }

        if (is_null($this->block)) {
            // Leave null
        }

         if (empty($this->viewWindow)) {
            $this->viewWindow = 0;
        }

        if (empty($this->clickWindow)) {
            $this->clickWindow = 0;
        }
    }

    /**
     * This method returns an array of fields with their corresponding types.
     *
     * @access public
     *
     * @return array
     */
    function getFieldsTypes()
    {
        return array(
                    'campaignId' => 'integer',
                    'advertiserId' => 'integer',
                    'campaignName' => 'string',
                    'startDate' => 'date',
                    'endDate' => 'date',
                    'impressions' => 'integer',
                    'clicks' => 'integer',
                    'priority' => 'integer',
                    'weight' => 'integer',
                    'targetImpressions' => 'integer',
                    'targetClicks' => 'integer',
                    'targetConversions' => 'integer',
                    'revenue' => 'double',
                    'revenueType' => 'integer',
                    'capping' => 'integer',
                    'sessionCapping' => 'integer',
                    'block' => 'integer',
                    'comments' => 'string',
                    'viewWindow' => 'integer',
                    'clickWindow' => 'integer'
                );
    }
}

?>