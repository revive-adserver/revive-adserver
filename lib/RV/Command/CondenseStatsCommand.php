<?php

namespace RV\Command;

use RV\Dal\Statistics\Condense;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'condense-stats', description: 'Condense statistics in order to free database space')]
class CondenseStatsCommand extends AbstractReviveCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Do not request permission to proceed')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry-run operation')
            ->addOption('daily-range', 'd', InputOption::VALUE_REQUIRED, 'Number of full months to keep before condensing to daily')
            ->addOption('monthly-range', 'm', InputOption::VALUE_REQUIRED, 'Number of full months to keep before condensing to monthly')
            ->addOption('process-only', 'b', InputOption::VALUE_REQUIRED, 'Number of months to process before exiting')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->initRevive($input, $output);

        require_once MAX_PATH . '/lib/OA/DB.php';
        require_once MAX_PATH . '/lib/OA/Permission.php';

        $daily = $this->parseIntInput($input, 'daily-range', 0);
        $monthly = $this->parseIntInput($input, 'monthly-range', 0);
        $batches = $this->parseIntInput($input, 'batches', 1);
        $dryRun = (bool) $input->getOption('dry-run');

        $message = sprintf(
            "Daily: %s - Monthly: %s",
            $daily ?? '<error>disabled</error>',
            $monthly ?? '<error>disabled</error>',
        );

        if ($batches > 0) {
            $message .= " - Batches: {$batches}";
        }

        if ($dryRun) {
            $message .= " <error>(DRY-RUN)</error>";
        }

        $output->writeln("<info>{$message}</info>");

        if (null === $daily && null === $monthly) {
            return self::INVALID;
        }

        if (!$this->askQuestion($input, $output, 'Are you sure you want to proceed?')) {
            return self::INVALID;
        }

        $condense = new Condense(new SymfonyStyle($input, $output));
        $condense->start($daily, $monthly, $batches, $dryRun);

        return self::SUCCESS;
    }

    private function parseIntInput(InputInterface $input, string $name, ?int $min = null): ?int
    {
        $value = $input->getOption($name);

        if (null === $value) {
            return null;
        }

        if (!ctype_digit($value)) {
            throw new \InvalidArgumentException("The '{$name}' option must be an integer number");
        }

        $value = (int) $value;

        if (null !== $min && $value < $min) {
            throw new \InvalidArgumentException("The '{$name}' option must be >= {$min}");
        }

        return $value;
    }

}
