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
     * A method to temporarily disable PEAR error handling by
     * pushing a null error handler onto the top of the stack.
     */
    public static function disableErrorHandling()
    {
        PEAR::pushErrorHandling(null);
    }

    /**
     * A method to re-enable PEAR error handling by popping
     * a null error handler off the top of the stack.
     *
     * @static
     */
    public static function enableErrorHandling()
    {
        // Ensure this method only acts when a null error handler exists
        $stack = &$GLOBALS['_PEAR_error_handler_stack'];
        list($mode, $options) = $stack[count($stack) - 1];
        if (is_null($mode) && is_null($options)) {
            PEAR::popErrorHandling();
        }
    }

    /**
     * A method to get the Revive Adserver configuration file details.
     *
     * @static
     * @return array
     */
    public static function getAppConfig()
    {
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
    public static function stripVersion($version, $aAllow = null)
    {
        $allow = is_null($aAllow) ? '' : '|' . implode('|', $aAllow);
        return preg_replace('/^v?(\d+.\d+.\d+(?:-(?:beta(?:-rc\d+)?|rc\d+' . $allow . '))?).*$/i', '$1', $version);
    }

    /**
     * UTF-8 strlen, using the best available extension.
     *
     */
    public static function strlen(string $value): int
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($value, 'UTF-8');
        }

        if (function_exists('iconv_strlen')) {
            return iconv_strlen($value, 'UTF-8');
        }

        return strlen($value);
    }
}
