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

// Require Banner Service Implementation
require_once MAX_PATH . '/www/api/v2/xmlrpc/BannerServiceImpl.php';

/**
 * Base Banner Service
 *
 */
class BaseBannerService
{
    /**
     * Reference to banner Service implementation.
     *
     * @var BannerServiceImpl $_oBannerServiceImp
     */
    var $_oBannerServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    function __construct()
    {
        $this->_oBannerServiceImp = new BannerServiceImpl();
    }
}

?>