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
 * @package    OpenX
 */

// Require User Service Implementation
require_once MAX_PATH . '/www/api/v1/xmlrpc/UserServiceImpl.php';

/**
 * Base User Service
 */
class BaseUserService
{
    /**
     * Reference to User Service implementation.
     *
     * @var UserServiceImpl $_oUserServiceImp
     */
    public $_oUserServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    public function __construct()
    {
        $this->_oUserServiceImp = new UserServiceImpl();
    }
}
