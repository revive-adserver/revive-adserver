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

// Require Advertiser Service Implementation
require_once MAX_PATH . '/www/api/v1/xmlrpc/AdvertiserServiceImpl.php';

/**
 * Base Advertiser Service
 *
 */
class BaseAdvertiserService
{
    /**
     * Reference to advertiser Service implementation.
     *
     * @var AdvertiserServiceImpl $_oAdvertiserServiceImp
     */
    public $_oAdvertiserServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    public function __construct()
    {
        $this->_oAdvertiserServiceImp = new AdvertiserServiceImpl();
    }
}
