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

define('OA_STATUS_NOT_INSTALLED', -1);
define('OA_STATUS_CURRENT_VERSION', 0);
define('OA_STATUS_PAN_NOT_INSTALLED', -1);
define('OA_STATUS_PAN_CONFIG_DETECTED', 1);
define('OA_STATUS_PAN_DBCONNECT_FAILED', 2);
define('OA_STATUS_PAN_VERSION_FAILED', 3);
define('OA_STATUS_PAN_DBINTEG_FAILED', 5);
define('OA_STATUS_PAN_CONFINTEG_FAILED', 6);
define('OA_STATUS_M01_NOT_INSTALLED', -1);
define('OA_STATUS_M01_CONFIG_DETECTED', 1);
define('OA_STATUS_M01_DBCONNECT_FAILED', 2);
define('OA_STATUS_M01_VERSION_FAILED', 3);
define('OA_STATUS_M01_DBINTEG_FAILED', 5);
define('OA_STATUS_M01_CONFINTEG_FAILED', 6);
define('OA_STATUS_MAX_NOT_INSTALLED', -1);
define('OA_STATUS_MAX_CONFIG_DETECTED', 1);
define('OA_STATUS_MAX_DBCONNECT_FAILED', 2);
define('OA_STATUS_MAX_VERSION_FAILED', 3);
define('OA_STATUS_MAX_DBINTEG_FAILED', 5);
define('OA_STATUS_MAX_CONFINTEG_FAILED', 6);
define('OA_STATUS_OAD_NOT_INSTALLED', -1);
define('OA_STATUS_OAD_CONFIG_DETECTED', 1);
define('OA_STATUS_OAD_DBCONNECT_FAILED', 2);
define('OA_STATUS_OAD_VERSION_FAILED', 3);
define('OA_STATUS_OAD_DBINTEG_FAILED', 5);
define('OA_STATUS_OAD_CONFINTEG_FAILED', 6);
define('OA_STATUS_CAN_UPGRADE', 10);


require_once 'MDB2.php';
require_once 'MDB2/Schema.php';

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Charset.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeLogger.php';
require_once MAX_PATH . '/lib/OA/Upgrade/DB_Upgrade.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradeAuditor.php';
require_once MAX_PATH . '/lib/OA/Upgrade/DB_UpgradeAuditor.php';
require_once MAX_PATH . '/lib/OA/Upgrade/UpgradePackageParser.php';
require_once MAX_PATH . '/lib/OA/Upgrade/VersionController.php';
require_once MAX_PATH . '/lib/OA/Upgrade/EnvironmentManager.php';
require_once MAX_PATH . '/lib/OA/Upgrade/phpAdsNew.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Configuration.php';
require_once MAX_PATH . '/lib/OA/Upgrade/DB_Integrity.php';
require_once MAX_PATH . '/lib/OA/Preferences.php';

/**
 * @package    OpenXUpgrade Class
 *
 */
class OA_Upgrade
{
    public $upgradePath = '';

    public $message = '';

    /**
     * @var OA_UpgradeLogger
     */
    public $oLogger;

    /**
     * @var OA_UpgradePackageParser
     */
    public $oParser;

    /**
     * @var OA_DB_Upgrade
     */
    public $oDBUpgrader;

    /**
     * @var OA_Version_Controller
     */
    public $oVersioner;

    /**
     * @var OA_UpgradeAuditor
     */
    public $oAuditor;

    /**
     * @var OA_Environment_Manager
     */
    public $oSystemMgr;

    /**
     * @var MDB2_Driver_Common
     */
    public $oDbh;

    /**
     * @var OA_phpAdsNew
     */
    public $oPAN;

    /**
     * @var OA_Upgrade_Config
     */
    public $oConfiguration;

    /** @var OA_DB_Table */
    public $oTable;

    /** @var OA_DB_Integrity */
    public $oIntegrity;

    public $aPackageList = [];
    public $aPackage = [];
    public $aDBPackages = [];
    public $aDsn = [];

    public $versionInitialApplication;
    public $versionInitialSchema = [];
    public $versionInitialAppOpenads;

    public $package_file = '';
    public $recoveryFile;
    public $nobackupsFile;
    public $postTaskFile = '';

    public $can_drop_database = false;

    public $existing_installation_status = OA_STATUS_NOT_INSTALLED;
    public $upgrading_from_milestone_version = false;
    public $aToDoList = [];

    /**
     * Static result of canUpgradeOrInstall
     * @var array
     */
    protected static $canUpgradeOrInstall;

    public function __construct()
    {
        $this->upgradePath = MAX_PATH . '/etc/changes/';
        $this->recoveryFile = MAX_PATH . '/var/RECOVER';
        $this->nobackupsFile = MAX_PATH . '/var/NOBACKUPS';
        $this->postTaskFile = MAX_PATH . '/var/TASKS.php';

        $this->oLogger = new OA_UpgradeLogger();
        $this->oParser = new OA_UpgradePackageParser();
        $this->oDBUpgrader = new OA_DB_Upgrade($this->oLogger);
        $this->oAuditor = new OA_UpgradeAuditor();
        $this->oVersioner = new OA_Version_Controller();
        $this->oPAN = new OA_phpAdsNew();
        $this->oSystemMgr = new OA_Environment_Manager();
        $this->oConfiguration = new OA_Upgrade_Config();
        $this->oTable = new OA_DB_Table();
        $this->oIntegrity = new OA_DB_Integrity();

        if ($this->seekFantasyUpgradeFile()) {
            $this->upgradePath = MAX_PATH . '/etc/changesfantasy/';
        }
        $this->oDBUpgrader->path_changes = $this->upgradePath;

        $this->aDsn['database'] = [];
        $this->aDsn['table'] = [];
        $this->aDsn['database']['type'] = 'mysql';
        $this->aDsn['database']['host'] = 'localhost';
        $this->aDsn['database']['port'] = '3306';
        $this->aDsn['database']['username'] = '';
        $this->aDsn['database']['passowrd'] = '';
        $this->aDsn['database']['name'] = '';
        $this->aDsn['table']['type'] = 'InnoDB';
        $this->aDsn['table']['prefix'] = 'rv_';
    }

    /**
     * initialise a database connection
     * hook up the various components with a db object
     *
     * @param array $dsn
     * @return boolean
     */
    public function initDatabaseConnection($aConf = null)
    {
        if (!$aConf) {
            $aConf = $GLOBALS['_MAX']['CONF'];
        } else {
            $this->oDbh = null;
        }
        if (is_null($this->oDbh)) {
            //$this->oDbh = OA_DB::singleton($dsn);
            $this->oDbh = OA_DB::singleton(OA_DB::getDsn($aConf));
        }
        if (PEAR::isError($this->oDbh)) {
            $this->oLogger->log($this->oDbh->getMessage());
            $this->oDbh = null;
            return false;
        }
        if (!$this->oDbh) {
            $this->oLogger->log('Unable to connect to database');
            $this->oDbh = null;
            return false;
        }
        $this->oTable->oDbh = $this->oDbh;
        $this->oDBUpgrader->initMDB2Schema();
        $this->oVersioner->init($this->oDbh);
        $this->oAuditor->init($this->oDbh, $this->oLogger);
        $this->oDBUpgrader->oAuditor = $this->oAuditor->oDBAuditor;
        $this->oDBUpgrader->doBackups = $this->_doBackups();
        $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
        $this->aDsn['table'] = $GLOBALS['_MAX']['CONF']['table'];
        return true;
    }

    /**
     * add any needed database parameter to the config array
     *
     * @param array $aConfig
     *
     * @return array
     */
    public function initDatabaseParameters($aConfig)
    {
        // Set charset information
        $oDbc = OA_DB_Charset::factory($this->oDbh);
        $charset = $oDbc->getConfigurationValue();
        $aConfig['databaseCharset'] = [
            'checkComplete' => true,
            'clientCharset' => $charset ? $charset : ''
        ];

        return $aConfig;
    }

    /**
     * see the recovery file and ye may findeth
     *
     * @return boolean
     */
    public function isRecoveryRequired()
    {
        return (is_array($this->seekRecoveryFile()) ? true : false);
    }

