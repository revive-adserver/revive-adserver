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
if (array_key_exists('file', $_POST))
{
    // do stuff
    // save as next version xml
    // to the /var folder
    // status = transitional
}

header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
readfile($file);
exit();

// comment the above and uncomment below to test/play with xAjax
//include 'index.html';

?>

