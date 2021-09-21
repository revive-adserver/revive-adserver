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

// Require Campaign Service Implementation
require_once MAX_PATH . '/www/api/v1/xmlrpc/CampaignServiceImpl.php';

/**
 * Base Campaign Service
 *
 */
class BaseCampaignService
{
    /**
     * Reference to campaign Service implementation.
     *
     * @var CampaignServiceImpl $_oCampaignServiceImp
     */
    public $_oCampaignServiceImp;

    /**
     * This method initialises Service implementation object field.
     *
     */
    public function __construct()
    {
        $this->_oCampaignServiceImp = new CampaignServiceImpl();
    }
}
