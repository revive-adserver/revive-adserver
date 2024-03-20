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

abstract class AbstractInstallerCommand extends ReviveCommand
{
    /** @var InputInterface */
    protected $input;

    /** @var OutputInterface */
    protected $output;

    /** @var CliInstallController */
    protected $oController;

    /** @var int|null */
    private $permissions = null;

    protected function configure()
    {
        parent::configure();

        $this->addOption('force', 'f', InputOption::VALUE_NONE, 'Do not request permission to install/upgrade');

        $this->addOption('set-permissions', 'P', InputOption::VALUE_OPTIONAL, 'Set file permissions after upgrading. It is possible to specify the permission bits in octal format, e.g. 0777', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->initRevive($input, $output);

        require_once MAX_PATH . '/lib/OX/Admin/UI/Controller/Request.php';

        $this->input = $input;
        $this->output = $output;
        $this->oController = new CliInstallController();

        $this->parsePermissions($input);

        return Command::SUCCESS;
    }

    protected function parsePermissions(InputInterface $input)
    {
        $permissions = $input->getOption('set-permissions') ?? '0777';

        if (false !== $permissions) {
            if (!preg_match('#^[0-7]{3,4}$#D', $permissions)) {
                throw new RuntimeException("Invalid permissions: {$permissions}. Please use the octal notation, e.g. 0777");
            }

            $this->permissions = octdec($permissions);
        }
    }

    protected function askContinueQuestion(InputInterface $input, OutputInterface $output, string $question): bool
    {
        if ($input->getOption('force')) {
            return true;
        }

        $helper = $this->getHelper('question');
        $confirmation = new ConfirmationQuestion($question, false);

        return $helper->ask($input, $output, $confirmation);
    }

    protected function runChecks(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $oRequest = new \OX_Admin_UI_Controller_Request();
        $oRequest->setParam('action', 'check');

        $this->output->writeln('<comment>Running checks</comment>');

        try {
            $this->oController->process($oRequest);

            throw new RuntimeException(\array_reduce(
                $this->oController->getModelProperty('aChecks'),
                function ($errors, $item) {
                    foreach ($item['checks'] as $check) {
                        foreach ($check['errors'] ?? [] as $error) {
                            $errors .= "{$error}\n";
                        }
                    }

                    return $errors;
                },
                ''
            ));
        } catch (RedirectException $e) {
            $nextAction = $this->oController->isUpgrade() ? 'login' : 'database';

            if ($nextAction !== $e->getAction()) {
                throw new RuntimeException("Unexpected redirect: {$e->getAction()}");
            }
        }
    }

    protected function runFinish(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_POST = [];
        $_REQUEST = [];

        $oRequest = new \OX_Admin_UI_Controller_Request();
        $oRequest->setParam('action', 'finish');

        $this->output->writeln("<info>Running finish</info>");

        $this->oController->process($oRequest);
    }

    protected function runJobs(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_POST = [];
        $_REQUEST = [];

        $oRequest = new \OX_Admin_UI_Controller_Request();
        $oRequest->setParam('action', 'jobs');

        $this->output->writeln("<comment>Running jobs</comment>");

        $this->oController->process($oRequest);
        $oPluginInstaller = new PluginInstaller();

        foreach (\json_decode($this->oController->getModelProperty('jobs'), true) as $job) {
            $this->output->write("<comment> * {$job['id']}: </comment>");
            $url = parse_url($job['url']);
            $script = basename($url['path']);
            parse_str($url['query'], $query);

            switch ($script) {
                case 'install-plugin.php':
                    $result = $oPluginInstaller($query['plugin'], $query['status']);
                    $status = \strip_tags($result['status']);

                    break;

                case 'install-runtask.php':
                    $oUpgrader = new \OA_Upgrade();
                    $result = $oUpgrader->runPostUpgradeTask($query['task']);
                    $status = $result['errors'] ? 'KO' : 'OK';

                    break;

                default:
                    throw new \RuntimeException("Unexpected script: {$script}");
            }

            if (!empty($result['errors'])) {
                foreach ($result['errors'] as $error) {
                    $this->output->writeln("<error>{$error}</error>");
                }
            } else {
                $this->output->writeln("<info>{$status}</info>");
            }
        };
    }

    protected function setPermissions(): void
    {
        if (null === $this->permissions) {
            return;
        }

        $this->output->writeln("<info>Setting file permissions</info>");

        $paths = [
            MAX_PATH . '/var',
            MAX_PATH . '/plugins',
            MAX_PATH . '/www/admin/plugins',
            MAX_PATH . '/www/images',
        ];

        foreach ($paths as $path) {
            chmod($path, $this->permissions);

            foreach ((new Finder())->in($path)->getIterator() as $file) {
                chmod($file->getPathname(), $this->permissions);
            }
        }
    }

    protected function showAdminUrl()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $this->output->writeln(\sprintf(
            "<comment>You can now log in at: </comment><info>http%s://%s</info>",
            $aConf['openads']['requireSSL'] ? 's' : '',
            $aConf['webpath']['admin'],
        ));
    }
}
