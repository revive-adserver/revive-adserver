<?php
/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
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
/**
 * Openads Upgrade Class
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */

require_once MAX_PATH.'/lib/OA/DB.php';

class OA_Environment_Manager
{

    var $aInfo = array();
    var $aFilePermissions = array();

    function OA_Environment_Manager()
    {
        $this->aFilePermissions = array(
                                        MAX_PATH.'/var/'
                                       );
    }

    function init()
    {
    }

    function getAllInfo($dbh='')
    {
        $this->aInfo['PHP']     = $this->getPHPInfo();
        $this->aInfo['PERMS']   = $this->getFilePermissionErrors();
        $this->aInfo['FILES']   = $this->getFileIntegInfo();
        $this->aInfo['PAN']     = $this->getPANInfo();
        $this->aInfo['MAX']     = $this->getMAXInfo();
        $this->aInfo['DB']      = $this->getDBInfo();
        return $this->aInfo;
    }

    function _getPANversion($aDsn)
    {
        $aDSN['database'] = $aDsn;
        $oDbh = OA_DB::singleton(OA_DB::getDsn($aDSN));

        $query = "SELECT config_version FROM {$this->aInfo['PAN']['table_prefix']}config";
        $result = $oDbh->queryOne($query);
        if (PEAR::isError($result))
        {
            return false;
        }
        return $result;
    }

    function getPANInfo()
    {
        if (file_exists(MAX_PATH.'/var/config.inc.php'))
        {
            include MAX_PATH.'/var/config.inc.php';
            return $phpAds_config;
        }
        return false;
    }

    function _getMAXversion($aDsn)
    {
        $aDSN['database'] = $aDsn;
        $oDbh = OA_DB::singleton(OA_DB::getDsn($aDSN));

        $query = "SELECT value FROM {$this->aInfo['DB']['table']['prefix']}application_variable WHERE name='max_version'";
        $result = $oDbh->queryOne($query);
        if (PEAR::isError($result))
        {
            return false;
        }
        return $result;
    }

    function getMAXInfo()
    {
        if ($GLOBALS['_MAX']['CONF'])
        {
            return $GLOBALS['_MAX']['CONF'];
        }
        return false;
    }

    function getDBInfo()
    {
        if ($this->aInfo['PAN'])
        {
            $aResult['host']        = $this->aInfo['PAN']['dbhost'];
            $aResult['type']        = 'mysql';
            $aResult['port']        = $this->aInfo['PAN']['dbport'];
            $aResult['username']    = $this->aInfo['PAN']['dbuser'];
            $aResult['password']    = $this->aInfo['PAN']['dbpassword'];
            $aResult['name']        = $this->aInfo['PAN']['dbname'];
            $aResult['table']['type']   = $this->aInfo['PAN']['table_type'];
            $aResult['table']['prefix'] = $this->aInfo['PAN']['table_prefix'];
            $this->aInfo['PAN']['version']  = $this->_getPANversion($aResult);
            return $aResult;
        }
        else if ($GLOBALS['_MAX']['CONF'])
        {
            $aResult = $GLOBALS['_MAX']['CONF']['database'];
            $aResult['table']['type']   = $GLOBALS['_MAX']['CONF']['table']['type'];
            $aResult['table']['prefix'] = $GLOBALS['_MAX']['CONF']['table']['prefix'];
            $this->aInfo['MAX']['version']  = $this->_getMAXversion($aResult);
            return $aResult;
        }
        return false;
    }

    function getPHPInfo()
    {
        $aResult['version'] = phpversion();
        return $aResult;
    }

    function getFileIntegInfo()
    {
        return false;
    }

    /**
     * check access to an array of requried files/folders
     *
     *
     * @return array of error messages
     */
    function getFilePermissionErrors()
    {
        $aErrors = array();

        foreach ($this->aFilePermissions as $file)
        {
            if (empty($file))
            {
                continue;
            }
            $aErrors[$file] = 'OK';
            if (!file_exists($file))
            {
                $aErrors[$file] = 'NOT writeable';
            }
            elseif (!is_writable($file))
            {
                $aErrors[$file] = 'NOT writeable';
            }
        }

        if (count($aErrors))
        {
            return $aErrors;
        }
        return false;
    }

}

?>