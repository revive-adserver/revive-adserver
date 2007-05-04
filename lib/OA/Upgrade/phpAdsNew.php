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

require_once MAX_PATH.'/lib/OA/DB.php';

class OA_phpAdsNew
{
    var $oDbh;

    var $detected   = false;
    var $aDsn       = false;
    var $aConfig    = false;
    var $pathCfg    = '/var/';
    var $fileCfg    = 'config.inc.php';
    var $prefix     = '';
    var $engine     = '';
    var $version    = '';

    function OA_phpAdsNew()
    {

    }

    function init()
    {
        $this->aConfig  = $this->_getPANConfig();
        if ($this->detected)
        {
            $this->aDsn     = $this->_getPANdsn($this->aConfig);
            $this->prefix   = $this->aConfig['table_prefix'];
            $this->engine   = $this->aConfig['table_type'];
            $this->oDbh     = OA_DB::singleton(OA_DB::getDsn($this->aDsn));
        }
    }

    function getPANversion()
    {
        if ($this->detected)
        {
            $query = "SELECT config_version FROM {$this->prefix}config";
            $result = $this->oDbh->queryOne($query);
            if (PEAR::isError($result))
            {
                return false;
            }
            return $result;
        }
        return false;
    }

    function _getPANConfig()
    {
        if (file_exists(MAX_PATH.$this->pathCfg.$this->fileCfg))
        {
            include MAX_PATH.$this->pathCfg.$this->fileCfg;
            if (is_array($phpAds_config))
            {
                $this->detected = true;
                return $phpAds_config;
            }
        }
        return false;
    }

    function _getPANdsn()
    {
        if ($this->detected)
        {
            $aResult['database']['host']        = $this->aConfig['dbhost'];
            $aResult['database']['type']        = 'mysql';
            $aResult['database']['port']        = $this->aConfig['dbport'];
            $aResult['database']['username']    = $this->aConfig['dbuser'];
            $aResult['database']['password']    = $this->aConfig['dbpassword'];
            $aResult['database']['name']        = $this->aConfig['dbname'];
            $aResult['table']['type']           = $this->aConfig['table_type'];
            $aResult['table']['prefix']         = $this->aConfig['table_prefix'];
            return $aResult;
        }
        return false;
    }

    function renamePANConfigFile()
    {
        if (file_exists(MAX_PATH.$this->pathCfg.$this->fileCfg))
        {
            if (copy(MAX_PATH.$this->pathCfg.$this->fileCfg, MAX_PATH.$this->pathCfg.$this->fileCfg.'phpadsnew'))
            {
                unlink(MAX_PATH.$this->pathCfg.$this->fileCfg);
            }
        }
        return (!file_exists(MAX_PATH.$this->pathCfg.$this->fileCfg));
    }


}

?>