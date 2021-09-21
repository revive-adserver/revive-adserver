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

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';

/**
 * A class for determining the available geotargeting modes.
 *
 * @package    Max
 * @static
 */
class MAX_Admin_Geotargeting
{
    /**
     * A method for returning an array of the available geotargeting modes.
     *
     * @return array  An array of strings representing the available geotargeting modes.
     */
    public function AvailableGeotargetingModes()
    {
        Language_Loader::load('default');

        $plugins = &MAX_Plugin::getPlugins('geotargeting');
        $modes['none'] = $GLOBALS['strNone'];
        $pluginModes = MAX_Plugin::callOnPlugins($plugins, 'getModuleInfo');
        foreach ($pluginModes as $key => $pluginMode) {
            $modes[$key] = $pluginMode;
        }
        return $modes;
    }
}
