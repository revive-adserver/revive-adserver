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

require_once './init.php';

if (array_key_exists('name',$_REQUEST) && ($_REQUEST['name']=='OpenXCore'))
{

    $data = file_get_contents(MAX_PATH.'/etc/version.properties');
    /*openx.version.minor=7
    openx.version.major=2
    openx.version.line=dev
    openx.version.revision=13
    openx.version.status=dev*/

    preg_match('/openx.version.rc=(?P<rc>[\d]+)\nopenx.version.minor=(?P<minor>[\d]+)\nopenx.version.major=(?P<major>[\d]+)\nopenx.version.line=(?P<line>[\w]+)\nopenx.version.revision=(?P<revision>[\d]+)\nopenx.version.status=(?P<status>[\w]+)/', $data, $aMatches);

    $version = $aMatches['major'].'.'.$aMatches['minor'].'.'.$aMatches['revision'];
    if ($aMatches['status'])
    {
        $version.= '-'.$aMatches['status'];
    }

    $aValues['date'] = date('Y-d-m');
    $aValues['version'] = $version;
    putPackage($aValues);
}

function putPackage($aVals)
{
    $source = 'templates/changes/openads_upgrade.xml';
    $target = MAX_PATH.'/etc/changes/openads_upgrade_'.$aVals['version'].'.xml';

    if (_fileExists($target))
    {
        unlink($target);
    }
    if (!_putFile($source, $target, $aVals) ||
        _fileMissing($target))
    {
        exit(1);
    }
}

function _putFile($source, $target, $aVals)
{
    $data = file_get_contents($source);
    foreach ($aVals AS $k => $v)
    {
        $data = str_replace('{'.strtoupper($k).'}', $v, $data);
    }
    $i = file_put_contents($target, $data);
    if (!$i)
    {
        echo 'Error writing file '.$target;
        return false;
    }
    return true;
}

function _fileExists($file)
{
    if (file_exists($file))
    {
        echo 'File exists '.$file;
        return true;
    }
    return false;
}

function _fileMissing($file)
{
    if (!file_exists($file))
    {
        echo 'File not found '.$file;
        return true;
    }
    return false;
}

?>
