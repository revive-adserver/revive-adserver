<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/Max.php';

/**
 * A class for creating {@link MAX_Forecast_Common} subclass objects, depending
 * on the forecast algorithm in use.
 *
 * @package    MaxForecast
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Forecast_Factory
{

    /**
     * The factory method used to instantiate a class that implements the
     * MAX_Forecast_Common interface.
     *
     * @param string $moduleName The name of the algorithm class to instantiate.
     * @return {@link MAX_Forecast_Common} The class object created.
     */
    function factory($algorithmName)
    {
        // Instantiate the class
        $classname = $this->_deriveClassName($algorithmName);
        return new $classname();
    }

    /**
     * A private method to derive the class name to instantiate.
     *
     * @access private
     * @param string $moduleName The name of the algorithm class to instantiate.
     * @return string The name of the class object to create.
     */
    function _deriveClassName($algorithmName)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $name = ucfirst(strtolower($algorithmName));
        $classname = 'MAX_Forecast_Algorithm_' . $name;
        $includeFile = MAX_PATH . "/lib/max/Forecast/Algorithm/$name.php";
        @include_once $includeFile;
        if (!class_exists($classname)) {
            // Unable to include the specified class file - raise error and halt
            MAX::debug('Unable to find the "' . $classname . '" class in the "' . $includeFile .
                       '" file.', PEAR_LOG_ERR);
            MAX::debug('Aborting script execution', PEAR_LOG_ERR);
            exit();
        }
        return $classname;
    }

}

?>
