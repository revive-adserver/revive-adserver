<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
    
}

?>