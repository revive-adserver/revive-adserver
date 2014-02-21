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

require_once RV_PATH . '/lib/pear/PEAR.php';

/**
 * The core Revive Adserver class, providing methods that are useful everywhere!
 *
 * @package    ReviveAdserver
 */
class RV
{

    /**
     * A method to get the Revive Adserver configuration file details.
     *
     * @static
     * @return array
     */
    static function getAppConfig() {
        return $GLOBALS['_MAX']['CONF'];
    }

}

?>