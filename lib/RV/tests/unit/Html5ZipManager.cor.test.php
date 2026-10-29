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

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Visibility;
use RV\Manager\Html5ZipManager;
use RV\Parser\Html5\MetaParser;

class Test_RV_Html5ZipManager extends UnitTestCase
{
    private string $directory;
    private Filesystem $filesystem;

    public function setUp()
    {
        $this->directory = tempnam(sys_get_temp_dir(), 'revive-html5-');
        unlink($this->directory);
        $this->filesystem = new Filesystem(new LocalFilesystemAdapter($this->directory), [
            'visibility' => Visibility::PUBLIC,
            'directory_visibility' => Visibility::PUBLIC,
        ]);
    }

    public function tearDown()
    {
        $this->filesystem->deleteDirectory('');
    }

    private function archive(array $files): string
    {
        $path = $this->directory . '/banner.zip';
        $zip = new ZipArchive();
        $zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach ($files as $name => $contents) {
            $zip->addFromString($name, $contents);
        }
        $zip->close();
        return $path;
    }

    private function html(): string
    {
        return '<html><head><meta name="ad.size" content="width=300,height=250">'
            . '<script>var clickTag = "https://example.test/";</script></head><body></body></html>';
    }

    public function testImportsRootAndNestedArchivesAndOverwritesFiles()
    {
        foreach (['', 'creative/'] as $prefix) {
            $manager = new Html5ZipManager($this->filesystem);
            $manager->addParser(new MetaParser(), 0);
            $manager->open($this->archive([
                $prefix . 'index.html' => $this->html(),
                $prefix . 'assets/banner.png' => "binary\0data\xff",
                $prefix . '.DS_Store' => 'ignored',
            ]));
            $this->assertEqual($manager->getWidth(), 300);
            $this->assertEqual($manager->getHeight(), 250);
            $hash = $manager->copyToWebdir();
            $this->assertEqual($this->filesystem->read($hash . '/assets/banner.png'), "binary\0data\xff");
            $this->assertFalse($this->filesystem->fileExists($hash . '/.DS_Store'));
            $html = $this->filesystem->read($hash . '/index.html');
            $this->assertTrue(str_contains($html, 'REVIVE.getParameter'));
            $this->assertEqual($this->filesystem->visibility($hash . '/index.html'), Visibility::PUBLIC);
            $this->filesystem->write($hash . '/assets/banner.png', 'old contents');
            $this->assertEqual($manager->copyToWebdir(), $hash);
            $this->assertEqual($this->filesystem->read($hash . '/assets/banner.png'), "binary\0data\xff");
        }
    }

    public function testRenamesSingleHtmlAndStripsImplicitMacOsDirectory()
    {
        $manager = new Html5ZipManager($this->filesystem);
        $manager->addParser(new MetaParser(), 0);
        $manager->open($this->archive([
            '__MACOSX/._banner.php' => 'ignored metadata',
            'creative/banner.html' => $this->html(),
        ]));
        $hash = $manager->copyToWebdir();
        $this->assertTrue($this->filesystem->fileExists($hash . '/index.html'));
        $this->assertFalse($this->filesystem->directoryExists($hash . '/__MACOSX'));
    }

    public function testConfiguredLocalAndFtpFilesystems()
    {
        foreach ([false, true] as $ftp) {
            $container = new \Symfony\Component\DependencyInjection\ContainerBuilder();
            foreach ($GLOBALS['_MAX']['CONF'] as $section => $values) {
                foreach ($values as $key => $value) {
                    $container->setParameter("{$section}.{$key}", $value);
                }
            }
            $container->setParameter('store.mode', $ftp);
            $container->setParameter('store.webDir', $this->directory);
            $container->setParameter('store.ftpHost', 'example.test');
            $container->setParameter('store.ftpUsername', 'test');
            $container->setParameter('store.ftpPassword', 'test');
            $container->setParameter('store.ftpPath', '/images');
            $container->setParameter('store.ftpPassive', '1');
            \RV\Config\AdminServiceConfigurator::configure($container);
            $container->compile();
            $filesystem = $container->get('filesystem');
            $this->assertIsA($filesystem, Filesystem::class);
            if (!$ftp) {
                $filesystem->write('public/banner.png', 'image');
                $this->assertEqual($filesystem->visibility('public/banner.png'), Visibility::PUBLIC);
                $this->assertEqual(fileperms($this->directory . '/public') & 0777, 0755);
                $filesystem->deleteDirectory('public');
            }
        }
    }

    public function testRejectsExecutableFiles()
    {
        $manager = new Html5ZipManager($this->filesystem);
        $this->expectException(RuntimeException::class);
        $manager->open($this->archive(['index.html' => $this->html(), 'code.php' => '<?php echo 1;']));
    }

    public function testRejectsMultipleIndexFiles()
    {
        $manager = new Html5ZipManager($this->filesystem);
        $this->expectException(RuntimeException::class);
        $manager->open($this->archive(['a/index.html' => $this->html(), 'b/index.html' => $this->html()]));
    }
}
