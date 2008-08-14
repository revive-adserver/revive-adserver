<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

/**
 * @package    OpenXDll
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
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
                    'weight' => 'integer'
                );
    }
}

?>