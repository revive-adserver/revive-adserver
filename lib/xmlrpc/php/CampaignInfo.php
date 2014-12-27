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
 *
 * This file describes the CampaignInfo class.
 */

// Require the base info class.
require_once 'Info.php';

/**
 *  The campaignInfo class extends the base Info class and contains information about the campaign.
 *
 */

class OA_Dll_CampaignInfo extends OA_Info
{
    /**
     * The campaignId variable is the unique ID for the campaign.
     *
     * @var integer $campaignId
     */
    var $campaignId;

    /**
     * The advertiserID variable is the ID of the advertiser associated with the campaign.
     *
     * @var integer $advertiserId
     */
    var $advertiserId;

    /**
     * The campaignName variable is the name of the campaign.
     *
     * @var string $campaignName
     */
    var $campaignName;

    /**
     * The startDate variable is the date the campaign will start.
     *
     * @var date $startDate
     */
    var $startDate;

    /**
     * The endDate variable is the date the campaign will end.
     *
     * @var date $endDate
     */
    var $endDate;

    /**
     * The impressions variable is the number of impressions booked for the campaign.
     *
     * @var integer $impressions
     */
    var $impressions;

    /**
     * The clicks variable is the number of clicks booked for the campaign.
     *
     * @var integer $clicks
     */
    var $clicks;

    /**
     * The priority variable is the priority level set for the campaign.
     *
     * @var integer $priority
     */
    var $priority;

    /**
     * The weight variable is the weight set for the campaign.
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

    /**
     * This function sets all default values when adding new campaign.
     *
     */
    function setDefaultForAdd() {
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
                );
    }
}

?>
