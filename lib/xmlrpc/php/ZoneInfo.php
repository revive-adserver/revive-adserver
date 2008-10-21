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
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 * This files describes the ZoneInfo class.
 *
 */

// Include base info class.
require_once 'Info.php';

/**
 *  The ZoneInfo class extends the base Info class and contains information about the zone.
 *
 */

class OA_Dll_ZoneInfo extends OA_Info
{


    /**
     * The zoneId variable is the unique ID for the zone.
     *
     * @var integer $zoneId
     */
    var $zoneId;

    /**
     * The publisherID is the ID of the publisher associated with the zone.
     *
     * @var integer $publisherId
     */
    var $publisherId;

    /**
     * The zoneName is the name of the zone.
     *
     * @var string $zoneName
     */
    var $zoneName;

    /**
     * The type variable type of zone, one of the following: banner, interstitial, popup, text, email.
     *
     * @var integer $type
     */
    var $type;

    /**
     * The width variable is the width of the zone.
     *
     * @var integer $width
     */
    var $width;

    /**
     * The height variable is the height of the zone.
     *
     * @var integer $height
     */
    var $height;

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
     * This method sets all default values when adding a new zone.
     *
     * @access public
     *
     */
    function setDefaultForAdd() {
        if (is_null($this->type)) {
            $this->type = 0;
        }

        if (is_null($this->width)) {
            $this->width = 0;
        }

        if (is_null($this->height)) {
            $this->height = 0;
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
                    'zoneId' => 'integer',
                    'publisherId' => 'integer',
                    'zoneName' => 'string',
                    'type' => 'integer',
                    'width' => 'integer',
                    'height' => 'integer',
                    'capping' => 'integer',
                    'sessionCapping' => 'integer',
                    'block' => 'integer',
                );
    }
}

?>
