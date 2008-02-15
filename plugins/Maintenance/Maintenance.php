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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * Plugins_Maintenance is an abstract class for every Maintenance plugin.
 *
 * @package    OpenXPlugin
 * @subpackage Maintenance
 * @author     Andrew Hill <andrew@m3.net>
 * @abstract
 */
class Plugins_Maintenance extends MAX_Plugin_Common
{

    /**
     * A method to return the (translated) name of plugin for use
     * in the user interface.
     *
     * @abstract
     * @return string
     */
    function getName()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * A method to return the Maintenance plugin hook type.
     *
     * @abstract
     * @return integer Either MAINTENANCE_PLUGIN_PRE or MAINTENANCE_PLUGIN_POST.
     */
    function getHookType()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * A method to return the Maintenance plugin hook point number.
     *
     * @abstract
     * @return integer
     */
    function getHook()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * The main method to carry out the plugin's actions.
     *
     * @abstract
     * @param array $aParams An optional array of parameters. The parameters
     *                       passed in will be specific to the plugin hook
     *                       point the plugin is written for. See the API
     *                       tutorial on plugins.
     */
    function run($aParams = null)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

}

?>
