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
 * Plugins_InventoryProperties is an abstract class for every inventory plugin.
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_InventoryProperties
 * @author     Matteo Beccati <matteo@beccati.com>
 * @abstract
 */
class Plugins_InventoryProperties extends MAX_Plugin_Common
{
    /**
     * Return type of plugin
     *
     * @abstract
     * @return string A string describing the type of plugin.
     */
    function getType()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Return variables that need to be globally registered
     *
     * @abstract
     * @return array Variables
     */
    function getGlobalVars()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Return properties array for Admin_DA entity functions
     *
     * @abstract
     * @return string A string describing the type of plugin.
     */
    function prepareVariables()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }


    /**
     * Display user interface
     *
     * @abstract
     * @param array Entity properties
     */
    function display($properties)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }
}

?>
