<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

define('TEST_ENVIRONMENT_RUNNING', true);

$argc = 2;
$argv = array($argv[0], 'test');

require_once dirname(__FILE__) . '/../../init.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/Table.php';

$conf = &$GLOBALS['_MAX']['CONF'];
$conf['table']['prefix'] = '';

if ($conf['database']['type'] != 'mysql') {
    die ("This script does currently work only with MySQL databases\n");
}

$oDbh = OA_DB::singleton();
if (!PEAR::isError($oDbh)) {
    $oDbh->disconnect();
    OA_DB::dropDatabase($conf['database']['name']);
}
OA_DB::createDatabase($conf['database']['name']);
OA_DB::changeDatabase($conf['database']['name']);

$oTbl = new OA_DB_Table();
$oTbl->init(MAX_PATH.'/etc/tables_core.xml');
$oTbl->createAllTables();

//  init DB_DataObject
$MAX_ENT_DIR =  MAX_PATH . '/lib/max/Dal/DataObjects';
$options = &PEAR::getStaticProperty('DB_DataObject', 'options');
$options = array(
    'database'              => OA_DB::getDsn(),
    'schema_location'       => $MAX_ENT_DIR,
    'class_location'        => $MAX_ENT_DIR,
    'require_prefix'        => $MAX_ENT_DIR . '/',
    'class_prefix'          => 'DataObjects_',
    'debug'                 => 0,
    'extends'               => 'DB_DataObjectCommon',
    'extends_location'      => 'DB_DataObjectCommon.php',
    'production'            => 0,
    'ignore_sequence_keys'  => 'ALL',
    'generator_strip_schema'=> 1,
    'generator_exclude_regex' => '/(data_raw_.*|data_summary_channel_.*|data_summary_zone_country.*|data_summary_zone_domain.*|data_summary_zone_site.*|data_summary_zone_source.*|database_action|z_.*)/'
);

require_once 'DB/DataObject/Generator.php';
// remove original dbdo keys file as it is unable to update an existing file
$schemaFile = $MAX_ENT_DIR . '/db_schema.ini';
if (is_file($schemaFile)) {
    unlink($schemaFile);
}

$generator = new DB_DataObject_Generator();
$generator->start();

// rename schema ini file
$newSchemaFile = $MAX_ENT_DIR . '/' . $conf['database']['name'] . '.ini';
rename($newSchemaFile, $schemaFile);

?>
