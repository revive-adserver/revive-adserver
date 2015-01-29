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

/**
 * OpenX Developer Toolbox
 */

require_once './init.php';

if (array_key_exists('btn_create',$_POST) && array_key_exists('name',$_POST))
{
    global $pathPluginsTmp;
    $pathPluginsTmp = MAX_PATH.'/var/tmp'.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'];
    if (_fileMissing($pathPluginsTmp))
    {
        return false;
    }
    $aPluginValues = $_POST;
    $aPluginValues['date'] = date('Y-d-m');
    $aPluginValues['oxversion'] = VERSION;
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
            $aPluginValues['grouporder'][] = $aVals['group'];
            putGroup($aVals);
        }
    }
    putPlugin($aPluginValues);
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

include 'templates/plugin.html';


?>