    /**
     * the recovery trigger file contains a record for each upgrade package
     * that was executed during the previous ugprade
     * this method reads that file and cycles through the upgrade audit ids
     * to retrieve, compile and execute the steps taken in reverse order
     * restoring tables that were changed and dropping tables that were added
     *
     * steps are audited and logged as per an upgrade
     *
     * @return boolean
     */
    public function recoverUpgrade()
    {
        $aRecover = $this->seekRecoveryFile();
        if (is_array($aRecover)) {
            if (!empty($aRecover)) {
                // hmm, use canUpgrade() instead?
                $this->detectPAN();
                $this->detectMAX01();
                $this->detectMAX();
                if (!$this->initDatabaseConnection()) {
                    return false;
                }
                $this->oDBUpgrader->prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
                $n = count($aRecover);
                for ($i = $n - 1;$i > -1;$i--) {
                    $aRec = $aRecover[$i];

                    $this->oLogger->logOnly('attempting to roll back upgrade action id ' . $aRec['auditId']);
                    $this->oLogger->logOnly('retrieving upgrade actions');

                    $aResult = $this->oAuditor->queryAuditByUpgradeId($aRec['auditId']);

                    if ($aResult[0]['upgrade_name'] != $aRec['package']) {
                        $this->oLogger->logError('cannot recover using this recovery file: package name mismatch');
                        return false;
                    }

                    $this->package_file = $aRec['package'];
                    $this->oLogger->setLogFile($aResult[0]['logfile'] . '.rollback');
                    $this->oDBUpgrader->logFile = $this->oLogger->logFile;
                    $this->oConfiguration->clearConfigBackupName();

                    $this->oLogger->logOnly('retrieved upgrade actions ok');

                    $this->oAuditor->setKeyParams(
                        ['upgrade_name' => $this->package_file,
                                                        'version_to' => $aResult[0]['version_from'],
                                                        'version_from' => $aResult[0]['version_to'],
                                                        'logfile' => basename($this->oLogger->logFile)
                                                       ]
                    );
                    $this->oAuditor->setUpgradeActionId();

                    $this->oLogger->log('Preparing to rollback package ' . $this->package_file);
                    if (!$this->oDBUpgrader->prepRollbackByAuditId($aRec['auditId'], $versionInitialSchema, $schemaName)) {
                        $this->oAuditor->logAuditAction(
                            ['description' => 'ROLLBACK FAILED',
                                                              'action' => UPGRADE_ACTION_ROLLBACK_FAILED,
                                                              'confbackup' => ''
                                                             ]
                        );
                        return false;
                    }
                    $this->oLogger->log('Starting to rollback package ' . $this->package_file);
                    if (!$this->oDBUpgrader->rollback()) {
                        $this->oAuditor->logAuditAction(
                            ['description' => 'ROLLBACK FAILED',
                                                              'action' => UPGRADE_ACTION_ROLLBACK_FAILED,
                                                              'confbackup' => ''
                                                             ]
                        );
                        return false;
                    }

                    if (!file_exists(MAX_PATH . '/var/UPGRADE')) {
                        if (!$this->_createEmptyVarFile('UPGRADE')) {
                            $this->oLogger->log('failed to replace the UPGRADE trigger file');
                        }
                    }
                    if ($this->upgrading_from_milestone_version) {
                        if (!$this->_removeInstalledFlagFile()) {
                            $this->oLogger->log('failed to remove the INSTALLED flag file');
                        }
                    }
                    if (!$this->_restoreConfigBackup($aResult[0]['confbackup'], $aRec['auditId'])) {
                        //return false;
                        // do we really want to halt rollback because of a conf file?
                    }
                    if ($this->oVersioner->tableAppVarsExists($this->oDBUpgrader->_listTables())) {
                        $product = 'oa';
                        if ($aResult[0]['version_from'] == '2.3.31-alpha-pr3') {
                            $product = 'max';
                            $this->oVersioner->removeOpenadsVersion();
                            $this->oVersioner->putApplicationVersion('v0.3.31-alpha', $product);
                        } elseif ($aResult[0]['version_from'] == '2.1.29-rc') {
                            $product = 'max';
                            $this->oVersioner->removeOpenadsVersion();
                            $this->oVersioner->putApplicationVersion('v0.1.29-rc', $product);
                        } else {
                            $this->oVersioner->putApplicationVersion($aResult[0]['version_from'], $product);
                        }
                        $this->oVersioner->putSchemaVersion($schemaName, $versionInitialSchema);
                    }
                    $this->oLogger->log('Finished rolling back package ' . $this->package_file);
                    $this->oLogger->log('Information regarding the problems encountered during the upgrade can be found in');
                    $this->oLogger->log($aResult[0]['logfile']);
                    $this->oLogger->log('Information regarding steps taken during rollback can be found in');
                    $this->oLogger->log($this->oLogger->logFile);
                    $this->oLogger->log('Database and configuration files have been rolled back to version ' . $aResult[0]['version_from']);
                    $this->oAuditor->logAuditAction(
                        ['description' => 'ROLLBACK COMPLETE',
                                                          'action' => UPGRADE_ACTION_ROLLBACK_SUCCEEDED,
                                                          'confbackup' => ''
                                                         ]
                    );
                }
            } else {
                $this->oLogger->log('No valid recovery information found in var/RECOVER');
                $this->oLogger->log('It is not possible to rollback the previous upgrade');
                return false;
            }
            $this->oLogger->log('Recovery complete');
        } else {
            $this->oLogger->log('No valid recovery information found in var/RECOVER');
            return false;
        }
        $this->_pickupRecoveryFile();
        return true;
    }

    /**
     * delete the existing conf file
     * copy the backup conf file to it's old name
     * delete the backup conf file and audit
     *
     * @param string $confBackup
     * @param integer $auditId
     */
    public function _restoreConfigBackup($confBackup, $auditId)
    {
        if ($confBackup) {
            $host = OX_getHostName();
            $confFile = $host . '.conf.php';
            if (file_exists(MAX_PATH . '/var/' . $confFile)) {
                if (!@unlink(MAX_PATH . '/var/' . $confFile)) {
                    $this->oLogger->logError('failed to remove current configuration file');
                    return false;
                }
            }
            if (!file_exists(MAX_PATH . '/var/' . $confBackup)) {
                $this->oLogger->logError('failed to find backup configuration file');
                return false;
            }
            $confOldName = substr($confBackup, strpos($confBackup, 'old.') + 4);
            if (substr($confOldName, -8, 4) == '.ini') {
                $confOldName = str_replace('.php', '', $confOldName);
            }
            if (!copy(MAX_PATH . '/var/' . $confBackup, MAX_PATH . '/var/' . $confOldName)) {
                return false;
            }
            $this->oLogger->log('restored config file ' . $confOldName);
            if (!@unlink(MAX_PATH . '/var/' . $confBackup)) {
                $this->oLogger->log('failed to remove backup configuration file');
                return false;
            }
            $this->oLogger->log('removed backup config file ' . $confBackup);
            $this->oAuditor->updateAuditBackupConfDroppedById($auditId, 'dropped during recovery');
        }
        return true;
    }

    /**
     * return an array of system environment info
     *
     * @return array
     */
    public function checkEnvironment()
    {
        return $this->oSystemMgr->checkSystem();
    }

    /**
     * A method to convert the application version that is currently stored
     * in the $this->versionInitialApplication variable into a string that
     * is suitable for displaying in the upgrade screen, advising the user
     * as to which version of the application the are upgrading FROM.
     *
     * @param boolean $shortVersion When set to true (not the default), returns
     *                              the text description in short format, being
     *                              just the version number, without the
     *                              additional human-friendly text.
     * @return string A descriptive text value of the version that is being
     *                upgraded FROM.
     */
    public function getProductApplicationVersion($noText = false)
    {
        switch ($this->versionInitialApplication) {
            case '':
                if ($noText) {
                    return 'unknown version';
                } else {
                    return 'An unknown version';
                }
                // no break
            case '0.100':
                if ($noText) {
                    return '2.1.29-rc';
                } else {
                    return 'Openads 2.1.29-rc';
                }
                // no break
            case '200.313':
            case '200.314':
                // Upgrade from Openads 2.0, need to know if this
                // is for MySQL or PostgreSQL
                if ($this->oDbh->dbsyntax == 'pgsql') {
                    $dbType = 'PostgreSQL';
                } else {
                    $dbType = 'MySQL';
                }
                if ($noText) {
                    return '2.0.11-pr1';
                } else {
                    return "Openads for $dbType 2.0.11-pr1";
                }
                // no break
            case 'v0.3.31-alpha':
                if ($noText) {
                    return '2.3.31-alpha';
                } else {
                    return 'Openads 2.3.31-alpha';
                }
                // no break
            default:
                if ($noText) {
                    return $this->versionInitialApplication;
                } else {
                    // The product was re-branded OpenX at 2.4.4, and Revive
                    // Adserver at 3.0.0, so deal with the product names in this
                    // text description accordingly
                    if (version_compare($this->versionInitialApplication, '2.4.4', '<')) {
                        return 'Openads ' . $this->versionInitialApplication;
                    } elseif (version_compare($this->versionInitialApplication, '3.0.0', '<')) {
                        return 'OpenX ' . $this->versionInitialApplication;
                    } else {
                        return 'Revive Adserver ' . $this->versionInitialApplication;
                    }
                }
        }
    }


    /**
     * Look for existing installations (phpAdsNew, MMM, Openads)
     * retrieve details and check for errors
     * Allows to limit calls to canUpgradeInit in one thread by storing it's results
     *
     * @param boolean $forceCheck should canUpgradeInit be called anyway
     * @return boolean true if can install or upgrade application, false if can't upgrade or it's current installation
     */
    public function canUpgradeOrInstall($forceCheck = false)
    {
        if ($forceCheck || !isset(self::$canUpgradeOrInstall)) {
            $result = $this->canUpgradeInit();
            self::$canUpgradeOrInstall = [
                'result' => $result,
                'existing_installation_status' => $this->existing_installation_status,
                'versionInitialApplication' => isset($this->versionInitialApplication) ? $this->versionInitialApplication : null,
                'tables_core' => isset($this->versionInitialSchema['tables_core']) ? $this->versionInitialSchema['tables_core'] : null,
                'package0' => isset($this->aPackageList[0]) ? $this->aPackageList[0] : null,
                'aDsn-database' => $this->aDsn['database'],
                'aDsn-table' => $this->aDsn['table'],
                'upgrading_from_milestone_version' => $this->upgrading_from_milestone_version,
                'globals-database' => $GLOBALS['_MAX']['CONF']['database'],
                'globals-table' => $GLOBALS['_MAX']['CONF']['table'],
                'oLogger' => clone $this->oLogger,
            ];
        } else {
            // restore results from self::$canUpgradeOrInstall
            $aResult = self::$canUpgradeOrInstall;
            $this->existing_installation_status = $aResult['existing_installation_status'];
            if (isset($aResult['versionInitialApplication'])) {
                $this->versionInitialApplication = $aResult['versionInitialApplication'];
            }
            if (isset($aResult['tables_core'])) {
                $this->versionInitialSchema['tables_core'] = $aResult['tables_core'];
            }
            if (isset($aResult['package0'])) {
                $this->aPackageList[0] = $aResult['package0'];
            }
            $this->aDsn['database'] = $aResult['aDsn-database'];
            $this->aDsn['table'] = $aResult['aDsn-table'];
            $this->upgrading_from_milestone_version = $aResult['upgrading_from_milestone_version'];
            $GLOBALS['_MAX']['CONF']['database'] = $aResult['globals-database'];
            $GLOBALS['_MAX']['CONF']['table'] = $aResult['globals-table'];
            $this->oLogger = $aResult['oLogger'];
        }
        return self::$canUpgradeOrInstall['result'];
    }


