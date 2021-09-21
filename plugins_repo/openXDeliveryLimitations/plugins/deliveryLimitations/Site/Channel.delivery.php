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

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
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
function MAX_checkSite_Channel($limitation, $op, $aParams = [])
{
    if (empty($limitation)) {
        return true;
    }
    if (!isset($GLOBALS['_MAX']['FILES']['aIncludedPlugins'])) {
        $GLOBALS['_MAX']['FILES']['aIncludedPlugins'] = [];
    }
    if (isset($GLOBALS['_MAX']['channel_results'][$limitation][$op])) {
        return $GLOBALS['_MAX']['channel_results'][$limitation][$op];
    }

    $aLimitations = MAX_cacheGetChannelLimitations($limitation);

    $aConf = $GLOBALS['_MAX']['CONF'];

    // Include required deliveryLimitation files...
    if (strlen($aLimitations['acl_plugins'])) {
        $acl_plugins = explode(',', $aLimitations['acl_plugins']);
        foreach ($acl_plugins as $acl_plugin) {
            list($extension, $package, $name) = explode(':', $acl_plugin);
            $pluginName = MAX_PATH . $aConf['pluginPaths']['plugins'] . "{$extension}/{$package}/{$name}.delivery.php";
            if (!isset($GLOBALS['_MAX']['FILES']['aIncludedPlugins'][$pluginName]) && file_exists($pluginName)) {
                require($pluginName);
                $GLOBALS['_MAX']['FILES']['aIncludedPlugins'][$pluginName] = true;
            }
        }
    }
    $result = true; // Set to true in case of error in eval
    if (!empty($aLimitations['compiledlimitation'])) {
        @eval('$result = (' . $aLimitations['compiledlimitation'] . ');');
    }

    // Store the channel result for later use.
    $GLOBALS['_MAX']['channels'][$result][] = ['limitation' => $limitation, 'op' => $op];
    $GLOBALS['_MAX']['channel_results'][$limitation][$op] = $result;

    return $result;
}
