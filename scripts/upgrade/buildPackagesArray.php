<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

// takes globals for tests
// takes arguments when run from cli

$path = dirname(dirname(dirname(__FILE__)));

global $readPath, $writeFile;

    if ($argc>0)
    {
        $readPath = $argv[1];
        $writeFile = $argv[2];
        echo 'reading directory '.$readPath."\n";
        echo 'writing file '.$writeFile."\n";
    }
    if (is_null($readPath))
    {
        $readPath = $path.'/etc/changes';
    }
    if (is_null($writeFile))
    {
        $writeFile = $path.'/etc/changes/openads_upgrade_array.txt';
    }

    $fp = fopen($writeFile, 'w');
    if ($fp === false)
    {
        echo __FILE__.' : unable to open output file '.$writeFile."\n";
        exit();
    }
    $aVersions = array();
    $dh = opendir($readPath);
    if ($dh)
    {
        while (false !== ($file = readdir($dh)))
        {
            if (preg_match('/_upgrade_[\w\W]+\.xml/', $file, $aMatches))
            {
                preg_match('/(?P<release>[\d]+)\.(?P<major>[\d]+)\.(?P<minor>[\d]+)(?P<beta>\-beta)?(?P<rc>\-rc)?(?P<build>[\d]+)?(?P<toversion>_to_)?/', $file, $aParsed);

                // we don't want *milestone* packages included in this array  (openads_upgrade_n.n.nn_to_n.n.nn.xml)
                if (!$aParsed['toversion'])
                {
                    $release    = $aParsed['release'];
                    $major      = $aParsed['major'];
                    $minor      = $aParsed['minor'];
                    $beta       = $aParsed['beta'];
                    $rc         = $aParsed['rc'];
                    $build      = $aParsed['build'];

                    if (!isset($aVersions[$release]))
                    {
                        $aVersions[$release] = array();
                    }
                    if (!isset($aVersions[$release][$major]))
                    {
                        $aVersions[$release][$major] = array();
                    }
                    if (!isset($aVersions[$release][$major][$minor]))
                    {
                        $aVersions[$release][$major][$minor] = array();
                    }
                    if ($rc && $beta)
                    {
                        $aVersions[$release][$major][$minor][$beta.$rc][$build]['file'] = $file;
                    }
                    else if ($beta)
                    {
                        $aVersions[$release][$major][$minor][$beta]['file'] = $file;
                    }
                    else if ($rc)
                    {
                        $aVersions[$release][$major][$minor][$rc][$build]['file'] = $file;
                    }
                    else
                    {
                        $aVersions[$release][$major][$minor]['file'] = $file;
                    }
                }
            }
        }
        closedir($dh);
    }
    reset($aVersions);
    $array = serialize($aVersions);
    $x = fwrite($fp, $array);
    fclose($fp);
//    if (!file_exists($writeFile))
//    {
//        echo 'file was not written '.$writeFile."\n";
//    }
//    else
//    {
//        echo 'file written '.$writeFile."\n";
//    }

?>