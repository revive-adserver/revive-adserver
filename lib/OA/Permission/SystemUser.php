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

require_once MAX_PATH . '/lib/OA/Permission/User.php';

/**
 * A class for managing users.
 *
 * @package    OpenXPermission
 */
class OA_Permission_SystemUser extends OA_Permission_User
{
    /**
     * Class constructor
     *
     * @return OA_Permission_User
     */
    public function __construct($userName)
    {
        // Store user information as array
        $this->aUser = [
            'user_id' => 0,
            'username' => $userName,
        ];

        // Make sure we start with an empty account
        $this->_clearAccountData();
    }
}
