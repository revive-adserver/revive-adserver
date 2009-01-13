<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal.php';


/**
 * A DAL class to easily deal with application variables
 *
 * @package    OpenXDal
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_Dal_ApplicationVariables
{
    /**
     * Get an appication variable value. The first call will cache
     *
     * @param string $name The variable name
     * @return string The value, or NULL if the variable doesn't exist
     */
    function get($name)
    {
        $aVars = &OA_Dal_ApplicationVariables::_getAll();

        if (isset($aVars[$name])) {
            return $aVars[$name];
        }

        return null;
    }

    /**
     * Set an appication variable
     *
     * @param string $name The variable name
     * @param string $value The variable value
     * @return boolean True on success
     */
    function set($name, $value)
    {
        // Load the cache
        $aVars = &OA_Dal_ApplicationVariables::_getAll();

        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name  = $name;
        $doAppVar->value = $value;

        if (isset($aVars[$name])) {
            $result = $doAppVar->update();
        } else {
            $result = $doAppVar->insert();
        }

        if (!$result) {
            return false;
        }

        $aVars[$name] = $value;
        return true;
    }

    /**
     * Get all the application variables
     *
     * @return array An array containing all the application variables
     */
    function getAll()
    {
        return OA_Dal_ApplicationVariables::_getAll();
    }

    /**
     * Delete an application variable
     *
     * @param string $name The variable name
     * @return boolean True on success
     */
    function delete($name)
    {
        $aVars = &OA_Dal_ApplicationVariables::_getAll();

        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = $name;
        $result = $doAppVar->delete();

        if (!$result) {
            return false;
        }

        unset($aVars[$name]);
        return true;
    }

    /**
     * Reload variables from the database
     *
     */
    function cleanCache()
    {
        OA_Dal_ApplicationVariables::_getAll(false);
    }

    /**
     * Private method to get a reference to a cache of all the application variables
     *
     * @param bool $fromCache Set to false to re-load variables from the db
     * @return array An array containing all the application variables
     */
    function &_getAll($fromCache = true)
    {
        static $aVars;

        if (!isset($aVars) || !$fromCache) {
            $doAppVar = OA_Dal::factoryDO('application_variable');
            $doAppVar->orderBy('name');

            $aVars = array();
            foreach ($doAppVar->getAll(array(), true, false) as $key => $value) {
                $aVars[$key] = $value['value'];
            }
        }

        return $aVars;
    }
    
    /**
     * Generates unique platform hash
     * 
     * @return string 40-chars hexadecimal number as unique platform hash
     */
    function generatePlatformHash()
    {
        return sha1(uniqid(rand(), true));
    }
}

?>
