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

require __DIR__.'/../../lib/vendor/autoload.php';

chdir(__DIR__.'/../..');

$finder = new \Symfony\Component\Finder\Finder;

$preg = '#(?:->|::)translate\((["\'])(.*?)\1\)#x';
$pregName = '#->nameEnglish *= *(["\'])(.*?)\1#x';

$files = $finder
    ->in('plugins_repo')
    ->exclude('openXDeveloperToolbox')
    ->name('*.php')
    ->contains($preg)
    ->getIterator();

$trans = [];

foreach ($files as $file) {
    $contents = $file->getContents();

    $path = explode(DIRECTORY_SEPARATOR, $file->getPathname());

    if ('plugins' === $path[2]) {
        $poFilePath = "plugins_repo/{$path[1]}/plugins/etc/{$path[4]}/_lang/po/en.po";
    } else {
        die("Unsupported path: ".$file->getPathname()."\n");
    }

    if (!is_writable($poFilePath)) {
        die("Unwritable file: {$poFilePath}\n");
    }

    if (!isset($trans[$poFilePath])) {
        $trans[$poFilePath] = [];
    }

    foreach (explode("\n", $contents) as $n => $line) {
        if (preg_match($preg, $line, $m) || preg_match($pregName, $line, $m)) {
            if (!isset($trans[$poFilePath][$m[2]])) {
                $trans[$poFilePath][$m[2]] = [];
            }

            $trans[$poFilePath][$m[2]][] = join(':', [
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

    foreach ($msgs as $msgid => $lines)
    {
        $po .= "\n";

        foreach ($lines as $line) {
            $po .= "#: {$line}\n";
        }

        $id = str_replace('\\n', "\\n\"\n\"", addcslashes($msgid, "\0..\37\"\\"));
        $po .= "msgid \"{$id}\"\nmsgstr \"{$id}\"\n";
    }

    $po = str_replace("\r", "", $po);

    file_put_contents($file, $po);
}

