<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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
$Id:$
*/

/**
 * @package    OpenXDll
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 * This file describes the CampaignInfo class.
 *
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
     * This function sets all default values when adding new campaign.
     *
     */
    function setDefaultForAdd() {
        if (is_null($this->startDate)) {
            $this->startDate = new Date(OA_Dal::noDateValue());
        }

        if (is_null($this->endDate)) {
            $this->endDate = new Date(OA_Dal::noDateValue());
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