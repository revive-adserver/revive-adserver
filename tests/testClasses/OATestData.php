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
    var $oDbh;
    var $oNow;
    var $aIds = array(
                        'agency'=>array(),
                        'clients'=>array(),
                        'affiliates'=>array(),
                        'campaigns'=>array(),
                        'banners'=>array(),
                        'zones'=>array(),
                        'ad_zone_assoc'=>array(),
                        'acls'=>array(),
                        'acls_channel'=>array(),
                        'campaigns_trackers'=>array(),
                        'channel'=>array(),
                        'trackers'=>array(),
                        'variables'=>array()
                      );
    /**
     * The constructor method.
     */
    function __construct()
    {
    }

    function init()
    {
        $this->oDbh = OA_DB::singleton();
        if (PEAR::isError($this->oDbh))
        {
            return false;
        }
        $this->oNow = new Date();
        return true;
    }

    /**
     *
     * @access private
     */
    function generateTestData()
    {
        return false;
    }

}

?>
