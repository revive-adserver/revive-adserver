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
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
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
    var $_oAdvertiserServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    function BaseAdvertiserService()
    {
        $this->_oAdvertiserServiceImp = new AdvertiserServiceImpl();
    }
}

?>