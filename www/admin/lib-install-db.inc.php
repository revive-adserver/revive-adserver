<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

// Required files
require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Table/Core.php';

/*-------------------------------------------------------*/
/* Check if the database already exists                  */
/*-------------------------------------------------------*/

function phpAds_checkDatabaseExists($installvars)
{
    $dbh = MAX_DB::singleton();
    $tables = MAX_Table_Core::singleton($installvars['database_type']);
    $availabletables = array();
    $availabletables = $dbh->getListOf('tables');
    $result = false;
    foreach ($tables->tables as $k => $v) {
        if (is_array($availabletables) && in_array($installvars['table_prefix'] . $k, $availabletables)) {
            // Table exists
            $result = true;
            break;
        }
    }
    return $result;
}

/*-------------------------------------------------------*/
/* Get SQL server types                                  */
/*-------------------------------------------------------*/

function phpAds_getServerTypes()
{
    // These values must be the same as used for the
    // data access layer file names!
    $types['mysql'] = 'mysql';
    return $types;
}

/*-------------------------------------------------------*/
/* Get table types                                       */
/*-------------------------------------------------------*/

function phpAds_getTableTypes()
{
    $types['MYISAM'] = 'MyISAM';
    $types['BDB'] = 'Berkeley DB';
    $types['GEMINI'] = 'NuSphere Gemini';
    $types['INNODB'] = 'InnoDB';
    return $types;
}

function phpAds_checkTableType($type)
{
    // Assume MySQL always supports MyISAM table types
    if ($type == 'MYISAM') {
        return true;
    } else {
        $dbh = MAX_DB::singleton();
        $result = $dbh->query('SHOW VARIABLES');
        while ($row = $result->fetchRow(DB_FETCHMODE_ORDERED)) {
            if ($type == 'BDB' && $row[0] == 'have_bdb' && $row[1] == 'YES') {
                return true;
            }
            if ($type == 'GEMINI' && $row[0] == 'have_gemini' && $row[1] == 'YES') {
                return true;
            }
            if ($type == 'INNODB' && $row[0] == 'have_innodb' && $row[1] == 'YES') {
                return true;
            }
        }
    }
    return false;
}

/*-------------------------------------------------------*/
/* Get the default table type                            */
/*-------------------------------------------------------*/

function phpAds_getTableTypeDefault()
{
    return 'INNODB';
}

?>
