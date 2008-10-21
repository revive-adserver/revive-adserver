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
$Id$
*/

/**
 * @package    OpenXDll
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */

// Require the base Info class.
require_once MAX_PATH . '/lib/OA/Info.php';

/**
 * The OA_Dll_ZoneInfo class extends the base OA_Info class and
 * contains information about the zone.
 *
 */

class OA_Dll_ZoneInfo extends OA_Info
{


    /**
     * This field provides the ID of the zone.
     *
     * @var integer $zoneId
     */
    var $zoneId;

    /**
     * This field provides the ID of the publisher associated with the zone.
     *
     * @var integer $publisherId
     */
    var $publisherId;

    /**
     * This field provides the name of the zone.
     *
     * @var string $zoneName
     */
    var $zoneName;

    /**
     * This field provides the type of the zone (banner, interstitial, popup, text, email).
     *
     * @var integer $type
     */
    var $type;

    /**
     * This field provides the width of the zone.
     *
     * @var integer $width
     */
    var $width;

    /**
     * This field provides the height of the zone.
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