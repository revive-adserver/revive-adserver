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
    //var $aPanConfig = false;
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
        $this->aConfig      = $this->_migratePANConfig($this->_getPANConfig());
        if ($this->detected)
        {
            $this->aDsn['database'] = $this->aConfig['database'];
            $this->aDsn['table']    = $this->aConfig['table'];
            $this->prefix   = $this->aConfig['table']['prefix'];
            $this->engine   = $this->aConfig['table']['type'];
            $this->oDbh     = OA_DB::singleton(OA_DB::getDsn($this->aConfig));
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

    function _migratePANConfig($phpAds_config)
    {
        if (is_array($phpAds_config))
        {
            $aResult['max']['uiEnabled'] = $phpAds_config['ui_enabled'];
            $aResult['openads']['requireSSL'] = $phpAds_config['ui_forcessl'];
            $aResult['maintenance']['autoMaintenance'] = $phpAds_config['auto_maintenance'];
            $aResult['logging']['reverseLookup'] = $phpAds_config['reverse_lookup'];
            $aResult['logging']['proxyLookup'] = $phpAds_config['proxy_lookup'];
            $aResult['logging']['adImpressions'] = $phpAds_config['log_adviews'];
            $aResult['logging']['adClicks'] = $phpAds_config['log_adclicks'];
            $aResult['logging']['ignoreHosts'] = join(',', $phpAds_config['ignore_hosts']);
            $aResult['logging']['blockAdImpressions'] = $phpAds_config['block_adviews'];
            $aResult['logging']['blockAdClicks'] = $phpAds_config['block_adclicks'];
            $aResult['p3p']['policies'] = $phpAds_config['p3p_policies'];
            $aResult['p3p']['compactPolicy'] = $phpAds_config['p3p_compact_policy'];
            $aResult['p3p']['policyLocation'] = $phpAds_config['p3p_policy_location'];
            $aResult['delivery']['acls'] = $phpAds_config['acl'];
            $aResult['delivery']['execPhp'] = $phpAds_config['type_html_php'];

            $aResult['database']['host']        = $phpAds_config['dbhost'];
            $aResult['database']['type']        = 'mysql';
            $aResult['database']['port']        = $phpAds_config['dbport'];
            $aResult['database']['username']    = $phpAds_config['dbuser'];
            $aResult['database']['password']    = $phpAds_config['dbpassword'];
            $aResult['database']['name']        = $phpAds_config['dbname'];
            $aResult['database']['persistent']  = $phpAds_config['persistent_connections'];

            $aResult['table']['type']           = $phpAds_config['table_type'];
            $aResult['table']['prefix']         = $phpAds_config['table_prefix'];
            
            return $aResult;
        }
        return array();
    }

    function renamePANConfigFile()
    {
        if (file_exists(MAX_PATH.$this->pathCfg.$this->fileCfg))
        {
            if (copy(MAX_PATH.$this->pathCfg.$this->fileCfg, MAX_PATH.$this->pathCfg.$this->fileCfg.'.AdsNew'))
            {
                unlink(MAX_PATH.$this->pathCfg.$this->fileCfg);
            }
        }
        return (!file_exists(MAX_PATH.$this->pathCfg.$this->fileCfg));
    }


}

?>