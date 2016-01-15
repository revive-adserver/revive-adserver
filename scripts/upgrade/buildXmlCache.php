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

// Protect this script to be used only from command-line
if (php_sapi_name() != 'cli') {
    echo "Sorry, this script must be run from the command-line";
    exit;
}

error_reporting(E_ALL & ~(E_NOTICE | E_WARNING | E_DEPRECATED | E_STRICT));

echo "=> STARTING TO REFRESH THE MDB2 SCHEMA XML FILE CACHE\n";

// Set the RV_PATH constant (this assumes that the script is located in
// RV_PATH . '/scripts/upgrade'
define('RV_PATH', dirname(dirname(dirname(__FILE__))));

define('MAX_PATH', dirname(__FILE__) . '/../..');
define('OX_PATH', dirname(__FILE__) . '/../..');
error_reporting(E_ALL);

// setup environment - do not require config file
require_once RV_PATH . '/init-parse.php';
require_once RV_PATH . '/constants.php';
require_once RV_PATH . '/memory.php';
require_once RV_PATH . '/variables.php';
setupServerVariables();

// set conf array to prevent loading config file
$GLOBALS['_MAX']['CONF'] = array();
$GLOBALS['_MAX']['CONF']['log']['enabled'] = false;
$GLOBALS['_MAX']['CONF']['webpath'] = null;
$GLOBALS['_MAX']['CONF']['openads']['sslPort'] = null;
$GLOBALS['_MAX']['HTTP'] = null;

// set pear path
$newPearPath = RV_PATH . DIRECTORY_SEPARATOR.'lib' . DIRECTORY_SEPARATOR . 'pear';
if (!empty($existingPearPath)) {
    $newPearPath .= PATH_SEPARATOR . $existingPearPath;
}
ini_set('include_path', $newPearPath);
$GLOBALS['_MAX']['CONF']['database']['type'] = 'mysql';

setupConstants();
setupConfigVariables();
@set_time_limit(600);
OX_increaseMemoryLimit(OX_getMinimumRequiredMemory('cache'));

error_reporting(E_ALL & ~(E_NOTICE | E_WARNING | E_DEPRECATED | E_STRICT));

if (!is_writable(RV_PATH.'/etc/xmlcache')) {
    die("=> The directory ".RV_PATH.'/etc/xmlcache'." is not writable\n");
}

require RV_PATH . '/lib/OA/DB/Table.php';

// Create a database mock so we will not have to connect to database itself
require_once RV_PATH . '/lib/simpletest/mock_objects.php';
require_once 'MDB2/Driver/mysql.php';
Mock::generatePartial('MDB2_Driver_mysql', 'MDB2_Mock', array());
$oDbh = new MDB2_Mock;
$oDbh->__construct();

// add datatype mapping
$aDatatypeOptions = OA_DB::getDatatypeMapOptions();
MDB2::setOptions($oDbh, $aDatatypeOptions);

$oCache = new OA_DB_XmlCache();

$aOptions = array('force_defaults'=>false);
$aSkipFiles = array(
);

clean_up();

// Generate XML caches
generateXmlCache(glob(RV_PATH.'/etc/tables_*.xml'));
generateXmlCache(glob(RV_PATH.'/etc/changes/schema_tables_*.xml'));
generateXmlCache(glob(RV_PATH.'/etc/changes/changes_tables_*.xml'), 'parseChangesetDefinitionFile');

echo "=> FINISHED REFRESHING THE MDB2 SCHEMA XML FILE CACHE\n\n";

function generateXmlCache($xmlFiles, $callback = 'parseDatabaseDefinitionFile')
{
    global $aSkipFiles, $aOptions, $oDbh, $oCache;

    foreach ($xmlFiles as $fileName) {
        if (!in_array(baseName($fileName), $aSkipFiles)) {
            echo "  => " . basename($fileName).": "; flush();
            $oSchema = &MDB2_Schema::factory($oDbh, $aOptions);
            $result = $oSchema->$callback($fileName, true);
            if (PEAR::isError($result)) {
                clean_up();
                die("Failed\n");
            } else {
                $oCache->save($result, $fileName);
                echo "Processed"; eol_flush();
            }
            unset($result);
        }
    }
}

function eol_flush()
{
    echo (PHP_SAPI != 'cli' ? '<br />' : '')."\n";
    flush();
}

function clean_up()
{
    foreach (glob(RV_PATH.'/etc/xmlcache/cache_*') as $fileName) {
        unlink($fileName);
    }
}

?>