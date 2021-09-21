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

// Require Zone Service Implementation
require_once MAX_PATH . '/www/api/v1/xmlrpc/ZoneServiceImpl.php';

/**
 * Base Zone Service
 *
 */
class BaseZoneService
{
    /**
     * Reference to zone Service implementation.
     *
     * @var ZoneServiceImpl $_oZoneServiceImp
     */
    public $_oZoneServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    public function __construct()
    {
        $this->_oZoneServiceImp = new ZoneServiceImpl();
    }
}
