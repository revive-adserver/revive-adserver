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
 * OpenX Developer Toolbox
 *
 * @author     Monique Szpak <monique.szpak@openx.org>
 * $Id$
 *
 */

function getExtensionList()
{
    require_once(LIB_PATH.'/Extension.php');
    return OX_Extension::getAllExtensionsArray();
}

function putPlugin($aVals)
{
    global $pathPluginsTmp;
    $target = $pathPluginsTmp.$aVals['name'].'.xml';
    $source = 'templates/plugins/plugin.xml';

    if (_fileExists($target) ||
        (!_putFile($source, $target, $aVals)) ||
        _fileMissing($target))
    {
        exit(1);
    }
    $target = MAX_PATH.'/var'.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'].$aVals['name'].'.readme.txt';
    if ($fp = fopen($target, 'w'))
    {
        fclose($fp);
    }
    $data = file_get_contents($target);
    foreach ($aVals['grouporder'] AS $i => $group)
    {
        $data = str_replace('{GROUP'.$i.'}', $group, $data);
    }
    $i = file_put_contents($target, $data);
}

function putGroup($aVals)
{
    global $pathPluginsTmp;
    $path = $pathPluginsTmp.$aVals['group'];
    $source = 'templates/plugins/group'.ucfirst($aVals['extension']).'/group'.ucfirst($aVals['extension']).'.xml';
    $target  = $path.'/'.$aVals['group'].'.xml';

    if (_fileExists($path)  ||
        _fileExists($target) ||
        (!_makeDir($path)) ||
        (!_putFile($source, $target, $aVals)) ||
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

function _makeDir($path)
{
    if (!mkdir($path))
    {
        echo 'Failed to create path '.$path;
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
