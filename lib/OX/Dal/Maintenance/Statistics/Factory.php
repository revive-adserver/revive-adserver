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
        $classname = $this->deriveClassName();
        return new $classname();
    }

    /**
     * A method to derive the class name to instantiate.
     *
     * @return string The name of the class object to create.
     */
    function deriveClassName()
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