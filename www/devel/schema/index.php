<?php

/**
 * Openads Schema Management Utility
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id $
 *
 */

define('MAX_PATH', dirname(__FILE__).'/../../..');
define('MAX_DEV', dirname(__FILE__).'/..');
define('MAX_XSL', MAX_DEV.'/schema/xsl');
define('MAX_PEAR', MAX_PATH.'/lib/pear/');

require_once MAX_DEV.'/lib/pear.inc.php';
require_once MAX_DEV.'/lib/oaclass.error.php';
require_once 'MDB2.php';
require_once 'MDB2/Schema.php';
require_once 'funcs.php';  // this contains the functions registered with xajax
//include xajax itself after the xajax registration funcs
require_once MAX_DEV.'/lib/xajax.inc.php'; // this instantiates xajax object and registers the functions
require_once MAX_PATH.'/lib/openads/Dal.php';

$file_schema_core = 'tables_core.xml';
$path_schema_final = MAX_PATH.'/etc/';
$path_schema_trans = MAX_PATH.'/var/';

if (file_exists($path_schema_trans.$file_schema_core))
{
    $file = $path_schema_trans.$file_schema_core;
}
else if (file_exists($path_schema_final.$file_schema_core))
{
    $file = $path_schema_final.$file_schema_core;
}
if (count($_POST)>0)
{
    // need some dsn info to make connection
    // even though we won't actually connect to the server
    // don't need to enter username/password/database
    // unless you need to connect for some reason
    // for parsing just the host and db type is required
    $dsn['phptype']     = 'mysql';
    $dsn['hostspec']    = 'localhost';
    $dsn['username']    = '';
    $dsn['password']    = '';
    $dsn['database']    = '';
    // required by Openads_Dal which would normally get it from conf.ini after init
    $GLOBALS['_MAX']['CONF']['database']['type'] = $dsn['phptype'];

    $schema = & MDB2_Schema::factory(Openads_Dal::singleton($dsn), $options);
}
if (array_key_exists('table_edit', $_POST))
{
    $db_definition = $schema->parseDatabaseDefinitionFile($file);
    $table = $_POST['table_edit'];
    $tbl_definition = $db_definition['tables'][$table];
}
else if (array_key_exists('table_add', $_POST))
{
    // do new table stuff
}

header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
readfile($file);
exit();

// comment the above and uncomment below to test/play with xAjax
//include 'index.html';

?>

