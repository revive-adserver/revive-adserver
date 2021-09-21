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
    public static function assetPath($asset = null)
    {
        global $installing;
        $aConf = $GLOBALS['_MAX']['CONF'];
        $assetsVersion = $aConf['webpath']['adminAssetsVersion'] ?? '';
        $prefix = $installing ? '' : MAX::constructURL(MAX_URL_ADMIN, '');
        $pathWithSuffix = $prefix . "assets";
        if (strlen($assetsVersion)) {
            $pathWithSuffix .= "/" . $assetsVersion;
        }
        if ($asset != null) {
            return $pathWithSuffix . "/" . $asset;
        } else {
            return $pathWithSuffix;
        }
    }

    /**
     * Similar to PHP's realpath(), but works on absolute paths. Cross platform
     * friendly, and does not add a trailing /
     *
     * @param string $path
     */

    public static function realPathRelative($path)
    {
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
        $absolutes = [];
        foreach ($parts as $part) {
            if ('.' == $part) {
                continue;
            }
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }
}
