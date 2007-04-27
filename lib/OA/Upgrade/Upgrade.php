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
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';

require_once MAX_PATH.'/lib/OA/DB.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradeLogger.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/DB_Upgrade.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/DB_UpgradeAuditor.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradePackageParser.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/VersionController.php');
require_once MAX_PATH.'/lib/OA/Upgrade/EnvironmentManager.php';
require_once MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php';

class OA_Upgrade
{
    var $upgradePath = '';

    var $oLogger;
    var $oParser;
    var $oDBUpgrader;
    var $oVersioner;
    var $oDBAuditor;
    var $oSystemMgr;
    var $oDbh;

    var $aPackage    = array();
    var $aDBPackages = array();
    var $aDsn = array();

    var $versionInitialApplication;
    var $versionInitialSchema = array();

    var $package_file = '';

    function OA_Upgrade()
    {
        $this->upgradePath  = MAX_PATH.'/var/upgrade/';

        $this->oLogger      = new OA_UpgradeLogger();
        $this->oParser      = new OA_UpgradePackageParser();
        $this->oDBUpgrader  = new OA_DB_Upgrade($this->oLogger);
        $this->oDbh         = $this->oDBUpgrader->oSchema->db;
        $this->oDBAuditor   = new OA_DB_UpgradeAuditor();
        $this->oVersioner   = new OA_Version_Controller();
        $this->oVersioner->init($this->oDbh);
        $this->oDBAuditor->init($this->oDbh, $this->oLogger);
        $this->oDBUpgrader->oAuditor = &$this->oDBAuditor;
        $this->oSystemMgr   = new OA_Environment_Manager();

        $this->aDsn['database'] = array();
        $this->aDsn['table']    = array();
        $this->aDsn['database']['type']     = 'mysql';
        $this->aDsn['database']['host']     = 'localhost';
        $this->aDsn['database']['port']     = '3306';
        $this->aDsn['database']['username'] = '';
        $this->aDsn['database']['passowrd'] = '';
        $this->aDsn['database']['name']     = '';
        $this->aDsn['table']['type']        = 'INNODB';
        $this->aDsn['table']['prefix']      = 'oa_';

    }

    function init($input_file, $timing='constructive')
    {
        $logFile = str_replace('.xml', '', $input_file).'_'.$timing.'_'.date('Y_m_d_h_i_s').'.log';
        $this->oLogger->setLogFile($logFile);

        $this->aPackage     = $this->_parseUpgradePackageFile($this->upgradePath.$input_file);
        $this->aDBPackages  = $this->aPackage['db_pkgs'];
    }

    function checkEnvironment()
    {
        $this->oSystemMgr->getAllInfo();
    }

    function upgrade()
    {
        if ($this->upgradeSchemas())
        {
            if (!$this->oVersioner->putApplicationVersion(OA_VERSION))
            {
                return false;
            }
            $this->oLogger->log('Application version updated to '. OA_VERSION);
            return true;
        }
        return false;
    }

    function upgradeSchemas()
    {
        foreach ($this->aDBPackages as $k=>$aPkg)
        {
            if (!array_key_exists($aPkg['schema'],$this->versionInitialSchema))
            {
                $this->versionInitialSchema[$aPkg['schema']] = $this->oVersioner->getSchemaVersion($aPkg['schema']);
            }
            if ($this->oDBUpgrader->init($timing, $aPkg['schema'], $aPkg['version']))
            {
                if ($this->oDBUpgrader->upgrade())
                {
                    $this->oVersioner->putSchemaVersion($aPkg['schema'], $aPkg['version']);
                }
                else
                {
                    $this->rollbackSchemas();
                    return false;
                }
            }
        }
        return true;
    }

