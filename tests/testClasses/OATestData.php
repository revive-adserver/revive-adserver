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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';

/**
 *
 * @abstract A base class for generating OpenX test data using DataObjects
 * @package Test Classes
 * @todo more _insert methods
 */
class OA_Test_Data
{
    public $oDbh;
    public $oNow;
    public $aIds = [
                        'agency' => [],
                        'clients' => [],
                        'affiliates' => [],
                        'campaigns' => [],
                        'banners' => [],
                        'zones' => [],
                        'ad_zone_assoc' => [],
                        'acls' => [],
                        'acls_channel' => [],
                        'campaigns_trackers' => [],
                        'channel' => [],
                        'trackers' => [],
                        'variables' => []
                      ];
    /**
     * The constructor method.
     */
    public function __construct() {}

    public function init()
    {
        $this->oDbh = OA_DB::singleton();
        if (PEAR::isError($this->oDbh)) {
            return false;
        }
        $this->oNow = new Date();
        return true;
    }

    /**
     *
     * @access private
     */
    public function generateTestData()
    {
        return false;
    }
}
