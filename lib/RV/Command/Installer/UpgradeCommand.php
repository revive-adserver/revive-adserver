<?php

namespace RV\Command\Installer;

use RV\Admin\Install\CliInstallController;
use RV\Admin\Install\RedirectException;
use RV\Command\ReviveCommand;
use RV\Upgrade\PluginInstaller;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Finder\Finder;

class UpgradeCommand extends AbstractInstallerCommand
{
    protected static $defaultName = 'upgrade';
    protected static $defaultDescription = 'Upgrade an existing Revive Adserver instance';

    protected function configure()
    {
        parent::configure();

        $this->addArgument('previous-path', InputArgument::REQUIRED, 'The path to the previous instance');

        $this->addOption('username', 'u', InputOption::VALUE_REQUIRED, 'The admin username. When none is provided, the env var <info>REVIVE_USERNAME</info> is used');
        $this->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'The admin password. When none is provided, the env var <info>REVIVE_PASSWORD</info> is used');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        parent::execute($input, $output);

        $previousPath = \realpath($input->getArgument('previous-path'));

        if (empty($previousPath)) {
            throw new RuntimeException("Invalid previous path");
        }

        if (\realpath(MAX_PATH) === $previousPath) {
            throw new RuntimeException("Previous path cannot be the same instance being upgraded");
        }

        if (
            !is_dir("{$previousPath}/plugins") ||
            !is_dir("{$previousPath}/www/admin/plugins")
        ) {
            throw new RuntimeException("Previous path does not contain 'plugins' or 'www/admin/plugins' folders");
        }

        $username = $input->getOption('username') ?? \getenv('REVIVE_USERNAME');
        $password = $input->getOption('password') ?? \getenv('REVIVE_PASSWORD');

        if (empty($username) || empty($password)) {
            throw new RuntimeException("Username or password missing. Please use the command options or env vars");
        }

        $this->runChecks();

        $this->oController->checkUpgradeSupported();

        $output->writeln(\sprintf(
            "<info>%s has been found</info>",
            $this->oController->getPreviousVersion(),
        ));

        $question = "<question>Continue with the upgrade?</question>";

        if (!$this->askContinueQuestion($input, $output, $question)) {
            return Command::FAILURE;
        }

        $this->runLogin($username, $password);
        if ($this->runDatabase()) {
            $this->runConfiguration($previousPath);
        }
        $this->runJobs();
        $this->runFinish();

        $this->setPermissions();
        $this->showAdminUrl();

        return Command::SUCCESS;
    }

    private function runLogin(string $username, string $password): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'action' => 'login',
            'username' => $username,
            'password' => $password,
        ];
        $_REQUEST = [
            '_qf__adserver-login-form' => '1'
        ];

        $oRequest = new \OX_Admin_UI_Controller_Request();
        $oRequest->setParam('action', $_POST['action']);

        $this->output->writeln("<comment>Running login</comment>");

        try {
            $this->oController->process($oRequest);

            throw new RuntimeException(
                \current(\current($this->oController->getModelProperty('aMessages')))
            );
        } catch (RedirectException $e) {
            if ('database' !== $e->getAction()) {
                throw new RuntimeException("Unexpected redirect: {$e->getAction()}");
            }
        }
    }

    private function runDatabase(): bool
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'action' => 'database',
        ];
        $_REQUEST = [
            '_qf__install-db-form' => '1'
        ];

        $oRequest = new \OX_Admin_UI_Controller_Request();
        $oRequest->setParam('action', $_POST['action']);

        $this->output->writeln("<comment>Running database</comment>");

        try {
            $this->oController->process($oRequest);

            throw new RuntimeException(
                \current(\current($this->oController->getModelProperty('aMessages')))
            );
        } catch (RedirectException $e) {
            return 'configuration' === $e->getAction();
        }
    }

    private function runConfiguration(string $previousPath): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'action' => 'configuration',
            'previousPath' => $previousPath,
        ];
        $_REQUEST = [
            '_qf__install-config-form' => '1'
        ];

        $oRequest = new \OX_Admin_UI_Controller_Request();
        $oRequest->setParam('action', $_POST['action']);

        $this->output->writeln("<comment>Running configuration</comment>");

        try {
            $this->oController->process($oRequest);

            throw new RuntimeException(
                \current(\current($this->oController->getModelProperty('aMessages')))
            );
        } catch (RedirectException $e) {
            if ('jobs' !== $e->getAction()) {
                throw new RuntimeException("Unexpected redirect: {$e->getAction()}");
            }
        }
    }
}
