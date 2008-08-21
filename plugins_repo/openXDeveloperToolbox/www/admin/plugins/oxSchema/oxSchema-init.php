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
 * @author  Monique Szpak <monique.szpak@openx.org>
 *
 * $Id$
 *
 */

/**
 * routing
 * require libs
 * determine the active schema
 * pass xajax calls along
 * handle cookies
 */
require_once 'oxSchema-common.php';

if (array_key_exists('btn_changeset_archive', $_POST))
{
    header('Location: archive.php');
    exit;
}

if (array_key_exists('clear_cookies', $_POST))
{
    setcookie('schemaPath', '');
    setcookie('schemaFile', '');
}
else if ( array_key_exists('xml_file', $_REQUEST) && (!empty($_REQUEST['xml_file'])) )
{
    $schemaPath = dirname($_REQUEST['xml_file']);
    if (!empty($schemaPath))
    {
        $schemaPath.= DIRECTORY_SEPARATOR;
    }
    $schemaFile = basename($_REQUEST['xml_file']);
    if ($schemaFile==$_COOKIE['schemaFile'])
    {
        $schemaPath = $_COOKIE['schemaPath'];
    }
    $_POST['table_edit'] = '';
}
else if ( array_key_exists('schemaFile', $_COOKIE) && (!empty($_COOKIE['schemaFile'])))
{
    $schemaPath = $_COOKIE['schemaPath'];
    $schemaFile = $_COOKIE['schemaFile'];
}
if (empty($schemaPath) || empty($schemaFile))
{
    $schemaPath = '';
    $schemaFile = 'tables_core.xml';
}
setcookie('schemaPath', $schemaPath);
setcookie('schemaFile', $schemaFile);

require_once 'lib/oxSchema.inc.php';
global $oSchema;
$oSchema = & new openXSchemaEditor($schemaFile, '', $schemaPath);

?>