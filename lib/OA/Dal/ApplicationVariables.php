<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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

require_once MAX_PATH . '/lib/OA/Dal.php';


/**
 * A DAL class to easily deal with application variables
 *
 * @package    OpenadsDal
 * @author     Matteo Beccati <matteo.beccati@openads.org
 */
class OA_Dal_ApplicationVariables
{
    /**
     * Get an appication variable value
     *
     * @param string $name The variable name
     * @return string The value, or NULL if the variable doesn't exist
     */
    function get($name)
    {
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = $name;
        $doAppVar->find();
        if ($doAppVar->fetch()) {
            return $doAppVar->value;
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
        $aData = array('value' => $value);
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->get($name);
        $doAppVar->setFrom($aData);
        $result = $doAppVar->update();

        if (!$result) {
            $doAppVar = OA_Dal::factoryDO('application_variable');
            $doAppVar->get($name);
            $doAppVar->find();

            if (!$doAppVar->fetch()) {
                $doAppVar = OA_Dal::factoryDO('application_variable');
                $doAppVar->name = $name;
                $doAppVar->setFrom($aData);
                $result = $doAppVar->insert();
                if (!$result) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get all the application variables
     *
     * @return array An array containing all the application variables
     */
    function getAll()
    {
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->orderBy('name');

        $aVars = $doAppVar->getAll(array(), true, false);

        foreach ($aVars as $key => $value) {
            $aVars[$key] = $value['value'];
        }

        return $aVars;
    }

    /**
     * Delete an application variable
     *
     * @param string $name The variable name
     * @return boolean True on success
     */
    function delete($name)
    {
        $doAppVar = OA_Dal::factoryDO('application_variable');
        $doAppVar->name = $name;
        $result = $doAppVar->delete();

        return (bool)$result;
    }
}

?>
