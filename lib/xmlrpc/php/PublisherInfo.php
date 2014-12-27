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
 * This file describes the PublisherInfo class.
 */

// Require the base Info class.
require_once 'Info.php';

/**
 *  The PublisherInfo class extends the base Info class and contains information about the publisher.
 *
 */

class OA_Dll_PublisherInfo extends OA_Info
{

    /**
     * The publisherId variable is the unique ID for the publisher.
     *
     * @var integer $publisherId
     */
    var $publisherId;

    /**
     * This field contains the ID of the agency account.
     *
     * @var integer $accountId
     */
    var $accountId;

    /**
     * The agencyID variable is the ID of the agency associated with the publisher.
     *
     * @var integer $agencyId
     */
    var $agencyId;

    /**
     * The publisherName variable is the name of the publisher.
     *
     * @var string $publisherName
     */
    var $publisherName;

    /**
     * The contactName variable is the name of the contact for the publisher.
     *
     * @var string $contactName
     */
    var $contactName;

    /**
     * The emailAddress variable is the email address for the contact.
     *
     * @var string $emailAddress
     */
    var $emailAddress;

    /**
     * The website variable is the website address of the publisher.
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