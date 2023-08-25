<?php

namespace RV\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

abstract class ReviveCommand extends Command
{
    protected function configure()
    {
        $this->addOption('hostname', 'H', InputOption::VALUE_REQUIRED, 'The hostname. If not provided, auto-detection will be enabled');
    }

    protected function initRevive(InputInterface $input, OutputInterface $output): void
    {
        global $argc, $argv, $conf;

        $hostname = $input->getOption('hostname') ?? $this->getDefaultHostname($output);

        $argc = 1;
        $argv = [
            $argv[0],
            $hostname,
        ];

        $_SERVER['REQUEST_URI'] = '/';

        require __DIR__ . '/../../../init.php';
    }

    private function getDefaultHostname(OutputInterface $output): string
    {
        $output->writeln('<comment>Hostname auto-detection</comment>', OutputInterface::VERBOSITY_VERY_VERBOSE);

        $varPath = realpath(__DIR__ . '/../../../var');

        $finder = new Finder();

        /** @var \SplFileInfo[] $files */
        $files = \iterator_to_array($finder
            ->in($varPath)
            ->name('*.conf.php')
            ->notName('#^\d+_old\.#')
            ->notName('#^default\.#')
            ->getIterator());

        $output->writeln(\sprintf('<comment>Found <info>%d</info> configuration file(s)</comment>', \count($files)), OutputInterface::VERBOSITY_DEBUG);

        if (1 === \count($files)) {
            return str_replace('.conf.php', '', \current($files)->getFilename());
        }

        $defaultConfPath = $varPath . '/default.conf.php';

        if (!file_exists($defaultConfPath)) {
            throw new RuntimeException("Hostname auto-detection impossible: default.conf.php not found");
        }

        $conf = @parse_ini_file($defaultConfPath);

        if (empty($conf['realConfig'])) {
            throw new RuntimeException("Hostname auto-detection impossible: default.conf.php malformed");
        }

        $output->writeln('<comment>Using <info>default.conf.php</info></comment>', OutputInterface::VERBOSITY_DEBUG);

        return $conf['realConfig'];
    }
}
