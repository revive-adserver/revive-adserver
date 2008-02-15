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

/**
 * A factory class to create instances of classes that implement the
 * OA_Admin_Statistics_Common "interface".
 *
 * @package    OpenXAdmin
 * @subpackage Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Factory
{

    /**
     *  Create a new object of the appropriate OA_Admin_Statistics_Common subclass.
     *
     * @static
     * @param string $controllerType The controller type (e.g. "global-advertiser").
     * @param array  $aParams        An array of parameters to be passed as the parameter
     *                               to the constructor of the class instantiated.
     * @return OA_Admin_Statistics_Common The instantiated class that inherits from
     *                                    OA_Admin_Statistics_Common.
     */
    function &getController($controllerType = '', $aParams = null)
    {
        if (!is_array($aParams)) {
            $aParams = array();
        }

        if (empty($controllerType) || $controllerType == '-')
        {
            $controllerType = basename($_SERVER['PHP_SELF']);
            $controllerType = preg_replace('#^(?:stats-)?(.*)\.php#', '$1', $controllerType);
        }

        // Prepare the strings required to generate the file and class names
        list($primary, $secondary) = explode('-', $controllerType, 2);
        $primary = ucfirst(strtolower($primary));
        $aSecondary = explode('-', $secondary);
        foreach ($aSecondary as $key => $string) {
            $aSecondary[$key] = ucfirst(strtolower($string));
        }

        // Generate the file and class names
        if ($aSecondary[0] == 'Targeting') {
            $file = MAX_PATH . '/lib/OA/Admin/Statistics/Targeting/Controller/';
        } else {
            $file = MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/Controller/';
        }
        $file .= $primary;
        foreach ($aSecondary as $string) {
            $file .= $string;
        }
        $file .= '.php';
        if ($aSecondary[0] == 'Targeting') {
            $class = 'OA_Admin_Statistics_Targeting_Controller_';
        } else {
            $class = 'OA_Admin_Statistics_Delivery_Controller_';
        }
        $class .= $primary;
        foreach ($aSecondary as $string) {
            $class .= $string;
        }

        // Instantiate & return the required statistics class
        require_once $file;
        $oController = new $class($aParams);
        return $oController;
    }

}

?>