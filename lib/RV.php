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

    /**
     * A method to strip unwanted ending tags from a Revive Adsaerver version
     * string.
     *
     * @static
     * @param string $version The original version string.
     * @param array  $aAllow  An array of allowed tags
     * @return string The stripped version string.
     */
    static function stripVersion($version, $aAllow = null)
    {
        $allow = is_null($aAllow) ? '' : '|'.join('|', $aAllow);
        return preg_replace('/^v?(\d+.\d+.\d+(?:-(?:beta(?:-rc\d+)?|rc\d+'.$allow.'))?).*$/i', '$1', $version);
    }

}

?>