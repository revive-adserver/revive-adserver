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
    function __construct()
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
