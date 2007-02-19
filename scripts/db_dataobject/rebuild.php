<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: demoDataFill.php 6 2006-12-15 17:27:27Z  $
*/

    require_once './../../init.php';
    require_once MAX_PATH . '/lib/max/DB.php';
    
    $conf = $GLOBALS['_MAX']['CONF'];
    
    define('MAX_ENT_DIR', MAX_PATH . '/lib/max/Dal/DataObjects');

    //  init DB_DataObject
    $options = &PEAR::getStaticProperty('DB_DataObject', 'options');
    $options = array(
        'database'              =>  MAX_DB::getDsn(MAX_DSN_STRING), //SGL_DB::getDsn(SGL_DSN_STRING),
        'schema_location'       => MAX_ENT_DIR,
        'class_location'        => MAX_ENT_DIR,
        'require_prefix'        => MAX_ENT_DIR . '/',
        'class_prefix'          => 'DataObjects_',
        'debug'                 => 0,
        'production'            => 0,
        'ignore_sequence_keys'  => 'ALL',
        'generator_strip_schema'=> 1,
        'generator_exclude_regex' => '/data_.*/'
    );
    
    require_once 'DB/DataObject/Generator.php';
    // remove original dbdo keys file as it is unable to update an existing file
    $keysFile = MAX_ENT_DIR . '/' . $conf['db']['name'] . '.ini';
    if (is_file($keysFile)) {
        $ok = unlink($keysFile);
    }
      
    $generator = new DB_DataObject_Generator();
    $generator->start();
    
?>