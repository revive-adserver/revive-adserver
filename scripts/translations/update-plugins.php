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

require __DIR__ . '/../../lib/vendor/autoload.php';

chdir(__DIR__ . '/../..');

$finder = new \Symfony\Component\Finder\Finder();

$preg = '#(?:->|::)translate\((["\'])(.*?)\1\)#x';
$pregName = '#->nameEnglish *= *(["\'])(.*?)\1#x';

$filesPHP = $finder
    ->in('plugins_repo')
    ->exclude('openXDeveloperToolbox')
    ->name('*.php')
    ->contains($preg)
    ->getIterator();

$filesXML = $finder
    ->in('plugins_repo')
    ->exclude('openXDeveloperToolbox')
    ->exclude('demoExtension')
    ->name('*.xml')
    ->contains('#<setting[^>]+label=#')
    ->getIterator();

$files = array_merge(
    iterator_to_array($filesXML),
    iterator_to_array($filesPHP),
);

$trans = [];

foreach ($files as $file) {
    $contents = $file->getContents();

    $path = explode(DIRECTORY_SEPARATOR, $file->getPathname());

    if ('plugins' === $path[2]) {
        $poFilePath = "plugins_repo/{$path[1]}/plugins/etc/{$path[4]}/_lang/po/en.po";
    } elseif ('www' === $path[2] && 'admin' === $path[3] && 'plugins' === $path[4]) {
        $poFilePath = "plugins_repo/{$path[1]}/plugins/etc/{$path[5]}/_lang/po/en.po";
    } else {
        die("Unsupported path: " . $file->getPathname() . "\n");
    }

    if (file_exists($poFilePath)) {
        if (!is_writable($poFilePath)) {
            die("Unwritable file: {$poFilePath}\n");
        }
    } else {
        @mkdir(dirname($poFilePath), 0755, true);
        @touch($poFilePath);
    }

    if (!isset($trans[$poFilePath])) {
        $trans[$poFilePath] = [];
    }

    if ('xml' === $file->getExtension()) {
        $dom = new \DOMDocument();
        $dom->loadXml($contents);

        $xpath = new \DOMXPath($dom);

        foreach ($xpath->query('//setting') as $setting) {
            $label = $setting->getAttribute('label');

            if (!isset($trans[$poFilePath][$label])) {
                $trans[$poFilePath][$label] = [];
            }

            $qLabel = preg_quote($label, '#');
            $previousContent = preg_replace("#<setting[^>]+label=['\"]{$qLabel}['\"].*#s", '', $contents);

            $line = count(explode("\n", $previousContent ?: ''));

            $trans[$poFilePath][$label][] = implode(':', [
                str_replace(DIRECTORY_SEPARATOR, '/', $file->getPathname()),
                $line,
            ]);
        }

        continue;
    }

    foreach (explode("\n", $contents) as $n => $ref) {
        if (preg_match($preg, $ref, $m) || preg_match($pregName, $ref, $m)) {
            if (!isset($trans[$poFilePath][$m[2]])) {
                $trans[$poFilePath][$m[2]] = [];
            }

            $trans[$poFilePath][$m[2]][] = implode(':', [
                str_replace(DIRECTORY_SEPARATOR, '/', $file->getPathname()),
                $n + 1,
            ]);
        }
    }
}

foreach ($trans as $file => $msgs) {
    $po = <<<EOF
msgid ""
msgstr ""
"Project-Id-Version: Revive Adserver: {$file}\\n"
"Last-Translator: Revive Adserver Team <noreply@revive-adserver.com>\\n"
"Language-Team: English\\n"
"Language: en_GB\\n"
"MIME-Version: 1.0\\n"
"Content-Type: text/plain; charset=UTF-8\\n"
"Content-Transfer-Encoding: 8bit\\n"
"Plural-Forms: (n != 1)\\n"


EOF;

    // Sort references by file path and line number
    $msgs = array_map(function ($references) {
        usort($references, function ($a, $b) {
            [$a_file, $a_line] = explode(':', $a);
            [$b_file, $b_line] = explode(':', $b);
            return $a_file !== $b_file ? $a_file <=> $b_file : $a_line <=> $b_line;
        });
        return $references;
    }, $msgs);

    // Sort messages by first reference
    uasort($msgs, function ($a, $b) {
        [$a_file, $a_line] = explode(':', $a[0]);
        [$b_file, $b_line] = explode(':', $b[0]);
        return $a_file !== $b_file ? $a_file <=> $b_file : $a_line <=> $b_line;
    });

    foreach ($msgs as $msgid => $references) {
        $po .= "\n";

        foreach ($references as $ref) {
            $po .= "#: {$ref}\n";
        }

        $id = str_replace('\\n', "\\n\"\n\"", addcslashes($msgid, "\0..\37\"\\"));
        $po .= "msgid \"{$id}\"\nmsgstr \"{$id}\"\n";
    }

    $po = str_replace("\r", "", $po);

    file_put_contents($file, $po);
}
