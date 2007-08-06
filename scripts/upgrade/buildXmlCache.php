<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

if (PHP_SAPI == 'cli') {
    $maxPath = '';
    if ($argc < 3) {
        $aTry = array('.', '..', '../..');
        foreach ($aTry as $dir) {
            $xmlcachePath = $dir.'/etc/xmlcache';
            if (file_exists($xmlcachePath) && is_dir($xmlcachePath)) {
                $maxPath = $dir;
                break;
            }
        }
        if (empty($maxPath)) {
            die ("Couldn't detect the correct path, use: {$argv[0]} <domain> <openads_path>\n");
        }
    } else {
        $xmlcachePath = $argv[2].'/etc/xmlcache';
        if (file_exists($xmlcachePath) && is_dir($xmlcachePath)) {
            $maxPath = $dir;
        }
        if (empty($maxPath)) {
            die ("The specified path is wrong, use: {$argv[0]} <domain> <openads_path>\n");
        }
    }

    define('MAX_PATH', $maxPath);
    require MAX_PATH . '/init.php';
} else {
    define('MAX_PATH', realpath('../..'));
    require MAX_PATH . '/init.php';

    @set_time_limit(600);
}

if (!is_writable(MAX_PATH.'/etc/xmlcache')) {
    die("The directory ".MAX_PATH.'/etc/xmlcache'." is not writable\n");
}


require MAX_PATH . '/lib/OA/DB/Table.php';

/*
$aTableFiles = array();
$aFiles = array_merge($aFiles, );
$aFiles = array_merge($aFiles, glob($etcPath.'/changes/changes_tables_*.xml'));
$aFiles = array_merge($aFiles, glob($etcPath.'/changes/schema_tables_*.xml'));
*/

$oDbh = OA_DB::singleton();
$oCache = new OA_DB_XmlCache();

$aOptions = array('force_defaults'=>false);

$aSkipFiles = array(
    'tables_core_2_0_12.xml'
);

clean_up();

foreach (glob(MAX_PATH.'/etc/tables_*.xml') as $fileName) {
    if (!in_array(baseName($fileName), $aSkipFiles)) {
        echo basename($fileName).": "; flush();
        $oSchema = &MDB2_Schema::factory($oDbh, $aOptions);
        $result = $oSchema->parseDatabaseDefinitionFile($fileName, true);
        if (PEAR::isError($result)) {
            clean_up();
            die("failed\n");
        } else {
            $oCache->save($result, $fileName);
            echo "processed"; eol_flush();
        }
    }
}

foreach (glob(MAX_PATH.'/etc/changes/schema_tables_*.xml') as $fileName) {
    if (!in_array(baseName($fileName), $aSkipFiles)) {
        echo basename($fileName).": "; flush();
        $oSchema = &MDB2_Schema::factory($oDbh, $aOptions);
        $result = $oSchema->parseDatabaseDefinitionFile($fileName, true);
        if (PEAR::isError($result)) {
            clean_up();
            die("failed\n");
        } else {
            $oCache->save($result, $fileName);
            echo "processed"; eol_flush();
        }
    }
}

foreach (glob(MAX_PATH.'/etc/changes/changes_tables_*.xml') as $fileName) {
    if (!in_array(baseName($fileName), $aSkipFiles)) {
        echo basename($fileName).": "; flush();
        $oSchema = &MDB2_Schema::factory($oDbh, $aOptions);
        $result = $oSchema->parseChangesetDefinitionFile($fileName);
        if (PEAR::isError($result, $result)) {
            clean_up();
            die("failed\n");
        } else {
            $oCache->save($result, $fileName);
            echo "processed"; eol_flush();
        }
    }
}

function eol_flush()
{
    echo (PHP_SAPI != 'cli' ? '<br />' : '')."\n";
    flush();
}

function clean_up()
{
    foreach (glob(MAX_PATH.'/etc/xmlcache/cache_*') as $fileName) {
        unlink($fileName);
    }
}
?>
