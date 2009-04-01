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
$Id: Channel.delivery.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris@m3.net>
 */

if (!isset($GLOBALS['_MAX']['FILES']['/lib/max/Delivery/cache.php'])) {
    require_once(MAX_PATH . '/lib/max/Delivery/cache.php');
}

/**
 * Check to see if this impression contains the valid channel.
 *
 * @param string $limitation The channel limitation
 * @param string $op The operator (either '==' or '=~', or '!~')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's channel passes this limitation's test.
 */
function MAX_checkSite_Channel($limitation, $op, $aParams = array())
{
	if (empty($limitation)) {
		return true;
	}
    if (!isset($GLOBALS['_MAX']['FILES']['aIncludedPlugins'])) {
        $GLOBALS['_MAX']['FILES']['aIncludedPlugins'] = array();
    }
	$aLimitations = MAX_cacheGetChannelLimitations($limitation);

	$aConf = $GLOBALS['_MAX']['CONF'];

    // Include required deliveryLimitation files...
    if(strlen($aLimitations['acl_plugins'])) {
        $acl_plugins = explode(',', $aLimitations['acl_plugins']);
        foreach ($acl_plugins as $acl_plugin) {
            list($extension, $package, $name) = explode(':', $acl_plugin);
            $pluginName = MAX_PATH . $aConf['pluginPaths']['extensions'] . "{$extension}/{$package}/{$name}.delivery.php";
            if (!isset($GLOBALS['_MAX']['FILES']['aIncludedPlugins'][$pluginName])) {
                require($pluginName);
                $GLOBALS['_MAX']['FILES']['aIncludedPlugins'][$pluginName] = true;
            }
        }
    }
    $result = true; // Set to true in case of error in eval
    if (!empty($aLimitations['compiledlimitation'])) {
        @eval('$result = ('.$aLimitations['compiledlimitation'].');');
    }
    return $result;
}

?>
