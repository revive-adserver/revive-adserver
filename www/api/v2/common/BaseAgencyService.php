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

// Require Agency Service Implementation
require_once MAX_PATH . '/www/api/v2/xmlrpc/AgencyServiceImpl.php';

/**
 * Base Agency Service
 *
 */
class BaseAgencyService
{
    /**
     * Reference to agency Service implementation.
     *
     * @var AgencyServiceImpl $_oAgencyServiceImp
     */
    public $_oAgencyServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    public function __construct()
    {
        $this->_oAgencyServiceImp = new AgencyServiceImpl();
    }
}
