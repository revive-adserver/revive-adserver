<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

define('MAX_PATH', dirname(__FILE__) . '/../..');
define('OX_PATH', dirname(__FILE__) . '/../..');
error_reporting(E_ALL);

// setup environment - do not require config file
require_once MAX_PATH . '/init-parse.php';
require_once MAX_PATH . '/constants.php';
require_once MAX_PATH . '/memory.php';
require_once MAX_PATH . '/variables.php';
setupServerVariables();
// set conf array to prevent loading config file
$GLOBALS['_MAX']['CONF'] = array();
$GLOBALS['_MAX']['CONF']['log']['enabled'] = false;
$GLOBALS['_MAX']['CONF']['webpath'] = null;
$GLOBALS['_MAX']['CONF']['openads']['sslPort'] = null;
$GLOBALS['_MAX']['HTTP'] = null;
// set pear path
$newPearPath = MAX_PATH . DIRECTORY_SEPARATOR.'lib' . DIRECTORY_SEPARATOR . 'pear';
if (!empty($existingPearPath)) {
    $newPearPath .= PATH_SEPARATOR . $existingPearPath;
}
ini_set('include_path', $newPearPath);
$GLOBALS['_MAX']['CONF']['database']['type'] = 'mysql';

setupConstants();
setupConfigVariables();
@set_time_limit(600);
OX_increaseMemoryLimit(OX_getMinimumRequiredMemory('cache'));


if (!is_writable(MAX_PATH.'/etc/xmlcache')) {
    die("The directory ".MAX_PATH.'/etc/xmlcache'." is not writable\n");
}

require MAX_PATH . '/lib/OA/DB/Table.php';

// Create a database mock so we will not have to connect to database itself
require_once MAX_PATH . '/lib/simpletest/mock_objects.php';
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
generateXmlCache(glob(MAX_PATH.'/etc/tables_*.xml'));
generateXmlCache(glob(MAX_PATH.'/etc/changes/schema_tables_*.xml'));
generateXmlCache(glob(MAX_PATH.'/etc/changes/changes_tables_*.xml'), 'parseChangesetDefinitionFile');

function generateXmlCache($xmlFiles, $callback = 'parseDatabaseDefinitionFile')
{
    global $aSkipFiles, $aOptions, $oDbh, $oCache;

    foreach ($xmlFiles as $fileName) {
        if (!in_array(baseName($fileName), $aSkipFiles)) {
            echo basename($fileName).": "; flush();
            $oSchema = &MDB2_Schema::factory($oDbh, $aOptions);
            $result = $oSchema->$callback($fileName, true);
            if (PEAR::isError($result)) {
                clean_up();
                die("failed\n");
            } else {
                $oCache->save($result, $fileName);
                echo "processed"; eol_flush();
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
    foreach (glob(MAX_PATH.'/etc/xmlcache/cache_*') as $fileName) {
        unlink($fileName);
    }
}
?>
