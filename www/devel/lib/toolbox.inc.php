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
/**
 * OpenX Developer Toolbox
 *
 * @author     Monique Szpak <monique.szpak@openx.org>
 *
 * $Id$
 *
 */


class OX_DevToolbox
{
    /**
     * check access to an array of requried files/folders
     *
     *
     * @return array of error messages
     */
    function checkFilePermissions($aFiles)
    {
        $aErrors = array();

        foreach ($aFiles as $file)
        {
            if (empty($file))
            {
                continue;
            }
            if (!file_exists($file))
            {
                $aErrors['errors'][] = sprintf("The file '%s' does not exist", $file);
            }
            elseif (!is_writable($file))
            {
                if (is_dir($file))
                {
                    $aErrors['errors'][] = sprintf("The directory '%s' is not writable", $file);
                    $aErrors['fixes'][]  = sprintf("chmod -R a+w %s", $file);
                }
                else
                {
                    $aErrors['errors'][] = sprintf("The file '%s' is not writable", $file);
                    $aErrors['fixes'][]  = sprintf("chmod a+w %s", $file);
                }
            }
        }

        if (count($aErrors))
        {
            return $aErrors;
        }
        return true;
    }

    /**
     * create a new database with the given name
     * check first and drop if necessary
     *
     * @param string $database_name
     * @return boolean
     */
    /*function _createDatabase($database_name)
    {
        if ($this->_dropDatabase($database_name))
        {
            $this->aDB_definition['name'] = $database_name;
            if ($this->oSchema->db->manager->createDatabase($database_name))
            {
                $this->oSchema->db = OA_DB::changeDatabase($database_name);
                $oaTable = new OA_DB_Table();
                $oaTable->oSchema = $this->oSchema;
                $oaTable->aDefinition = $this->aDB_definition;
                return $oaTable->createAllTables();
            }
        }
        return false;
    }*/

    /**
     * check if given database exists and drop if it does
     *
     * @param string $database_name
     * @return boolean
     */
    /*function _dropDatabase($database_name)
    {
        if ($this->_databaseExists($database_name))
        {
            $this->oSchema->db->manager->dropDatabase($database_name);
        }
        return (!$this->_databaseExists($database_name));
    }*/

    /**
     * check if a given database name is in use
     *
     * @param string $database_name
     * @return boolean
     */
    /*function _databaseExists($database_name)
    {
        $result = $this->oSchema->db->manager->listDatabases();
        if (PEAR::isError($result))
        {
            $this->oLogger->logError($result->getUserInfo());
            return false;
        }
        return in_array(strtolower($database_name), array_map('strtolower', $result));
    }*/
}
?>
