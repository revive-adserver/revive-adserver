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
$Id$
*/

define('OA_STATUS_NOT_INSTALLED',          -1);
define('OA_STATUS_CURRENT_VERSION',         0);
define('OA_STATUS_PAN_NOT_INSTALLED',      -1);
define('OA_STATUS_PAN_CONFIG_DETECTED',     1);
define('OA_STATUS_PAN_DBCONNECT_FAILED',    2);
define('OA_STATUS_PAN_VERSION_FAILED',      3);
define('OA_STATUS_PAN_DBINTEG_FAILED',      5);
define('OA_STATUS_M01_NOT_INSTALLED',      -1);
define('OA_STATUS_M01_CONFIG_DETECTED',     1);
define('OA_STATUS_M01_DBCONNECT_FAILED',    2);
define('OA_STATUS_M01_VERSION_FAILED',      3);
define('OA_STATUS_M01_DBINTEG_FAILED',      5);
define('OA_STATUS_MAX_NOT_INSTALLED',      -1);
define('OA_STATUS_MAX_CONFIG_DETECTED',     1);
define('OA_STATUS_MAX_DBCONNECT_FAILED',    2);
define('OA_STATUS_MAX_VERSION_FAILED',      3);
define('OA_STATUS_MAX_DBINTEG_FAILED',      5);
define('OA_STATUS_OAD_NOT_INSTALLED',      -1);
define('OA_STATUS_OAD_CONFIG_DETECTED',     1);
define('OA_STATUS_OAD_DBCONNECT_FAILED',    2);
define('OA_STATUS_OAD_VERSION_FAILED',      3);
define('OA_STATUS_OAD_DBINTEG_FAILED',      5);
define('OA_STATUS_CAN_UPGRADE',            10);


require_once 'MDB2.php';
require_once 'MDB2/Schema.php';

require_once MAX_PATH.'/lib/OA/DB.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradeLogger.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/DB_Upgrade.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradeAuditor.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/DB_UpgradeAuditor.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/UpgradePackageParser.php');
require_once(MAX_PATH.'/lib/OA/Upgrade/VersionController.php');
require_once MAX_PATH.'/lib/OA/Upgrade/EnvironmentManager.php';
require_once MAX_PATH.'/lib/OA/Upgrade/phpAdsNew.php';
require_once(MAX_PATH.'/lib/OA/Upgrade/Configuration.php');
require_once MAX_PATH.'/lib/OA/Upgrade/DB_Integrity.php';

/**
 * Openads Upgrade Class
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 */
class OA_Upgrade
{
    var $upgradePath = '';

    var $message = '';

    var $oLogger;
    var $oParser;
    var $oDBUpgrader;
    var $oVersioner;
    var $oAuditor;
    var $oSystemMgr;
    var $oDbh;
    var $oPAN;
    var $oConfiguration;
    var $oIntegrity;

    var $aPackageList = array();
    var $aPackage     = array();
    var $aDBPackages  = array();
    var $aDsn         = array();

    var $versionInitialApplication;
    var $versionInitialSchema = array();
    var $versionInitialAppOpenads;

    var $package_file = '';
    var $recoveryFile;

    var $can_drop_database = false;

    var $existing_installation_status = OA_STATUS_NOT_INSTALLED;
    var $upgrading_from_milestone_version = false;

    function OA_Upgrade()
    {
        $this->upgradePath  = MAX_PATH.'/etc/changes/';
        $this->recoveryFile = MAX_PATH.'/var/recover.log';

        $this->oLogger      = new OA_UpgradeLogger();
        $this->oParser      = new OA_UpgradePackageParser();
        $this->oDBUpgrader  = new OA_DB_Upgrade($this->oLogger);
        $this->oAuditor     = new OA_UpgradeAuditor();
        $this->oVersioner   = new OA_Version_Controller();
        $this->oPAN         = new OA_phpAdsNew();
        $this->oSystemMgr   = new OA_Environment_Manager();
        $this->oConfiguration = new OA_Upgrade_Config();
        $this->oTable       = new OA_DB_Table();
        $this->oIntegrity   = new OA_DB_Integrity();

        $this->oDBUpgrader->path_changes = $this->upgradePath;

        $this->aDsn['database'] = array();
        $this->aDsn['table']    = array();
        $this->aDsn['database']['type']     = 'mysql';
        $this->aDsn['database']['host']     = 'localhost';
        $this->aDsn['database']['port']     = '3306';
        $this->aDsn['database']['username'] = '';
        $this->aDsn['database']['passowrd'] = '';
        $this->aDsn['database']['name']     = '';
        $this->aDsn['table']['type']        = 'InnoDB';
        $this->aDsn['table']['prefix']      = 'oa_';
    }

    /**
     * initialise a database connection
     * hook up the various components with a db object
     *
     * @param array $dsn
     * @return boolean
     */
    function initDatabaseConnection($dsn=null)
    {
        if (is_null($this->oDbh))
        {
            //$this->oDbh = OA_DB::singleton($dsn);
            $this->oDbh = OA_DB::singleton(OA_DB::getDsn());
        }
        if (PEAR::isError($this->oDbh))
        {
            $this->oLogger->log($this->oDbh->getMessage());
            $this->oDbh = null;
            return false;
        }
        if (!$this->oDbh)
        {
            $this->oLogger->log('Unable to connect to database');
            $this->oDbh = null;
            return false;
        }
        $this->oTable->oDbh = $this->oDbh;
        $this->oDBUpgrader->initMDB2Schema();
        $this->oVersioner->init($this->oDbh);
        $this->oAuditor->init($this->oDbh, $this->oLogger);
        $this->oDBUpgrader->oAuditor = &$this->oAuditor->oDBAuditor;
        $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
        $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
        return true;
    }

    /**
     * add any needed database parameter to the config array
     *
     * @param array $aConfig
     *
     * @return array
     */
    function initDatabaseParameters($aConfig)
    {
        // Check if we need to ensure to enable MySQL 4 compatibility
        if (strcasecmp($aConfig['database']['type'], 'mysql') === 0) {
            $result = $this->oDbh->exec("SET SESSION sql_mode='MYSQL40'");
            $aConfig['database']['mysql4_compatibility'] = !PEAR::isError($result);
        }

        return $aConfig;
    }

    /**
     * see the recovery file and ye may findeth
     *
     * @return boolean
     */
    function isRecoveryRequired()
    {
        return $this->seekRecoveryFile();
    }

    /**
     * execute the db_upgrade recovery method
     *
     * @return unknown
     */
    function recoverUpgrade()
    {
        $this->aDBPackages = $this->seekRecoveryFile();
        $this->detectPAN();
        $this->detectMAX01();
        $this->detectMAX();
        if (!$this->initDatabaseConnection())
        {
            return false;
        }
        if (!$this->rollbackSchemas())
        {
            return false;
        }
        $this->_pickupRecoveryFile();
        return true;
    }

