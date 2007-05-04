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
                                        MAX_PATH.'/var/',
                                       );
        $this->aInfo['PHP']['expected']     = array();
        $this->aInfo['PERMS']['expected']   = array();
        $this->aInfo['FILES']['expected']   = array();
//        $this->aInfo['PAN']['expected']     = array();
//        $this->aInfo['MAX']['expected']     = array();
//        $this->aInfo['DB']['expected']      = array();

        $this->aInfo['PHP']['actual']       = array();
        $this->aInfo['PERMS']['actual']     = array();
        $this->aInfo['FILES']['actual']     = array();
//        $this->aInfo['PAN']['actual']       = array();
//        $this->aInfo['MAX']['actual']       = array();
//        $this->aInfo['DB']['actual']        = array();
    }

    function init()
    {
        $this->aInfo['PHP']['expected']['version']              = '4.3.6';
        $this->aInfo['PHP']['expected']['magic_quotes_runtime'] = '0';
        $this->aInfo['PHP']['expected']['memory_limit']         = '8192';
        $this->aInfo['PHP']['expected']['safe_mode']            = '0';
        $this->aInfo['PHP']['expected']['date.timezone']        = true;
        $this->aInfo['PERMS']['expected']                   = $this->aFilePermissions;
        $this->aInfo['FILES']['expected']                   = array();
//        $this->aInfo['PAN']['expected']['version']          = '2.0.12';
//        $this->aInfo['MAX']['expected']['version']          = 'v0.3.32-alpha';
//        $this->aInfo['DB']['expected']['mysql']['version']  = '4.0.12';
//        $this->aInfo['DB']['expected']['pgsql']['version']  = '7.0.0';
        return $this->aInfo;
    }

    function checkSystem()
    {
        $this->getAllInfo();
        $this->checkCritical();
        return $this->aInfo;
    }

    function getAllInfo()
    {
        $this->aInfo['PHP']['actual']     = $this->getPHPInfo();
        $this->aInfo['PERMS']['actual']   = $this->getFilePermissionErrors();
        $this->aInfo['FILES']['actual']   = $this->getFileIntegInfo();
//        $this->aInfo['PAN']['actual']     = $this->getPANInfo();
//        $this->aInfo['MAX']['actual']     = $this->getMAXInfo();
//        $this->aInfo['DB']['actual']      = $this->getDBInfo();
        return $this->aInfo;
    }

    function getPHPInfo()
    {
        $aResult['version'] = phpversion();
        $aResult['memory_limit'] = ini_get('memory_limit');
        $aResult['magic_quotes_runtime'] = get_magic_quotes_runtime();
        $aResult['safe_mode'] = ini_get('safe_mode');
        $aResult['date.timezone'] = (ini_get('date.timezone') ? ini_get('date.timezone') : getenv('TZ'));
        //$aResult['register_globals'] = ini_get('register_globals');
        //$aResult['magic_quotes_gpc'] = get_magic_quotes_gpc();

        //$aResult['extensions'] = get_loaded_extensions();
        //mmturck, eaccelerator, apc, xcache, zendplatfor

        //$aResult = ini_get_all();
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

    function checkCritical()
    {
        $this->_checkCriticalPHP();
        $this->_checkCriticalPermissions();
        $this->_checkCriticalFiles();
        return $this->aInfo;
    }

    function _checkCriticalPHP()
    {
        $result = version_compare($this->aInfo['PHP']['actual']['version'],
                                  $this->aInfo['PHP']['expected']['version']
                                 );
        $result = ($result<0 ? false : true);
        if (!$result)
        {
            $this->aInfo['PHP']['error'][] = "Version {$this->aInfo['PHP']['actual']['version']} is below the minimum supported version {$this->aInfo['PHP']['expected']['version']}";
        }
        else
        {
            $this->aInfo['PHP']['error'] = false;
        }

        $memlim = $this->aInfo['PHP']['actual']['memory_limit'];
        if (($memlim > 0) && ($memlim < $this->aInfo['PHP']['expected']['memory_limit']))
        {
            $result = false;
            $this->aInfo['PHP']['error'][] = 'memory_limit needs to be increased';
        }
        if ($this->aInfo['PHP']['actual']['safe_mode'])
        {
            $result = false;
            $this->aInfo['PHP']['error'][] = 'safe_mode must be OFF';
        }
        if ($this->aInfo['PHP']['actual']['magic_quotes_runtime'])
        {
            $result = false;
            $this->aInfo['PHP']['error'][] = 'magic_quotes_runtime must be OFF';
        }
        if (!$this->aInfo['PHP']['actual']['date.timezone'])
        {
            $result = false;
            $this->aInfo['PHP']['error'][] = 'date.timezone expected to be set';
        }
        return $result;
    }

    function _checkCriticalPermissions()
    {
        foreach ($this->aInfo['PERMS']['actual'] AS $k=>$v)
        {
            if ($v!='OK')
            {
                $this->aInfo['PERMS']['error'][] = 'Some folders and files require write permissions';
                return false;
            }
        }
        $this->aInfo['PERMS']['error'] = false;
        return true;
    }

    function _checkCriticalFiles()
    {
        //$this->aInfo['FILES']['actual'];
        $this->aInfo['FILES']['error'] = false;
        return true;
    }
/*
    function _checkCriticalPAN()
    {
        if ($this->aInfo['PAN']['actual'])
        {
            $result = version_compare($this->aInfo['PAN']['actual']['version'],
                                      $this->aInfo['PAN']['expected']['version']
                                     );
            return ($result<0 ? false : true);
        }
        return true;
    }

    function _checkCriticalMAX()
    {
        $result = true;
        if ($this->aInfo['MAX']['actual'])
        {
            $result = version_compare($this->aInfo['MAX']['actual']['version'],
                                      $this->aInfo['MAX']['expected']['version']
                                     );
            return ($result<0 ? false : true);
        }
        return true;
    }

    function _getPANversion($aDsn)
    {
        $oDbh = OA_DB::singleton(OA_DB::getDsn($aDsn['database']));

        $query = "SELECT config_version FROM {$this->aInfo['PAN']['actual']['table_prefix']}config";
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
        $oDbh = OA_DB::singleton(OA_DB::getDsn($aDsn['database']));

        $query = "SELECT value FROM {$this->aInfo['DB']['actual']['table']['prefix']}application_variable WHERE name='max_version'";
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
        if ($this->aInfo['PAN']['actual'])
        {
            $aResult['host']        = $this->aInfo['PAN']['actual']['dbhost'];
            $aResult['type']        = 'mysql';
            $aResult['port']        = $this->aInfo['PAN']['actual']['dbport'];
            $aResult['username']    = $this->aInfo['PAN']['actual']['dbuser'];
            $aResult['password']    = $this->aInfo['PAN']['actual']['dbpassword'];
            $aResult['name']        = $this->aInfo['PAN']['actual']['dbname'];
            $aResult['table']['type']   = $this->aInfo['PAN']['actual']['table_type'];
            $aResult['table']['prefix'] = $this->aInfo['PAN']['actual']['table_prefix'];
            $this->aInfo['PAN']['actual']['version']  = $this->_getPANversion($aResult);
            return $aResult;
        }
        else if ($GLOBALS['_MAX']['CONF'])
        {
            $aResult = $GLOBALS['_MAX']['CONF']['database'];
            $aResult['table']['type']   = $GLOBALS['_MAX']['CONF']['table']['type'];
            $aResult['table']['prefix'] = $GLOBALS['_MAX']['CONF']['table']['prefix'];
            $this->aInfo['MAX']['actual']['version']  = $this->_getMAXversion($aResult);
            return $aResult;
        }
        return false;
    }
*/

}

?>