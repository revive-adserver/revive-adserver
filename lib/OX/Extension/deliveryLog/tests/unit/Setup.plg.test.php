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

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once LIB_PATH . '/Extension/deliveryLog/Setup.php';
require_once LIB_PATH . '/Extension/deliveryLog/DeliveryLog.php';

/**
 * A class for testing the OX_Extension_DeliveryLog_Setup class.
 *
 * @package    OpenXExtension
 * @subpackage TestSuite
 */
class Test_OX_Extension_DeliveryLog_Setup extends UnitTestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testGetDependencyOrderedPlugins()
    {
        Mock::generatePartial(
            'OX_Extension_DeliveryLog_Setup',
            $mockSetup = 'OX_Extension_DeliveryLog_Setup' . __CLASS__ . __FUNCTION__,
            ['getComponentsDependencies']
        );

        $oSetup = new $mockSetup($this);

        $aAllComponentsDependencies = $this->_getDependencies();
        $aComponentsToSchedule = ['extension1:group1:component2', 'extension1:group1:component3'];
        $oSetup->setReturnValue('getComponentsDependencies', $aAllComponentsDependencies);
        // second parameter is mocked so we just pass array
        $aOrdered = $oSetup->getDependencyOrderedPlugins($aComponentsToSchedule, []);
        $aExpected = [
            'extension1:group1:component3',
            'extension1:group1:component2',
        ];
        $this->assertEqual($aOrdered, $aExpected);
    }

    public function testGetComponentsDependencies()
    {
        Mock::generatePartial(
            'OX_Extension_DeliveryLog_Setup',
            $mockSetup = 'OX_Extension_DeliveryLog_Setup' . __CLASS__ . __FUNCTION__,
            ['_factoryComponentById']
        );

        $oSetup = new $mockSetup($this);

        $oSetup->setReturnValue(
            '_factoryComponentById',
            new PluginTestComponent1(),
            ['extension1:group1:component1']
        );
        $oSetup->setReturnValue(
            '_factoryComponentById',
            new PluginTestComponent2(),
            ['extension1:group1:component2']
        );
        $oSetup->setReturnValue(
            '_factoryComponentById',
            new PluginTestComponent3(),
            ['extension1:group1:component3']
        );
        $aDependencies = $oSetup->getComponentsDependencies(
            [
                'hook1' => [
                    'extension1:group1:component1',
                    'extension1:group1:component2',
                ],
                'hook2' => [
                    'extension1:group1:component3',
                ],
            ]
        );
        $aExpectedDependencies = $this->_getDependencies();

        $this->assertEqual($aDependencies, $aExpectedDependencies);
    }

    public function _getDependencies()
    {
        return [
            'extension1:group1:component1' => [
                'extension1:group1:component2', // component1 depends on component2
            ],
            'extension1:group1:component2' => [
                'extension1:group1:component3', // component2 depends on component3
            ],
            'extension1:group1:component3' => [ // component3 do not depend on anything
            ],
        ];
    }

    public function testGetExtensionGroupComponentFromId()
    {
        $aExpected = ['extensionName', 'groupName', 'componentName'];
        $ret = OX_Extension_DeliveryLog_Setup::getExtensionGroupComponentFromId('extensionName:groupName:componentName');
        $this->assertEqual($aExpected, $ret);
    }

    public function testGeneratePluginsCode()
    {
        Mock::generatePartial(
            'OX_Extension_DeliveryLog_Setup',
            $mockSetup = 'OX_Extension_DeliveryLog_Setup' . __CLASS__ . __FUNCTION__,
            ['getFilePathToPlugin']
        );

        $oSetup = new $mockSetup($this);

        $testDataDir = LIB_PATH . '/Extension/deliveryLog/tests/data/';
        $oSetup->setReturnValue(
            'getFilePathToPlugin',
            $testDataDir . 'logBoo.delivery.php',
            ['extension1', 'group1', 'component1']
        );
        $oSetup->setReturnValue(
            'getFilePathToPlugin',
            $testDataDir . 'logFoo.delivery.php',
            ['extension1', 'group1', 'component2']
        );

        $aHooks = [
                'hook1' => [
                    'extension1:group1:component1',
                    'extension1:group1:component2',
                ],
        ];
        $code = $oSetup->generatePluginsCode($aHooks);
        $this->assertPattern('/foo/', $code);
        $this->assertPattern('/boo/', $code);
    }

    public function testInstallComponents()
    {
        Mock::generatePartial(
            'OX_Extension_DeliveryLog_Setup',
            $mockSetup = 'OX_Extension_DeliveryLog_Setup' . __CLASS__ . __FUNCTION__,
            ['_getComponents', '_logError', '_factoryComponentById']
        );
        $oSetup = new $mockSetup($this);
        $aComponents = [
            new PluginTestComponent1(),
            new PluginTestComponent2(),
        ];
        $oSetup->setReturnValue('_getComponents', $aComponents);
        $ret = $oSetup->installComponents('boo', ['boo']);
        $this->assertTrue($ret);

        // test that it recovers
        $aComponents[] = new PluginTestComponent3();
        $oSetup = new $mockSetup($this);
        $oSetup->setReturnValue('_getComponents', $aComponents);
        $oSetup->setReturnValue(
            '_factoryComponentById',
            new PluginTestComponent1(),
            ['extension1:group1:component1']
        );
        $oSetup->setReturnValue(
            '_factoryComponentById',
            new PluginTestComponent2(),
            ['extension1:group1:component2']
        );
        $oSetup->setReturnValue(
            '_factoryComponentById',
            new PluginTestComponent3(),
            ['extension1:group1:component3']
        );

        $ret = $oSetup->installComponents('boo', ['boo']);
        $this->assertFalse($ret);
        foreach ($aComponents as $component) {
            if (!is_a($component, 'PluginTestComponent3')) {
                $this->assertTrue($component->checkRecovered());
            }
        }
    }
}

