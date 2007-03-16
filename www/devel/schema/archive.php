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
/**
 * Openads Schema Management Utility
 *
 * @author Monique Szpak <monique.szpak@openads.org>
 *
 * $Id$
 *
 */

function getLastChangeset()
{
    $opts = '';
    $dh = opendir(MAX_CHG);
    if ($dh) {
        while (false !== ($file = readdir($dh))) {
            if (strpos($file, '.xml')>0)
            {
                return $file;
            }
        }
        closedir($dh);
    }
    return false;
}

require_once '../../../init.php';
define('MAX_DEV', MAX_PATH.'/www/devel');
define('MAX_CHG', MAX_PATH.'/etc/changes/');

if (array_key_exists('select_changesets', $_POST))
{
    $file = MAX_CHG.$_POST['select_changesets'];
    setcookie('changesetFile', basename($file));
}
else if (array_key_exists('xajax', $_POST))
{
   $file = $_COOKIE['changesetFile'];
}
else {
    $file = MAX_CHG.getLastChangeset();
    setcookie('changesetFile', basename($file));
}
require_once MAX_DEV.'/lib/xajax.inc.php';

if ($file && file_exists($file))
{
    header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
    readfile($file);
    exit();
}
else
{
    echo 'Error reading file: '.MAX_CHG.$file;
}
?>
