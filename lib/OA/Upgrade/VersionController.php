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

require_once MAX_PATH.'/lib/OA/Dal.php';

/**
 * OpenX Upgrade Class
 *
 * @author     Monique Szpak <monique.szpak@openx.org>
 */
class OA_Version_Controller
{
    var $oDbh;

    var $doApplicationVariable;

    var $versionTablename;

    function OA_Version_Controller()
    {

    }

    function init($oDbh='')
    {
        $this->oDbh = $oDbh;
        $this->versionTablename = $oDbh->quoteIdentifier($GLOBALS['_MAX']['CONF']['table']['prefix'].'application_variable', true);
    }

    function tableAppVarsExists($aExistingTables)
    {
        return (in_array($GLOBALS['_MAX']['CONF']['table']['prefix'].'application_variable',$aExistingTables));
    }

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

    function getApplicationVersion($product='oa')
    {
        return $this->_runQuery($this->_getQuerySelect($product.'_version'));
    }

    function _insertApplicationVersion($version, $product='oa')
    {
        if ($this->_execQuery($this->_getQueryInsert($product.'_version', $version)))
        {
            return $this->getApplicationVersion($product);
        }
        return false;
    }

    function _updateApplicationVersion($version, $product='oa')
    {
        if ($this->_execQuery($this->_getQueryUpdate($product.'_version', $version)))
        {
            return $this->getApplicationVersion();
        }
        return false;
    }

    function putApplicationVersion($version, $product='oa')
    {
        if ($this->getApplicationVersion($product))
        {
            return $this->_updateApplicationVersion($version, $product);
        }
        else
        {
            return $this->_insertApplicationVersion($version, $product);
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
        return sprintf("UPDATE {$this->versionTablename} SET value = '%s' WHERE name = '%s'", $value, $name);
    }

    function _getQueryInsert($name, $value)
    {
        return sprintf("INSERT INTO {$this->versionTablename} (name,value) VALUES ('%s', '%s')", $name, $value);
    }

    function _getQuerySelect($name)
    {
        return sprintf("SELECT value FROM {$this->versionTablename} WHERE name = '%s'", $name);
    }

    function _runQuery($query)
    {
        OA::disableErrorHandling();
        $result = $this->oDbh->queryOne($query);
        OA::enableErrorHandling();
        if (PEAR::isError($result))
        {
            return false;
        }
        return $result;
    }

    function _execQuery($query)
    {
        OA::disableErrorHandling();
        $result = $this->oDbh->exec($query);
        OA::enableErrorHandling();
        if (PEAR::isError($result))
        {
            return false;
        }
        return $result;
    }

    function removeMaxVersion()
    {
        $query = "SELECT value FROM {$this->versionTablename} WHERE name = 'max_version'";
        if ($this->_execQuery($query))
        {
            $query = "DELETE FROM {$this->versionTablename} WHERE name = 'max_version'";
            return $this->_execQuery($query);
        }
        else
        {
            return true;
        }
    }

    // when rolling back to max
    function removeOpenadsVersion()
    {
        $query = "DELETE FROM {$this->versionTablename} WHERE name = 'oa_version'";
        return $this->_execQuery($query);
    }
}

?>