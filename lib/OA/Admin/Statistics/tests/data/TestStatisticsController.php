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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Common.php';

class OA_Admin_Statistics_Test extends OA_Admin_Statistics_Common
{

    var $aPlugins;

    function __construct($aParams)
    {
        $this->aPlugins = array();
        parent::__construct($aParams);
    }

    function _loadPlugins()
    {
    }

    function _checkStatsAccuracy()
    {
    }

}
?>