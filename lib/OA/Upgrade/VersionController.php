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

require_once MAX_PATH.'/lib/OA/Dal.php';

/**
 * OpenX Upgrade Class
 *
 */
class OA_Version_Controller
{
    var $oDbh;

    var $doApplicationVariable;

    var $versionTablename;

    function __construct()
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
            return $this->getApplicationVersion($product);
        }
        return false;
    }

    function putApplicationVersion($version, $product='oa')
    {
        // Set default product name if null given
        if (is_null($product)) {
            $product = 'oa';
        }
        if ($this->getApplicationVersion($product))
        {
            return $this->_updateApplicationVersion($version, $product);
        }
        else
        {
            return $this->_insertApplicationVersion($version, $product);
        }
    }

    function getComponentGroupVersion($group)
    {
        return $this->_runQuery($this->_getQuerySelect($group));
    }

    function putComponentGroupVersion($group, $version)
    {
        if ($this->getComponentGroupVersion($group))
        {
            return $this->_updateComponentGroupVersion($group, $version);
        }
        else
        {
            return $this->_insertComponentGroupVersion($group, $version);
        }
    }

    function _insertComponentGroupVersion($group, $version)
    {
        if ($this->_execQuery($this->_getQueryInsert($group, $version)))
        {
            return $this->getComponentGroupVersion($group);
        }
        return false;
    }

    function _updateComponentGroupVersion($group, $version)
    {
        if ($this->_execQuery($this->_getQueryUpdate($group, $version)))
        {
            return $this->getComponentGroupVersion($group);
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
        RV::disableErrorHandling();
        $result = $this->oDbh->queryOne($query);
        RV::enableErrorHandling();
        if (PEAR::isError($result))
        {
            return false;
        }
        return $result;
    }

    function _execQuery($query)
    {
        RV::disableErrorHandling();
        $result = $this->oDbh->exec($query);
        RV::enableErrorHandling();
        if (PEAR::isError($result))
        {
            return false;
        }
        return $result;
    }

    function removeVariable($name)
    {
        $query = "SELECT value FROM {$this->versionTablename} WHERE name = '{$name}'";
        if ($this->_runQuery($query))
        {
            $query = "DELETE FROM {$this->versionTablename} WHERE name = '{$name}'";
            return $this->_execQuery($query);
        }
        else
        {
            return true;
        }
    }

    function removeVersion($name)
    {
        return $this->removeVariable($name.'_version');
    }

    function removeMaxVersion()
    {
        return $this->removeVersion('max');
    }

    // when rolling back to max
    function removeOpenadsVersion()
    {
        return $this->removeVersion('oa');
    }
}

?>
