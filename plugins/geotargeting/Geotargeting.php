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

/**
 * Plugins_Geotargeting is an abstract class for every GeoTargeting plugin
 *
 * @package    OpenXPlugin
 * @subpackage Geotargeting
 * @author     Radek Maciaszek <radek@m3.net>
 * @abstract
 */
class Plugins_Geotargeting extends MAX_Plugin_Common
{
    var $type;

    /**
     * Return plugin name
     *
     * @abstract
     * @return string A string describing the class.
     */
    function getModuleInfo()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * The method to look up the GeoTargeting information, based on
     * the IP address.
     *
     * @abstract
     * @return array An array that will contain the results of the
     *               GeoTargeting lookup.
     */
    function getInfo()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Return geotargeting specific config file
     *
     * @param boolean $processSections      If true the configuration data is returned
     *                                      as one dimension array
     * @param boolean $commonPackageConfig  If true read the global plugin.conf.php file
     *                                      for specific package
     *
     * @return object                       Plugin object or false if any error occured
     *
     */
    function getConfig($processSections = false, $commonPackageConfig = true)
    {
        return parent::getConfig($processSections, $commonPackageConfig);
    }
}

?>