    function rollbackSchemas()
    {
        foreach ($this->versionInitialSchema AS $schema => $version)
        {
            if ($this->oVersioner->getSchemaVersion($schema) != $version)
            {
                if ($this->oDBUpgrader->init($timing, $schema, $version))
                {
                    if ($this->oDBUpgrader->rollback())
                    {
                        $this->oVersioner->putSchemaVersion($schema, $version);
                    }
                    else
                    {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    function _parseUpgradePackageFile($input_file)
    {
        $result = $this->oParser->setInputFile($input_file);
        if (PEAR::isError($result)) {
            return $result;
        }

        $result = $this->oParser->parse();
        if (PEAR::isError($result)) {
            return $result;
        }
        if (PEAR::isError($this->oParser->error)) {
            return $this->oParser->error;
        }

        return $this->oParser->aPackage;
    }

    function _getPackageList()
    {
        $aFiles = array();
        $dh = opendir($this->upgradePath);
        if ($dh) {
            while (false !== ($file = readdir($dh)))
            {
                $aMatches = array();
                if (preg_match('/openads_upgrade_[\w\W\d]+_to_([\w\W\d])+\.xml/', $file, $aMatches))
                {
                    $aFiles[] = $file;
                }
            }
        }
        closedir($dh);
        return $aFiles;
    }

    /**
     * Open each changeset and determine the version and timings
     *
     * @return boolean
     */
    function _compileChangesetInfo()
    {
        $this->aChangesetList = $this->_getChangesetList();
        foreach ($this->aChangesetList as $version=>$aFiles)
        {
            $file       = MAX_PATH.'/etc/changes/'.$aFiles['changeset'];
            $aChanges   = $this->oDBUpgrader->oSchema->parseChangesetDefinitionFile($file);
            if (!$this->_isPearError($aChanges, "failed to parse changeset ({$file})"))
            {
                $this->_log('changeset found in file: '.$file);
                $this->_log('name: '.$aChanges['name']);
                $this->_log('version: '.$aChanges['version']);
                $this->_log('comments: '.$aChanges['comments']);
                $this->_log(($aChanges['constructive'] ? 'constructive changes found' : 'constructive changes not found'));
                $this->_log(($aChanges['destructive'] ? 'destructive changes found' : 'destructive changes not found'));
            }
            else
            {
                return false;
            }
        }
        return true;
    }
    /**
     * Open each changeset and determine the version and timings
     *
     * @return boolean
     */
    function _checkChangesetAudit($schema)
    {
        $aResult = $this->oDBAuditor->queryAudit('', '', $schema, DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED);
        if ($aResult)
        {
            foreach ($aResult as $k=>$v)
            {
                $this->oLogger->log($v['schema_name'].' upgraded to version '.$v['version'].' on '.$v['updated']);
            }
        }
        return true;
    }

    function detectOpenads()
    {
        $oPAN = new OA_phpAdsNew();
        $oPAN->init();
        if ($oPAN->detected)
        {
            $this->versionInitialApplication = $oPAN->getPANversion();
            if ($this->versionInitialApplication) // its PAN
            {
                $valid = (version_compare($this->versionInitialApplication,'200.312')>=0);
                if ($valid)
                {
                    $this->package_file = 'openads_upgrade_2.0.12_to_2.3.32_beta.xml';
                    $this->aDsn         = $oPAN->aDsn;
                }
                $this->oLogger->log('phpAdsNew '.$this->versionInitialApplication).' detected';
                return true;
            }
        }
        if (file_exists(MAX_PATH . '/var/INSTALLED'))
        {
            $this->versionInitialApplication = $this->oVersioner->getApplicationVersion('max');
            if ($this->versionInitialApplication) // its MAX
            {
                $valid = (version_compare($this->versionInitialApplication,'v0.3.31-alpha')>=0);
                if ($valid)
                {
                    $this->package_file     = 'openads_upgrade_2.3.31_to_2.3.32_beta.xml';
                    $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                    $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
                }
                $this->oLogger->log('Max Media Manager '.$this->versionInitialApplication.' detected');
                return true;
            }
        }
        $this->versionInitialApplication = $this->oVersioner->getApplicationVersion();
        if ($this->versionInitialApplication) // its openads
        {
            $valid = (version_compare($this->versionInitialApplication,OA_VERSION)>=0);
            if ($valid)
            {
                $this->package_file     = 'openads_upgrade_2.3.32_to_2.3.33_beta.xml';
                $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
            }
            $this->oLogger->log('Openads '.$this->versionInitialApplication.' detected');
            return true;
        }
        $this->versionInitialApplication = '0';
        $this->oLogger->log('Openads not detected');
        return false;
    }

    function getMessages()
    {
        return $this->oLogger->aMessages;
    }

    function getErrors()
    {
        return $this->oLogger->aErrors;
    }

    /**
     * compile a list of changesets available in /etc/changes
     * could be used for a changeset manager
     *
     *
     * @return array
     */
    /*
    function _getChangesetList($schema)
    {
        $aFiles = array();
        $dh = opendir(MAX_PATH.'/etc/changes');
        if ($dh) {
            while (false !== ($file = readdir($dh)))
            {
                $aMatches = array();
                if (preg_match("/schema_{$schema}_([\d])+\.xml/", $file, $aMatches))
                {
                    $version = $aMatches[1];
                    $fileSchema = basename($file);
                    $aFiles[$version] = array();
                    $fileChanges = str_replace('schema', 'changes', $fileSchema);
                    $fileMigrate = str_replace('schema', 'migration', $fileSchema);
                    $fileMigrate = str_replace('xml', 'php', $fileMigrate);
                    if (!file_exists(MAX_CHG.$fileChanges))
                    {
                        $fileChanges = 'not found';
                    }
                    $aFiles[$version]['changeset'] = $fileChanges;
                    if (!file_exists(MAX_CHG.$fileMigrate))
                    {
                        $fileMigrate = 'not found';
                    }
                    $aFiles[$version]['migration'] = $fileMigrate;
                    $aFiles[$version]['schema'] = $fileSchema;
                }
            }
        }
        closedir($dh);
        return $aFiles;
    }
    */

}

?>