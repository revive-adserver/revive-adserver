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

if (!defined('MAX_PATH'))
{
    require_once dirname(__FILE__) . '/../../init.php';
}
//  init DB_DataObject
$MAX_ENT_DIR =  MAX_PATH . '/lib/max/Dal/DataObjects';
global $pathdbo;
if ($pathdbo)
{
    $MAX_ENT_DIR =  $pathdbo;
}

$options = &PEAR::getStaticProperty('DB_DataObject', 'options');
$options = array(
    'schema_location'       => $MAX_ENT_DIR,
    'class_location'        => $MAX_ENT_DIR,
    'require_prefix'        => $MAX_ENT_DIR . '/',
    'class_prefix'          => 'DataObjects_',
    'debug'                 => 0,
    'extends'               => 'DB_DataObjectCommon',
    'extends_location'      => '/lib/max/Dal/DataObjects/DB_DataObjectCommon.php',
    'production'            => 0,
    'ignore_sequence_keys'  => 'ALL',
    'generator_strip_schema'=> 1,
    'generator_exclude_regex' => '/(data_raw_.*|data_summary_channel_.*|data_summary_zone_country.*|data_summary_zone_domain.*|data_summary_zone_site.*|data_summary_zone_source.*|database_action|z_.*)/'
);

require_once MAX_PATH . '/lib/OA/DB/DataObject/Generator.php';

$generator = new OA_DB_DataObject_Generator();
if (!isset($schema)) {
    $schema = MAX_PATH . '/etc/tables_core.xml';
}
$generator->start($schema);

?>
