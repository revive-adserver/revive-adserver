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

require_once MAX_PATH . '/lib/OA/Permission.php';

/**
 * Reporting scope for Openads
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
        $this->_publisherId = OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER) ? OA_Permission::getEntityId() : false;
        $this->_advertiserId = OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) ? OA_Permission::getEntityId() : false;
        $this->_agencyId = OA_Permission::isAccount(OA_ACCOUNT_ADMIN) ? false : OA_Permission::getAgencyId();
    }
    function getPublisherId()
    {
        return $this->_publisherId;
    }
    function setPublisherId($publisherId)
    {
        if (is_numeric($publisherId) && !OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $this->_publisherId = $publisherId;
        }
    }
    function getAdvertiserId()
    {
        return $this->_advertiserId;
    }
    function setAdvertiserId($advertiserId)
    {
        if (is_numeric($advertiserId) && !OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            $this->_advertiserId = $advertiserId;
        }
    }
    function getAgencyId()
    {
        return $this->_agencyId;
    }
    function setAgencyId($agencyId)
    {
        if (is_numeric($agencyId) && OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
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
