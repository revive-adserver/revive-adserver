<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: ZoneScope.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

/**
 * Zone selection scope for Max Media Manager
 *
 * A ZoneScope object represents either all available zones or
 * one specific zone.
 *
 * This is useful for reports, where a user may want to
 * report on everything or narrow it down to one zone.
 */
class ZoneScope
{
    /* @var bool */
    var $_is_zone_specified;

    /* @var int */
    var $_zone_id;

    /**
     * Does this scope refer to just one zone?
     *
     * @return bool False if this scope refers to all zones
     */
    function isSpecificZone()
    {
        return $this->_is_zone_specified;
    }

    /**
     * The numeric zone identifier that this scope refers to.
     *
     * @return int The specific zone ID.
     */
    function getZoneId()
    {
        if ($this->_is_zone_specified) {
            return $this->_zone_id;
        }
        trigger_error('Programmer failure: Max was asked to provide a single zone ID to represent all zones.');
    }

    function useZoneId($zone_id)
    {
        $this->_is_zone_specified = true;
        $this->_zone_id = $zone_id;
    }

    function useAllZones()
    {
        $this->_is_zone_specified = false;
    }
}

?>
