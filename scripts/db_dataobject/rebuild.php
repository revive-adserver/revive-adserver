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
