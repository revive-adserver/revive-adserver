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
*/
/**
 * Openads Upgrade Class
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id$
 *
 */
define('OA_ENV_ERROR_PHP_NOERROR',                    1);
define('OA_ENV_ERROR_PHP_VERSION',                   -1);
define('OA_ENV_ERROR_PHP_MEMORY',                    -2);
define('OA_ENV_ERROR_PHP_SAFEMODE',                  -3);
define('OA_ENV_ERROR_PHP_MAGICQ',                    -4);
define('OA_ENV_ERROR_PHP_TIMEZONE',                  -5);

require_once MAX_PATH.'/lib/OA/DB.php';

class OA_Environment_Manager
{

    var $aInfo = array();

    function OA_Environment_Manager()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $this->aInfo['PERMS']['expected'] = array(
                                                  MAX_PATH.'/var',
                                                  MAX_PATH.'/var/cache',
                                                  MAX_PATH.'/var/plugins',
                                                  MAX_PATH.'/var/plugins/cache',
                                                  MAX_PATH.'/var/plugins/config',
                                                  MAX_PATH.'/var/templates_compiled'
                                                 );
        if ($conf) {
            $this->aInfo['PERMS']['expected'][] = $conf['store']['webDir'];
        }

        $this->aInfo['PHP']['actual']       = array();
        $this->aInfo['PERMS']['actual']     = array();
        $this->aInfo['FILES']['actual']     = array();

        $this->aInfo['PHP']['expected']['version']              = '4.3.6';
        $this->aInfo['PHP']['expected']['magic_quotes_runtime'] = '0';
        $this->aInfo['PHP']['expected']['memory_limit']         = '8192';
        $this->aInfo['PHP']['expected']['safe_mode']            = '0';
        //$this->aInfo['PHP']['expected']['date.timezone']        = true;

        $this->aInfo['FILES']['expected']                   = array();
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
        return $this->aInfo;
    }

    function getPHPInfo()
    {
        $aResult['version'] = phpversion();

        $aResult['memory_limit'] = ini_get('memory_limit');
        if (preg_match('/^(\d+)M$/i', $aResult['memory_limit'], $m)) {
            $aResult['memory_limit'] = $m[1] * 1024;
        }

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

        foreach ($this->aInfo['PERMS']['expected'] as $file)
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
        if (function_exists('version_compare'))
        {
            $result = version_compare($this->aInfo['PHP']['actual']['version'],
                                      $this->aInfo['PHP']['expected']['version'], "<");
            $result = ($result ? OA_ENV_ERROR_PHP_VERSION : OA_ENV_ERROR_PHP_NOERROR);
        }
        else
        {
            $result = OA_ENV_ERROR_PHP_VERSION;
        }
        if (!$result)
        {
            $this->aInfo['PHP']['error'][OA_ENV_ERROR_PHP_VERSION] = "Version {$this->aInfo['PHP']['actual']['version']} is below the minimum supported version {$this->aInfo['PHP']['expected']['version']}";
        }
        else
        {
            $this->aInfo['PHP']['error'] = false;
        }

        $memlim = $this->aInfo['PHP']['actual']['memory_limit'];

        // Double the required mem if PHP >= 5.2.0 - memory handling has changed and
        // memory occupation info is mora accurate. The default has been raised
        if (version_compare($this->aInfo['PHP']['actual']['version'], '5.2.0', '>=')) {
            $memlim *= 2;
        }
        if (($memlim > 0) && ($memlim < $this->aInfo['PHP']['expected']['memory_limit']))
        {
            $result = OA_ENV_ERROR_PHP_MEMORY;
            $this->aInfo['PHP']['error'][OA_ENV_ERROR_PHP_MEMORY] = 'memory_limit needs to be increased';
        }
        if ($this->aInfo['PHP']['actual']['safe_mode'])
        {
            $result = OA_ENV_ERROR_PHP_SAFEMODE;
            $this->aInfo['PHP']['error'][OA_ENV_ERROR_PHP_SAFEMODE] = 'safe_mode must be OFF';
        }
        if ($this->aInfo['PHP']['actual']['magic_quotes_runtime'])
        {
            $result = OA_ENV_ERROR_PHP_MAGICQ;
            $this->aInfo['PHP']['error'][OA_ENV_ERROR_PHP_MAGICQ] = 'magic_quotes_runtime must be OFF';
        }
//        if (!$this->aInfo['PHP']['actual']['date.timezone'])
//        {
//            $result = OA_ENV_ERROR_PHP_TIMEZONE;
//            $this->aInfo['PHP']['error'][OA_ENV_ERROR_PHP_TIMEZONE] = 'date.timezone expected to be set';
//        }
        return $result;
    }

    function _checkCriticalPermissions()
    {
        foreach ($this->aInfo['PERMS']['actual'] AS $k=>$v)
        {
            if ($v!='OK')
            {
                $this->aInfo['PERMS']['error'][] = sprintf($GLOBALS['strErrorWritePermissions'], $k);;
                return false;
            }
        }
        $this->aInfo['PERMS']['error'] = false;
        return true;
    }

    function _checkCriticalFiles()
    {
        $this->aInfo['FILES']['error'] = false;
        return true;
    }

}

?>
