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

// Require the XMLRPC classes
require_once MAX_PATH . '/www/api/v2/xmlrpc/LogonServiceImpl.php';


/**
 * Base Logon Service
 *
 */
class BaseLogonService
{
    /**
     * Reference to logon Service implementation.
     *
     * @var LogonServiceImpl $logonServiceImp
     */
    public $logonServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    public function __construct()
    {
        $this->logonServiceImp = new LogonServiceImpl();
    }
}
