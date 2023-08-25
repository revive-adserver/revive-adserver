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

namespace RV\Admin\Install;

use OA_Upgrade;
use Symfony\Component\Console\Exception\RuntimeException;

require_once MAX_PATH . '/lib/OX/Admin/UI/Install/InstallController.php';

class CliInstallController extends \OX_Admin_UI_Install_InstallController
{
    public function isInstall()
    {
        $oUpgrade = new OA_Upgrade();
        $result = $oUpgrade->canUpgradeOrInstall();

        return $result && empty($oUpgrade->versionInitialApplication);
    }

    public function isUpgrade()
    {
        $oUpgrade = new OA_Upgrade();
        $result = $oUpgrade->canUpgradeOrInstall();

        return $result && !empty($oUpgrade->versionInitialApplication);
    }

    public function checkUpgradeSupported()
    {
        $oUpgrade = new OA_Upgrade();
        $result = $oUpgrade->canUpgradeOrInstall();

        if (!$result || !$oUpgrade->versionInitialApplication) {
            throw new RuntimeException("No upgradeable instance has been found");
        }

        if (\version_compare($oUpgrade->getProductApplicationVersion(true), '2.8.0', '<')) {
            throw new RuntimeException($oUpgrade->getProductApplicationVersion() . " detected, command-line upgrade is not supported");
        }
    }

    public function getPreviousVersion(): ?string
    {
        $oUpgrade = new OA_Upgrade();
        $result = $oUpgrade->canUpgradeOrInstall();

        return $oUpgrade->getProductApplicationVersion();
    }

    public function process($request)
    {
        OA_Upgrade::clearCanUpgradeOrInstall();

        return parent::process($request);
    }

    protected function abortInstall(): void
    {
        fputs(STDERR, "Installer is not supposed to be executed\n");

        exit(1);
    }

    protected function redirect($action)
    {
        throw new RedirectException($action);
    }
}
