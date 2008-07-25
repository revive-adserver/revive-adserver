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

require_once './init.php';

if (array_key_exists('btn_create',$_POST) && array_key_exists('name',$_POST))
{
    $aPluginValues = $_POST;
    $aPluginValues['date'] = date('Y-d-m');
    $aPluginValues['oxversion'] = OA_VERSION;
    $aGroupValues = $aPluginValues['group'];
    unset($aPluginValues['group']);

    if ($aGroupValues)
    {
        foreach ($aGroupValues as $name => $aVal)
        {
            $aVals = $aPluginValues;
            $aVals['extension'] = $name;
            $aVals['component'] = $aVal['componentname'];
            $aVals['group'] = $aVal['groupname'];
            putGroup($aVals);
        }
    }
    putPlugin($aPluginValues);
}

function putPlugin($aVals)
{
    $source = 'templates/plugins/plugin.xml';
    $target = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'].$aVals['name'].'.xml';

    if (_fileExists($target) ||
        (!_putFile($source, $target, $aVals)) ||
        _fileMissing($target))
    {
        exit(1);
    }
    $target = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'].$aVals['name'].'.readme.txt';
    if ($fp = fopen($target, 'w')
    {
        fclose($fp);
    }
}

function putGroup($aVals)
{
    $path = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'].$aVals['group'];
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

include 'templates/plugin.html';


?>