    /**
     * return an array of system environment info
     *
     * @return array
     */
    function checkEnvironment()
    {
        return $this->oSystemMgr->checkSystem();
    }

    function getProductApplicationVersion()
    {
        switch ($this->versionInitialApplication)
        {
            case '' :
                return 'unknown version';
            case '0.100' :
                return '2.1.29-rc';
            case '200.313' :
            case '200.314' :
                return '2.0.11-pr1';
            case 'v0.3.31-alpha' :
                return '2.3.31-alpha';
            default :
                return $this->versionInitialApplication;
        }
    }

    /**
     * look for existing installations (phpAdsNew, MMM, Openads)
     * retrieve details and check for errors
     *
     * @return boolean
     */
    function canUpgrade()
    {
        $strDetected       = ' configuration file detected';
        $strCanUpgrade     = 'This version can be upgraded';
        $strNoConnect      = 'Could not connect to the database';
        $strConnected      = 'Connected to the database ok';
        $strNoUpgrade      = 'This version cannot be upgraded';
        $strTableError     = 'Error accessing Database Tables';

        $this->oLogger->logClear();
        $this->detectPAN();
        $strProductName = MAX_PRODUCT_NAME.' '.$this->getProductApplicationVersion();
        switch ($this->existing_installation_status)
        {
            case OA_STATUS_PAN_NOT_INSTALLED:
                break;
            case OA_STATUS_PAN_CONFIG_DETECTED:
                $this->oLogger->logError($strProductName.$strDetected);
                break;
            case OA_STATUS_PAN_DBCONNECT_FAILED:
                $this->oLogger->logError($strProductName.$strDetected);
                $this->oLogger->logError($strNoConnect.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                break;
            case OA_STATUS_PAN_VERSION_FAILED:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->log($strConnected.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                break;
            case OA_STATUS_PAN_DBINTEG_FAILED:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->log($strConnected.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                return false;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }

        $this->detectMAX01();
        $strProductName = MAX_PRODUCT_NAME.' '.$this->getProductApplicationVersion();
        switch ($this->existing_installation_status)
        {
            case OA_STATUS_M01_NOT_INSTALLED:
                break;
            case OA_STATUS_M01_CONFIG_DETECTED:
                $this->oLogger->logError($strProductName.$strDetected);
                break;
            case OA_STATUS_M01_DBCONNECT_FAILED:
                $this->oLogger->logError($strProductName.$strDetected);
                $this->oLogger->logError($strNoConnect.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                break;
            case OA_STATUS_M01_DBINTEG_FAILED:
                return false;
            case OA_STATUS_M01_VERSION_FAILED:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->logError($strConnected.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                break;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }

        $this->detectMAX();
        $strProductName = MAX_PRODUCT_NAME.' '.$this->getProductApplicationVersion();
        switch ($this->existing_installation_status)
        {
            case OA_STATUS_MAX_NOT_INSTALLED:
                break;
            case OA_STATUS_MAX_CONFIG_DETECTED:
                $this->oLogger->logError($strProductName.$strDetected);
                break;
            case OA_STATUS_MAX_DBCONNECT_FAILED:
                $this->oLogger->logError($strProductName.$strDetected);
                $this->oLogger->logError($strNoConnect.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                break;
            case OA_STATUS_MAX_DBINTEG_FAILED:
                return false;
            case OA_STATUS_MAX_VERSION_FAILED:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->logError($strConnected.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                break;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }

        $this->detectOpenads();
        $strProductName = MAX_PRODUCT_NAME.' '.$this->getProductApplicationVersion();
        switch ($this->existing_installation_status)
        {
            case OA_STATUS_OAD_NOT_INSTALLED:
                if (!$this->oLogger->errorExists)
                {
                    $this->oLogger->log('No previous version of Openads detected');
                    return true;
                }
                break;
            case OA_STATUS_OAD_CONFIG_DETECTED:
                $this->oLogger->logError('Openads'.$strDetected);
                break;
            case OA_STATUS_OAD_DBCONNECT_FAILED:
                $this->oLogger->logError('Openads'.$strDetected);
                $this->oLogger->logError($strNoConnect.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                return false;
            case OA_STATUS_OAD_DBINTEG_FAILED:
                return false;
            case OA_STATUS_OAD_VERSION_FAILED:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->logError($strConnected.' : '.$GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                return false;
            case OA_STATUS_CURRENT_VERSION:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->log('This version is up to date.');
                return false;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log($strProductName.' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }
        return false;
    }

    /**
     * check existance of upgrade package file
     *
     * @return boolean
     */
    function checkUpgradePackage()
    {
        if ($this->package_file)
        {
            if (!file_exists($this->upgradePath.$this->package_file))
            {
                $this->oLogger->logError('Upgrade package file '.$this->package_file.' NOT found');
                return false;
            }
            return true;
        }
        else if ($this->existing_installation_status == OA_STATUS_NOT_INSTALLED)
        {
            return true;
        }
        $this->oLogger->logError('No upgrade package file specified');
        return false;
    }

    /**
     * search for an existing phpAdsNew installation
     *
     * @param string $skipIntegrityCheck If true the integrity test is skipped
     * @return boolean
     */
    function detectPAN($skipIntegrityCheck = false)
    {
        $this->oPAN->init();
        if ($this->oPAN->detected)
        {
            $GLOBALS['_MAX']['CONF']['database'] = $this->oPAN->aDsn['database'];
            $GLOBALS['_MAX']['CONF']['table']    = $this->oPAN->aDsn['table'];
            $this->existing_installation_status = OA_STATUS_PAN_CONFIG_DETECTED;
            if (PEAR::isError($this->oPAN->oDbh))
            {
                $this->existing_installation_status = OA_STATUS_PAN_DBCONNECT_FAILED;
                return false;
            }
            $this->oDbh = & $this->oPAN->oDbh;
            if (!$this->initDatabaseConnection())
            {
                $this->existing_installation_status = OA_STATUS_PAN_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oPAN->getPANversion();
            if (!$this->versionInitialApplication)
            {
                $this->existing_installation_status = OA_STATUS_PAN_VERSION_FAILED;
                return false;
            }
            $valid = ( (version_compare($this->versionInitialApplication,'200.313')==0)
                      ||
                       (version_compare($this->versionInitialApplication,'200.314')==0)
                     );
            if ($valid)
            {
                $this->versionInitialSchema['tables_core'] = '099';
                if (!$this->initDatabaseConnection())
                {
                    $this->existing_installation_status = OA_STATUS_PAN_DBCONNECT_FAILED;
                    return false;
                }
                if (!$skipIntegrityCheck && !$this->_checkDBIntegrity($this->versionInitialSchema['tables_core']))
                {
                    $this->existing_installation_status = OA_STATUS_PAN_DBINTEG_FAILED;
                    return false;
                }
                $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                $this->aPackageList[0] = 'openads_upgrade_2.0.11_to_2.3.32_beta.xml';
                $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
                $this->upgrading_from_milestone_version = true;
                return true;
            }
            // if its not a max 0.1 installation
            if (!version_compare($this->versionInitialApplication,'200.000')<0)
            {
                $this->existing_installation_status = OA_STATUS_PAN_VERSION_FAILED;
                return false;
            }
        }
        $this->existing_installation_status = OA_STATUS_PAN_NOT_INSTALLED;
        return false;
    }

    /**
     * search for an existing MMM 0.1 installation
     * very similar to a PAN installation with config.inc.php and config table
     * schema is half way between PAN and MAX
     *
     * @param string $skipIntegrityCheck If true the integrity test is skipped
     * @return boolean
     */
    function detectMAX01($skipIntegrityCheck = false)
    {
        $this->oPAN->init();
        if ($this->oPAN->detected)
        {
            $GLOBALS['_MAX']['CONF']['database'] = $this->oPAN->aDsn['database'];
            $GLOBALS['_MAX']['CONF']['table']    = $this->oPAN->aDsn['table'];
            $this->existing_installation_status = OA_STATUS_M01_CONFIG_DETECTED;
            if (PEAR::isError($this->oPAN->oDbh))
            {
                $this->existing_installation_status = OA_STATUS_M01_DBCONNECT_FAILED;
                return false;
            }
            $this->oDbh = & $this->oPAN->oDbh;
            if (!$this->initDatabaseConnection())
            {
                $this->existing_installation_status = OA_STATUS_M01_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oPAN->getPANversion();
            if (!$this->versionInitialApplication)
            {
                $this->existing_installation_status = OA_STATUS_M01_VERSION_FAILED;
                return false;
            }

            $valid = (version_compare($this->versionInitialApplication,'0.100')==0);
            if ($valid)
            {
                $this->versionInitialSchema['tables_core'] = '300';
                if (!$this->initDatabaseConnection())
                {
                    $this->existing_installation_status = OA_STATUS_M01_DBCONNECT_FAILED;
                    return false;
                }
                if (!$skipIntegrityCheck && !$this->_checkDBIntegrity($this->versionInitialSchema['tables_core']))
                {
                    $this->existing_installation_status = OA_STATUS_M01_DBINTEG_FAILED;
                    return false;
                }
                $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                $this->aPackageList[0] = 'openads_upgrade_2.1.29_to_2.3.32_beta.xml';
                $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
                $this->upgrading_from_milestone_version = true;
                return true;
            }
            $this->existing_installation_status = OA_STATUS_M01_VERSION_FAILED;
            return false;
        }
        $this->existing_installation_status = OA_STATUS_PAN_NOT_INSTALLED;
        return false;
    }

    /**
     * search for an existing Max Media Manager installation
     *
     * @param string $skipIntegrityCheck If true the integrity test is skipped
     * @return boolean
     */
    function detectMAX($skipIntegrityCheck = false)
    {
        if ($GLOBALS['_MAX']['CONF']['max']['installed'])
        {
            $this->existing_installation_status = OA_STATUS_MAX_CONFIG_DETECTED;
            if (!$this->initDatabaseConnection())
            {
                $this->existing_installation_status = OA_STATUS_MAX_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oVersioner->getApplicationVersion('max');
            if (!$this->versionInitialApplication)
            {
                $this->existing_installation_status = OA_STATUS_MAX_VERSION_FAILED;
                return false;
            }
            $valid = (version_compare($this->versionInitialApplication,'v0.3.31-alpha')==0);
            if ($valid)
            {
                $this->versionInitialSchema['tables_core'] = '500';
                if (!$skipIntegrityCheck && !$this->_checkDBIntegrity($this->versionInitialSchema['tables_core']))
                {
                    $this->existing_installation_status = OA_STATUS_MAX_DBINTEG_FAILED;
                    return false;
                }
                $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                $this->aPackageList[0]  = 'openads_upgrade_2.3.31_to_2.3.32_beta.xml';
                $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
                $this->upgrading_from_milestone_version = true;
                return true;
            }
            $this->existing_installation_status = OA_STATUS_MAX_VERSION_FAILED;
            return false;
        }
        $this->existing_installation_status = OA_STATUS_MAX_NOT_INSTALLED;
        return false;
    }

    function _checkDBIntegrity($version)
    {
        $path_schema = $this->oDBUpgrader->path_schema;
        $file_schema = $this->oDBUpgrader->file_schema;
        $path_changes = $this->oDBUpgrader->path_changes;
        $file_changes = $this->oDBUpgrader->file_changes;

//        require_once MAX_PATH.'/lib/OA/Upgrade/DB_Integrity.php';
//        $oIntegrity = new OA_DB_Integrity();
        $this->oIntegrity->oUpgrader = $this;
        $result =$this->oIntegrity->checkIntegrityQuick($version);

        $this->oDBUpgrader->path_schema     = $path_schema;
        $this->oDBUpgrader->file_schema     = $file_schema;
        $this->oDBUpgrader->path_changes    = $path_changes;
        $this->oDBUpgrader->file_changes    = $file_changes;

        if (!$result)
        {
            $this->oLogger->logError('database integrity check could not complete due to problems');
            return false;
        }
        $this->oLogger->logClear();
        if (count($this->oIntegrity->aTasksConstructiveAll)>0)
        {
            $this->oLogger->logError('database integrity check detected problems with the database');
            foreach ($this->oIntegrity->aTasksConstructiveAll AS $elem => $aTasks)
            {
                foreach ($aTasks AS $task => $aItems)
                {
                    $this->oLogger->logError(count($aItems).' '.$elem.' to '.$task);
                }
            }
            return false;
        }
        return true;
    }


    /**
     * search for an existing Openads installation
     * WORK IN PROGRESS
     *
     * @param string $skipIntegrityCheck If true the integrity test is skipped
     * @return boolean
     */
    function detectOpenads($skipIntegrityCheck = false)
    {
        if ($GLOBALS['_MAX']['CONF']['openads']['installed'])
        {
            $this->existing_installation_status = OA_STATUS_CONFIG_FOUND;
            if (!$this->initDatabaseConnection())
            {
                $this->existing_installation_status = OA_STATUS_MAX_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oVersioner->getApplicationVersion();
            if (!$this->versionInitialApplication)
            {
                $this->existing_installation_status = OA_STATUS_OAD_VERSION_FAILED;
                return false;
            }
            $current = (version_compare($this->versionInitialApplication,OA_VERSION)==0);
            $valid   = (version_compare($this->versionInitialApplication,OA_VERSION)<0);
            if ($valid)
            {
                $this->aPackageList = $this->getUpgradePackageList($this->versionInitialApplication, $this->_readUpgradePackagesArray());
                if (!$skipIntegrityCheck && count($this->aPackageList)>0)
                {
                    $this->versionInitialSchema['tables_core'] = $this->oVersioner->getSchemaVersion('tables_core');
                    if (!$this->_checkDBIntegrity($this->versionInitialSchema['tables_core']))
                    {
                        $this->existing_installation_status = OA_STATUS_OAD_DBINTEG_FAILED;
                        return false;
                    }
                }
                $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                $this->aDsn['table']    = $GLOBALS['_MAX']['CONF']['table'];
                $this->upgrading_from_milestone_version = false;
                return true;
            }
            else if ($current)
            {
                $this->existing_installation_status = OA_STATUS_CURRENT_VERSION;
                $this->aPackageList = array();
                return false;
            }
            $this->existing_installation_status = OA_STATUS_OAD_VERSION_FAILED;
            return false;
        }
        $this->existing_installation_status = OA_STATUS_OAD_NOT_INSTALLED;
        return false;
    }

    /**
     * execute the installation steps
     *
     * @return boolean
     */
    function install($aConfig)
    {
        $this->oLogger->setLogFile('install.log');
        $this->oLogger->deleteLogFile();
        $this->aDsn['database'] = $aConfig['database'];
        $this->aDsn['table']    = $aConfig['table'];

        $this->oLogger->log('Installation started '.OA::getNow());
        $this->oLogger->log('Attempting to connect to database '.$this->aDsn['database']['name'].' with user '.$this->aDsn['database']['username']);

        if (!$this->_createDatabase())
        {
            $this->oLogger->logError('Installation failed to create the database '.$this->aDsn['database']['name']);
            return false;
        }
        $this->oLogger->log('Connected to database '.$this->oDbh->connected_database_name);

        if (!$this->checkExistingTables())
        {
            if (!$this->oLogger->errorExists)
            {
                $this->oLogger->logError();
            }
            return false;
        }

        if (!$this->checkPermissionToCreateTable())
        {
            $this->oLogger->logError('Insufficient database permissions to install');
            return false;
        }

        if (!$this->initDatabaseConnection())
        {
            $this->oLogger->logError('Installation failed to connect to the database '.$this->aDsn['database']['name']);
            $this->_dropDatabase();
            return false;
        }

        $aConfig = $this->initDatabaseParameters($aConfig);

        if (!$this->createCoreTables())
        {
            $this->oLogger->logError('Installation failed to create the core tables');
            $this->_dropDatabase();
            return false;
        }
        $this->oLogger->log('Installation created the core tables');

        $this->oAuditor->setKeyParams(array('upgrade_name'=>'install_'.OA_VERSION,
                                            'version_to'=>OA_VERSION,
                                            'version_from'=>0,
                                            'logfile'=>basename($this->oLogger->logFile)
                                            )
                                     );

        if (!$this->oVersioner->putSchemaVersion('tables_core', $this->oTable->aDefinition['version']))
        {
            $this->_auditInstallationFailure('Installation failed to update the schema version to '.$oTable->aDefinition['version']);
            $this->_dropDatabase();
            return false;
        }
        $this->oLogger->log('Installation updated the schema version to '.$this->oTable->aDefinition['version']);

        if (!$this->oVersioner->putApplicationVersion(OA_VERSION))
        {
            $this->_auditInstallationFailure('Installation failed to update the application version to '.OA_VERSION);
            $this->_dropDatabase();
            return false;
        }
        $this->oLogger->log('Installation updated the application version to '.OA_VERSION);

        $this->oConfiguration->getInitialConfig();
        if (!$this->saveConfigDB($aConfig))
        {
            $this->_auditInstallationFailure('Installation failed to write database details to the configuration file '.$this->oConfiguration->configFile);
            if (file_exists($this->oConfiguration->configPath.$this->oConfiguration->configFile))
            {
                unlink($this->oConfiguration->configPath.$this->oConfiguration->configFile);
                $this->oLogger->log('Installation deleted the configuration file '.$this->oConfiguration->configFile);
            }
            $this->_dropDatabase();
            return false;
        }
        $this->oAuditor->logUpgradeAction(array('description'=>'COMPLETE',
                                                'action'=>UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                               )
                                         );
        return true;
    }

    function _auditInstallationFailure($msg)
    {
        $this->oLogger->logError($msg);
        $this->oAuditor->logUpgradeAction(array('description'=>'FAILED',
                                                'action'=>UPGRADE_ACTION_UPGRADE_FAILED,
                                                )
                                         );
    }

    /**
     * remove the currently connected database
     *
     * @param boolean $log
     */
    function _dropDatabase($log = true)
    {
        if ($this->can_drop_database)
        {
            if (OA_DB::dropDatabase($this->aDsn['database']['name']))
            {
                if ($log)
                {
                    $this->oLogger->log('Installation dropped the database '.$this->aDsn['database']['name']);
                }
                return true;
            }
            $this->oLogger->logError('Installation failed to drop the database '.$this->aDsn['database']['name']);
            return false;
        }
        else
        {
            $this->oTable->dropAllTables();
            if ($log)
            {
                $this->oLogger->log('Installation dropped the core tables from database '.$this->aDsn['database']['name']);
            }
            return true;
        }
    }

    /**
     * create the empty database
     *
     * @return boolean
     */
    function _createDatabase()
    {
        $GLOBALS['_MAX']['CONF']['database']          = $this->aDsn['database'];
        $GLOBALS['_MAX']['CONF']['table']['prefix']   = $this->aDsn['table']['prefix'];
        $GLOBALS['_MAX']['CONF']['table']['type']     = $this->aDsn['table']['type'];
        $this->oDbh = &OA_DB::singleton(OA_DB::getDsn($this->aDsn));
        if (PEAR::isError($this->oDbh))
        {
            $GLOBALS['_OA']['CONNECTIONS']  = array();
            $GLOBALS['_MDB2_databases']     = array();

            $result = OA_DB::createDatabase($this->aDsn['database']['name']);
            if (PEAR::isError($result))
            {
                $this->oLogger->logError($result->getMessage());
                return false;
            }
            $this->oDbh = OA_DB::changeDatabase($this->aDsn['database']['name']);
            if (PEAR::isError($this->oDbh))
            {
                $this->oLogger->logError($this->oDbh->getMessage());
                $this->oDbh = null;
                return false;
            }
            $this->oLogger->log('Database created '.$this->aDsn['database']['name']);
            $this->can_drop_database = true;
        }

        $result = OA_DB::createFunctions();
        if (PEAR::isError($result)) {
            $this->oLogger->logError($result->getMessage());
            return false;
        }

        return true;
    }

    /**
     * create the tables_core schema in the database
     *
     * @return boolean
     */
    function createCoreTables()
    {
        if ($this->oTable->init(MAX_PATH.'/etc/tables_core.xml'))
        {
            $this->oTable->dropAllTables();
            return $this->oTable->createAllTables();
        }
        return false;
    }

    function setOpenadsInstalledOn()
    {
        $this->oConfiguration->setOpenadsInstalledOn();
    }

    /**
     * retrieve the configuration settings
     *
     * @return array
     */
    function getConfig()
    {
        if (!$GLOBALS['_MAX']['CONF']['max']['installed'])
        {
            $this->oConfiguration->getInitialConfig();
        }
        return $this->oConfiguration->aConfig;
    }

    /**
     * save database configuration settings
     *
     * @param array $aConfig
     * @return boolean
     */
    function saveConfigDB($aConfig)
    {
        $this->oConfiguration->setupConfigDatabase($aConfig['database']);
        $this->oConfiguration->setupConfigTable($aConfig['table']);
        return $this->oConfiguration->writeConfig();
    }

    /**
     * save configuration settings
     *
     * @param array $aConfig
     * @return boolean
     */
    function saveConfig($aConfig)
    {
        $this->oConfiguration->setupConfigWebPath($aConfig['webpath']);

        // Don't reparse the config file to prevent constants being parsed.
        $this->oConfiguration->writeConfig(false);
        $aConfig['database'] = $GLOBALS['_MAX']['CONF']['database'];
        $aConfig['table'] = $GLOBALS['_MAX']['CONF']['table'];
        $this->oConfiguration->setupConfigDatabase($aConfig['database']);
        $this->oConfiguration->setupConfigTable($aConfig['table']);
        $this->oConfiguration->setupConfigTimezone($aConfig['timezone']);
        $this->oConfiguration->setupConfigStore($aConfig['store']);
        $this->oConfiguration->setupConfigMax($aConfig['max']);
        $this->oConfiguration->setupConfigPriority('');
        return $this->oConfiguration->writeConfig();
    }

    /**
     * prepare to execute the upgrade steps
     * assumes that you have run canUpgrade first (to detect install and determine versionInitialApplication)
     *
     * @return boolean
     */
    function upgrade($input_file='', $timing='constructive')
    {
//        $this->oLogger->setLogFile($this->_getUpgradeLogFileName($timing));
//        $this->oDBUpgrader->logFile = $this->oLogger->logFile;

        // initialise database connection if necessary
        if (is_null($this->oDbh))
        {
            $this->initDatabaseConnection();
            // ensure db user has db permissions
        }
        if (!$this->checkPermissionToCreateTable())
        {
            $this->oLogger->logError('Insufficient database permissions');
            return false;
        }
        $version_from = $this->getProductApplicationVersion();

        // first deal with each of the packages in the list
        // that was compiled during detection
        if (count($this->aPackageList)>0)
        {
            foreach ($this->aPackageList AS $k => $this->package_file)
            {
                if (!$this->upgradeExecute($this->package_file))
                {
                    $halt = true;
                    break;
                }
            }
        }
        if ($halt)
        {
            return false;
        }
        // when upgrading from a milestone version such as pan or max
        // run through this upgrade again
        if ($this->upgrading_from_milestone_version)
        {
            // if openads installed was not on
            // set installed on so openads can be detected
            $GLOBALS['_MAX']['CONF']['openads']['installed'] = 1;
            if ($this->detectOpenads())
            {
                if (!$this->upgrade())
                {
                    return false;
                }
            }
        }
        else
        {
            $this->oAuditor->setKeyParams(array('upgrade_name'=>'version stamp',
                                                'version_to'=>OA_VERSION,
                                                'version_from'=>$version_from,
                                                'logfile'=>basename($this->oLogger->logFile)
                                                )
                                         );
            if (!$this->_upgradeConfig())
            {
                // put the old config back if merge failed?
                $this->_auditUpgradeFailure('Failed to upgrade configuration file');
                return false;
            }
            if ($this->versionInitialApplication != OA_VERSION)
            {
                if (!$this->oVersioner->putApplicationVersion(OA_VERSION))
                {
                    $this->_auditUpgradeFailure('Failed to update application version to '.OA_VERSION);
                    $this->message = 'Failed to update application version to '.OA_VERSION;
                    return false;
                }
                $this->versionInitialApplication = $this->oVersioner->getApplicationVersion();
                $this->oLogger->log('Application version updated to '. OA_VERSION);
            }
            $this->oAuditor->logUpgradeAction(array('description'=>'COMPLETE',
                                                    'action'=>UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                                    'confbackup'=>$this->oConfiguration->getConfigBackupName()
                                                   )
                                             );
        }
        return true;
    }

    function _auditUpgradeFailure($msg)
    {
        $this->oLogger->logError($msg);
        $this->oAuditor->logUpgradeAction(array('description'=>'FAILED',
                                                'action'=>UPGRADE_ACTION_UPGRADE_FAILED,
                                                )
                                         );
    }

    function _upgradeConfig()
    {
        $aConfig['database'] = $GLOBALS['_MAX']['CONF']['database'];
        $aConfig['table']    = $GLOBALS['_MAX']['CONF']['table'];
        $aConfig             = $this->initDatabaseParameters($aConfig);
        $this->saveConfigDB($aConfig);
        // Backs up the existing config file and merges any changes from dist.conf.php.
        if (!$this->oConfiguration->mergeConfig())
        {
            $this->oLogger->logError('Failed to merge configuration file');
            return false;
        }
        return true;
    }

    /**
     * execute the upgrade steps
     *
     * @return boolean
     */
    function upgradeExecute($input_file='')
    {
        $this->oLogger->setLogFile($this->_getUpgradeLogFileName());
        $this->oDBUpgrader->logFile = $this->oLogger->logFile;

        if ($input_file)
        {
            $input_file = $this->upgradePath.$input_file;
        }
        if (!$this->_parseUpgradePackageFile($input_file))
        {
            return false;
        }
        $this->oAuditor->setKeyParams(array('upgrade_name'=>$this->package_file,
                                            'version_to'=>$this->aPackage['versionTo'],
                                            'version_from'=>$this->aPackage['versionFrom'],
                                            'logfile'=>basename($this->oLogger->logFile)
                                            )
                                     );
        $this->oAuditor->setUpgradeActionId();  // links the upgrade_action record with database_action records
        if (!$this->runScript($this->aPackage['prescript']))
        {
            $this->_auditUpgradeFailure('Failure from upgrade prescript '.$this->aPackage['prescript']);
            return false;
        }
        if (!$this->upgradeSchemas())
        {
            $this->_auditUpgradeFailure('Failure while upgrading schemas');
            return false;
        }
        if (!$this->runScript($this->aPackage['postscript']))
        {
            $this->_auditUpgradeFailure('Failure from upgrade postscript '.$this->aPackage['postscript']);
            return false;
        }
        if (!$this->oVersioner->putApplicationVersion($this->aPackage['versionTo']))
        {
            $this->_auditUpgradeFailure('Failed to update application version to '.$this->aPackage['versionTo']);
            $this->message = 'Failed to update application version to '.$this->aPackage['versionTo'];
            return false;
        }
        $this->versionInitialApplication = $this->aPackage['versionTo'];
        $this->oAuditor->logUpgradeAction(array('description'=>'COMPLETE',
                                                'action'=>UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                                'confbackup'=>$this->oConfiguration->getConfigBackupName()
                                               )
                                         );
        return true;
    }

/*
    function getAdmin()
    {
        require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
        $oPrefs = new MAX_Admin_Preferences();
        $aAdmin = $oPrefs->loadPrefs();
        if (empty($aAdmin))
        {
            if ($this->putAdmin())
            {
                $aAdmin = $oPrefs->loadPrefs();
            }
        }
        return $aAdmin;
    }
*/

    /**
     * insert admin record into preferences table
     *
     * @param array $aAdmin
     * @return boolean
     */
    function putAdmin($aAdmin)
    {
        require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
        // Insert basic preferences into database
        $oPrefs = new MAX_Admin_Preferences();

        $oPrefs->setPrefChange('admin', $aAdmin['name']);
        $oPrefs->setPrefChange('admin_email', $aAdmin['email']);
        $oPrefs->setPrefChange('admin_pw', md5($aAdmin['pword']));

        if (!$oPrefs->writePrefChange())
        {
            $this->oLogger->logError('error writing admin preference record');
            return false;
        }
        return true;
    }

    /**
     * insert CommunitySharing and UpdatesEnabled values into Preferences
     *
     * @param array $aAdmin
     * @return boolean
     */
    function putCommunityPreferences($aCommunity)
    {
        require_once MAX_PATH . '/lib/max/Admin/Preferences.php';
        // Insert basic preferences into database
        $oPrefs = new MAX_Admin_Preferences();

        // Load preferences, needed below to check instance_id existance
        $oPrefs->loadPrefs();

        $oPrefs->setPrefChange('updates_enabled', isset($aCommunity['updates_enabled'])?'t':'f');
        // Generate a new instance ID if empty
        if (empty($GLOBALS['_MAX']['PREF']['instance_id'])) {
            $oPrefs->setPrefChange('instance_id',  sha1(uniqid('', true)));
        }

        if (!$oPrefs->writePrefChange())
        {
            $this->oLogger->logError('Error inserting Community Preferences into database');
            return false;
        }
        return true;
    }

    /**
     * calls the dummy data class insert() method
     * which uses the DataGenerator to insert some data
     *
     * @return boolean
     */
    function insertDummyData()
    {
        require_once MAX_PATH.'/lib/OA/Upgrade/DummyData.php';
        $oDummy = new OA_Dummy_Data();
        $oDummy->insert();
        return true;
    }

    /**
     * this can be used to run custom scripts
     * for planned enhancement: pre/post upgrade
     *
     * @param string $file
     * @param string $classprefix
     * @return boolean
     */
    function runScript($file)
    {
        if (!$file)
        {
            return true;
        }
        else if (file_exists($this->upgradePath.$file))
        {
            $this->oLogger->log('acquiring script '.$file);
            require_once $this->upgradePath.$file;
            $type = substr(basename($file), 0, strpos(basename($file), '_'));
            $class = 'OA_Upgrade'.ucfirst($type);
            if (class_exists($class))
            {
                $this->oLogger->log('instantiating class '.$class);
                $oScript = new $class;
                $method = 'execute';
                if (is_callable(array($oScript, $method)))
                {
                    $this->oLogger->log('method is callable '.$method);
                    $aParams = array($this);
                    if (!call_user_func(array($oScript, $method), $aParams))
                    {
                        $this->oLogger->logError('script returned false '.$class);
                        return false;
                    }
                    return true;
                }
                $this->oLogger->logError('method not found '.$method);
                return false;
            }
            $this->oLogger->logError('class not found '.$class);
            return false;
        }
        $this->oLogger->logError('script not found '.$file);
        return false;
    }

    /**
     * test if the database username has permissions to create tables
     *
     * @return boolean
     */
    function checkPermissionToCreateTable()
    {
        $tblTmp = 'oa_tmp_dbpriviligecheck';
        $aExistingTables = $this->oDbh->manager->listTables();
        if (in_array($tblTmp, $aExistingTables))
        {
            $result = $this->oDbh->exec('DROP TABLE '.$tblTmp);
        }
        $result = $this->oDbh->exec("CREATE TABLE {$tblTmp} (tmp int)");
        $data   = $this->oDbh->manager->listTableFields($tblTmp);
        PEAR::popErrorHandling();
        if (!PEAR::isError($data))
        {
            $result = $this->oDbh->exec('DROP TABLE '.$tblTmp);
            $this->oLogger->log('Database permissions are OK');
            return true;
        }
        else
        {
            $this->oLogger->logError('Failed to create test privileges table - check your database permissions');
            return false;
        }
    }

    /**
     * test if the database username has permissions to create tables
     *
     * @return boolean
     */
    function checkExistingTables()
    {
        $result = true;

        $aExistingTables = $this->oDbh->manager->listTables();

        if (in_array($this->aDsn['table']['prefix'].'config', $aExistingTables))
        {
            $this->oLogger->logError('Your database contains an old Openads configuration table: '.$this->aDsn['table']['prefix'].'config. If you are wanting to upgrade this database, please copy your config.inc.php file into the var folder of this install. If you wish to proceed with a fresh installation, please either choose a new Table Prefix or a new Database.');
            return false;
        }
        if (in_array($this->aDsn['table']['prefix'].'preference', $aExistingTables))
        {
            $this->oLogger->logError('Your database contains an old Openads configuration table: '.$this->aDsn['table']['prefix'].'preference. If you are wanting to upgrade this database, please copy your domain.conf.ini file into the var folder of this install. If you wish to proceed with a fresh installation, please either choose a new Table Prefix or a new Database Name.');
            return false;
        }
        $tablePrefixError = false;
        foreach ($aExistingTables AS $k => $tablename)
        {
            if (substr($tablename, 0, strlen($this->aDsn['table']['prefix'])) == $this->aDsn['table']['prefix'])
            {
               $result = false;
               $this->oLogger->log('Table with the prefix '.$this->aDsn['table']['prefix'].' found: '.$tablename);
               if ($tablePrefixError == false)
               {
                   $this->oLogger->logError('The database you have chosen already contains tables with the prefix '.$this->aDsn['table']['prefix']);
                   $this->oLogger->logError('Please either remove these tables or choose a new prefix');
                   $tablePrefixError = true;
               }
            }
        }
        return $result;
    }

    /**
     * execute each of the db upgrade packages
     *
     * @return boolean
     */
    function upgradeSchemas()
    {
        foreach ($this->aDBPackages as $k=>$aPkg)
        {
            if (!array_key_exists($aPkg['schema'],$this->versionInitialSchema))
            {
                $this->versionInitialSchema[$aPkg['schema']] = $this->oVersioner->getSchemaVersion($aPkg['schema']);
            }
            $ok = false;
            $this->_writeRecoveryFile($aPkg['schema'], $aPkg['version']);
            if ($this->oDBUpgrader->init('constructive', $aPkg['schema'], $aPkg['version'], false))
            {
                if ($this->_runUpgradeSchemaPreScript($aPkg['prescript']))
                {
                    if ($this->oDBUpgrader->upgrade())
                    {
                        if ($this->_runUpgradeSchemaPostscript($aPkg['postscript']))
                        {
                            $ok = true;
                        }
                    }
                }
            }
            // for now we execute destructive immediately after constructive
            if ($ok)
            {
                $ok = false; // start over - should return true throughout even if nothing to do
                // last param 'true' will reset the object without having to re-parse the schema
                if ($this->oDBUpgrader->init('destructive', $aPkg['schema'], $aPkg['version'], true))
                {
                    if ($this->_runUpgradeSchemaPreScript($aPkg['prescript']))
                    {
                        if ($this->oDBUpgrader->upgrade())
                        {
                            if ($this->_runUpgradeSchemaPostscript($aPkg['postscript']))
                            {
                                $ok = true;
                            }
                        }
                    }
                }
            }
            if ($ok)
            {
              $version = ( $aPkg['stamp'] ?  $aPkg['stamp'] : $aPkg['version']);
              $this->oVersioner->putSchemaVersion($aPkg['schema'],$version);
            }
            else
            {
                if ($this->rollbackSchemas())
                {
                    $this->_pickupRecoveryFile();
                }
                return false;
            }
        }
        $this->_pickupRecoveryFile();
        return true;
    }

    /**
     * call the db_upgrader's prepare and run script functions
     * for pre / post upgrade schema packages
     *
     * @param string $file
     * @return boolean
     */
    function _runUpgradeSchemaPreScript($file)
    {
        if ($file)
        {
            if (!$this->oDBUpgrader->prepPreScript($this->upgradePath.$file))
            {
                $this->oLogger->logError('schema prepping prescript: '.$this->upgradePath.$file);
                return false;
            }
            if(!$this->oDBUpgrader->runPreScript($this->upgradePath.$file))
            {
                $this->oLogger->logError('schema prepping prescript: '.$this->upgradePath.$file);
                return false;
            }
        }
        return true;
    }

    /**
     * call the db_upgrader's prepare and run script functions
     * for pre / post upgrade schema packages
     *
     * @param string $file
     * @return boolean
     */
    function _runUpgradeSchemaPostScript($file)
    {
        if ($file)
        {
            if (!$this->oDBUpgrader->prepPostScript($this->upgradePath.$file))
            {
                $this->oLogger->logError('schema prepping postscript: '.$this->upgradePath.$file);
                return false;
            }
            if(!$this->oDBUpgrader->runPostScript($this->upgradePath.$file))
            {
                $this->oLogger->logError('schema prepping postscript: '.$this->upgradePath.$file);
                return false;
            }
        }
        return true;
    }

    /**
     * for each schema, replace the upgraded tables with the backup tables
     *
     * @return boolean
     */
    function rollbackSchemas()
    {
        foreach ($this->versionInitialSchema AS $schema => $version)
        {
            if ($this->oVersioner->getSchemaVersion($schema) != $version)
            {
                krsort($this->aDBPackages);
                foreach ($this->aDBPackages as $k=>$aPkg)
                {
                    $this->oAuditor->oDBAuditor->logDatabaseAction(array('info1'=>'UPGRADE FAILED',
                                                               'info2'=>'ROLLING BACK',
                                                               'action'=>DB_UPGRADE_ACTION_UPGRADE_FAILED,
                                                              )
                                                        );
                    if (!$this->oDBUpgrader->init('destructive', $aPkg['schema'], $aPkg['version']))
                    {
                        return false;
                    }
                    if (!$this->oDBUpgrader->prepRollback())
                    {
                        return false;
                    }
                    if (!$this->oDBUpgrader->rollback())
                    {
                        $this->oLogger->logError('ROLLBACK FAILED: '.$aPkg['schema'].'_'.$aPkg['version']);
                        return false;
                    }
                    if (!$this->oDBUpgrader->init('constructive', $aPkg['schema'], $aPkg['version'], true))
                    {
                        return false;
                    }
                    if (!$this->oDBUpgrader->prepRollback())
                    {
                        return false;
                    }
                    if (!$this->oDBUpgrader->rollback())
                    {
                        $this->oLogger->logError('ROLLBACK FAILED: '.$aPkg['schema'].'_'.$aPkg['version']);
                        return false;
                    }
                    $this->oLogger->logError('ROLLBACK SUCCEEDED: '.$aPkg['schema'].'_'.$aPkg['version']);
                    $this->oVersioner->putSchemaVersion($aPkg['schema'], $aPkg['version']);
                }
                $this->oVersioner->putSchemaVersion($schema, $version);
            }
        }
        return true;
    }


    /**
     * use the xml parser to parse the upgrade package
     *
     * @param string $input_file
     * @return array
     */
    function _parseUpgradePackageFile($input_file)
    {
        $this->aPackage = array();
        $this->aDBPackages = array();


        $this->oParser->aPackage       = array('db_pkgs' => array());
        $this->oParser->DBPkg_version  = '';
        $this->oParser->DBPkg_stamp    = '';
        $this->oParser->DBPkg_schema   = '';
        $this->oParser->DBPkg_prescript = '';
        $this->oParser->DBPkg_postscript = '';
        $this->oParser->aDBPkgs        = array('files'=>array());
        $this->oParser->aSchemas       = array();
        $this->oParser->aFiles         = array();

        $this->oParser->elements   = array();
        $this->oParser->element    = '';
        $this->oParser->count      = 0;
        $this->oParser->error      ='';

        if ($input_file!='')
        {
            $result = $this->oParser->setInputFile($input_file);
            if (PEAR::isError($result)) {
                return $result;
            }

            $result = $this->oParser->parse();
            if (PEAR::isError($result))
            {
                $this->oLogger->logError('problem parsing the package file: '.$result->getMessage());
                return false;
            }
            if (PEAR::isError($this->oParser->error))
            {
                $this->oLogger->logError('problem parsing the package file: '.$this->oParser->error);
                return false;
            }
            $this->aPackage     = $this->oParser->aPackage;
            $this->aDBPackages  = $this->aPackage['db_pkgs'];
            $this->aPackage['versionFrom'] = ($this->aPackage['versionFrom'] ? $this->aPackage['versionFrom'] : $this->versionInitialApplication);
        }
        else
        {
            // an actual package for this version does not exist so fake it
            $this->aPackage['versionTo']   = OA_VERSION;
            $this->aPackage['versionFrom'] = $this->versionInitialApplication;
            $this->aPackage['prescript']   = '';
            $this->aPackage['postscript']  = '';
            $this->aDBPackages             = array();
        }
        return true;
    }

    /**
     * not used in actual upgrader
     * retrieve a list of available upgrade packages
     *
     * @return array
     */
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
     * THIS IS NOT USED BY THE UPGRADER
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
     * THIS IS NOT USED BY THE UPGRADER
     *
     * @return boolean
     */
    function _checkChangesetAudit($schema)
    {
        $aResult = $this->oAuditor->oDBAuditor->queryAudit(null, null, $schema, DB_UPGRADE_ACTION_UPGRADE_SUCCEEDED);
        if ($aResult)
        {
            foreach ($aResult as $k=>$v)
            {
                $this->oLogger->log($v['schema_name'].' upgraded to version '.$v['version'].' on '.$v['updated']);
            }
        }
        return true;
    }

    /**
     * retrieve the message errary
     *
     * @return boolean
     */
    function getMessages()
    {
        return $this->oLogger->aMessages;
    }

    /**
     * not used anymore i think
     * retrieve the error array
     *
     * @return boolean
     */
    function getErrors()
    {
        return $this->oLogger->aErrors;
    }

    /**
     * write the version, schema and timestamp to a small temp file in the var folder
     * this will be written when an upgrade starts and deleted when it ends
     * if this file is present outside of the upgrade process it indicates that
     * the upgrade was interrupted
     *
     * @return boolean
     */
    function _writeRecoveryFile($schema, $version)
    {
        $log = fopen($this->recoveryFile, 'a');
        $date = date('Y-m-d h:i:s');
        fwrite($log, "{$schema}/{$version}/{$date}/{$this->versionInitialSchema[$schema]}/{$this->versionInitialApplication};\r\n");
        fclose($log);
        return file_exists($this->recoveryFile);
    }

    function _pickupRecoveryFile()
    {
        if (file_exists($this->recoveryFile))
        {
            unlink($this->recoveryFile);
        }
        return (!file_exists($this->recoveryFile));
    }

    function seekRecoveryFile()
    {
        if (file_exists($this->recoveryFile))
        {
            $aContent = explode(';', file_get_contents($this->recoveryFile));
            foreach ($aContent as $k => $v)
            {
                if (trim($v))
                {
                    $aLine = explode('/', trim($v));
                    $aResult[] = array(
                                        'schema'    =>$aLine[0],
                                        'version'   =>$aLine[1],
                                        'updated'   =>$aLine[2],
                                        'versionInitialSchema'      =>$aLine[3],
                                        'versionInitialApplication' =>$aLine[4],
                                        );
                }
            }
            return $aResult;
        }
        return false;
    }

    function _getUpgradeLogFileName($timing='constructive')
    {
        if ($this->package_file=='')
        {
            $package = 'openads_upgrade_'.OA_VERSION;
        }
        else
        {
            $package = str_replace('.xml', '', $this->package_file);
        }
        return $package.'_'.$timing.'_'.OA::getNow('Y_m_d_h_i_s').'.log';
    }

    function getLogFileName()
    {
        return $this->oLogger->logFile;
    }

    function removeUpgradeTriggerFile()
    {
        if (file_exists(MAX_PATH.'/var/UPGRADE'))
        {
            return unlink(MAX_PATH.'/var/UPGRADE');
        }
        return true;
    }

    function _readUpgradePackagesArray($file='')
    {
        if (!$file)
        {
            $file = $this->upgradePath.'openads_upgrade_array.txt';
        }
        if (!file_exists($file))
        {
            return false;
        }
        return unserialize(file_get_contents($file));
    }

    /**
     * walk an array of version information to build a list of required upgrades
     * they must be in the RIGHT order!!!
     * hence the weird sorting of keys etc..
     */
    function getUpgradePackageList($verPrev, $aVersions=null)
    {
        $aFiles = array();
        if (is_array($aVersions))
        {
            ksort($aVersions, SORT_NUMERIC);
            foreach ($aVersions as $release => $aMajor)
            {
                ksort($aMajor, SORT_NUMERIC);
                foreach ($aMajor as $major => $aMinor)
                {
                    ksort($aMinor, SORT_NUMERIC);
                    foreach ($aMinor as $minor => $aStatus)
                    {
                        if (array_key_exists('-beta-rc', $aStatus))
                        {
                            $aKeys = array_keys($aStatus['-beta-rc']);
                            sort($aKeys, SORT_NUMERIC);
                            foreach ($aKeys AS $k => $v)
                            {
                                $version = $release.'.'.$major.'.'.$minor.'-beta-rc'.$v;
                                if (version_compare($verPrev, $version)<0)
                                {
                                    $aFiles[] = $aStatus['-beta-rc'][$v]['file'];
                                }
                            }
                        }
                        if (array_key_exists('-beta', $aStatus))
                        {
                            $aBeta = $aStatus['-beta'];
                            foreach ($aBeta as $key => $file)
                            {
                                $version = $release.'.'.$major.'.'.$minor.'-beta';
                                if (version_compare($verPrev, $version)<0)
                                {
                                    $aFiles[] = $file;
                                }
                            }
                        }
                        if (array_key_exists('-rc', $aStatus))
                        {
                            $aKeys = array_keys($aStatus['-rc']);
                            sort($aKeys, SORT_NUMERIC);
                            foreach ($aKeys AS $k => $v)
                            {
                                $version = $release.'.'.$major.'.'.$minor.'-rc'.$v;
                                if (version_compare($verPrev, $version)<0)
                                {
                                    $aFiles[] = $aStatus['-rc'][$v]['file'];
                                }
                            }
                        }
                        if (array_key_exists('file', $aStatus))
                        {
                            $version = $release.'.'.$major.'.'.$minor;
                            if (version_compare($verPrev, $version)<0)
                            {
                                $aFiles[] = $aStatus['file'];
                            }
                        }
                    }
                }
            }
        }
        return $aFiles;
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
