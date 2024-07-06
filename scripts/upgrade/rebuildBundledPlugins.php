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

// Protect this script to be used only from command-line
if (php_sapi_name() != 'cli') {
    echo "Sorry, this script must be run from the command-line";
    exit;
}

error_reporting(E_ALL & ~(E_NOTICE | E_WARNING | E_DEPRECATED | E_STRICT));

echo "=> STARTING TO UPDATE THE BUNDLED PLUGINS\n";

define('MAX_PATH', realpath(__DIR__ . '/../..'));

$aDefaultPlugins = [];
require MAX_PATH . '/etc/default_plugins.php';

$aDefaultPlugins = array_map(fn($v) => $v['name'], $aDefaultPlugins);

chdir(MAX_PATH . '/plugins_repo');

foreach ($aDefaultPlugins as $plugin) {
    [$currentVersion, $nextVersion] = getVersions($plugin);

    echo "  => " . basename($plugin) . " ({$currentVersion}): ";

    buildPlugin($plugin);

    if (zipDiff("{$plugin}.zip", "../etc/plugins/{$plugin}.zip")) {
        bumpVersion($plugin, $nextVersion);
        buildPlugin($plugin);

        if (!@copy("{$plugin}.zip", "../etc/plugins/{$plugin}.zip")) {
            echo "FAILED!\n";
            exit(1);
        }

        echo "UPDATED TO {$nextVersion}\n";
    } else {
        echo "no changes\n";
    }

    @unlink("{$plugin}.zip");
}

echo "=> FINISHED UPDATING THE BUNDLED PLUGINS\n";

function buildPlugin(string $plugin): void
{
    exec('./zipkg.sh ' . escapeshellarg($plugin) . ' >/dev/null', $output, $rc) ??
        throw new \RuntimeException("Build error code: {$rc}:\n" . implode("\n", $output));
}

function bumpVersion(string $plugin, string $version): void
{
    exec('ant update-version -Dname=' . escapeshellarg($plugin) . ' -Dversion=' . escapeshellarg($version) . ' >/dev/null', $output, $rc) ??
        throw new \RuntimeException("Version update error code: {$rc}:\n" . implode("\n", $output));
}

function zipDiff($file1, $file2)
{
    $z0 = new ZipArchive();
    $z1 = new ZipArchive();
    $z0->open($file1);
    $z1->open($file2);

    $f = function (ZipArchive $z0, ZipArchive $z1) {
        if ($z0->numFiles != $z1->numFiles) {
            return true;
        }

        for ($i = 0; $i < $z0->numFiles; $i++) {
            $s0 = $z0->statIndex($i);
            $s1 = $z1->statName($s0['name']);
            if (!$s1 || $s0['size'] != $s1['size'] || $s0['crc'] != $s1['crc']) {
                return true;
            }
        }

        return false;
    };

    $ret = $f($z0, $z1);

    $z0->close();
    $z1->close();

    return $ret;
}

function getVersions(string $plugin): array
{
    $fileName = "{$plugin}/plugins/etc/{$plugin}.xml";
    $xml = file_get_contents($fileName) ?: throw new \RuntimeException("Can't find xml file: {$fileName}");

    if (!preg_match('#<version>(\d+\.\d+\.)(\d+)</version>#', $xml, $m)) {
        throw new \RuntimeException("Can't parse version in: {$fileName}");
    }

    return [
        $m[1] . $m[2],
        sprintf("%s%d", $m[1], (int) $m[2] + 1),
    ];
}
