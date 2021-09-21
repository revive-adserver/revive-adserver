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

require_once MAX_PATH . '/www/api/v2/xmlrpc/TrackerServiceImpl.php';

class BaseTrackerService
{
    protected $oTrackerServiceImpl;

    public function __construct()
    {
        $this->oTrackerServiceImpl = new TrackerServiceImpl();
    }
}
