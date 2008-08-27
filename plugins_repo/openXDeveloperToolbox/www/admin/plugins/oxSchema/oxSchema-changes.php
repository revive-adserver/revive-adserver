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
/**
* OpenX Schema Management Utility
*
* @author     Monique Szpak <monique.szpak@openx.org>
*
* $Id$
*
*/
require_once '../../../../init.php';

if ( array_key_exists('schemaFile', $_COOKIE) && (!empty($_COOKIE['schemaFile'])))
{
    $schemaPath = $_COOKIE['schemaPath'];
    $schemaFile = $_COOKIE['schemaFile'];
}
if (empty($schemaPath) || empty($schemaFile))
{
    $schemaPath = '';
    $schemaFile = 'tables_core.xml';
}
if (array_key_exists('changesetFile', $_COOKIE) && ($_COOKIE['changesetFile']))
{
    $changesFile = $_COOKIE['changesetFile'];
}
if (empty($changesFile))
{
    $changesFile = MAX_PATH.'/var/changes_tables_core.xml';
}

if (array_key_exists('btn_field_save', $_POST))
{
    require_once 'lib/oxSchema.inc.php';
    $oSchema = & new openXSchemaEditor($schemaFile, $changesFile, $schemaPath);

    $table_name = $_POST['table_name'];
    $field_name = $_POST['fld_old_name'];
    $field_name_was = $_POST['fld_new_name'];
    $oSchema->fieldWasSave($changesFile, $table_name, $field_name, $field_name_was);
}
else if (array_key_exists('btn_table_save', $_POST))
{
    require_once 'lib/oxSchema.inc.php';
    $oSchema = & new openXSchemaEditor($schemaFile, $changesFile, $schemaPath);

    //$table_name = $_POST['table_name'];
    $table_name = $_POST['tbl_old_name'];
    $table_name_was = $_POST['tbl_new_name'];

    $oSchema->tableWasSave($changesFile, $table_name, $table_name_was);
}

require_once 'lib/oxAjax.inc.php';

if ($changesFile && file_exists($changesFile))
{
    header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
    readfile($changesFile);
    exit();
}
else
{
    if ($file)
    {
        echo 'archive.php: error reading '.$changesFile;
    }
    else
    {
        echo '<h2 style="font-family: Arial, Helvetica, sans-serif;text-align:center;">no changesets in archive</h2>';
    }
//    header('Location: oxSchema-frame.php');
//    exit;
}

?>