<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';

/**
 * A class for determining the available geotargeting modes.
 *
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 * @static
 */
class MAX_Admin_Geotargeting
{

    /**
     * A method for returning an array of the available geotargeting modes.
     *
     * @return array  An array of strings representing the available geotargeting modes.
     */
    function AvailableGeotargetingModes()
    {
        Language_Loader::load('default');
        
        $plugins = &MAX_Plugin::getPlugins('geotargeting');
        $modes['none'] = $GLOBALS['strNone'];
        $pluginModes = MAX_Plugin::callOnPlugins($plugins, 'getModuleInfo');
        foreach($pluginModes as $key => $pluginMode) {
            $modes[$key] = $pluginMode;
        }
        return $modes;
    }
    
}

?>