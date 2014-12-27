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

require_once MAX_PATH . '/lib/OA/Dal.php';


/**
 * A DAL class to easily deal with application variables
 *
 * @package    OpenXDal
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
