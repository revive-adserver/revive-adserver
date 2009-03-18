<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
 * @author     Heiko Weber <heiko@wecos.de>
 *
 * This file describes the ChannelInfo class.
 *
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
