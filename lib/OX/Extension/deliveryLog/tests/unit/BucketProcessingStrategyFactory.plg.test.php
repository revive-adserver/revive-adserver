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

require_once LIB_PATH . '/Extension/deliveryLog/BucketProcessingStrategyFactory.php';

/**
 * A class for testing the OX_Extension_DeliveryLog_Setup class.
 *
 * @package    OpenXExtension
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
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
        $aconf['database']['type'] = 'mysql';
        $oProcessingStrategy =
            OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::getAggregateBucketProcessingStrategy($aconf['database']['type']);
        $this->assertTrue(is_a($oProcessingStrategy, 'OX_Extension_DeliveryLog_AggregateBucketProcessingStrategyMysql'));


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
        $aconf['database']['type'] = 'mysql';
        $oProcessingStrategy =
            OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::getRawBucketProcessingStrategy($aconf['database']['type']);
        $this->assertTrue(is_a($oProcessingStrategy, 'OX_Extension_DeliveryLog_RawBucketProcessingStrategyMysql'));


        // Restore the configuration file
        TestEnv::restoreConfig();
    }

}

?>