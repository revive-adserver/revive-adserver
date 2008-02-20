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
 * The OA_Dll_AdvertiserInfo class extends the base OA_info class and
 * contains information about an advertiser.
 *
 */

class OA_Dll_AdvertiserInfo extends OA_Info
{

    /**
     * This required field provides the ID of the advertiser.
     *
     * @var integer $advertiserId
     */
    var $advertiserId;

    /**
     * This field contains the ID of the advertiser account.
     *
     * @var integer $accountId
     */
    var $accountId;

    /**
     * This option provides the ID of the agency to associate with the advertiser.
     *
     * @var integer $agencyId
     */
    var $agencyId;

    /**
     * This required field provides the name of the advertiser.
     *
     * @var string $advertiserName
     */
    var $advertiserName;

    /**
     * This option provides the name of the contact for the advertiser.
     *
     * @var string $contactName
     */
    var $contactName;

    /**
     * This field provides the email address of the contact.
     *
     * @var string $emailAddress
     */
    var $emailAddress;

    /**
     * This method sets all default values when adding a new advertiser.
     *
     */
    function setDefaultForAdd() {
        if (empty($this->agencyId)) {
            $this->agencyId = OA_Permission::getAgencyId();
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
                    'advertiserId' => 'integer',
                    'accountId' => 'integer',
                    'agencyId' => 'integer',
                    'advertiserName' => 'string',
                    'contactName' => 'string',
                    'emailAddress' => 'string'
                );
    }
}

?>