    /**
     * look for existing installations (phpAdsNew, MMM, Openads)
     * retrieve details and check for errors
     *
     * @return boolean
     */
    protected function canUpgradeInit()
    {
        $strDetected = 'configuration file detected';
        $strCanUpgrade = 'This version can be upgraded';
        $strNoConnect = 'Could not connect to the database';
        $strConnected = 'Connected to the database ok';
        $strNoUpgrade = 'This version cannot be upgraded';
        $strTableError = 'Error accessing Database Tables';

        $this->oLogger->logClear();
        $this->oLogger->logOnly('=========================================================================');
        $this->oLogger->logOnly('Attempting to detect an existing Openads (aka. phpAdsNew) installation...');
        $this->detectPAN();
        $strProductName = $this->getProductApplicationVersion();
        switch ($this->existing_installation_status) {
            case OA_STATUS_PAN_NOT_INSTALLED:
                $this->oLogger->logOnly('PAN not detected');
                break;
            case OA_STATUS_PAN_CONFIG_DETECTED:
                $this->oLogger->logError($strProductName . ' ' . $strDetected);
                break;
            case OA_STATUS_PAN_DBCONNECT_FAILED:
                $this->oLogger->logError($strProductName . ' ' . $strDetected);
                $this->oLogger->logError($strNoConnect . ' : ' . $GLOBALS['_MAX']['CONF']['database']['name']);
                break;
            case OA_STATUS_PAN_VERSION_FAILED:
                $this->oLogger->log($strProductName . ' detected');
                $this->oLogger->log($strConnected . ' : ' . $GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                break;
            case OA_STATUS_PAN_DBINTEG_FAILED:
                $this->oLogger->log($strProductName . ' detected');
                $this->oLogger->log($strConnected . ' : ' . $GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                return false;
            case OA_STATUS_PAN_CONFINTEG_FAILED:
                $this->oLogger->log($strProductName . ' detected');
                $this->oLogger->log($strConnected . ' : ' . $GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                return false;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log($strProductName . ' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }

        $this->oLogger->logOnly('Attempting to detect an existing Openads (aka. Max Media Manager 0.1) installation...');
        $this->detectMAX01();
        $strProductName = $this->getProductApplicationVersion();
        switch ($this->existing_installation_status) {
            case OA_STATUS_M01_NOT_INSTALLED:
                $this->oLogger->logOnly('MMM v0.1 not detected');
                break;
            case OA_STATUS_M01_CONFIG_DETECTED:
                if (!$this->oLogger->errorExists) {
                    $this->oLogger->logError($strProductName . ' ' . $strDetected);
                }
                break;
            case OA_STATUS_M01_DBCONNECT_FAILED:
                if (!$this->oLogger->errorExists) {
                    $this->oLogger->logError($strProductName . ' ' . $strDetected);
                    $this->oLogger->logError($strNoConnect . ' : ' . $GLOBALS['_MAX']['CONF']['database']['name']);
                }
                break;
            case OA_STATUS_M01_DBINTEG_FAILED:
                return false;
            case OA_STATUS_M01_CONFINTEG_FAILED:
                return false;
            case OA_STATUS_M01_VERSION_FAILED:
                if (!$this->oLogger->errorExists) {
                    $this->oLogger->log($strProductName . ' detected');
                    $this->oLogger->logError($strConnected . ' : ' . $GLOBALS['_MAX']['CONF']['database']['name']);
                    $this->oLogger->logError($strNoUpgrade);
                }
                break;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log($strProductName . ' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }

        $this->oLogger->logOnly('Attempting to detect an existing Openads (aka. Max Media Manager 0.3) installation...');
        $this->detectMAX();
        $strProductName = $this->getProductApplicationVersion();
        switch ($this->existing_installation_status) {
            case OA_STATUS_MAX_NOT_INSTALLED:
                $this->oLogger->logOnly('MMM v0.3 not detected');
                break;
            case OA_STATUS_MAX_CONFIG_DETECTED:
                $this->oLogger->logError($strProductName . ' ' . $strDetected);
                break;
            case OA_STATUS_MAX_DBCONNECT_FAILED:
                $this->oLogger->logError($strProductName . ' ' . $strDetected);
                $this->oLogger->logError($strNoConnect . ' : ' . $GLOBALS['_MAX']['CONF']['database']['name']);
                break;
            case OA_STATUS_MAX_DBINTEG_FAILED:
                return false;
            case OA_STATUS_MAX_CONFINTEG_FAILED:
                return false;
            case OA_STATUS_MAX_VERSION_FAILED:
                $this->oLogger->log($strProductName . ' detected');
                $this->oLogger->logError($strConnected . ' : ' . $GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                break;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log($strProductName . ' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }

        $this->oLogger->logOnly('Attempting to detect an existing Revive Adserver installation...');
        $this->detectOpenads();
        $strProductName = $this->getProductApplicationVersion();
        switch ($this->existing_installation_status) {
            case OA_STATUS_OAD_NOT_INSTALLED:
                if (!$this->oLogger->errorExists) {
                    $this->oLogger->log('No previous version of Revive Adserver detected');
                    return true;
                }
                break;
            case OA_STATUS_OAD_CONFIG_DETECTED:
                $this->oLogger->logError('Openads' . ' ' . $strDetected);
                break;
            case OA_STATUS_OAD_DBCONNECT_FAILED:
                $this->oLogger->logError('Openads' . ' ' . $strDetected);
                $this->oLogger->logError($strNoConnect . ' : ' . $GLOBALS['_MAX']['CONF']['database']['name']);
                return false;
            case OA_STATUS_OAD_DBINTEG_FAILED:
                return false;
            case OA_STATUS_OAD_CONFINTEG_FAILED:
                $this->oLogger->logError('Openads' . ' ' . $strDetected);
                $this->oLogger->logError($strProductName . ' detected');
                $this->oLogger->logError($strNoUpgrade);
                return false;
            case OA_STATUS_OAD_VERSION_FAILED:
                $this->oLogger->log($strProductName . ' detected');
                $this->oLogger->logError($strConnected . ' : ' . $GLOBALS['_MAX']['CONF']['database']['name']);
                $this->oLogger->logError($strNoUpgrade);
                return false;
            case OA_STATUS_CURRENT_VERSION:
                $this->oLogger->log($strProductName . ' detected');
                $this->oLogger->log('This version is up to date.');
                return false;
            case OA_STATUS_CAN_UPGRADE:
                $this->oLogger->log($strProductName . ' detected');
                $this->oLogger->log($strCanUpgrade);
                return true;
        }
        return false;
    }


    /**
     * Do quick check for existing installations (phpAdsNew, MMM, Openads)
     * Is it this fresh install or upgrade?
     *
     * @return boolean
     */
    public function isFreshInstall()
    {
        $freshInstall = true;
        if (!empty($GLOBALS['_MAX']['CONF']['max']['installed'])) {
            $freshInstall = false;
        } elseif ((!empty($GLOBALS['_MAX']['CONF']['openads']['installed'])) || file_exists(MAX_PATH . '/var/INSTALLED')) {
            $freshInstall = false;
        } else {
            $this->oPAN->init();
            if ($this->oPAN->detected) {
                $freshInstall = false;
            }
        }

        return $freshInstall;
    }


    /**
     * check existance of upgrade package file
     *
     * @return boolean
     */
    public function checkUpgradePackage()
    {
        if ($this->package_file) {
            if (!file_exists($this->upgradePath . $this->package_file)) {
                $this->oLogger->logError('Upgrade package file ' . $this->package_file . ' NOT found');
                return false;
            }
            return true;
        } elseif ($this->existing_installation_status == OA_STATUS_NOT_INSTALLED) {
            return true;
        }
        $this->oLogger->logError('No upgrade package file specified');
        return false;
    }


    /**
     * search for an existing phpAdsNew installation
     *
     * @param boolean $skipIntegrityCheck
     * @return boolean
     */
    public function detectPAN($skipIntegrityCheck = false)
    {
        $this->oPAN->init();
        if ($this->oPAN->detected) {
            $GLOBALS['_MAX']['CONF']['database'] = $this->oPAN->aDsn['database'];
            //$GLOBALS['_MAX']['CONF']['table']    = $this->oPAN->aDsn['table'];
            $this->existing_installation_status = OA_STATUS_PAN_CONFIG_DETECTED;
            if (PEAR::isError($this->oPAN->oDbh)) {
                $this->existing_installation_status = OA_STATUS_PAN_DBCONNECT_FAILED;
                return false;
            }
            $this->oDbh = $this->oPAN->oDbh;
            if (!$this->initDatabaseConnection()) {
                $this->existing_installation_status = OA_STATUS_PAN_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oPAN->getPANversion();
            if (!$this->versionInitialApplication) {
                $this->existing_installation_status = OA_STATUS_PAN_VERSION_FAILED;
                return false;
            }
            $valid = (
                (version_compare($this->versionInitialApplication, '200.313') == 0)
                      ||
                       (version_compare($this->versionInitialApplication, '200.314') == 0)
            );
            if ($valid) {
                if (null !== $this->oDbh && $this->oDbh->dbsyntax === 'pgsql') {
                    // Openads 2.0 for PostgreSQL
                    $this->versionInitialSchema['tables_core'] = '049';
                } else {
                    // Openads 2.0
                    $this->versionInitialSchema['tables_core'] = '099';
                }
                if (!$skipIntegrityCheck && !$this->_checkDBIntegrity($this->versionInitialSchema['tables_core'])) {
                    $this->existing_installation_status = OA_STATUS_PAN_DBINTEG_FAILED;
                    return false;
                }
                if (!$skipIntegrityCheck && !$this->oPAN->checkPANConfigIntegrity($this)) {
                    $this->existing_installation_status = OA_STATUS_PAN_CONFINTEG_FAILED;
                    return false;
                }
                $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                $this->aPackageList[0] = 'openads_upgrade_2.0.11_to_2.3.32_beta.xml';
                $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                $this->aDsn['table'] = $GLOBALS['_MAX']['CONF']['table'];
                $this->upgrading_from_milestone_version = true;
                return true;
            }
            // if its not a max 0.1 installation
            if (!version_compare($this->versionInitialApplication, '200.000') < 0) {
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
     * @param boolean $skipIntegrityCheck
     * @return boolean
     */
    public function detectMAX01($skipIntegrityCheck = false)
    {
        $this->oPAN->init();
        if ($this->oPAN->detected) {
            $GLOBALS['_MAX']['CONF']['database'] = $this->oPAN->aDsn['database'];
            $GLOBALS['_MAX']['CONF']['table'] = $this->oPAN->aDsn['table'] ?? null;
            $this->existing_installation_status = OA_STATUS_M01_CONFIG_DETECTED;
            if (PEAR::isError($this->oPAN->oDbh)) {
                $this->existing_installation_status = OA_STATUS_M01_DBCONNECT_FAILED;
                return false;
            }
            $this->oDbh = $this->oPAN->oDbh;
            if (!$this->initDatabaseConnection()) {
                $this->existing_installation_status = OA_STATUS_M01_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oPAN->getPANversion();
            if (!$this->versionInitialApplication) {
                $this->existing_installation_status = OA_STATUS_M01_VERSION_FAILED;
                return false;
            }

            $valid = (version_compare($this->versionInitialApplication, '0.100') == 0);
            if ($valid) {
                $this->versionInitialSchema['tables_core'] = '300';
                if (!$this->initDatabaseConnection()) {
                    $this->existing_installation_status = OA_STATUS_M01_DBCONNECT_FAILED;
                    return false;
                }
                if (!$skipIntegrityCheck && !$this->_checkDBIntegrity($this->versionInitialSchema['tables_core'])) {
                    $this->existing_installation_status = OA_STATUS_M01_DBINTEG_FAILED;
                    return false;
                }
                $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                $this->aPackageList[0] = 'openads_upgrade_2.1.29_to_2.3.32_beta.xml';
                $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                $this->aDsn['table'] = $GLOBALS['_MAX']['CONF']['table'];
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
     * @param boolean $skipIntegrityCheck
     * @return boolean
     */
    public function detectMAX($skipIntegrityCheck = false)
    {
        if (!empty($GLOBALS['_MAX']['CONF']['max']['installed'])) {
            $this->existing_installation_status = OA_STATUS_MAX_CONFIG_DETECTED;
            if (!$this->initDatabaseConnection()) {
                $this->existing_installation_status = OA_STATUS_MAX_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oVersioner->getApplicationVersion('max');
            if (!$this->versionInitialApplication) {
                $this->existing_installation_status = OA_STATUS_MAX_VERSION_FAILED;
                return false;
            }
            $valid = (version_compare($this->versionInitialApplication, 'v0.3.31-alpha') == 0);
            if ($valid) {
                $this->versionInitialSchema['tables_core'] = '500';
                if (!$skipIntegrityCheck && !$this->_checkDBIntegrity($this->versionInitialSchema['tables_core'])) {
                    $this->existing_installation_status = OA_STATUS_MAX_DBINTEG_FAILED;
                    return false;
                }
                $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                $this->aPackageList[0] = 'openads_upgrade_2.3.31_to_2.3.32_beta.xml';
                $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                $this->aDsn['table'] = $GLOBALS['_MAX']['CONF']['table'];
                $this->upgrading_from_milestone_version = true;
                return true;
            }
            $this->existing_installation_status = OA_STATUS_MAX_VERSION_FAILED;
            return false;
        }
        $this->existing_installation_status = OA_STATUS_MAX_NOT_INSTALLED;
        return false;
    }

    /**
     * compare the schema of the connected database
     * with that of a given schema
     *
     * @param string $version
     * @param array $aSchema
     * @return boolean
     */
    public function _checkDBIntegrity($version, $aSchema = [])
    {
        if (empty($aSchema)) {
            $path_schema = $this->oDBUpgrader->path_schema ?? '';
            $file_schema = $this->oDBUpgrader->file_schema;
            $aSchema['name'] = 'tables_core';
        }
        $path_changes = $this->oDBUpgrader->path_changes;
        $file_changes = $this->oDBUpgrader->file_changes;

        $this->oIntegrity->oUpgrader = $this;
        $result = $this->oIntegrity->checkIntegrityQuick($version, $aSchema);

        if (empty($schema)) {
            $this->oDBUpgrader->path_schema = $path_schema;
            $this->oDBUpgrader->file_schema = $file_schema;
        }
        $this->oDBUpgrader->path_changes = $path_changes;
        $this->oDBUpgrader->file_changes = $file_changes;

        if (!$result) {
            $this->oLogger->logError('database integrity check could not complete due to problems');
            return false;
        }
        $this->oLogger->logClear();
        if (!empty($this->oIntegrity->aTasksConstructiveAll)) {
            $this->oLogger->logError('database integrity check detected problems with the database');
            foreach ($this->oIntegrity->aTasksConstructiveAll as $elem => &$aTasks) {
                foreach ($aTasks as $task => &$aItems) {
                    $this->oLogger->logError(count($aItems) . ' ' . $elem . ' to ' . $task);
                }
            }
            return false;
        }
        return $this->oDBUpgrader->checkPotentialUpgradeProblems();
    }


    /**
     * search for an existing OpenX installation
     *
     * @param boolean $skipIntegrityCheck
     * @return boolean
     */
    public function detectOpenads($skipIntegrityCheck = false)
    {
        if ((!empty($GLOBALS['_MAX']['CONF']['openads']['installed'])) || file_exists(MAX_PATH . '/var/INSTALLED')) {
            $this->existing_installation_status = OA_STATUS_OAD_CONFIG_DETECTED;

            if (!$this->initDatabaseConnection()) {
                $this->existing_installation_status = OA_STATUS_OAD_DBCONNECT_FAILED;
                return false;
            }
            $this->versionInitialApplication = $this->oVersioner->getApplicationVersion();
            if (!$this->versionInitialApplication) {
                $this->existing_installation_status = OA_STATUS_OAD_VERSION_FAILED;
                return false;
            }
            // hark the special case of 2.3.34-beta - the borked schema
            // treat this as a milestone upgrade for repair purposes
            //if (version_compare($this->versionInitialApplication,'2.3.34-beta')==0)
            // actually, better check for any version < .38 in case of upgrades from .34 prior to the repair pkg
            $this->versionInitialSchema['tables_core'] = $this->oVersioner->getSchemaVersion('tables_core');

            if (version_compare($this->versionInitialApplication, '2.3.38-beta', '<') == -1) {
//                $this->versionInitialSchema['tables_core'] = $this->oVersioner->getSchemaVersion('tables_core');
                if ($this->versionInitialSchema['tables_core'] == '129') {
                    $this->versionInitialSchema['tables_core'] = '12934';
                    if (!$skipIntegrityCheck && !$this->_checkDBIntegrity($this->versionInitialSchema['tables_core'])) {
                        $this->existing_installation_status = OA_STATUS_OAD_DBINTEG_FAILED;
                        return false;
                    }
                    $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                    $this->aPackageList[0] = 'openads_upgrade_2.3.34_to_2.3.38_beta.xml';
                    $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                    $this->aDsn['table'] = $GLOBALS['_MAX']['CONF']['table'];
                    $this->upgrading_from_milestone_version = true;
                    return true;
                }
            }
            $current = (version_compare($this->versionInitialApplication, VERSION) == 0);
            $valid = (version_compare($this->versionInitialApplication, VERSION) < 0);
            if ($valid) {
                $this->aPackageList = $this->getUpgradePackageList($this->versionInitialApplication, $this->_readUpgradePackagesArray());
                if (!$skipIntegrityCheck && count($this->aPackageList) > 0) {
//                    $this->versionInitialSchema['tables_core'] = $this->oVersioner->getSchemaVersion('tables_core');
                    if (!$this->_checkDBIntegrity($this->versionInitialSchema['tables_core'])) {
                        $this->existing_installation_status = OA_STATUS_OAD_DBINTEG_FAILED;
                        return false;
                    }
                }
                $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                $this->aDsn['table'] = $GLOBALS['_MAX']['CONF']['table'];
                $this->upgrading_from_milestone_version = false;
                return true;
            } elseif ($current) {
                if ($this->seekFantasyUpgradeFile()) {
                    $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                    $this->aPackageList[0] = 'openads_fantasy_upgrade_999.999.999.xml';
                    $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                    $this->aDsn['table'] = $GLOBALS['_MAX']['CONF']['table'];
                    $this->oLogger->log('Fantasy Upgrade Requested');
                    return true;
                }
                $this->existing_installation_status = OA_STATUS_CURRENT_VERSION;
                $this->aPackageList = [];
                return false;
            } elseif ($this->oConfiguration->checkForConfigAdditions()) {
                $this->existing_installation_status = OA_STATUS_CAN_UPGRADE;
                $this->aDsn['database'] = $GLOBALS['_MAX']['CONF']['database'];
                $this->aDsn['table'] = $GLOBALS['_MAX']['CONF']['table'];
                $this->upgrading_from_milestone_version = false;
                return true;
            } elseif ($this->seekFantasyUpgradeFile()) {
                // check if this is after fantasy upgrade
                $this->existing_installation_status = OA_STATUS_CURRENT_VERSION;
                $this->aPackageList = [];
                $this->oLogger->log('Fantasy Upgrade detected');
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
    public function install($aConfig)
    {
        $this->oLogger->setLogFile('install.log');
        $this->oLogger->deleteLogFile();

        // Always use lower case prefixes for new installs
        $aConfig['table']['prefix'] = strtolower($aConfig['table']['prefix']);

        if ($aConfig['database']['localsocket'] == true) {
            $aConfig['database']['protocol'] = 'unix';
        } else {
            $aConfig['database']['protocol'] = 'tcp';
        }

        $this->aDsn['database'] = $aConfig['database'];
        $this->aDsn['table'] = $aConfig['table'];

        $this->oLogger->log('Installation started ' . OA::getNow());
        $this->oLogger->log('Attempting to connect to database ' . $this->aDsn['database']['name'] . ' with user ' . $this->aDsn['database']['username']);

        if (!$this->_createDatabase()) {
            $this->oLogger->logError('Installation failed to create the database ' . stripslashes($this->aDsn['database']['name']));
            return false;
        }
        $this->oLogger->log('Connected to database ' . $this->oDbh->connected_database_name);

        /**
         * validate table prefix before creating DB since it does not
         * make much sense to create a DB and then be unable to add tables
         */
        if (PEAR::isError(OA_DB::validateTableName($aConfig['table']['prefix'] . 'foo'))) {
            $this->oLogger->logError('Illegal characters in table prefix ' . stripslashes($aConfig['table']['prefix']));
            return false;
        }
        if (!$this->checkExistingTables()) {
            if (!$this->oLogger->errorExists) {
                $this->oLogger->logError();
            }
            return false;
        }

        if (!$this->checkPermissionToCreateTable()) {
            $this->oLogger->logError('Insufficient database permissions or incorrect database settings to install');
            return false;
        }

        if (!$this->initDatabaseConnection()) {
            $this->oLogger->logError('Installation failed to connect to the database ' . $this->aDsn['database']['name']);
            $this->_dropDatabase();
            return false;
        }

        $aConfig = $this->initDatabaseParameters($aConfig);

        if (!$this->createCoreTables()) {
            $this->oLogger->logError('Installation failed to create the core tables');
            $this->_dropDatabase();
            return false;
        }
        $this->oLogger->log('Installation created the core tables');

        $this->oAuditor->setKeyParams(
            ['upgrade_name' => 'install_' . VERSION,
                                            'version_to' => VERSION,
                                            'version_from' => 0,
                                            'logfile' => basename($this->oLogger->logFile)
                                            ]
        );

        if (!$this->oVersioner->putSchemaVersion('tables_core', $this->oTable->aDefinition['version'])) {
            $this->_auditInstallationFailure('Installation failed to update the schema version to ' . $this->oTable->aDefinition['version']);
            $this->_dropDatabase();
            return false;
        }
        $this->oLogger->log('Installation updated the schema version to ' . $this->oTable->aDefinition['version']);

        if (!$this->oVersioner->putApplicationVersion(VERSION)) {
            $this->_auditInstallationFailure('Installation failed to update the application version to ' . VERSION);
            $this->_dropDatabase();
            return false;
        }
        $this->oLogger->log('Installation updated the application version to ' . VERSION);

        $this->oConfiguration->getInitialConfig();
        if (!$this->saveConfigDB($aConfig)) {
            $this->_auditInstallationFailure('Installation failed to write database details to the configuration file ' . $this->oConfiguration->configFile);
            if (file_exists($this->oConfiguration->configPath . $this->oConfiguration->configFile)) {
                @unlink($this->oConfiguration->configPath . $this->oConfiguration->configFile);
                $this->oLogger->log('Installation deleted the configuration file ' . $this->oConfiguration->configFile);
            }
            $this->_dropDatabase();
            return false;
        }

        $this->oAuditor->logAuditAction(
            ['description' => 'UPGRADE_COMPLETE',
                                                'action' => UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                               ]
        );

        if ($this->upgrading_from_milestone_version) {
            if (!$this->removeUpgradeTriggerFile()) {
                $this->oLogger->log('failed to remove the UPGRADE trigger file');
            }
        }

        return true;
    }

    /**
     * first, record the status of plugins (enabled/disabled)
     * so that enabled plugins can be re-enabled by post-upgrade task
     * before core upgrade, all plugins should be disabled
     * flatten the caches - no menus, extensions or dependencies
     * after core upgrade, check all plugins and rebuild caches
     *
     * @param array $aPackages
     * @return boolean
     */
    public function disableAllPlugins($aPackages = '')
    {
        $file = MAX_PATH . '/var/plugins/recover/enabled.log';
        if (file_exists($file)) {
            @unlink($file);
        }
        if ($fh = fopen($file, 'w')) {
            foreach ($GLOBALS['_MAX']['CONF']['plugins'] as $name => $enabled) {
                fwrite($fh, "{$name}={$enabled};\r\n");
            }
            fclose($fh);
        }
        $this->oConfiguration->setPluginsDisabled();
        return true;
    }

    public function _auditInstallationFailure($msg)
    {
        $this->oLogger->logError($msg);
        $this->oAuditor->logAuditAction(
            ['description' => 'UPGRADE_FAILED',
                                                'action' => UPGRADE_ACTION_UPGRADE_FAILED,
                                                ]
        );
    }

    /**
     * remove the currently connected database
     *
     * @param boolean $log
     */
    public function _dropDatabase($log = true)
    {
        if ($this->can_drop_database) {
            if (OA_DB::dropDatabase($this->aDsn['database']['name'])) {
                if ($log) {
                    $this->oLogger->log('Installation dropped the database ' . $this->aDsn['database']['name']);
                }
                return true;
            }
            $this->oLogger->logError('Installation failed to drop the database ' . $this->aDsn['database']['name']);
            return false;
        } else {
            $this->oTable->dropAllTables();
            if ($log) {
                $this->oLogger->log('Installation dropped the core tables from database ' . $this->aDsn['database']['name']);
            }
            return true;
        }
    }

    /**
     * create the empty database
     *
     * @return boolean
     */
    public function _createDatabase($aDsn = '')
    {
        if ($aDsn) {
            $this->aDsn = $aDsn;
        }
        $GLOBALS['_MAX']['CONF']['database'] = $this->aDsn['database'];
        $GLOBALS['_MAX']['CONF']['table']['prefix'] = $this->aDsn['table']['prefix'];
        $GLOBALS['_MAX']['CONF']['table']['type'] = $this->aDsn['table']['type'];
        // Try connecting to the database
        $this->oDbh = OA_DB::singleton(OA_DB::getDsn($this->aDsn));
        if (PEAR::isError($this->oDbh)) {
            $GLOBALS['_OA']['CONNECTIONS'] = [];
            $GLOBALS['_MDB2_databases'] = [];

            //attempt to create DB
            $result = OA_DB::createDatabase($this->aDsn['database']['name']);
            if (PEAR::isError($result)) {
                $this->oLogger->logError($result->getMessage());
                $this->oLogger->logErrorUnlessEmpty($result->getUserInfo());
                return false;
            }
            $this->oDbh = OA_DB::changeDatabase($this->aDsn['database']['name']);
            if (PEAR::isError($this->oDbh)) {
                $this->oLogger->logError($this->oDbh->getMessage());
                $this->oLogger->logErrorUnlessEmpty($this->oDbh->getUserInfo());
                $this->oDbh = null;
                return false;
            }
            $this->oLogger->log('Database created ' . $this->aDsn['database']['name']);
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
    public function createCoreTables()
    {
        if ($this->oTable->init(MAX_PATH . '/etc/tables_core.xml')) {
            $this->oLogger->logOnly('schema definition from cache ' . ($this->oTable->cached_definition ? 'TRUE' : 'FALSE'));
            $this->oTable->dropAllTables();
            return $this->oTable->createAllTables();
        }
        return false;
    }

    public function setOpenadsInstalledOn()
    {
        $this->oConfiguration->setOpenadsInstalledOn();
    }

    /**
     * retrieve the configuration settings
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->oConfiguration->aConfig;
    }

    /**
     * save database configuration settings
     *
     * @param array $aConfig
     * @return boolean
     */
    public function saveConfigDB($aConfig)
    {
        $this->oConfiguration->setupConfigDatabase($aConfig['database']);
        $this->oConfiguration->setupConfigDatabaseCharset($aConfig['databaseCharset']);
        $this->oConfiguration->setupConfigTable($aConfig['table']);

        $this->oConfiguration->generateDeliverySecret();

        return $this->oConfiguration->writeConfig();
    }

    /**
     * save configuration settings
     *
     * @param array $aConfig
     * @return boolean
     */
    public function saveConfig($aConfig)
    {
        $this->oConfiguration->setupConfigWebPath($aConfig['webpath']);

        $aConfig['database'] = $GLOBALS['_MAX']['CONF']['database'];
        $aConfig['table'] = $GLOBALS['_MAX']['CONF']['table'];
        $this->oConfiguration->setupConfigDatabase($aConfig['database']);
        $this->oConfiguration->setupConfigTable($aConfig['table']);
        $this->oConfiguration->setupConfigStore($aConfig['store']);
        $this->oConfiguration->setupConfigPriority();
        $this->oConfiguration->setupConfigPlugins($aConfig['plugins'] ?? []);
        return $this->oConfiguration->writeConfig(true);
    }

    /**
     * prepare to execute the upgrade steps
     * assumes that you have run canUpgrade first (to detect install and determine versionInitialApplication)
     * execute milestones followed by incremental packages
     * this method is called recursively for incremental packages
     * audit each package execution
     *
     *
     * @return boolean
     */
    public function upgrade($input_file = '', $timing = 'constructive')
    {
        // only need to disable plugins once
        static $plugins_disabled;
        if (!$plugins_disabled) {
            $this->disableAllPlugins();
            $plugins_disabled = true;
        }
        // initialise database connection if necessary
        if (is_null($this->oDbh)) {
            $this->initDatabaseConnection();
        }
        if (!$this->checkPermissionToCreateTable()) {
            $this->oLogger->logError('Insufficient database permissions or incorrect database settings');
            return false;
        }
        // first deal with each of the packages in the list
        // that was compiled during detection
        if (count($this->aPackageList) > 0) {
            foreach ($this->aPackageList as $k => $this->package_file) {
                if (!$this->upgradeExecute($this->package_file)) {
                    return false;
                }
            }
        }
        // when upgrading from a milestone version such as pan or max
        // run through this upgrade again
        // else finish by doing a *version stamp* upgrade
        if ($this->upgrading_from_milestone_version) {
            // if openads installed was not on
            // set installed on so openads can be detected
            $GLOBALS['_MAX']['CONF']['openads']['installed'] = 1;
            if ($this->detectOpenads()) {
                if (!$this->upgrade()) {
                    $GLOBALS['_MAX']['CONF']['openads']['installed'] = 0;
                    $this->_removeInstalledFlagFile();
                    return false;
                }
            }
        } else {
            $version = VERSION;
            if ($this->seekFantasyUpgradeFile()) {
                $version = '999.999.999';
                $this->createFantasyRecoveryFile();
            }
            $this->package_file = 'openads_version_stamp_' . $version;
            $this->oLogger->setLogFile($this->_getUpgradeLogFileName($timing));
            $this->oDBUpgrader->logFile = $this->oLogger->logFile;
            $this->oAuditor->setUpgradeActionId();
            $this->oAuditor->setKeyParams(
                ['upgrade_name' => $this->package_file,
                                                'version_to' => $version,
                                                'version_from' => $this->getProductApplicationVersion(true),
                                                'logfile' => basename($this->oLogger->logFile)
                                                ]
            );
            $this->oAuditor->logAuditAction(
                ['description' => 'FAILED',
                                                  'action' => UPGRADE_ACTION_UPGRADE_FAILED,
                                                 ]
            );
            // Update SQL functions to the latest version
            if (PEAR::isError(OA_DB::createFunctions())) {
                $this->oLogger->logError('Failed to update SQL functions');
                $this->message = 'Failed to update SQL functions';
                return false;
            }
            // Reparse the config file to ensure that new items are loaded
            $this->oConfiguration->aConfig = $GLOBALS['_MAX']['CONF'];
            if (!$this->_upgradeConfig()) {
                $this->oLogger->logError('Failed to upgrade configuration file');
                return false;
            }
            if ($this->versionInitialApplication != $version) {
                if (!$this->oVersioner->putApplicationVersion($version)) {
                    $this->oLogger->logError('Failed to update application version to ' . $version);
                    $this->message = 'Failed to update application version to ' . $version;
                    return false;
                }
                $this->versionInitialApplication = $this->oVersioner->getApplicationVersion();
                $this->oLogger->log('Application version updated to ' . $version);
            }

            $this->oAuditor->updateAuditAction(
                ['description' => 'UPGRADE_COMPLETE',
                                                     'action' => UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                                     'confbackup' => $this->oConfiguration->getConfigBackupName()
                                                    ]
            );
            $this->_writeRecoveryFile();
            $this->_pickupNoBackupsFile();
        }

        $this->_writePostUpgradeTasksFile();
        $this->_pickupRecoveryFile();
        return true;
    }

    /**
     * save database settings and merge new settings from dist config
     *
     * @return boolean
     */
    public function _upgradeConfig()
    {
        // Reparse the config file to ensure that new items are loaded
        $this->oConfiguration->aConfig = $GLOBALS['_MAX']['CONF'];

        $aConfig['database'] = $GLOBALS['_MAX']['CONF']['database'];
        $aConfig['table'] = $GLOBALS['_MAX']['CONF']['table'];
        $aConfig = $this->initDatabaseParameters($aConfig);
        $this->saveConfigDB($aConfig);

        // Backs up the existing config file and merges any new options in
        // dist.conf.php into the main configuration, then writes the
        // configuration file out
        if (!$this->oConfiguration->backupConfig()) {
            return false;
        }
        if (!$this->oConfiguration->mergeConfig()) {
            return false;
        }
        if (!$this->oConfiguration->writeConfig()) {
            return false;
        }
        return true;
    }

    /**
     * execute an upgrade package and audit
     *
     *
     * @return boolean
     */
    public function upgradeExecute($input_file = '')
    {
        $this->oLogger->setLogFile($this->_getUpgradeLogFileName());
        $this->oDBUpgrader->logFile = $this->oLogger->logFile;
        $this->oConfiguration->clearConfigBackupName();

        if ($input_file) {
            $input_file = $this->upgradePath . $input_file;
        }
        if (!$this->_parseUpgradePackageFile($input_file)) {
            return false;
        }
        $this->oAuditor->setUpgradeActionId();  // links the upgrade_action record with database_action records
        $this->oAuditor->setKeyParams(
            ['upgrade_name' => $this->package_file,
                                            'version_to' => $this->aPackage['versionTo'],
                                            'version_from' => $this->aPackage['versionFrom'],
                                            'logfile' => basename($this->oLogger->logFile)
                                            ]
        );
        // do this here in case there is a fatal error
        // in one of the upgrade methods
        // this ensures that there is recovery info available after
        $this->oAuditor->logAuditAction(
            ['description' => 'FAILED',
                                              'action' => UPGRADE_ACTION_UPGRADE_FAILED,
                                             ]
        );
        $this->_writeRecoveryFile();
        if (!$this->runScript($this->aPackage['prescript'] ?? null)) {
            $this->oLogger->logError('Failure in upgrade prescript ' . $this->aPackage['prescript']);
            return false;
        }
        if (!$this->upgradeSchemas()) {
            $this->oLogger->logError('Failure while upgrading schemas');
            return false;
        }
        if (!$this->runScript($this->aPackage['postscript'] ?? null)) {
            $this->oLogger->logError('Failure in upgrade postscript ' . $this->aPackage['postscript']);
            return false;
        }
        if (!$this->oVersioner->putApplicationVersion($this->aPackage['versionTo'], $this->aPackage['product'] ?? null)) {
            $this->oLogger->logError('Failed to update ' . $this->aPackage['product'] . ' version to ' . $this->aPackage['versionTo']);
            $this->message = 'Failed to update ' . $this->aPackage['product'] . ' version to ' . $this->aPackage['versionTo'];
            return false;
        }
        $this->versionInitialApplication = $this->aPackage['versionTo'];
        $this->oAuditor->updateAuditAction(
            ['description' => 'UPGRADE_COMPLETE',
                                                 'action' => UPGRADE_ACTION_UPGRADE_SUCCEEDED,
                                                 'confbackup' => $this->oConfiguration->getConfigBackupName()
                                                ]
        );
        return true;
    }

    public function addPostUpgradeTask($task)
    {
        $this->aToDoList[] = $task;
    }


    /**
     * Create the admin user and account, plus a default manager, also
     * inserts admin default timezone preferences
     *
     * @param array $aAdmin
     * @param array $aPrefs
     * @return boolean
     */
    public function putAdmin($aAdmin, $aPrefs)
    {
        try {
            // init transaction
            $oDbh = OA_DB::singleton();
            $useTransaction = $oDbh->supports('transactions');
            if ($useTransaction) {
                $oDbh->beginTransaction();
            }

            // Create Admin account
            $doAccount = OA_Dal::factoryDO('accounts');
            $doAccount->account_name = 'Administrator account';
            $doAccount->account_type = OA_ACCOUNT_ADMIN;
            $adminAccountId = $doAccount->insert();

            if (!$adminAccountId) {
                throw new Exception('error creating the admin account');
            }

            // Create Manager entity
            $doAgency = OA_Dal::factoryDO('agency');
            $doAgency->name = 'Default manager';
            $doAgency->email = $aAdmin['email'];
            $doAgency->active = 1;
            $agencyId = $doAgency->insert();

            if (!$agencyId) {
                throw new Exception('error creating the manager entity');
            }

            $doAgency = OA_Dal::factoryDO('agency');
            if (!$doAgency->get($agencyId)) {
                throw new Exception('error retrieving the manager account ID');
            }

            $agencyAccountId = $doAgency->account_id;

            // Create Admin user
            $doUser = OA_Dal::factoryDO('users');
            $doUser->contact_name = 'Administrator';
            $doUser->email_address = $aAdmin['email'];
            $doUser->username = $aAdmin['name'];
            $doUser->password = \RV\Manager\PasswordManager::getPasswordHash($aAdmin['pword']);
            $doUser->default_account_id = $agencyAccountId;
            $doUser->language = $aAdmin['language'];
            $userId = $doUser->insert();

            if (!$userId) {
                throw new Exception('error creating the admin user');
            }

            $result = OA_Permission::setAccountAccess($adminAccountId, $userId);
            if (!$result) {
                throw new Exception("error creating access to admin account, account id: $adminAccountId, user ID: $userId");
            }
            $result = OA_Permission::setAccountAccess($agencyAccountId, $userId);
            if (!$result) {
                throw new Exception("error creating access to default agency account, account id: $agencyAccountId, user ID: $userId");
            }

            OA_Preferences::putDefaultPreferences($adminAccountId);

            if (!$this->putTimezoneAccountPreference($aPrefs)) {
                // rollback if fails
                throw new Exception();
            }

            if ($useTransaction) {
                $oDbh->commit();
            }
        } catch (Exception $e) {
            $this->oLogger->logErrorUnlessEmpty($e->getMessage());
            if ($useTransaction) {
                $oDbh->rollback();
            } else {
                $this->_rollbackPutAdmin();
            }
            return false;
        }
        return true;
    }


    /**
     * MyISAM has no transaction, so we are reverting changes by truncating tables
     * Assuming that this is install step and we have empty database!
     *
     * @param int $adminAccountId
     * @param int $agencyId
     * @param int $userId
     * @param bool $deletePreferences
     */
    protected function _rollbackPutAdmin()
    {
        // delete from account_preference_assoc
        $doPreferencesAssoc = OA_Dal::factoryDO('account_preference_assoc');
        $doPreferencesAssoc->whereAdd('1=1');
        $doPreferencesAssoc->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        // delete from preferences
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->whereAdd('1=1');
        $doPreferences->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        // delete from account_user_assoc
        $doUserAssoc = OA_Dal::factoryDO('account_user_assoc');
        $doUserAssoc->whereAdd('1=1');
        $doUserAssoc->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        // delete from users
        $doUser = OA_Dal::factoryDO('users');
        $doUser->whereAdd('1=1');
        $doUser->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        // delete from agency
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->whereAdd('1=1');
        $doAgency->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        // delete from accounts
        $doAccount = OA_Dal::factoryDO('accounts');
        $doAccount->whereAdd('1=1');
        $doAccount->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        // remove admin_account_id from application variables
        OA_Dal_ApplicationVariables::delete('admin_account_id');
    }

    /**
     * A method to store the timezone account preference for the admin account.
     *
     * @param array $aPrefs An array which must contain the key "timezone",
     *                      containing the desired timezone.
     * @param boolean $ignoreNoAdminAccount If true, then ignore the case
     *                                      where the admin account does not
     *                                      exist, as this is an installation,
     *                                      and the method will be called again
     *                                      later on, once the admin account
     *                                      has actually been created.
     * @return boolean True on success, false otherwise.
     */
    public function putTimezoneAccountPreference($aPrefs, $ignoreNoAdminAccount = false)
    {
        $this->oLogger->log('Preparing to set timezone preference...');
        $adminAccountId = OA_Dal_ApplicationVariables::get('admin_account_id');

        if (!$adminAccountId) {
            $this->oLogger->logError('Error getting the admin account ID');
            if ($ignoreNoAdminAccount) {
                $this->oLogger->logError('Ignoring above error when getting the admin account ID - installing, so not yet required');
                return true;
            }
            $this->oLogger->logError('Cannot ignore error getting the admin account ID - not setting the timezone preference');
            return false;
        }

        // Store the timezone selected for the admin account preference
        $timezonePreferenceId = 0;
        $doPreferences = OA_Dal::factoryDO('preferences');
        $doPreferences->preference_name = 'timezone';
        $doPreferences->find();
        if ($doPreferences->getRowCount() != 1) {
            // The timezone preference may not exist yet, create
            $this->oLogger->log('Did not find the timezone preference ID, creating in preferences table...');
            $doPreferences = OA_Dal::factoryDO('preferences');
            $doPreferences->preference_name = 'timezone';
            $doPreferences->account_type = OA_ACCOUNT_MANAGER;
            $timezonePreferenceId = $doPreferences->insert();
        } elseif ($doPreferences->fetch()) {
            // Get the preference ID
            $timezonePreferenceId = $doPreferences->preference_id;
        }
        if ($timezonePreferenceId == 0) {
            $this->oLogger->logError("Error locating the timezone preference ID");
            return false;
        }
        $this->oLogger->log("Found timezone preference ID of $timezonePreferenceId");
        // Try to locate the admin account/preference ID
        $doAccount_preference_assoc = OA_Dal::factoryDO('account_preference_assoc');
        $doAccount_preference_assoc->account_id = $adminAccountId;
        $doAccount_preference_assoc->preference_id = $timezonePreferenceId;
        $doAccount_preference_assoc->find();
        if ($doAccount_preference_assoc->getRowCount() != 1) {
            // There is no preference value yet, create it!
            $this->oLogger->log('Did not find the admin account\'s timezone association, inserting preference...');
            $doAccount_preference_assoc = OA_Dal::factoryDO('account_preference_assoc');
            $doAccount_preference_assoc->account_id = $adminAccountId;
            $doAccount_preference_assoc->preference_id = $timezonePreferenceId;
            $doAccount_preference_assoc->value = $aPrefs['timezone'];
            $result = $doAccount_preference_assoc->insert();
            if (!$result) {
                $this->oLogger->logError("Error adding admin account timezone preference of: '" . $aPrefs['timezone'] . "'");
                return false;
            }
            $this->oLogger->log("Added the admin account timezone preference of: '" . $aPrefs['timezone'] . "'");
        } else {
            // Update the preference, if required
            $this->oLogger->log('Found the admin account\'s timezone association, updating preference...');
            $doAccount_preference_assoc->fetch();
            if ($doAccount_preference_assoc->value == $aPrefs['timezone']) {
                // No need to update, it's already been set
                $this->oLogger->log('Existing admin account\'s timezone association value not changed, no update needed');
                return true;
            }
            $doAccount_preference_assoc->value = $aPrefs['timezone'];
            $result = $doAccount_preference_assoc->update();
            if (!$result) {
                $this->oLogger->logError("Error updating admin account timezone preference to: '" . $aPrefs['timezone'] . "'");
                return false;
            }
            $this->oLogger->log("Updated the admin account timezone preference to: '" . $aPrefs['timezone'] . "'");
        }
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
    public function runScript($file)
    {
        if (!$file) {
            return true;
        } elseif (file_exists($this->upgradePath . $file)) {
            $this->oLogger->log('loading script ' . $file);
            if (!@include($this->upgradePath . $file)) {
                $this->oLogger->logError('cannot include script ' . $file);
                return false;
            }
            if (empty($className)) {
                $this->oLogger->logError('missing $className variable in ' . $file);
                return false;
            }

            if (class_exists($className)) {
                $this->oLogger->log('instantiating class ' . $className);
                $oScript = new $className();
                $method = 'execute';
                if (is_callable([$oScript, $method])) {
                    $this->oLogger->log('method is callable ' . $method);
                    $aParams = [&$this];
                    if (!call_user_func([$oScript, $method], $aParams)) {
                        $this->oLogger->logError('script returned false ' . $className);
                        return false;
                    }
                    return true;
                }
                $this->oLogger->logError('method not found ' . $method);
                return false;
            }
            $this->oLogger->logError('class not found ' . $className);
            return false;
        }
        $this->oLogger->logError('script not found ' . $file);
        return false;
    }

    /**
     * test if the database username has necessary permissions
     *
     * @return boolean
     */
    public function checkPermissionToCreateTable()
    {
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];

        // If prefix is not lowercase, check for DB case sensitivity
        if ($prefix != strtolower($prefix)) {
            $result = $this->oDbh->isDBCaseSensitive();
            if (PEAR::isError($result)) {
                $this->oLogger->logError('Unable to retrieve database case sensitivity info');
                return false;
            }
            if (!$result) {
                $this->oLogger->logError('OpenX requires database case sensitivity to work with uppercase prefixes');
                return false;
            }
        }
        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();
        if (PEAR::isError($aExistingTables)) {
            $this->oLogger->logError('Unable to SHOW TABLES - check your database permissions');
            return false;
        }
        $tblTmp = $prefix . 'tmp_dbpriviligecheck';
        $tblTmpQuoted = $this->oDbh->quoteIdentifier($tblTmp, true);
        if (in_array($tblTmp, $aExistingTables)) {
            $result = $this->oDbh->exec("DROP TABLE {$tblTmpQuoted}");

            if (PEAR::isError($result)) {
                $this->oLogger->logError('Test privileges table already exists and you don\'t have permissions to remove it');
                return false;
            }
        }

        $result = $this->oDbh->exec("CREATE TABLE {$tblTmpQuoted} (tmp int)");
        if (PEAR::isError($result)) {
            $this->oLogger->logError('Failed to CREATE TABLE - check your database permissions');
            return false;
        }
        $result = $this->oDbh->manager->listTableFields($tblTmp);
        if (PEAR::isError($result)) {
            $this->oDbh->exec("DROP TABLE {$tblTmpQuoted}");
            $this->oLogger->logError('Failed to SHOW FIELDS - check your database permissions');
            return false;
        }
        $result = $this->oDbh->exec("ALTER TABLE {$tblTmpQuoted} ADD test_desc TEXT");
        if (PEAR::isError($result)) {
            $this->oDbh->exec("DROP TABLE {$tblTmpQuoted}");
            $this->oLogger->logError('Failed to ALTER TABLE - check your database permissions');
            return false;
        }
        $result = $this->oDbh->manager->createIndex($tblTmp, $tblTmp . '_idx', ['fields' => ['tmp' => [ 'sorting' => 'ascending' ]]]);
        if (PEAR::isError($result)) {
            $this->oDbh->exec("DROP TABLE {$tblTmpQuoted}");
            $this->oLogger->logError('Failed to CREATE INDEX - check your database permissions');
            return false;
        }
        $result = $this->oDbh->manager->dropIndex($tblTmp, $tblTmp . '_idx');
        if (PEAR::isError($result)) {
            $this->oDbh->exec("DROP TABLE {$tblTmpQuoted}");
            $this->oLogger->logError('Failed to DROP INDEX - check your database permissions');
            return false;
        }
        $result = $this->oDbh->exec("DROP TABLE {$tblTmpQuoted}");
        if (PEAR::isError($result)) {
            $this->oLogger->logError('Failed to DROP TABLE - check your database permissions');
            return false;
        }
        //$tblTmp = $prefix.'tmp_tmp_dbpriviligecheck';
        $result = $this->oDbh->exec("CREATE TEMPORARY TABLE {$tblTmpQuoted} (tmp int)");
        if (PEAR::isError($result)) {
            $this->oLogger->logError('Failed to CREATE TEMPORARY TABLE - check your database permissions');
            return false;
        }
        $result = $this->oDbh->exec("DROP TABLE {$tblTmpQuoted}");
        if (PEAR::isError($result)) {
            $this->oLogger->logError('Failed to DROP TEMPORARY TABLE - check your database permissions');
            return false;
        }
        $this->oLogger->log('Database settings and permissions are OK');
        return true;
    }

    /**
     * check if openads tables already exist in the specified database
     *
     * @return boolean
     */
    public function checkExistingTables()
    {
        $result = true;

        $aExistingTables = OA_DB_Table::listOATablesCaseSensitive();

        $oldTableMessagePrefix = 'Your database contains an old OpenX configuration table: ';
        $oldTableMessagePostfix = 'If you are trying to upgrade this database, please copy your existing configuration file into the var folder of this install. If you wish to proceed with a fresh installation, please either choose a new Table Prefix or a new Database.';
        if (in_array($this->aDsn['table']['prefix'] . 'config', $aExistingTables)) {
            $this->oLogger->logError($oldTableMessagePrefix . $this->aDsn['table']['prefix'] . 'config. ' . $oldTableMessagePostfix);
            return false;
        }
        if (in_array($this->aDsn['table']['prefix'] . 'preference', $aExistingTables)) {
            $this->oLogger->logError($oldTableMessagePrefix . $this->aDsn['table']['prefix'] . 'preference. ' . $oldTableMessagePostfix);
            return false;
        }
        if (in_array($this->aDsn['table']['prefix'] . 'preferences', $aExistingTables)) {
            $this->oLogger->logError($oldTableMessagePrefix . $this->aDsn['table']['prefix'] . 'preferences. ' . $oldTableMessagePostfix);
            return false;
        }
        $tablePrefixError = false;
        foreach ($aExistingTables as &$tablename) {
            if (substr($tablename, 0, strlen($this->aDsn['table']['prefix'])) == $this->aDsn['table']['prefix']) {
                $result = false;
                $this->oLogger->log('Table with the prefix ' . $this->aDsn['table']['prefix'] . ' found: ' . $tablename);
                if ($tablePrefixError == false) {
                    $this->oLogger->logError('The database you have chosen already contains tables with the prefix ' . $this->aDsn['table']['prefix']);
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
    public function upgradeSchemas()
    {
        foreach ($this->aDBPackages as &$aPkg) {
            if (!array_key_exists($aPkg['schema'], $this->versionInitialSchema)) {
                $this->versionInitialSchema[$aPkg['schema']] = $this->oVersioner->getSchemaVersion($aPkg['schema']);
            }
            $ok = false;
            if ($this->oDBUpgrader->init('constructive', $aPkg['schema'], $aPkg['version'], false)) {
                if ($this->_runUpgradeSchemaPreScript($aPkg['prescript'] ?? null)) {
                    if ($this->oDBUpgrader->upgrade($this->versionInitialSchema[$aPkg['schema']])) {
                        if ($this->_runUpgradeSchemaPostscript($aPkg['postscript'] ?? null)) {
                            $ok = true;
                        }
                    }
                }
            }
            // for now we execute destructive immediately after constructive
            if ($ok) {
                $ok = false; // start over - should return true throughout even if nothing to do
                // last param 'true' will reset the object without having to re-parse the schema
                if ($this->oDBUpgrader->init('destructive', $aPkg['schema'], $aPkg['version'], true)) {
                    if ($this->_runUpgradeSchemaPreScript($aPkg['prescript'] ?? null)) {
                        if ($this->oDBUpgrader->upgrade($this->versionInitialSchema[$aPkg['schema']])) {
                            if ($this->_runUpgradeSchemaPostscript($aPkg['postscript'] ?? null)) {
                                $ok = true;
                            }
                        }
                    }
                }
            }
            if ($ok) {
                $version = ($aPkg['stamp'] ?? '') ?: $aPkg['version'];
                $this->oVersioner->putSchemaVersion($aPkg['schema'], $version);
            } else {
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
    public function _runUpgradeSchemaPreScript($file)
    {
        if ($file) {
            if (!$this->oDBUpgrader->prepPreScript($this->upgradePath . $file)) {
                $this->oLogger->logError('schema prepping prescript: ' . $this->upgradePath . $file);
                return false;
            }
            if (!$this->oDBUpgrader->runPreScript([$this])) {
                $this->oLogger->logError('schema prepping prescript: ' . $this->upgradePath . $file);
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
    public function _runUpgradeSchemaPostScript($file)
    {
        if ($file) {
            if (!$this->oDBUpgrader->prepPostScript($this->upgradePath . $file)) {
                $this->oLogger->logError('schema prepping postscript: ' . $this->upgradePath . $file);
                return false;
            }
            if (!$this->oDBUpgrader->runPostScript([$this])) {
                $this->oLogger->logError('schema prepping postscript: ' . $this->upgradePath . $file);
                return false;
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
    public function _parseUpgradePackageFile($input_file)
    {
        $this->aPackage = [];
        $this->aDBPackages = [];


        $this->oParser->aPackage = ['db_pkgs' => []];
        $this->oParser->DBPkg_version = '';
        $this->oParser->DBPkg_stamp = '';
        $this->oParser->DBPkg_schema = '';
        $this->oParser->DBPkg_prescript = '';
        $this->oParser->DBPkg_postscript = '';
        $this->oParser->aDBPkgs = ['files' => []];
        $this->oParser->aSchemas = [];
        $this->oParser->aFiles = [];

        $this->oParser->elements = [];
        $this->oParser->element = '';
        $this->oParser->count = 0;
        $this->oParser->error = '';

        if ($input_file != '') {
            $result = $this->oParser->setInputFile($input_file);
            if (PEAR::isError($result)) {
                return $result;
            }

            $result = $this->oParser->parse();
            if (PEAR::isError($result)) {
                $this->oLogger->logError('problem parsing the package file: ' . $result->getMessage());
                return false;
            }
            if (PEAR::isError($this->oParser->error)) {
                $this->oLogger->logError('problem parsing the package file: ' . $this->oParser->error);
                return false;
            }
            $this->aPackage = $this->oParser->aPackage;
            $this->aDBPackages = $this->aPackage['db_pkgs'];
            $this->aPackage['versionFrom'] = ($this->aPackage['versionFrom'] ?? $this->versionInitialApplication);
        } else {
            // an actual package for this version does not exist so fake it
            $this->aPackage['versionTo'] = VERSION;
            $this->aPackage['versionFrom'] = $this->versionInitialApplication;
            $this->aPackage['prescript'] = '';
            $this->aPackage['postscript'] = '';
            $this->aDBPackages = [];
        }
        return true;
    }

    /**
     * retrieve the message errary
     *
     * @return boolean
     */
    public function getMessages()
    {
        return $this->oLogger->aMessages;
    }

    /**
     * not used anymore i think
     * retrieve the error array
     *
     * @return boolean
     */
    public function getErrors()
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
    public function _writeRecoveryFile()
    {
        $log = fopen($this->recoveryFile, 'a');
        $date = date('Y-m-d h:i:s');
        $auditId = $this->oAuditor->getUpgradeActionId();
        fwrite($log, "{$auditId}/{$this->package_file}/{$date};\r\n");
        fclose($log);
        return file_exists($this->recoveryFile);
    }

    /**
     * remove the recovery file
     *
     * @return boolean
     */
    public function _pickupRecoveryFile()
    {
        if (file_exists($this->recoveryFile)) {
            @unlink($this->recoveryFile);
        }
        return (!file_exists($this->recoveryFile));
    }

    /**
     * retrieves the contents of the recovery file into an array
     *
     * @return array | false
     */
    public function seekRecoveryFile()
    {
        if (file_exists($this->recoveryFile)) {
            $aContent = explode(';', file_get_contents($this->recoveryFile));
            foreach ($aContent as $k => &$v) {
                if (trim($v)) {
                    $aLine = explode('/', trim($v));
                    if (is_array($aLine) && (count($aLine) == 3) && (is_numeric($aLine[0]))) {
                        $aResult[] = [
                                            'auditId' => $aLine[0],
                                            'package' => $aLine[1],
                                            'updated' => $aLine[2],
                                            ];
                    } else {
                        return [];
                    }
                }
            }
            return $aResult;
        }
        return false;
    }

    /**
     * This method examines the recovery file (if present) and finds the first "version_from"
     * value, this allows us to know the version that this upgrade came from orignally
     *
     * It shouldn't be necessary to use this very often, but it's here if you need it
     *
     * @return mixed string/boolean The version_from string, or false if it can't be found
     */
    public function getOriginalApplicationVersion()
    {
        $aResult = $this->seekRecoveryFile();
        if (is_array($aResult) && isset($aResult[0]['auditId'])) {
            $auditId = $aResult[0]['auditId'];
            $aAudit = $this->oAuditor->queryAuditByUpgradeId($auditId);
            if (is_array($aAudit[0]) && isset($aAudit[0]['version_from'])) {
                return $aAudit[0]['version_from'];
            }
        }
        return false;
    }

    /**
     * write a list of files to be included after the upgrade
     *
     * @return boolean
     */
    public function _writePostUpgradeTasksFile()
    {
        if (!empty($this->aToDoList)) {
            $f = fopen($this->postTaskFile, 'w');
            $this->aToDoList = array_unique($this->aToDoList);
            foreach ($this->aToDoList as $k => &$v) {
                fwrite($f, "{$v};\r\n");
            }
            fclose($f);
            return file_exists($this->postTaskFile);
        }
        return true;
    }


    /**
     * Get array of post upgrade tasks
     *
     * @return array array of tasks
     */
    public function getPostUpgradeTasks()
    {
        $aTasks = [];
        if (file_exists($this->postTaskFile)) {
            $aContent = array_unique(explode(';', trim(file_get_contents($this->postTaskFile))));
            foreach ($aContent as $v) {
                $taskname = trim($v);
                if ($taskname) {
                    $aTasks[] = $taskname;
                }
            }
        }
        return $aTasks;
    }


    /**
     * Run single post upgrade task
     *
     * @param string $task task name
     * @return array contains 'task' - task name, 'file' - executed file, 'result' - task result 'errors' - array of errors if any
     */
    public function runPostUpgradeTask($task)
    {
        require_once MAX_PATH . '/lib/OX/Upgrade/PostUpgradeTask/MessagesCollector.php';

        $oldAudit = $GLOBALS['_MAX']['CONF']['audit']['enabled'];
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = 0;

        $file = $this->upgradePath . "tasks/openads_upgrade_task_" . $task . ".php";
        $upgradeTaskResult = null;
        $oMessages = new OX_Upgrade_PostUpgradeTask_MessagesCollector($this->oLogger);
        if (file_exists($file)) {
            $this->oLogger->logOnly('attempting to include file ' . $file);
            include $file;
            $this->oLogger->logOnly('executed file ' . $file);
        } else {
            $oMessages->logError('file not found ' . $file);
        }
        $aResult['task'] = $task;
        $aResult['file'] = $file;
        $aResult['result'] = $upgradeTaskResult;
        $aResult['errors'] = $oMessages->getErrors();

        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = $oldAudit;
        return $aResult;
    }


    /**
     * remove the nobackups file
     *
     * @return boolean
     */
    public function pickupPostUpgradeTasksFile()
    {
        @unlink($this->postTaskFile);
        return (!file_exists($this->postTaskFile));
    }

    /**
     * looks for the UPGRADE.FANTASY file
     *
     * @return array | false
     */
    public function seekFantasyUpgradeFile()
    {
        return file_exists(MAX_PATH . '/var/UPGRADE.FANTASY');
    }

    /**
     * copy a recovery file to a RECOVERY.FANTASY file
     *
     */
    public function createFantasyRecoveryFile()
    {
        if ($this->seekFantasyUpgradeFile()) {
            if (file_exists($this->recoveryFile)) {
                @copy($this->recoveryFile, $this->recoveryFile . '.FANTASY');
            }
        }
    }

    /**
     * identifies if upgrade without backups is requested
     *
     * @return boolean
     */
    public function _doBackups()
    {
        return (!file_exists($this->nobackupsFile));
    }

    /**
     * remove the nobackups file
     *
     * @return boolean
     */
    public function _pickupNoBackupsFile()
    {
        @unlink($this->nobackupsFile);
        return (!file_exists($this->nobackupsFile));
    }

    /**
     * build a string for naming a logfile
     * should identify it's purpose
     *
     * @param string $timing -- not used currently
     * @return string
     */
    public function _getUpgradeLogFileName($timing = 'constructive')
    {
        if ($this->package_file == '') {
            $package = 'openads_upgrade_' . VERSION;
        } else {
            $package = str_replace('.xml', '', $this->package_file);
        }
        return $package . '_' . OA::getNow('Y_m_d_h_i_s') . '.log';
    }

    /**
     * get the name of the logfile currently assigned to the logger
     *
     * @return string
     */
    public function getLogFileName()
    {
        return $this->oLogger->logFile;
    }

    /**
     * remove the upgrade file
     *
     * @return boolean
     */
    public function removeUpgradeTriggerFile()
    {
        if (file_exists(MAX_PATH . '/var/UPGRADE')) {
            return @unlink(MAX_PATH . '/var/UPGRADE');
        }
        return true;
    }

    /**
     * remove the upgrade file
     *
     * @return boolean
     */
    public function _removeInstalledFlagFile()
    {
        if (file_exists(MAX_PATH . '/var/INSTALLED')) {
            return @unlink(MAX_PATH . '/var/INSTALLED');
        }
        return true;
    }

    public function _createEmptyVarFile($filename)
    {
        $fp = fopen(MAX_PATH . '/var/' . $filename, 'a');
        fwrite($fp, "");
        fclose($fp);
        return (file_exists(MAX_PATH . '/var/' . $filename));
    }

    /**
     * retrieve the contents of the upgrade package file into an array
     * this file contains a list of all valid openads 2.3 upgrade packages
     *
     * @param string $file
     * @return array
     */
    public function _readUpgradePackagesArray($file = '')
    {
        if (!$file) {
            $file = $this->upgradePath . 'openads_upgrade_array.txt';
        }
        if (!file_exists($file)) {
            return false;
        }
        return unserialize(file_get_contents($file));
    }

    /**
     * walk an array of version information to build a list of required upgrades
     * they must be in the RIGHT order!!!
     * hence the weird sorting of keys etc..
     */
    public function getUpgradePackageList($verPrev, $aVersions = null)
    {
        $verPrev = RV::stripVersion($verPrev);
        $aFiles = [];
        if (is_array($aVersions)) {
            ksort($aVersions, SORT_NUMERIC);
            foreach ($aVersions as $release => $aMajor) {
                ksort($aMajor, SORT_NUMERIC);
                foreach ($aMajor as $major => $aMinor) {
                    ksort($aMinor, SORT_NUMERIC);
                    foreach ($aMinor as $minor => $aStatus) {
                        if (array_key_exists('-beta-rc', $aStatus)) {
                            $aKeys = array_keys($aStatus['-beta-rc']);
                            sort($aKeys, SORT_NUMERIC);
                            foreach ($aKeys as $k => $v) {
                                $version = $release . '.' . $major . '.' . $minor . '-beta-rc' . $v;
                                if (version_compare($verPrev, $version) < 0) {
                                    $aFiles[] = $aStatus['-beta-rc'][$v]['file'];
                                }
                            }
                        }
                        if (array_key_exists('-beta', $aStatus)) {
                            $aBeta = $aStatus['-beta'];
                            foreach ($aBeta as $key => $file) {
                                $version = $release . '.' . $major . '.' . $minor . '-beta';
                                if (version_compare($verPrev, $version) < 0) {
                                    $aFiles[] = $file;
                                }
                            }
                        }
                        if (array_key_exists('-dev', $aStatus)) {
                            $aDev = $aStatus['-dev'];
                            foreach ($aDev as $key => $file) {
                                $version = $release . '.' . $major . '.' . $minor . '-dev';
                                if (version_compare($verPrev, $version) < 0) {
                                    $aFiles[] = $file;
                                }
                            }
                        }
                        if (array_key_exists('-rc', $aStatus)) {
                            $aKeys = array_keys($aStatus['-rc']);
                            sort($aKeys, SORT_NUMERIC);
                            foreach ($aKeys as $k => $v) {
                                $version = $release . '.' . $major . '.' . $minor . '-rc' . $v;
                                if (version_compare($verPrev, $version) < 0) {
                                    $aFiles[] = $aStatus['-rc'][$v]['file'];
                                }
                            }
                        }
                        if (array_key_exists('-RC', $aStatus)) {
                            $aKeys = array_keys($aStatus['-RC']);
                            sort($aKeys, SORT_NUMERIC);
                            foreach ($aKeys as $k => $v) {
                                $version = $release . '.' . $major . '.' . $minor . '-RC' . $v;
                                if (version_compare($verPrev, $version) < 0) {
                                    $aFiles[] = $aStatus['-RC'][$v]['file'];
                                }
                            }
                        }
                        if (array_key_exists('file', $aStatus)) {
                            $version = $release . '.' . $major . '.' . $minor;
                            if (version_compare($verPrev, $version) < 0) {
                                $aFiles[] = $aStatus['file'];
                            }
                        }
                    }
                }
            }
        }
        return $aFiles;
    }


    public function getLogger()
    {
        return $this->oLogger;
    }
}
