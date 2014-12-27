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

/**
 * @package    OpenXDll
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
     * This field provides any additional comments to be stored.
     *
     * @var string $comments
     */
    var $comments;

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
                    'emailAddress' => 'string',
                    'comments' => 'string',
                );
    }
}

?>