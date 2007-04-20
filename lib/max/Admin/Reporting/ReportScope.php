<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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
$Id$
*/

/**
 * Reporting scope for Openads
 *
 * Describes whether a report should be for a specific publisher,
 * a specific advertiser or 'everyone'.
 */
class ReportScope
{
    /* @var int */
    var $_publisher_id;

    /* @var int */
    var $_advertiser_id;

    /* @var int */
    var $_agency_id;

    /* @var string */
    var $description;

    /**
     * PHP4 constructor
     */
    function ReportScope()
    {
        $this->useAllAvailableData();
    }

    function getPublisherId()
    {
        return $this->_publisher_id;
    }

    function getAdvertiserId()
    {
        return $this->_advertiser_id;
    }

    function getAgencyId()
    {
        return $this->_agency_id;
    }

    function useAllAvailableData()
    {
        $this->_publisher_id = false;
        $this->_advertiser_id = false;
        $this->_agency_id = false;
        $this->description = 'all available advertisers and publishers';
    }

    function usePublisherId($id)
    {
        $this->_publisher_id = $id;
        $this->_advertiser_id = false;
        $this->description = "publisher $id";
    }

    function useAdvertiserId($id)
    {
        $this->_advertiser_id = $id;
        $this->_publisher_id = false;
        $this->description = "advertiser $id";
    }

    function useAgencyId($id)
    {
        $this->_agency_id = $id;
    }

    function hasNoRestrictions()
    {
        if ($this->_publisher_id) {
            return false;
        }
        if ($this->_advertiser_id) {
            return false;
        }
        return true;
    }

    function useValuesFromQueryArray($values, $base_key)
    {
        $specifier_key = $base_key . '_entity';
        $publisher_key = $base_key . '_publisher';
        $advertiser_key = $base_key . '_advertiser';

        $scope_specifier = $values[$specifier_key];

        if ($scope_specifier == 'publisher') {
            $publisher_id = $values[$publisher_key];
            $this->usePublisherId($publisher_id);
        } elseif ($scope_specifier == 'advertiser') {
            $advertiser_id = $values[$advertiser_key];
            $this->useAdvertiserId($advertiser_id);
        } elseif ($scope_specifier == 'all') {
            $this->useAllAvailableData();
        }else {
            trigger_error("Max was asked to limit scope for something to an enity that it didn't recognize.");
        }
    }
}

?>
