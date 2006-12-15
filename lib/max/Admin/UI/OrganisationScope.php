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
$Id$
*/

require_once MAX_PATH . '/www/admin/lib-permissions.inc.php';

/**
 * Reporting scope for Max Media Manager
 *
 * Describes whether a report should be for a specific publisher,
 * a specific advertiser or 'everyone'.
 */
class Admin_UI_OrganisationScope
{
    /* @var int */
    var $_publisherId;
    /* @var int */
    var $_advertiserId;
    /* @var int */
    var $_agencyId;
    /* @var boolean */
    var $_anonymous;

    /**
     * PHP4 constructor
     */
    function Admin_UI_OrganisationScope()
    {
        $this->_publisherId = phpAds_isUser(phpAds_Affiliate) ? phpAds_getUserID() : false;
        $this->_advertiserId = phpAds_isUser(phpAds_Client) ? phpAds_getUserID() : false;
        $this->_agencyId = phpAds_isUser(phpAds_Admin) ? false : phpAds_getAgencyID();
    }
    function getPublisherId()
    {
        return $this->_publisherId;
    }
    function setPublisherId($publisherId)
    {
        if (is_numeric($publisherId) && !phpAds_isUser(phpAds_Affiliate)) {
            $this->_publisherId = $publisherId;
        }
    }
    function getAdvertiserId()
    {
        return $this->_advertiserId;
    }
    function setAdvertiserId($advertiserId)
    {
        if (is_numeric($advertiserId) && !phpAds_isUser(phpAds_Client)) {
            $this->_advertiserId = $advertiserId;
        }
    }
    function getAgencyId()
    {
        return $this->_agencyId;
    }
    function setAgencyId($agencyId)
    {
        if (is_numeric($agencyId) && phpAds_isUser(phpAds_Admin)) {
            $this->_agencyId = $agencyId;
        }
    }
    function getAnonymous()
    {
        return $this->_anonymous;
    }
    function setAnonymous($anonymous)
    {
        $this->_anonymous = $anonymous;
    }
}

?>
