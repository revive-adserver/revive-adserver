<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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

/**
 * @package    Max
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@m3.net>
 */

    require_once MAX_PATH . '/lib/max/Forecast/Ad.php';
    require_once MAX_PATH . '/lib/max/Forecast/algorithm/simple.php';
    require_once MAX_PATH . '/lib/max/Dal/Forecasting.php';

    class TestOfMAX_Forecast_Ad extends UnitTestCase {
        
        function TestOfMAX_Forecast_Ad() {
            $this->UnitTestCase('Ad Forecast test');
            
            Mock::generate('MAX_Dal_Forecasting', 'MockForecastAd_MAX_Dal_Forecasting');
        }

        /**
         * Test 1: test when dal return false
         * Test 2: test when activate and expire days exists in dal
         * Test 3: test when activate and expire days are not set
         */
        function testGetStartEndDatesForAd() {
            $oServiceLocator = &ServiceLocator::instance();
            
            // Test 1
            $dal = new MockForecastAd_MAX_Dal_Forecasting($this);
            $dal->setReturnValue('getCampaignByAdId', false);
            $oServiceLocator->register('MAX_Dal_Forecasting', $dal);
            
            $fa = new MAX_Forecast_Ad();
            $ret = $fa->getStartEndDatesForAd(666);
            $this->assertFalse($ret);
            
            // Test 2
            $campaign['activate'] = '2005-08-30';
            $campaign['expire']   = '2005-09-30';
            
            $dal = new MockForecastAd_MAX_Dal_Forecasting($this);
            $dal->setReturnValue('getCampaignByAdId', $campaign);
            $oServiceLocator->register('MAX_Dal_Forecasting', $dal);
            
            $GLOBALS['_MAX']['CONF']['maintenance']['channelForecastingMaxDaysAhead'] = 60;
            
            $ret = $fa->getStartEndDatesForAd(666);
            
            $this->assertEqual($campaign['activate'].' 00:00:00', $ret['start']);
            $this->assertEqual($campaign['expire'].' 00:00:00', $ret['end']);
            
            // Test 4
            $GLOBALS['_MAX']['CONF']['maintenance']['channelForecastingMaxDaysAhead'] = 1;
            
            $ret = $fa->getStartEndDatesForAd(666, new Date('2005-09-09'));
            
            $this->assertEqual($campaign['activate'].' 00:00:00', $ret['start']);
            $this->assertEqual('2005-09-10 00:00:00', $ret['end']);
            
            // Test 3
            $GLOBALS['_MAX']['CONF']['maintenance']['channelForecastingMaxDaysAhead'] = 30;
            $campaign['activate'] = null;
            $campaign['expire']   = '0000-00-00';
            
            $dal = new MockForecastAd_MAX_Dal_Forecasting($this);
            $dal->setReturnValue('getCampaignByAdId', $campaign);
            $oServiceLocator->register('MAX_Dal_Forecasting', $dal);
            
            $GLOBALS['_MAX']['CONF']['maintenance']['channelForecastingDaysBack'] = 3;
            $daysAhead = $GLOBALS['_MAX']['CONF']['maintenance']['channelForecastingDaysAhead'] = 7;
            $ret = $fa->getStartEndDatesForAd(666, new Date('2005-08-15'));
            
            $this->assertEqual('2005-08-12 00:00:00', $ret['start']);
            $this->assertEqual('2005-08-22 00:00:00', $ret['end']);
            $this->assertEqual($daysAhead, $ret['forecastDays']);
        }

        /**
         * Test 1: test when agency and affiliateIds are set
         * Test 2: test when agency and affiliateIds are not set
         */
        function testGetChannelsHistory() {
            $oServiceLocator = &ServiceLocator::instance();
            
            // Test 1
            $dal = new MockForecastAd_MAX_Dal_Forecasting($this);
            $dal->expectOnce('getAvailableChannelsByAgencyAndAffiliates');
            $dal->expectCallCount('getChannelSummaryForZones', 2);
            $dal->setReturnValue('getAvailableChannelsByAgencyAndAffiliates', array(1, 2));
            $oServiceLocator->register('MAX_Dal_Forecasting', $dal);
            
            $fa = new MAX_Forecast_Ad();
            $ret = $fa->getChannelsHistory(1, null, null, 123, array(123));
            $this->assertTrue(is_array($ret));
            
            $dal->tally();
            
            // Test 2
            $dal = new MockForecastAd_MAX_Dal_Forecasting($this);
            $dal->expectOnce('getAdChannelsIds');
            $dal->expectCallCount('getChannelSummaryForZones', 2);
            $dal->setReturnValue('getAdChannelsIds', array(1, 2));
            $oServiceLocator->register('MAX_Dal_Forecasting', $dal);
            
            $fa = new MAX_Forecast_Ad();
            $ret = $fa->getChannelsHistory(1, null, null);
            $this->assertTrue(is_array($ret));
            
            $dal->tally();
        }
        
        /**
         */
        function testGroupHistoryInDays() {
            $oServiceLocator = &ServiceLocator::instance();
            
            $dal = new MockForecastAd_MAX_Dal_Forecasting($this);
            $oServiceLocator->register('MAX_Dal_Forecasting', $dal);
            
            $history = array(
                '2005-08-30 12:00:00' => 123,
                '2005-08-30 13:00:00' => 123,
                '2005-08-30 14:00:00' => 123,
                '2005-08-31 12:00:00' => 123,
            );
            
            $fa = new MAX_Forecast_Ad();
            $groupedData = $fa->groupHistoryInDays($history);
            
            $this->assertTrue(isset($groupedData['2005-08-30']));
            $this->assertTrue(isset($groupedData['2005-08-30'][12]));
            $this->assertTrue(isset($groupedData['2005-08-30'][13]));
            $this->assertTrue(isset($groupedData['2005-08-30'][14]));
            $this->assertEqual($groupedData['2005-08-30'][14], 123);
            $this->assertTrue(isset($groupedData['2005-08-31']));
        }
        
        /**
         *
         */
        function testForecastLastDay() {
            $history = array(
                '2005-08-30' => array(
                    1 => array('impressions' => 123, 'clicks' => 10),
                    2 => array('impressions' => 123, 'clicks' => 20),
                    3 => array('impressions' => 123, 'clicks' => 30),
                ),
                '2005-08-31' => array(
                    1 => array('impressions' => 123, 'clicks' => 10),
                    2 => array('impressions' => 123, 'clicks' => 20),
                ),
            );
            
            $GLOBALS['_MAX']['CONF']['maintenance']['channelForecasting'] = 'impressions,clicks';
            
            $fa = new MAX_Forecast_Ad();
            $fa->forecastLastDay($history, '2005-08-31', 1);
            
            $this->assertTrue(isset($history['2005-08-31'][3]));
            $this->assertEqual($history['2005-08-31'][3]['impressions'], 123);
            $this->assertTrue(!empty($history['2005-08-31'][3]['clicks']));
        }
        
        /**
         *
         */
        function testForecastAdRawData() {
            
            $channelId = 1;
            
            $history = array(
                $channelId => array(
                    '2005-08-30 01:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-30 02:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-30 03:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-30 04:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-30 05:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-30 06:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-30 07:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-30 08:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-30 09:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-30 10:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-30 11:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-30 12:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-30 12:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-30 13:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-30 14:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-30 15:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-30 16:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-30 17:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-30 18:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-30 19:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-30 20:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-30 21:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-30 22:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-30 23:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-30 24:00:00' => array('impressions' => 123, 'clicks' => 10),
                    
                    '2005-08-31 01:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-31 02:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-31 03:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-31 04:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-31 05:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-31 06:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-31 07:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-31 08:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-31 09:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-31 10:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-31 11:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-31 12:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-31 12:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-31 13:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-31 14:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-31 15:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-31 16:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-31 17:00:00' => array('impressions' => 123, 'clicks' => 20),
                    '2005-08-31 18:00:00' => array('impressions' => 123, 'clicks' => 30),
                    '2005-08-31 19:00:00' => array('impressions' => 123, 'clicks' => 40),
                    '2005-08-31 20:00:00' => array('impressions' => 123, 'clicks' => 10),
                    '2005-08-31 21:00:00' => array('impressions' => 123, 'clicks' => 20),
                ),
            );
            
            $GLOBALS['_MAX']['CONF']['maintenance']['channelForecasting'] = 'impressions,clicks';
            
            $oServiceLocator = &ServiceLocator::instance();
            $dal = new MockForecastAd_MAX_Dal_Forecasting($this);
            
            
            Mock::generatePartial('MAX_Forecast_Ad', 'PartialMockMax_Forecast_Ad', array('getStartEndDatesForAd', 'getChannelsHistory'));
            
            $faMock = new PartialMockMAX_Forecast_Ad($this);
            
            $dates['start'] = '2005-08-30';
            $dates['end'] = '2005-09-07';
            $dates['forecastDays'] = 12;
            $faMock->setReturnValue('getStartEndDatesForAd', $dates);
            $faMock->setReturnValue('getChannelsHistory', $history);
            $faMock->_init();
            
            $forecasted = $faMock->forecastAdRawData(123);
            
            $this->assertTrue(!empty($forecasted[$channelId]['impressions']));
            $this->assertTrue(!empty($forecasted[$channelId]['clicks']));
        }
    }

?>