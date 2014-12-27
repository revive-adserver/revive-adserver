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
 * This file describes the ChannelInfo class.
 */

// Require the base info class.
require_once 'Info.php';

/**
 *  The channelInfo class extends the base Info class and contains information about the channel.
 *
 */

class OA_Dll_ChannelInfo extends OA_Info
{

    /**
     * The channelID variable is the unique ID for the channel.
     *
     * @var integer $channelId
     */
    var $channelId;

    /**
     * This field contains the ID of the agency account.
     *
     * @var integer $agencyId
     */
    var $agencyId;

    /**
     * This field contains the ID of the publisher.
     *
     * @var integer $websiteId
     */
    var $websiteId;

    /**
     * The channelName variable is the name of the channel.
     *
     * @var string $channelName
     */
    var $channelName;

    /**
     * The description variable is the description for the channel.
     *
     * @var string $description
     */
    var $description;

    /**
     * The comments variable is the comment for the channel.
     *
     * @var string $comments
     */
    var $comments;

    /**
     * This method sets all default values when adding a new channel.
     *
     */

    function getFieldsTypes()
    {
        return array(
            'channelId' => 'integer',
            'agencyId' => 'integer',
            'websiteId' => 'integer',
            'channelName' => 'string',
            'description' => 'string',
            'comments' => 'string',
        );
    }
}
