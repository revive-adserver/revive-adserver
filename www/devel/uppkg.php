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
    $file = putPackage($aValues);
    if ($file)
    {
        header('Content-Type: application/xhtml+xml; charset=ISO-8859-1');
        readfile(putPackage($aValues));
        exit();
    }
}

function putPackage($aVals)
{
    $source = 'templates/changes/openads_upgrade.xml';
    $target = MAX_PATH.'/etc/changes/openads_upgrade_'.$aVals['version'].'.xml';

    if (_fileExists($target))
    {
        return $target;
    }
    if (!_putFile($source, $target, $aVals) ||
        _fileMissing($target))
    {
        exit(1);
    }
    return $target;
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
        //echo 'File exists '.$file;
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
