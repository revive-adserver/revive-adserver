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
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */

// Require the base Info class.
require_once MAX_PATH . '/lib/OA/Info.php';

/**
 * The OA_Dll_PublisherInfo class extends the base OA_Info class and contains
 * information about publisher
 *
 */

class OA_Dll_PublisherInfo extends OA_Info
{

    /**
     * This field provides the ID of the publisher.
     *
     * @var integer $publisherId
     */
    var $publisherId;

    /**
     * This field contains the ID of the publisher account.
     *
     * @var integer $accountId
     */
    var $accountId;

    /**
     * This field provides the ID of the agency associated with the publisher.
     *
     * @var integer $agencyId
     */
    var $agencyId;

    /**
     * This field provides the name of the publisher.
     *
     * @var string $publisherName
     */
    var $publisherName;

    /**
     * This field provides the name of the contact for the publisher.
     *
     * @var string $contactName
     */
    var $contactName;

    /**
     * This field provides the email address of the contact for the publisher.
     *
     * @var string $emailAddress
     */
    var $emailAddress;

    /**
     * This field provides the website address of the publisher.
     *
     * @var string $website
     */
    var $website;

    /**
     * This field provides any additional comments to be stored.
     *
     * @var string $comments
     */
    var $comments;

    /**
     * This method sets all default values when adding a new publisher.
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
                    'publisherId' => 'integer',
                    'accountId' => 'integer',
                    'agencyId' => 'integer',
                    'publisherName' => 'string',
                    'contactName' => 'string',
                    'emailAddress' => 'string',
                    'website' => 'string',
                    'comments' => 'string',
                );
    }
}

?>