/**
 * Class used in tests - component1
 *
 */
abstract class PluginTestComponentCommon extends Plugins_DeliveryLog
{
    public static $wasRecovered = false;

    public function onInstall()
    {
        return true;
    }

    public function onUninstall()
    {
        self::$wasRecovered = true;
    }

    public function checkRecovered()
    {
        return self::$wasRecovered;
    }

    public function getBucketName()
    {
        return 'foo';
    }

    public function getBucketTableColumns()
    {
        return [];
    }
}

/**
 * Class used in tests - component1
 *
 */
class PluginTestComponent1 extends PluginTestComponentCommon
{
    public function getDependencies()
    {
        return [
            'extension1:group1:component1' => [
                'extension1:group1:component2', // component1 depends on component2
            ],
        ];
    }

    public function getComponentIdentifier()
    {
        return 'extension1:group1:component1';
    }

    public function getStatisticsName()
    {
        return 'fake_table';
    }

    public function getStatisticsMigration()
    {
        return false;
    }
}

/**
 * Class used in tests - component2
 *
 */
class PluginTestComponent2 extends PluginTestComponentCommon
{
    public function getDependencies()
    {
        return [
            'extension1:group1:component2' => [
                'extension1:group1:component3', // component2 depends on component3
            ],
        ];
    }

    public function getComponentIdentifier()
    {
        return 'extension1:group1:component2';
    }

    public function getStatisticsName()
    {
        return 'fake_table';
    }

    public function getStatisticsMigration()
    {
        return false;
    }
}

/**
 * Class used in tests - component3
 *
 */
class PluginTestComponent3 extends PluginTestComponentCommon
{
    public function getDependencies()
    {
        return [
            'extension1:group1:component3' => [ // component3 do not depend on anything
            ],
        ];
    }

    public function onInstall()
    {
        return false;
    }

    public function getComponentIdentifier()
    {
        return 'extension1:group1:component3';
    }

    public function getStatisticsName()
    {
        return 'fake_table';
    }

    public function getStatisticsMigration()
    {
        return false;
    }
}
