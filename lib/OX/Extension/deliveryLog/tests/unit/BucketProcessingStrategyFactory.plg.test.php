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

require_once LIB_PATH . '/Extension/deliveryLog/BucketProcessingStrategyFactory.php';

/**
 * A class for testing the OX_Extension_DeliveryLog_Setup class.
 *
 * @package    OpenXExtension
 * @subpackage TestSuite
 *
 * @TODO Complete tests for all cases, once central server strategies have been
 *       implemented.
 */
class Test_OX_Extension_DeliveryLog_BucketProcessingStrategyFactory extends UnitTestCase
{

    /**
     * The method to test the factory's getAggregateBucketProcessingStrategy()
     * methiod.
     */
    function testGetAggregateBucketProcessingStrategy()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];

        // Test the creation of an edge/aggregate server MySQL strategy class
        $aConf['lb']['enabled'] = true;
        $aConf['database']['type'] = 'mysql';
        $oProcessingStrategy =
            OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::getAggregateBucketProcessingStrategy($aConf['database']['type']);
        $this->assertTrue(is_a($oProcessingStrategy, 'OX_Extension_DeliveryLog_AggregateBucketProcessingStrategyMysql'));

        $aConf['database']['type'] = 'mysqli';
        $oProcessingStrategy =
            OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::getAggregateBucketProcessingStrategy($aConf['database']['type']);
        $this->assertTrue(is_a($oProcessingStrategy, 'OX_Extension_DeliveryLog_AggregateBucketProcessingStrategyMysqli'));

        $aConf['database']['type'] = 'pgsql';
        $oProcessingStrategy =
            OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::getAggregateBucketProcessingStrategy($aConf['database']['type']);
        $this->assertTrue(is_a($oProcessingStrategy, 'OX_Extension_DeliveryLog_AggregateBucketProcessingStrategyPgsql'));

        // Restore the configuration file
        TestEnv::restoreConfig();
    }

    /**
     * The method to test the factory's getRawBucketProcessingStrategy()
     * methiod.
     */
    function testGetRawBucketProcessingStrategy()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];

        // Test the creation of an edge/aggregate server MySQL strategy class
        $aConf['lb']['enabled'] = true;
        $aConf['database']['type'] = 'mysql';
        $oProcessingStrategy =
            OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::getRawBucketProcessingStrategy($aConf['database']['type']);
        $this->assertTrue(is_a($oProcessingStrategy, 'OX_Extension_DeliveryLog_RawBucketProcessingStrategyMysql'));

        $aConf['database']['type'] = 'mysqli';
        $oProcessingStrategy =
            OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::getRawBucketProcessingStrategy($aConf['database']['type']);
        $this->assertTrue(is_a($oProcessingStrategy, 'OX_Extension_DeliveryLog_RawBucketProcessingStrategyMysqli'));

        $aConf['database']['type'] = 'pgsql';
        $oProcessingStrategy =
            OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::getRawBucketProcessingStrategy($aConf['database']['type']);
        $this->assertTrue(is_a($oProcessingStrategy, 'OX_Extension_DeliveryLog_RawBucketProcessingStrategyPgsql'));

        // Restore the configuration file
        TestEnv::restoreConfig();
    }

}

?>
