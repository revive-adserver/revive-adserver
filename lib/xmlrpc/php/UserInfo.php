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
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 */

// Require the base Info class.
require_once 'Info.php';

/**
 * The OA_Dll_UserInfo class extends the base OA_Info class and
 * contains information about the user.
 *
 */

class OA_Dll_UserInfo extends OA_Info
{
    /**
     * This fields provides the ID of the user
     *
     * @var int
     */
    var $userId;

    /**
     * This option provides the name of the contact for the user.
     *
     * @var string $contactName
     */
    var $contactName;

    /**
     * This field provides the email address of the user.
     *
     * @var string $emailAddress
     */
    var $emailAddress;

    /**
     * This option provides the username of the user.
     *
     * @var string $username
     */
    var $username;

    /**
     * This field provides the password of the user.
     *
     * @var string $password
     */
    var $password;

    /**
     * This field provides the default account ID of the user.
     *
     * @var int $defaultAccountId
     */
    var $defaultAccountId;

    /**
     * This field provides the status of the user.
     *
     * @var int $active
     */
    var $active;

    function getFieldsTypes()
    {
        return array(
                    'userId' => 'integer',
                    'contactName' => 'string',
                    'emailAddress' => 'string',
                    'username' => 'string',
                    'password' => 'string',
                    'defaultAccountId' => 'integer',
                    'active' => 'integer',
                );
    }
}

?>