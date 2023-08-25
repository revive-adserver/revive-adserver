<?php

namespace RV\Command\Installer;

use RV\Admin\Install\CliInstallController;
use RV\Admin\Install\RedirectException;
use RV\Command\Installer\Model\ConfSetting;
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

class InstallCommand extends AbstractInstallerCommand
{
    protected static $defaultName = 'install';
    protected static $defaultDescription = 'Install a Revive Adserver instance';

    protected function configure()
    {
        parent::configure();

        $this->addArgument('installer-conf', InputArgument::REQUIRED, 'The path to the installer configuration file. A template in etc/installer.conf.php');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        parent::execute($input, $output);

        $iniSettings = \parse_ini_file($input->getArgument('installer-conf'), true);

        if (!is_array($iniSettings)) {
            throw new \RuntimeException("Configuration file not found or invalid");
        }

        $dbSettings = $this->parseSettings($iniSettings, ConfSetting::TYPE_DB);
        $dbSettings['local'] = !empty($dbSettings['socket']);

        $confSettings = $this->parseSettings($iniSettings, ConfSetting::TYPE_CONF);

        $this->runChecks();

        if ($this->oController->isUpgrade()) {
            throw new RuntimeException("Please run an upgrade instead");
        }

        $question = \sprintf("<question>Continue installing %s?</question>", PRODUCT_NAME);

        if (!$this->askContinueQuestion($input, $output, $question)) {
            return Command::FAILURE;
        }

        $this->runDatabase($dbSettings);
        $this->runConfiguration($confSettings);
        $this->runJobs();
        $this->runFinish();

        $this->setPermissions();
        $this->showAdminUrl();

        return Command::SUCCESS;
    }

    protected function initRevive(InputInterface $input, OutputInterface $output): void
    {
        global $argc, $argv, $conf, $installing;

        $installing = true;

        $_SERVER['REQUEST_URI'] = '/';
        $_COOKIE['ox_install_session_id'] = true;

        require __DIR__ . '/../../../../init.php';
    }

    private function runDatabase(array $dbSettings): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = \array_merge($dbSettings, [
            'action' => 'database',
        ]);
        $_REQUEST = [
            '_qf__install-db-form' => '1'
        ];

        $oRequest = new \OX_Admin_UI_Controller_Request();
        $oRequest->setParam('action', $_POST['action']);

        $this->output->writeln("<comment>Running database</comment>");

        try {
            $this->oController->process($oRequest);

            $form = $this->oController->getModelProperty('form');

            throw new RuntimeException(\join("\n", $form['errors']));
        } catch (RedirectException $e) {
            if ('configuration' !== $e->getAction()) {
                throw new RuntimeException("Unexpected redirect: {$e->getAction()}");
            }
        }
    }

    private function runConfiguration(array $confSettings): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = \array_merge($confSettings, [
            'action' => 'configuration',
        ]);
        $_REQUEST = [
            '_qf__install-config-form' => '1'
        ];

        $oRequest = new \OX_Admin_UI_Controller_Request();
        $oRequest->setParam('action', $_POST['action']);

        $this->output->writeln("<comment>Running configuration</comment>");

        try {
            $this->oController->process($oRequest);

            $form = $this->oController->getModelProperty('form');

            throw new RuntimeException(\join("\n", $form['errors']));
        } catch (RedirectException $e) {
            if ('jobs' !== $e->getAction()) {
                throw new RuntimeException("Unexpected redirect: {$e->getAction()}");
            }
        }
    }

    private function parseSettings(array $iniSettings, string $type): array
    {
        $result = [];

        foreach (self::getConfSettings($type) as $section => $settings) {
            foreach ($settings as $key => $setting) {
                $value = $iniSettings[$section][$key] ?? null;

                if (empty($value)) {
                    $value = $setting->getDefault();
                }

                if ($setting->isRequired() && empty($value)) {
                    throw new RuntimeException("Configuration entry [{$section}][{$key}] is required");
                }

                foreach ($setting->getDestination() as $dest) {
                    $result[$dest] = $value;
                }
            }
        }

        return $result;
    }

    /**
     * @return ConfSetting[][]
     */
    private static function getConfSettings(string $type): array
    {
        if ($type === ConfSetting::TYPE_DB) {
            return [
                'database' => [
                    'type' => new ConfSetting(true, 'dbType'),
                    'host' => new ConfSetting(true, 'dbHost', 'localhost'),
                    'name' => new ConfSetting(true, 'dbName'),
                    'port' => new ConfSetting(true, 'dbPort'),
                    'username' => new ConfSetting(true, 'dbUser'),
                    'password' => new ConfSetting(true, 'dbPassword'),
                    'socket' => new ConfSetting(false, 'dbSocket'),
                ],
                'table' => [
                    'prefix' => new ConfSetting(false, 'dbTablePrefix', ''),
                    'type' => new ConfSetting(false, 'dbTableType', 'INNODB'),
                ],
            ];
        }
        
        return [
            'admin' => [
                'username' => new ConfSetting(true, 'adminName'),
                'password' => new ConfSetting(true, ['adminPassword', 'adminPassword2']),
                'email' => new ConfSetting(true, 'adminEmail'),
                'language' => new ConfSetting(false, 'adminLanguage', 'en'),
                'timezone' => new ConfSetting(false, 'prefsTimezone', \OX_Admin_Timezones::getTimezone()),
            ],
            'paths' => [
                'admin' => new ConfSetting(true, 'webpathAdmin'),
                'delivery' => new ConfSetting(true, ['webpathDelivery', 'webpathDeliverySSL']),
                'images' => new ConfSetting(true, ['webpathImages', 'webpathImagesSSL']),
                'path' => new ConfSetting(true, 'storeWebDir', realpath(__DIR__ . '/../../../../www/images')),
            ],
        ];
    }
}
