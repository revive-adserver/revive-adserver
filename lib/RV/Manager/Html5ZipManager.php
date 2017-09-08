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

namespace RV\Manager;

use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use RV\Parser\Html5ParserInterface;

class Html5ZipManager
{
    /**
     * @var string
     */
    private static $reviveScript = <<<EOF
<script>
window.REVIVE = {
    getParameter: function (name, defautVal) {
        var match = (new RegExp('[?&]' + name + '=([^&]*)')).exec(window.location.search);
        return match ? decodeURIComponent(match[1].replace(/\+/g, ' ')) : defautVal;
    }
};
</script>
EOF;

    /**
     * An array containing all the allowed (lowercase) extension as key. If a file with a non-listed extension is
     * found, an exception will be thrown. Extensions with false as a value are skipped during the copy.
     *
     * @var array
     */
    private static $extensions = [
        'html' => true,
        'js' => true,
        'css' => true,
        'png' => true,
        'jpg' => true,
        'jpeg' => true,
        'gif' => true,
        'mp4' => true,
        'mov' => true,
        'webm' => true,
        'mp3' => true,
        'ogg' => true,
        'woff' => true,
        'woff2' => true,
        'eot' => true,
        'ds_store' => false,
        'ini' => false,
    ];

    /**
     * @var Filesystem
     */
    private $destination;

    /**
     * @var MountManager
     */
    private $mountManager;

    /**
     *
     * @var Html5ParserInterface[][]
     */
    private $parsers = [];

    /**
     * @var string
     */
    private $hash;

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * Html5ZipManager constructor.
     *
     * @param Filesystem $destination
     */
    public function __construct(Filesystem $destination)
    {
        $this->destination = $destination;
    }

    /**
     * Add an HTML5 parser.
     *
     * @param Html5ParserInterface $parser
     * @param int $priority
     */
    public function addParser(Html5ParserInterface $parser, $priority)
    {
        if (!isset($this->parsers[$priority])) {
            $this->parsers[$priority] = [];
        }

        $this->parsers[$priority][] = $parser;
    }

    /**
     * Opens the zipfile as a Filesystem object with the index.html file in the root directory.
     *
     * @param string $zipFile
     *
     * @return Filesystem
     */
    public function open($zipFile)
    {
        $source = new Filesystem(new ZipArchiveAdapter($zipFile));
        $this->hash = md5(file_get_contents($zipFile));

        self::stripMacOsDir($source);

        $basedir = self::findBasedir($source);

        if (!empty($basedir)) {
            $source = new Filesystem(new ZipArchiveAdapter($zipFile, null, $basedir));
        }

        $this->mountManager = new MountManager(array(
            'src'  => $source,
            'dst' => $this->destination,
        ));

        $this->verifyContent();
        $this->parseSize();
    }

    /**
     * Copy the content of the zip file to the images store, returning the destination directory.
     *
     * @return string
     */
    public function copyToWebdir()
    {
        foreach ($this->mountManager->listContents('src://', true) as $entry) {
            if ('file' !== $entry['type'] || empty(self::$extensions[strtolower($entry['extension'])])) {
                continue;
            }

            $srcPath = "src://{$entry['path']}";
            $dstPath = "dst://{$this->hash}/{$entry['path']}";

            if ('index.html' === $entry['basename']) {
                $this->mountManager->put($dstPath, $this->alterHtml($this->mountManager->read($srcPath)));
            } else {
                $this->mountManager->putStream($dstPath, $this->mountManager->readStream($srcPath));
            }
        }

        return $this->hash;
    }

    /**
     * Returns the width of the HTML5, or null if not available.
     *
     * @return int|null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Returns the height of the HTML5, or null if not available.
     *
     * @return int|null
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Parse the size of the HTML5 ad.
     */
    private function parseSize()
    {
        $html = $this->mountManager->read('src://index.html');

        foreach ($this->getSortedParsers() as $parser) {
            $size = $parser->parseSize($html);

            if (null !== $size) {
                list($this->width, $this->height) = $size;
                return;
            }
        }
    }

    /**
     * @param $html
     *
     * @return string
     */
    private function alterHtml($html)
    {
        if (!preg_match('#<head>(.*?)</head>#is', $html, $m)) {
            return $html;
        }

        $head = $m[1];

        $pos = stripos($head, '<script');

        if (false === $pos) {
            return $html;
        }

        $newhead = substr($head, 0, $pos).self::$reviveScript.substr($head, $pos);

        preg_match_all('#<script.*?>(.*?)</script>#is', $head, $m);

        foreach ($m[1] as $script) {
            preg_match_all('#var\s+(clickTag)\s+=\s+((["\'])(.*?)\\3);#i', $head, $jsvar);

            $newscript = $script;
            foreach ($jsvar[1] as $k => $var) {
                $newscript = str_replace(
                    $jsvar[0][$k],
                    str_replace($jsvar[2][$k], "REVIVE.getParameter('{$var}', {$jsvar[2][$k]})", $jsvar[0][$k]),
                    $newscript
                );
            }

            $newhead = str_replace($script, $newscript, $newhead);
        }

        return str_replace($head, $newhead, $html);
    }

    /**
     * Verify that the content is allowed.
     *
     * @throws \RuntimeException
     */
    private function verifyContent()
    {
        foreach ($this->mountManager->listContents('src://', true) as $entry) {
            if ('file' === $entry['type'] && !isset(self::$extensions[strtolower($entry['extension'])])) {
                throw new \RuntimeException("Invalid file type: {$entry['basename']}");
            }
        }
    }

    /**
     * Strips the useless __MACOSX system directory, which is sometimes present in zip files.
     *
     * @param Filesystem $filesystem
     */
    private static function stripMacOsDir(Filesystem $filesystem)
    {
        try {
            $macOsDir = $filesystem->getMetadata('__MACOSX');

            if (false !== $macOsDir && 'dir' === $macOsDir['type']) {
                $filesystem->deleteDir('__MACOSX');
            }
        } catch (FileNotFoundException $e) {
        }
    }

    /**
     * Finds the main directory containing the index.html file.
     *
     * @param Filesystem $filesystem
     *
     * @throws \RuntimeException when the filesystem contains 0 or more than 1 index.html files
     *
     * @return string
     */
    private static function findBasedir(Filesystem $filesystem)
    {
        $htmls = [];
        foreach ($filesystem->listContents('', true) as $entry) {
            if ('file' !== $entry['type'] || 'html' !== $entry['extension']) {
                continue;
            }

            if (!isset($htmls[$entry['basename']])) {
                $htmls[$entry['basename']] = [];
            }

            $htmls[$entry['basename']][] = $entry['dirname'];
        }

        if (isset($htmls['index.html'])) {
            if (1 === count($htmls['index.html'])) {
                return $htmls['index.html'][0];
            }

            throw new \RuntimeException("Multiple 'index.html' files found");
        }

        // Is there a single HTML file that we can rename to index.html?
        $fileName = key($htmls);
        if (1 === count($htmls) && 1 === count($htmls[$fileName])) {
            $dir = current($htmls[$fileName]);
            $filesystem->rename("{$dir}/{$fileName}", "{$dir}/index.html");

            return $dir;
        }

        throw new \RuntimeException("Multiple '*.html' files found, please rename the main one to 'index.html'".print_r($htmls, true));
    }

    /**
     * @return Html5ParserInterface[]|\Generator
     */
    private function getSortedParsers()
    {
        ksort($this->parsers);

        $sortedParsers = call_user_func_array('array_merge', $this->parsers);

        foreach ($sortedParsers as $parser) {
            yield $parser;
        }
    }
}
