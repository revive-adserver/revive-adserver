<?php

namespace RV\Command;

use League\Flysystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

#[AsCommand(name: 'delete-orphan-images', description: 'Delete orphan image files and HTML5 banner folders')]
class DeleteOrphanImagesCommand extends AbstractReviveCommand
{
    protected function configure()
    {
        parent::configure();

        $this->addOption('force', 'f', InputOption::VALUE_NONE, 'Do not request permission to proceed');
        $this->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry-run operation');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->initRevive($input, $output);

        require_once MAX_PATH . '/lib/OA/DB.php';

        $aConf = $GLOBALS['_MAX']['CONF'];

        if (!$this->askQuestion($input, $output, 'Are you sure you want to proceed?')) {
            return self::INVALID;
        }

        $oDbh = \OA_DB::singleton();

        if (\PEAR::isError($oDbh)) {
            $output->writeln("<error>{$oDbh->getMessage()}</error>");

            return self::FAILURE;
        }

        $prefix = $aConf['table']['prefix'];

        $res = $oDbh->query("SELECT filename FROM {$prefix}banners b WHERE storagetype = 'web' OR ext_bannertype = 'bannerTypeHtml:oxHtml:html5' ORDER BY bannerid");

        $aDbImages = [];
        while ($row = $res->fetchRow()) {
            $aDbImages[] = $row['filename'];
        }

        $finder = (new Finder())
            ->in($aConf['store']['webDir'])
            ->depth('== 0')
            ->name('/^[0-9a-f]{32}\.?/')
        ;

        $aFsImages = [];
        foreach ($finder->getIterator() as $file) {
            $aFsImages[] = $file->getFilename();
        }

        $dryRun = $input->getOption('dry-run');

        /** @var Filesystem $filesystem */
        $filesystem = \RV_getContainer()->get('filesystem');

        $cnt = 0;
        $unlinked = 0;
        foreach (\array_diff($aFsImages, $aDbImages) as $filename) {
            ++$cnt;

            $path = "{$aConf['store']['webDir']}/{$filename}";

            $output->writeln($path, OutputInterface::VERBOSITY_VERBOSE);

            if (!$dryRun) {
                try {
                    if (is_dir($path)) {
                        $unlinked += (int) $filesystem->deleteDir($filename);
                    } else {
                        $unlinked += (int) $filesystem->delete($filename);
                    }
                } catch (\Exception $e) {
                    $output->writeln("<error>{$e->getMessage()}</error>");
                }
            }
        }

        $cntDb = count($aDbImages);
        $output->writeln("Deleted {$unlinked} out of {$cnt} image files / HTML5 banners ({$cntDb} referenced from the db)");

        return self::SUCCESS;
    }
}
