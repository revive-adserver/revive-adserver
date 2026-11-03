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

use RV\Command\Installer\InstallCommand;
use RV\Command\Installer\UpgradeCommand;
use Symfony\Component\Console\Application;

/**
 * A class for testing that the installer commands can be registered the
 * same way scripts/installer does it.
 *
 * @package    RV_Command
 * @subpackage TestSuite
 */
class Test_RV_Command_Installer_Commands extends UnitTestCase
{
    public function testCommandsAreRegisteredWithNameAndDescription()
    {
        $oApplication = new Application();
        $oApplication->add(new InstallCommand());
        $oApplication->add(new UpgradeCommand());

        $this->assertTrue($oApplication->has('install'));
        $this->assertEqual('Install a Revive Adserver instance', $oApplication->get('install')->getDescription());

        $this->assertTrue($oApplication->has('upgrade'));
        $this->assertEqual('Upgrade an existing Revive Adserver instance', $oApplication->get('upgrade')->getDescription());
    }
}
