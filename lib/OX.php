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

require_once OX_PATH . '/lib/pear/Log.php';
require_once OX_PATH . '/lib/pear/PEAR.php';

/**
 * The core OpenX class, providing handy methods that are useful everywhere!
 *
 * @package    OpenX
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OX
{

    /**
     * A method to construct URLs for static assets, such as images, CSS and
     * JavaScript files, based on OpenX installation and configuration details.
     *
     * @param string $asset An optional relative path to the asset.
     * @return string       The URL to the asset. If asset was not provided,
     * 		                the path does not contain a trailing slash.
     */
    function assetPath($asset = null)
    {
        global $installing;
        $aConf = $GLOBALS['_MAX']['CONF'];
        $assetsVersion = $aConf['webpath']['adminAssetsVersion'];
        $prefix = $installing ? '' : MAX::constructURL(MAX_URL_ADMIN, '');
    	$pathWithSuffix = $prefix . "assets";
        if (strlen($assetsVersion))
        {
        	$pathWithSuffix .= "/" . $assetsVersion;
        }
    	if ($asset != null)
    	{
    		return $pathWithSuffix . "/" . $asset;
    	}
    	else
    	{
	    	return $pathWithSuffix;
    	}
    }

    /**
     * Similar to PHP's realpath(), but works on absolute paths. Cross platform
     * friendly, and does not add a trailing /
     *
     * @param string $path
     */

    function realPathRelative($path) {
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }

    /**
     * A method to temporarily disable PEAR error handling by
     * pushing a null error handler onto the top of the stack.
     *
     * @static
     */
    function disableErrorHandling()
    {
        PEAR::pushErrorHandling(null);
    }

    /**
     * A method to re-enable PEAR error handling by popping
     * a null error handler off the top of the stack.
     *
     * @static
     */
    function enableErrorHandling()
    {
        // Ensure this method only acts when a null error handler exists
        $stack = &$GLOBALS['_PEAR_error_handler_stack'];
        list($mode, $options) = $stack[sizeof($stack) - 1];
        if (is_null($mode) && is_null($options)) {
            PEAR::popErrorHandling();
        }
    }

}

?>