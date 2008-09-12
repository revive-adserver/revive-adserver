<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once LIB_PATH . '/Extension/deliveryLog/Setup.php';
require_once LIB_PATH . '/Extension/deliveryLog/DeliveryLog.php';

/**
 * A class for testing the OX_Extension_DeliveryLog_Setup class.
 *
 * @package    OpenXExtension
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Test_OX_Extension_DeliveryLog_Setup extends UnitTestCase
{

    function Test_OX_Extension_DeliveryLog_Setup()
    {
        $this->UnitTestCase();
    }

    function testGetDependencyOrderedPlugins()
    {
        Mock::generatePartial(
            'OX_Extension_DeliveryLog_Setup',
            $mockSetup = 'OX_Extension_DeliveryLog_Setup'.__CLASS__.__FUNCTION__,
            array('getComponentsDependencies')
        );

        $oSetup = new $mockSetup($this);

        $aAllComponentsDependencies = $this->_getDependencies();
        $aComponentsToSchedule = array('extension1:group1:component2', 'extension1:group1:component3');
        $oSetup->setReturnValue('getComponentsDependencies', $aAllComponentsDependencies);
        // second parameter is mocked so we just pass array
        $aOrdered = $oSetup->getDependencyOrderedPlugins($aComponentsToSchedule, array());
        $aExpected = array(
            'extension1:group1:component3',
            'extension1:group1:component2',
            'extension1:group1:component3'
        );
        $this->assertTrue($aOrdered, $aExpected);
    }

    function testGetComponentsDependencies()
    {
        Mock::generatePartial(
            'OX_Extension_DeliveryLog_Setup',
            $mockSetup = 'OX_Extension_DeliveryLog_Setup'.__CLASS__.__FUNCTION__,
            array('_factoryComponentById')
        );

        $oSetup = new $mockSetup($this);

        $oSetup->setReturnValue('_factoryComponentById',
            new PluginTestComponent1(),
            array('extension1:group1:component1'));
        $oSetup->setReturnValue('_factoryComponentById',
            new PluginTestComponent2(),
            array('extension1:group1:component2'));
        $oSetup->setReturnValue('_factoryComponentById',
            new PluginTestComponent3(),
            array('extension1:group1:component3'));
        $aDependencies = $oSetup->getComponentsDependencies(
            array(
                'hook1' => array(
                    'extension1:group1:component1',
                    'extension1:group1:component2',
                ),
                'hook2' => array(
                    'extension1:group1:component3',
                ),
            )
        );
        $aExpectedDependencies = $this->_getDependencies();

        $this->assertEqual($aDependencies, $aExpectedDependencies);
    }

    function _getDependencies()
    {
        return array(
            'extension1:group1:component1' => array(
                'extension1:group1:component2', // component1 depends on component2
            ),
            'extension1:group1:component2' => array(
                'extension1:group1:component3', // component2 depends on component3
            ),
            'extension1:group1:component3' => array( // component3 do not depend on anything
            ),
        );
    }

    function testGetExtensionGroupComponentFromId()
    {
        $aExpected = array('extensionName', 'groupName', 'componentName');
        $ret = OX_Extension_DeliveryLog_Setup::getExtensionGroupComponentFromId('extensionName:groupName:componentName');
        $this->assertEqual($aExpected, $ret);
    }

    function testGeneratePluginsCode()
    {
        Mock::generatePartial(
            'OX_Extension_DeliveryLog_Setup',
            $mockSetup = 'OX_Extension_DeliveryLog_Setup'.__CLASS__.__FUNCTION__,
            array('getFilePathToPlugin')
        );

        $oSetup = new $mockSetup($this);

        $testDataDir = LIB_PATH . '/Extension/deliveryLog/tests/data/';
        $oSetup->setReturnValue(
            'getFilePathToPlugin',
            $testDataDir . 'logBoo.delivery.php',
            array('extension1','group1','component1')
        );
        $oSetup->setReturnValue(
            'getFilePathToPlugin',
            $testDataDir . 'logFoo.delivery.php',
            array('extension1','group1','component2')
        );

        $aHooks = array(
                'hook1' => array(
                    'extension1:group1:component1',
                    'extension1:group1:component2',
                ),
        );
        $code = $oSetup->generatePluginsCode($aHooks);
        $this->assertPattern('/foo/', $code);
        $this->assertPattern('/boo/', $code);
    }

    function testInstallComponents()
    {
        Mock::generatePartial(
            'OX_Extension_DeliveryLog_Setup',
            $mockSetup = 'OX_Extension_DeliveryLog_Setup'.__CLASS__.__FUNCTION__,
            array('_getComponents', '_logError', '_factoryComponentById')
        );
        $oSetup = new $mockSetup($this);
        $aComponents = array(
            new PluginTestComponent1(),
            new PluginTestComponent2(),
        );
        $oSetup->setReturnValue('_getComponents', $aComponents);
        $ret = $oSetup->installComponents('boo', array('boo'));
        $this->assertTrue($ret);

        // test that it recovers
        $aComponents[] = new PluginTestComponent3();
        $oSetup = new $mockSetup($this);
        $oSetup->setReturnValue('_getComponents', $aComponents);
        $oSetup->setReturnValue('_factoryComponentById',
            new PluginTestComponent1(),
            array('extension1:group1:component1'));
        $oSetup->setReturnValue('_factoryComponentById',
            new PluginTestComponent2(),
            array('extension1:group1:component2'));
        $oSetup->setReturnValue('_factoryComponentById',
            new PluginTestComponent3(),
            array('extension1:group1:component3'));

        $ret = $oSetup->installComponents('boo', array('boo'));
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
    static public $wasRecovered = false;

    function onInstall()
    {
        return true;
    }

    function onUninstall()
    {
        self::$wasRecovered = true;
    }

    function checkRecovered()
    {
        return self::$wasRecovered;
    }

    function getBucketName()
    {
        return 'foo';
    }

    function getBucketTableColumns()
    {
        return array();
    }
}

/**
 * Class used in tests - component1
 *
 */
class PluginTestComponent1 extends PluginTestComponentCommon
{
    function getDependencies()
    {
        return array(
            'extension1:group1:component1' => array(
                'extension1:group1:component2', // component1 depends on component2
            ),
        );
    }

    function getComponentIdentifier()
    {
        return 'extension1:group1:component1';
    }

    function getStatisticsName()
    {
        return 'fake_table';
    }

    function getStatisticsMigration()
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
    function getDependencies()
    {
        return array(
            'extension1:group1:component2' => array(
                'extension1:group1:component3', // component2 depends on component3
            ),
        );
    }

    function getComponentIdentifier()
    {
        return 'extension1:group1:component2';
    }

    function getStatisticsName()
    {
        return 'fake_table';
    }

    function getStatisticsMigration()
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
    function getDependencies()
    {
        return array(
            'extension1:group1:component3' => array( // component3 do not depend on anything
            ),
        );
    }

    function onInstall()
    {
        return false;
    }

    function getComponentIdentifier()
    {
        return 'extension1:group1:component3';
    }

    function getStatisticsName()
    {
        return 'fake_table';
    }

    function getStatisticsMigration()
    {
        return false;
    }
}

?>