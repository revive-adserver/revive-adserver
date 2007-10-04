<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
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
$Id:$
*/

/**
 * @package    OpenadsDll
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */

// Include base info class.
require_once MAX_PATH . '/lib/OA/Info.php';

/**
 *  Class with information about zone
 *
 */

class OA_Dll_ZoneInfo extends OA_Info
{


    /**
     * The ID of the zone to modify.
     *
     * @var integer $zoneId
     */
	var $zoneId;

    /**
     * The ID of the publisher to which to add the zone.
     *
     * @var integer $publisherId
     */
	var $publisherId;

    /**
     * The name of the zone.
     *
     * @var string $zoneName
     */
	var $zoneName;

    /**
     * The type of the zone (banner, interstitial, popup, text, email).
     *
     * @var integer $type
     */
	var $type;

    /**
     * The width of the zone.
     *
     * @var integer $width
     */
	var $width;

    /**
     * The width of the zone.
     *
     * @var integer $height
     */
    var $height;


	/**
	 * Setting all default values. Used in adding new zone.
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
	}

	/**
	 * This method returns array of fields with their corresponding types.
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
                    'height' => 'integer'
                );
    }
}

?>