<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
/**
 * Openads Upgrade Class
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */

require_once MAX_PATH.'/lib/OA/Dal.php';

class OA_Version_Controller
{
//    var $oDBUpgrader;
//    var$oLogger;

    var $oDbh;

    var $doApplicationVariable;

    function OA_Version_Controller()
    {

    }

    function init($oDbh='')
    {
        $this->oDbh = $oDbh;
    }

//    /**
//     * return upgrade info for a given database schema
//     *
//     * @return boolean
//     */
//    function _listDBUpgradesForSchema($schema)
//    {
//        return $this->oDBUpgrader->_queryLogTable('', '', $schema, DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED);
//    }

    function getSchemaVersion($schema)
    {
        return $this->_runQuery($this->_getQuerySelect($schema));
    }

    function putSchemaVersion($schema, $version)
    {
        if ($this->getSchemaVersion($schema))
        {
            return $this->_updateSchemaVersion($schema, $version);
        }
        else
        {
            return $this->_insertSchemaVersion($schema, $version);
        }
    }

    function _insertSchemaVersion($schema, $version)
    {
        if ($this->_execQuery($this->_getQueryInsert($schema, $version)))
        {
            return $this->getSchemaVersion($schema);
        }
        return false;
    }

    function _updateSchemaVersion($schema, $version)
    {
        if ($this->_execQuery($this->_getQueryUpdate($schema, $version)))
        {
            return $this->getSchemaVersion($schema);
        }
        return false;
    }

    function getApplicationVersion($max='')
    {
        if ($max)
        {
            return $this->_runQuery($this->_getQuerySelect('max_version'));
        }
        else
        {
            return $this->_runQuery($this->_getQuerySelect('oa_version'));
        }
    }

    function _insertApplicationVersion($version)
    {
        if ($this->_execQuery($this->_getQueryInsert('oa_version', $version)))
        {
            return $this->getApplicationVersion();
        }
        return false;
    }

    function _updateApplicationVersion($version)
    {
        if ($this->_execQuery($this->_getQueryUpdate('oa_version', $version)))
        {
            return $this->getApplicationVersion();
        }
        return false;
    }

    function putApplicationVersion($version)
    {
        if ($this->getApplicationVersion())
        {
            return $this->_updateApplicationVersion($version);
        }
        else
        {
            return $this->_insertApplicationVersion($version);
        }
    }

    function getPluginVersion($plugin)
    {
        return $this->_runQuery($this->_getQuerySelect($plugin));
    }

    function putPluginVersion($plugin, $version)
    {
        if ($this->getPluginVersion($plugin))
        {
            return $this->_updatePluginVersion($plugin, $version);
        }
        else
        {
            return $this->_insertPluginVersion($plugin, $version);
        }
    }

    function _insertPluginVersion($plugin, $version)
    {
        if ($this->_execQuery($this->_getQueryInsert($plugin, $version)))
        {
            return $this->getPluginVersion($plugin);
        }
        return false;
    }

    function _updatePluginVersion($plugin, $version)
    {
        if ($this->_execQuery($this->_getQueryUpdate($plugin, $version)))
        {
            return $this->getPluginVersion($plugin);
        }
        return false;
    }


    function _getQueryUpdate($name, $value)
    {
        return sprintf("UPDATE {$GLOBALS['_MAX']['CONF']['table']['prefix']}application_variable SET value = '%s' WHERE name = '%s'", $value, $name);
    }

    function _getQueryInsert($name, $value)
    {
        return sprintf("INSERT INTO {$GLOBALS['_MAX']['CONF']['table']['prefix']}application_variable (name,value) VALUES ('%s', '%s')", $name, $value);
    }

    function _getQuerySelect($name)
    {
        return sprintf("SELECT value FROM {$GLOBALS['_MAX']['CONF']['table']['prefix']}application_variable WHERE name = '%s'", $name);
    }

    function _runQuery($query)
    {
        $result = $this->oDbh->queryOne($query);
        if (PEAR::isError($result))
        {
            return false;
        }
        return $result;
    }

    function _execQuery($query)
    {
        $result = $this->oDbh->exec($query);
        if (PEAR::isError($result))
        {
            return false;
        }
        return $result;
    }

    function removeMaxVersion()
    {
        $query = "DELETE FROM {$GLOBALS['_MAX']['CONF']['table']['prefix']}application_variable WHERE name = 'max_version'";
        return $this->_execQuery($query);
    }


}

?>