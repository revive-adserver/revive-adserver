<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id:$
*/

/**
 * @package    OpenXDll
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 * This file describes the PublisherInfo class.
 *
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
                    'comments' => 'string',
                );
    }
}

?>