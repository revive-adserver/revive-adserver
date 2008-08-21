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
    global $pathPluginTmp;
    $target = $pathPluginTmp.'extensions/etc/plugin.xml';
    $source = 'etc/elements/header.xml.tpl';

    $dataSource = file_get_contents($source);
    foreach ($aVals AS $k => $v)
    {
        $dataSource = str_replace('{'.strtoupper($k).'}', $v, $dataSource);
    }
    $section    = '{HEADER}';
    $dataTarget = file_get_contents($target);
    $dataTarget = str_replace($section, $dataSource, $dataTarget);
    foreach ($aVals['grouporder'] AS $i => $group)
    {
        $dataTarget = str_replace('{GROUP'.$i.'}', $group, $dataTarget);
    }
    $i = file_put_contents($target, $dataTarget);

    copy($target, str_replace('plugin',$aVals['name'], $target));
    unlink($target);

    $target = $pathPluginTmp.'extensions/etc/plugin.readme.txt';
    copy($target, str_replace('plugin',$aVals['name'], $target));
    unlink($target);
}

function putGroup($aVals)
{
    global $pathPluginTmp, $pathAdminTmp;
    $pathGroupTmp = $pathPluginTmp.'extensions/etc/'.$aVals['group'].'/';

    $target = $pathGroupTmp.'group.xml';
    $dataTarget = file_get_contents($target);

    $fileSource = 'etc/elements/header.xml.tpl';
    $dataSource = file_get_contents($fileSource);
    $dataTarget = str_replace('{HEADER}', $dataSource, $dataTarget);

    $fileSource = 'etc/elements/files-'.$aVals['extension'].'.xml.tpl';
    if (!file_exists($source))
    {
        $fileSource = 'etc/elements/files-generic.xml.tpl';
    }
    $dataSource = file_get_contents($fileSource);
    $dataTarget = str_replace('{FILES}', $dataSource, $dataTarget);

    if ($aVals['extension']=='admin')
    {
        $fileSource = 'etc/elements/navigation.xml.tpl';
        $dataSource = file_get_contents($fileSource);
        $dataTarget = str_replace('{NAVIGATION}', $dataSource, $dataTarget);
    }
    else
    {
        $dataTarget = str_replace('{NAVIGATION}', '', $dataTarget);
    }

    foreach ($aVals AS $k => $v)
    {
        $dataTarget = str_replace('{'.strtoupper($k).'}', $v, $dataTarget);
    }
    $i = file_put_contents($target, $dataTarget);

    copy($target, str_replace('group',$aVals['name'], $target));
    unlink($target);

    $target = $pathGroupTmp.'processSettings.php';
    $dataTarget = file_get_contents($target);
    $dataTarget = str_replace('{GROUP}', $aVals['group'], $dataTarget);
    $i = file_put_contents($target, $dataTarget);

    $target = $pathGroupTmp.'processPreferences.php';
    $dataTarget = file_get_contents($target);
    $dataTarget = str_replace('{GROUP}', $aVals['group'], $dataTarget);
    $i = file_put_contents($target, $dataTarget);

    $target = $pathGroupTmp.'etc/postscript_install_group.php';
    $dataTarget = file_get_contents($target);
    $dataTarget = str_replace('{GROUP}', $aVals['group'], $dataTarget);
    $i = file_put_contents($target, $dataTarget);
    copy($target, str_replace('group',$aVals['name'], $target));
    unlink($target);

    $target = $pathGroupTmp.'etc/prescript_install_group.php';
    $dataTarget = file_get_contents($target);
    $dataTarget = str_replace('{GROUP}', $aVals['group'], $dataTarget);
    $i = file_put_contents($target, $dataTarget);
    copy($target, str_replace('group',$aVals['name'], $target));
    unlink($target);

    if ($aVals['extension']=='admin')
    {
        $aAdminFiles[] = $pathAdminTmp.'lib/group.inc.php';
        $aAdminFiles[] = $pathAdminTmp.'templates/group.html';
        $aAdminFiles[] = $pathAdminTmp.'group-common.php';
        $aAdminFiles[] = $pathAdminTmp.'group-index.php';

        foreach ($aAdminFiles as $target)
        {
            $dataTarget = file_get_contents($target);
            foreach ($aVals AS $k => $v)
            {
                $dataTarget = str_replace('{'.strtoupper($k).'}', $v, $dataTarget);
            }
            $i = file_put_contents($target, $dataTarget);
            copy($target, str_replace('group',$aVals['group'], $target));
            unlink($target);
        }
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
