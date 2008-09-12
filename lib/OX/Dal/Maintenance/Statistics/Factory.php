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

/**
 * A class for creating {@link OX_Dal_Maintenance_Statistics} subclass
 * objects, depending on the database type in use.
 *
 * @package    OpenXDal
 * @subpackage MaintenanceStatistics
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OX_Dal_Maintenance_Statistics_Factory
{

    /**
     * The factory method used to instantiate a class that implements the
     * OX_Dal_Maintenance_Statistics interface.
     *
     * @param string $moduleName The name of the module class to instantiate.
     * @return {@link OX_Dal_Maintenance_Statistics} The class object created.
     */
    function factory()
    {
        // Instantiate the class
        $classname = $this->_deriveClassName();
        return new $classname();
    }

    /**
     * A private method to derive the class name to instantiate.
     *
     * @access private
     * @return string The name of the class object to create.
     */
    function _deriveClassName()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $filename  = ucfirst(strtolower($aConf['database']['type']));
        $classname = 'OX_Dal_Maintenance_Statistics_' . $filename;
        $includeFile = LIB_PATH . "/Dal/Maintenance/Statistics/{$filename}.php";
        require_once $includeFile;
        if (!class_exists($classname)) {
            // Unable to include the specified class file - raise error and halt
            OA::debug('Unable to find the "' . $classname . '" class in the "' . $includeFile .
                       '" file.', PEAR_LOG_ERR);
            OA::debug('Aborting script execution', PEAR_LOG_ERR);
            exit();
        }
        return $classname;
    }

}

?>