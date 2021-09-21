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

// Require Channel Service Implementation
require_once MAX_PATH . '/www/api/v2/xmlrpc/ChannelServiceImpl.php';

/**
 * Base Channel Service
 *
 */
class BaseChannelService
{
    /**
     * Reference to channel Service implementation.
     *
     * @var ChannelServiceImpl $_oChannelServiceImp
     */
    public $_oChannelServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    public function __construct()
    {
        $this->_oChannelServiceImp = new ChannelServiceImpl();
    }
}
