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
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */

// Require Publisher Service Implementation
require_once MAX_PATH . '/www/api/v2/xmlrpc/PublisherServiceImpl.php';

/**
 * Base Publisher Service
 *
 */
class BasePublisherService
{
    /**
     * Reference to Publisher Service implementation.
     *
     * @var PublisherServiceImpl $_oPublisherServiceImp
     */
    var $_oPublisherServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    function BasePublisherService()
    {
        $this->_oPublisherServiceImp = new PublisherServiceImpl();
    }
}

?>