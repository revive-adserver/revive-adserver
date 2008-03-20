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

require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the OA_Central_AdNetworks class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_Central_AdNetworks extends UnitTestCase
{
    /**
     * @var array
     */
    var $aCleanupTables = array('clients','campaigns','banners', 'affiliates', 'ad_zone_assoc', 'zones');

    /**
     * @var OA_PermanentCache
     */
    var $oCache;

    /**
     * The constructor method.
     */
    function Test_OA_Central_AdNetworks()
    {
        $this->UnitTestCase();

        $GLOBALS['_MAX']['PREF'] = array(
            'language'    => 'en',
            'admin_name'  => 'Foo Bar',
            'admin_email' => 'foo@example.com'
        );

        $this->oCache = new OA_PermanentCache();
    }

    function _setUpAppVars()
    {
        OA_Dal_ApplicationVariables::set('platform_hash', sha1('foo'));
        OA_Dal_ApplicationVariables::set('sso_admin', 'foo');
        OA_Dal_ApplicationVariables::set('sso_passwd', md5('bar'));
    }

    function _mockSendReference(&$oAdNetworks, &$reference)
    {
        $oAdNetworks->oMapper->oRpc->oXml->setReturnReference('send', $reference);
    }

    function _mockSendExpect(&$oAdNetworks, $args)
    {
        $oAdNetworks->oMapper->oRpc->oXml->expect('send', $args);
    }
    /**
     * Create a new OA_Central_AdNetworks instance with a mocked Rpc class
     *
     * @return OA_Central_AdNetworks
     */
    function _newInstance()
    {
        Mock::generatePartial(
            'OA_XML_RPC_Client',
            $oXmlRpc = 'OA_XML_RPC_Client_'.md5(uniqid('', true)),
            array('send')
        );

        $oAdNetworks = new OA_Central_AdNetworks();
        $oAdNetworks->oMapper->oRpc->oXml = new $oXmlRpc();

        return $oAdNetworks;
    }


    /**
     * A method to test the getCategories() method.
     *
     */
    function testGetCategories()
    {
        $this->_setUpAppVars();

        $aCategories = array(
            10 => array(
                'name' => 'Music',
                'subcategories' => array(
                    21 => 'Pop',
                    22 => 'Rock'
                )
            )
        );

        $oResponse = new XML_RPC_Response(XML_RPC_encode($aCategories));

        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, $oResponse);

/* DOESN'T WORK!!!
        $oMsg = new XML_RPC_Message('oac.getCategories');
        $oMsg->addParam(XML_RPC_encode(array(
            'protocolVersion'   => OA_CENTRAL_PROTOCOL_VERSION,
            'platformHash'      => sha1('foobar')
        )));
        $oMsg->addParam(new XML_RPC_Value('1', $GLOBALS['XML_RPC_String']));

        $this->_mockSendExpect($oAdNetworks, array($oMsg));
*/
        $result = $oAdNetworks->getCategories();
        $this->assertEqual($result, $aCategories);

        // Test error, this should use the cached values
        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, new XML_RPC_Response(0, 1, 'testMock'));
        $result = $oAdNetworks->getCategories();
        $expected = $this->oCache->get('AdNetworks::getCategories');
        $this->assertTrue($expected, 'Invalid cache file for getCategories');
        $this->assertEqual($result, $expected);
        DataGenerator::cleanUp($this->aCleanupTables);
    }

    /**
     * A method to test the getCountries() method.
     *
     */
    function testGetCountries()
    {
        $this->_setUpAppVars();

        $aCountries = array(
            'UK' => 'United Kingdom',
            'IT' => 'Italy'
        );

        $oResponse = new XML_RPC_Response(XML_RPC_encode($aCountries));

        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, $oResponse);
        $result = $oAdNetworks->getCountries();
        $this->assertEqual($result, $aCountries);

        // Test error, this should use the cached values
        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, new XML_RPC_Response(0, 1, 'testMock'));
        $result = $oAdNetworks->getCountries();
        $expected = $this->oCache->get('AdNetworks::getCountries');
        $this->assertTrue($expected, 'Invalid cache file for getCountries');
        $this->assertEqual($result, $expected);

        DataGenerator::cleanUp($this->aCleanupTables);
    }

    /**
     * A method to test the getLanguages() method.
     *
     */
    function testGetLanguages()
    {
        $this->_setUpAppVars();

        $aLanguages = array(
            1 => 'en',
            2 => 'it'
        );

        $oResponse = new XML_RPC_Response(XML_RPC_encode($aLanguages));

        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, $oResponse);
        $result = $oAdNetworks->getLanguages();
        $this->assertEqual($result, $aLanguages);

        // Test error, this should use the cached values
        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, new XML_RPC_Response(0, 1, 'testMock'));
        $result = $oAdNetworks->getLanguages();
        $expected = $this->oCache->get('AdNetworks::getLanguages');
        $this->assertTrue($expected, 'Invalid cache file for getLanguages');
        $this->assertEqual($result, $expected);

        DataGenerator::cleanUp($this->aCleanupTables);
    }

    /**
     * A method to test the subscribeWebsites() method.
     *
     */
    function testSubscribeWebsites()
    {
        $this->_setUpAppVars();

        $aWebsites = array(
            array(
                'url'      => 'http://www.beccati.com',
                'category' => 1,
                'country'  => 'it',
                'language' => 2
            ),
            array(
                'url'      => 'http://www.openx.org',
                'category' => 2,
                'country'  => 'uk',
                'language' => 1
            )
        );

        $aResponse = $this->_subscribeArray();

        $oResponse = new XML_RPC_Response(XML_RPC_encode($aResponse));

        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, $oResponse);

        // Note since subscribeWebsites now passes-by-reference, and we want to re-create, pass in a copy
        $aWebsitesCopy = $aWebsites;
        $result = $oAdNetworks->subscribeWebsites($aWebsitesCopy);
        $this->assertTrue($result);

        // Check counts
        $oDo = OA_Dal::factoryDO('clients');
        $this->assertEqual($oDo->count(), 1);
        $oDo = OA_Dal::factoryDO('campaigns');
        $this->assertEqual($oDo->count(), 2);
        $oDo = OA_Dal::factoryDO('banners');
        $this->assertEqual($oDo->count(), 3);
        $oDo = OA_Dal::factoryDO('affiliates');
        $this->assertEqual($oDo->count(), 2);
        $oDo = OA_Dal::factoryDO('zones');
        $this->assertEqual($oDo->count(), 3);
        $oDo = OA_Dal::factoryDO('ad_zone_assoc');
        $this->assertEqual($oDo->count(), 6);

        // Subscribe again
        $aWebsitesCopy = $aWebsites;
        $result = $oAdNetworks->subscribeWebsites($aWebsitesCopy);
        $this->assertTrue($result);

        // Check counts
        $oDo = OA_Dal::factoryDO('clients');
        $this->assertEqual($oDo->count(), 1);
        $oDo = OA_Dal::factoryDO('campaigns');
        $this->assertEqual($oDo->count(), 4);
        $oDo = OA_Dal::factoryDO('banners');
        $this->assertEqual($oDo->count(), 6);
        $oDo = OA_Dal::factoryDO('affiliates');
        $this->assertEqual($oDo->count(), 4);
        $oDo = OA_Dal::factoryDO('zones');
        $this->assertEqual($oDo->count(), 6);
        $oDo = OA_Dal::factoryDO('ad_zone_assoc');
        $this->assertEqual($oDo->count(), 12);

        // Check name uniqueness
        $oDo = OA_Dal::factoryDO('campaigns');
        $oDo->campaignid = 3;
        $oDo->find();
        $oDo->fetch();
        $row = $oDo->toArray();
        $this->assertEqual($row['campaignname'], 'Beccati.com - Campaign 1 - http://www.beccati.com (2)');
        DataGenerator::cleanUp($this->aCleanupTables);
    }

    /**
     * A method to test the GetCampaignStatuses() method.
     *
     */
    function testGetCampaignStatuses()
    {
        $this->_setUpAppVars();

        $aCampaigns = array(
             999 => array(OA_ENTITY_STATUS_RUNNING, OA_ENTITY_ADNETWORKS_STATUS_RUNNING),
            1000 => array(OA_ENTITY_STATUS_PAUSED, OA_ENTITY_ADNETWORKS_STATUS_RUNNING),
            1001 => array(OA_ENTITY_STATUS_PENDING, OA_ENTITY_ADNETWORKS_STATUS_APPROVAL),
            1002 => array(OA_ENTITY_STATUS_PENDING, OA_ENTITY_ADNETWORKS_STATUS_APPROVAL),
            1003 => array(OA_ENTITY_STATUS_PENDING, OA_ENTITY_ADNETWORKS_STATUS_APPROVAL),
            1004 => array(OA_ENTITY_STATUS_PENDING, OA_ENTITY_ADNETWORKS_STATUS_REJECTED),
            1005 => array(OA_ENTITY_STATUS_PAUSED, OA_ENTITY_ADNETWORKS_STATUS_APPROVAL),
        );

        $doCampaign = OA_Dal::factoryDO('campaigns');
        foreach ($aCampaigns as $campaignId => $aStatuses) {
            $doCampaign->an_campaign_id = $campaignId;
            $doCampaign->status = $aStatuses[0];
            $doCampaign->an_status = $aStatuses[1];
            DataGenerator::generateOne(clone($doCampaign));
        }

        $aResponse = array(
             999 => OA_ENTITY_ADNETWORKS_STATUS_RUNNING,
            1000 => OA_ENTITY_ADNETWORKS_STATUS_RUNNING,
            1001 => OA_ENTITY_ADNETWORKS_STATUS_RUNNING,
            1002 => OA_ENTITY_ADNETWORKS_STATUS_APPROVAL,
            1003 => OA_ENTITY_ADNETWORKS_STATUS_REJECTED,
            1004 => OA_ENTITY_ADNETWORKS_STATUS_RUNNING,
            1005 => OA_ENTITY_ADNETWORKS_STATUS_RUNNING,
        );

        $oResponse = new XML_RPC_Response(XML_RPC_encode($aResponse));

        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, $oResponse);

        $oAdNetworks->getCampaignStatuses();

        $doCampaign = OA_Dal::factoryDO('campaigns');
        $doCampaign->selectAdd();
        $doCampaign->selectAdd('an_campaign_id');
        $doCampaign->selectAdd('status');
        $doCampaign->selectAdd('an_status');
        $doCampaign->whereAdd('1 = 1');

        $aResult = $doCampaign->getAll(array(), false, false);

        foreach ($aResult as $aCampaign) {
            $aCampaigns[$aCampaign['an_campaign_id']] = array($aCampaign['status'], $aCampaign['an_status']);
        }

        $aExpected = array(
             999 => array(OA_ENTITY_STATUS_RUNNING, OA_ENTITY_ADNETWORKS_STATUS_RUNNING),
            1000 => array(OA_ENTITY_STATUS_PAUSED, OA_ENTITY_ADNETWORKS_STATUS_RUNNING),
            1001 => array(OA_ENTITY_STATUS_RUNNING, OA_ENTITY_ADNETWORKS_STATUS_RUNNING),
            1002 => array(OA_ENTITY_STATUS_PENDING, OA_ENTITY_ADNETWORKS_STATUS_APPROVAL),
            1003 => array(OA_ENTITY_STATUS_PENDING, OA_ENTITY_ADNETWORKS_STATUS_REJECTED),
            1004 => array(OA_ENTITY_STATUS_RUNNING, OA_ENTITY_ADNETWORKS_STATUS_RUNNING),
            1005 => array(OA_ENTITY_STATUS_PAUSED, OA_ENTITY_ADNETWORKS_STATUS_RUNNING),
        );

        $this->assertEqual($aCampaigns, $aExpected);

        DataGenerator::cleanUp($this->aCleanupTables);
    }

    /**
     * A method to test the unsubscribeWebsites() method
     * Note: Using the data inserted by the above test
     */
    function testUnsubscribeWebsites()
    {
        $this->_setUpAppVars();

        $aWebsites = array(
            array(
                'url'      => 'http://www.beccati.com',
                'category' => 1,
                'country'  => 'it',
                'language' => 2
            ),
            array(
                'url'      => 'http://www.openx.org',
                'category' => 2,
                'country'  => 'uk',
                'language' => 1
            )
        );

        // The sites above will generate different numbers of zones
        // So set the expected number of zones to be created here
        $aExpectedZoneCount = array(
            array('zoneCount' => 2),
            array('zoneCount' => 1),
        );

        $aResponse = $this->_subscribeArray();

        $oResponse = new XML_RPC_Response(XML_RPC_encode($aResponse));

        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, $oResponse);

        $result = $oAdNetworks->subscribeWebsites($aWebsites);

        // First assert that the correct number of ad_zone_assoc links are present
        foreach ($aWebsites as $idx => $aWebsite) {
            $doAza = OA_Dal::factoryDO('ad_zone_assoc');
            $doZones = OA_Dal::factoryDO('zones');
            $doZones->affiliateid = $aWebsite['id'];
            $doAza->joinAdd($doZones);
            $this->assertEqual($doAza->count(), $aExpectedZoneCount[$idx]['zoneCount'], 'subscribe call did not setup expected data');
        }

        // No need to mock since this call is currently local-only
        $aResponse = $oAdNetworks->unsubscribeWebsites($aWebsites);
        $this->assertTrue($aResponse, 'unsubscribe websites did not return true');

        // Check that all the ad_zone_assoc entries have been removed
        foreach ($aWebsites as $idx => $aWebsite) {
            $doAza = OA_Dal::factoryDO('ad_zone_assoc');
            $doZones = OA_Dal::factoryDO('zones');
            $doZones->affiliateid = $aWebsite['id'];
            $doAza->joinAdd($doZones);
            $this->assertEqual($doAza->count(), 0);
        }
        DataGenerator::cleanUp($this->aCleanupTables);
    }

    /**
     * A method to test the getRevenue() method.
     *
     * Note: needs to be the last test in the set!!!
     */
    function testGetRevenue()
    {
        $this->_setUpAppVars();

        // Force TimeZone
        $tz = 'Europe/Rome';
        $revenue = 23.45;

        $aResponse = new XML_RPC_Value(array(
            1000 => new XML_RPC_Value(array(
                new XML_RPC_Value(array(
                    'start'   => new XML_RPC_Value('2007-08-01 00:00:00', $GLOBALS['XML_RPC_DateTime']),
                    'end'     => new XML_RPC_Value('2007-08-01 23:59:59', $GLOBALS['XML_RPC_DateTime']),
                    'revenue' => new XML_RPC_Value($revenue, $GLOBALS['XML_RPC_Double']),
                    'type'    => new XML_RPC_Value('CPC', $GLOBALS['XML_RPC_String'])
                ), $GLOBALS['XML_RPC_Struct'])
            ), $GLOBALS['XML_RPC_Array'])
        ), $GLOBALS['XML_RPC_Struct']);

        $oResponse = new XML_RPC_Response($aResponse);

        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, $oResponse);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->an_banner_id = 1000;
        $bannerId = DataGenerator::generateOne($doBanners);
        $this->assertTrue($bannerId);

        $result = $oAdNetworks->getRevenue();
        $this->assertTrue($result);

        $this->assertEqual(OA_Dal_ApplicationVariables::get('batch_sequence'), 1);

        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->orderBy('date_time');
        $doDsah->find();
        $aStats = array();
        $revenueSum = 0;
        while ($doDsah->fetch()) {
            $oDate = new Date($doDsah->date_time);
            $oDate->setTZbyID('UTC');
            $oDate->convertTZbyID($tz);
            $aStats[] = array(
                'day' => $oDate->format('%Y-%m-%d'),
                'hour' => (int)$oDate->format('%H'),
                'impressions' => $doDsah->impressions,
                'clicks' => $doDsah->clicks,
                'total_revenue' => $doDsah->total_revenue
            );
            $revenueSum += $doDsah->total_revenue;
        }

        $this->assertEqual(strval($revenueSum), strval($revenue));

        $aExpected = $this->_getRevenueArray1();
        $this->assertEqual($aStats, $aExpected);

        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->whereAdd('1=1');
        $doDsah->delete(true);

        foreach (array('2007-07-31', '2007-08-01', '2007-08-02') as $day) {
            for ($hour = 0; $hour < 24; $hour++) {
                $oDate = new Date(sprintf('%s %02d:00:00', $day, $hour));
                $oDate->setTZbyID($tz);
                $oDate->toUTC();
                $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
                $doDsah->date_time   = $oDate->format('%Y-%m-%d %H:%M:%S');
                $doDsah->ad_id       = $bannerId;
                $doDsah->zone_id     = 0;
                $doDsah->creative_id = 0;
                $doDsah->impressions = 12 - abs($hour - 12);
                $doDsah->clicks      = floor($doDsah->impressions / 6);
                $doDsah->insert();
            }
        }

        $result = $oAdNetworks->getRevenue(1);
        $this->assertTrue($result);

        $this->assertEqual(OA_Dal_ApplicationVariables::get('batch_sequence'), 2);

        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->orderBy('date_time');
        $doDsah->find();
        $aStats = array();
        $revenueSum = 0;
        while ($doDsah->fetch()) {
            $oDate = new Date($doDsah->date_time);
            $oDate->setTZbyID('UTC');
            $oDate->convertTZbyID($tz);
            $aStats[] = array(
                'day' => $oDate->format('%Y-%m-%d'),
                'hour' => (int)$oDate->format('%H'),
                'impressions' => $doDsah->impressions,
                'clicks' => $doDsah->clicks,
                'total_revenue' => $doDsah->total_revenue
            );
            $revenueSum += $doDsah->total_revenue;
        }

        $this->assertEqual(strval($revenueSum), strval($revenue));

        $aExpected = $this->_getRevenueArray2();
        $this->assertEqual($aStats, $aExpected);


        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->whereAdd('1=1');
        $doDsah->delete(true);

        foreach (array('2007-07-31', '2007-08-01', '2007-08-02') as $day) {
            for ($hour = 0; $hour < 24; $hour += 4) {
                $oDate = new Date(sprintf('%s %02d:00:00', $day, $hour));
                $oDate->setTZbyID($tz);
                $oDate->toUTC();
                $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
                $doDsah->date_time   = $oDate->format('%Y-%m-%d %H:%M:%S');
                $doDsah->ad_id       = $bannerId;
                $doDsah->zone_id     = 10;
                $doDsah->creative_id = 0;
                $doDsah->impressions = 1;
                $doDsah->clicks      = 0;
                $doDsah->insert();
            }
        }

        $result = $oAdNetworks->getRevenue(1);
        $this->assertTrue($result);

        $this->assertEqual(OA_Dal_ApplicationVariables::get('batch_sequence'), 3);

        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->orderBy('date_time');
        $doDsah->find();
        $aStats = array();
        $revenueSum = 0;
        while ($doDsah->fetch()) {
            $oDate = new Date($doDsah->date_time);
            $oDate->setTZbyID('UTC');
            $oDate->convertTZbyID($tz);
            $aStats[] = array(
                'day' => $oDate->format('%Y-%m-%d'),
                'hour' => (int)$oDate->format('%H'),
                'impressions' => $doDsah->impressions,
                'clicks' => $doDsah->clicks,
                'total_revenue' => $doDsah->total_revenue
            );
            $revenueSum += $doDsah->total_revenue;
        }

        $this->assertEqual(strval($revenueSum), strval($revenue));

        $aExpected = $this->_getRevenueArray3();
        $this->assertEqual($aStats, $aExpected);


        DataGenerator::cleanUp($this->aCleanupTables);
    }

    function _subscribeArray()
    {
        return array(
            'adnetworks' => array(
                array(
                    'adnetwork_id' => 1,
                    'name' => 'Beccati.com'
                )
            ),
            'websites' => array(
                array(
                    'website_id' => 2345,
                    'url'        => 'http://www.beccati.com',
                    'campaigns'  => array(
                        array(
                            'campaign_id'  => 2000,
                            'adnetwork_id' => 1,
                            'name'         => 'Campaign 1',
                            'weight'       => 1,
                            'capping'      => 0,
                            'status'       => 0,
                            'banners'      => array(
                                array(
                                    'banner_id' => 3000,
                                    'name' => 'Banner 1',
                                    'width' => 468,
                                    'height' => 60,
                                    'capping' => 0,
                                    'html' => '<script language=\'JavaScript\' type=\'text/javascript\' src=\'http://www.example.com/adx.js\'></script>
<script language=\'JavaScript\' type=\'text/javascript\'>
<!--
if (!document.phpAds_used) document.phpAds_used = \',\';
phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);

document.write ("<" + "script language=\'JavaScript\' type=\'text/javascript\' src=\'");
document.write ("http://www.example.com/adjs.php?n=" + phpAds_random);
document.write ("&amp;what=zone:1");
document.write ("&amp;exclude=" + document.phpAds_used);
if (document.referrer)
  document.write ("&amp;referer=" + escape(document.referrer));
document.write ("\'><" + "/script>");
//-->
</script><noscript><a href=\'http://www.example.com/adclick.php?n=a29f51cf\' target=\'_blank\'><img src=\'http://www.example.com/adview.php?what=zone:1&amp;n=a29f51cf\' border=\'0\' alt=\'\'></a></noscript>
',
                                    'adserver' => ''
                                ),
                                array(
                                    'banner_id' => 3002,
                                    'name' => 'Banner 2',
                                    'width' => 125,
                                    'height' => 125,
                                    'capping' => 1,
                                    'html' => '<script language=\'JavaScript\' type=\'text/javascript\' src=\'http://www.example.com/adx.js\'></script>
<script language=\'JavaScript\' type=\'text/javascript\'>
<!--
if (!document.phpAds_used) document.phpAds_used = \',\';
phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);

document.write ("<" + "script language=\'JavaScript\' type=\'text/javascript\' src=\'");
document.write ("http://www.example.com/adjs.php?n=" + phpAds_random);
document.write ("&amp;what=zone:2");
document.write ("&amp;exclude=" + document.phpAds_used);
if (document.referrer)
  document.write ("&amp;referer=" + escape(document.referrer));
document.write ("\'><" + "/script>");
//-->
</script><noscript><a href=\'http://www.example.com/adclick.php?n=a29f51cf\' target=\'_blank\'><img src=\'http://www.example.com/adview.php?what=zone:2&amp;n=a29f51cf\' border=\'0\' alt=\'\'></a></noscript>
',
                                    'adserver' => ''
                                )
                            )
                        )
                    )
                ),
                array(
                    'website_id' => 2346,
                    'url'        => 'http://www.openx.org',
                    'campaigns'  => array(
                        array(
                            'campaign_id' => 2001,
                            'adnetwork_id' => 1,
                            'name'        => 'Campaign 1',
                            'weight'      => 1,
                            'capping'     => 0,
                            'status'      => 0,
                            'banners'     => array(
                                array(
                                    'banner_id' => 3001,
                                    'name' => 'Banner 1',
                                    'width' => 468,
                                    'height' => 60,
                                    'capping' => 0,
                                    'html' => '<script language=\'JavaScript\' type=\'text/javascript\' src=\'http://www.example.com/adx.js\'></script>
<script language=\'JavaScript\' type=\'text/javascript\'>
<!--
if (!document.phpAds_used) document.phpAds_used = \',\';
phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);

document.write ("<" + "script language=\'JavaScript\' type=\'text/javascript\' src=\'");
document.write ("http://www.example.com/adjs.php?n=" + phpAds_random);
document.write ("&amp;what=zone:3");
document.write ("&amp;exclude=" + document.phpAds_used);
if (document.referrer)
  document.write ("&amp;referer=" + escape(document.referrer));
document.write ("\'><" + "/script>");
//-->
</script><noscript><a href=\'http://www.example.com/adclick.php?n=a29f51cf\' target=\'_blank\'><img src=\'http://www.example.com/adview.php?what=zone:3&amp;n=a29f51cf\' border=\'0\' alt=\'\'></a></noscript>
',
                                    'adserver' => ''
                                )
                            )
                        )
                    )
                )
            )
        );
    }

    function _getRevenueArray1()
    {
        return array (
          0 =>
          array (
            'day' => '2007-08-01',
            'hour' => '2',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          1 =>
          array (
            'day' => '2007-08-01',
            'hour' => '3',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          2 =>
          array (
            'day' => '2007-08-01',
            'hour' => '4',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          3 =>
          array (
            'day' => '2007-08-01',
            'hour' => '5',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          4 =>
          array (
            'day' => '2007-08-01',
            'hour' => '6',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          5 =>
          array (
            'day' => '2007-08-01',
            'hour' => '7',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          6 =>
          array (
            'day' => '2007-08-01',
            'hour' => '8',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          7 =>
          array (
            'day' => '2007-08-01',
            'hour' => '9',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          8 =>
          array (
            'day' => '2007-08-01',
            'hour' => '10',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          9 =>
          array (
            'day' => '2007-08-01',
            'hour' => '11',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          10 =>
          array (
            'day' => '2007-08-01',
            'hour' => '12',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          11 =>
          array (
            'day' => '2007-08-01',
            'hour' => '13',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          12 =>
          array (
            'day' => '2007-08-01',
            'hour' => '14',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          13 =>
          array (
            'day' => '2007-08-01',
            'hour' => '15',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          14 =>
          array (
            'day' => '2007-08-01',
            'hour' => '16',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          15 =>
          array (
            'day' => '2007-08-01',
            'hour' => '17',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          16 =>
          array (
            'day' => '2007-08-01',
            'hour' => '18',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          17 =>
          array (
            'day' => '2007-08-01',
            'hour' => '19',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          18 =>
          array (
            'day' => '2007-08-01',
            'hour' => '20',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          19 =>
          array (
            'day' => '2007-08-01',
            'hour' => '21',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          20 =>
          array (
            'day' => '2007-08-01',
            'hour' => '22',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          21 =>
          array (
            'day' => '2007-08-01',
            'hour' => '23',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          22 =>
          array (
            'day' => '2007-08-02',
            'hour' => '0',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.9700',
          ),
          23 =>
          array (
            'day' => '2007-08-02',
            'hour' => '1',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '1.1400',
          )
        );
    }

    function _getRevenueArray2()
    {
        return array (
          0 =>
          array (
            'day' => '2007-07-31',
            'hour' => '0',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          1 =>
          array (
            'day' => '2007-07-31',
            'hour' => '1',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          2 =>
          array (
            'day' => '2007-07-31',
            'hour' => '2',
            'impressions' => '2',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          3 =>
          array (
            'day' => '2007-07-31',
            'hour' => '3',
            'impressions' => '3',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          4 =>
          array (
            'day' => '2007-07-31',
            'hour' => '4',
            'impressions' => '4',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          5 =>
          array (
            'day' => '2007-07-31',
            'hour' => '5',
            'impressions' => '5',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          6 =>
          array (
            'day' => '2007-07-31',
            'hour' => '6',
            'impressions' => '6',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          7 =>
          array (
            'day' => '2007-07-31',
            'hour' => '7',
            'impressions' => '7',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          8 =>
          array (
            'day' => '2007-07-31',
            'hour' => '8',
            'impressions' => '8',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          9 =>
          array (
            'day' => '2007-07-31',
            'hour' => '9',
            'impressions' => '9',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          10 =>
          array (
            'day' => '2007-07-31',
            'hour' => '10',
            'impressions' => '10',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          11 =>
          array (
            'day' => '2007-07-31',
            'hour' => '11',
            'impressions' => '11',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          12 =>
          array (
            'day' => '2007-07-31',
            'hour' => '12',
            'impressions' => '12',
            'clicks' => '2',
            'total_revenue' => NULL,
          ),
          13 =>
          array (
            'day' => '2007-07-31',
            'hour' => '13',
            'impressions' => '11',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          14 =>
          array (
            'day' => '2007-07-31',
            'hour' => '14',
            'impressions' => '10',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          15 =>
          array (
            'day' => '2007-07-31',
            'hour' => '15',
            'impressions' => '9',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          16 =>
          array (
            'day' => '2007-07-31',
            'hour' => '16',
            'impressions' => '8',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          17 =>
          array (
            'day' => '2007-07-31',
            'hour' => '17',
            'impressions' => '7',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          18 =>
          array (
            'day' => '2007-07-31',
            'hour' => '18',
            'impressions' => '6',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          19 =>
          array (
            'day' => '2007-07-31',
            'hour' => '19',
            'impressions' => '5',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          20 =>
          array (
            'day' => '2007-07-31',
            'hour' => '20',
            'impressions' => '4',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          21 =>
          array (
            'day' => '2007-07-31',
            'hour' => '21',
            'impressions' => '3',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          22 =>
          array (
            'day' => '2007-07-31',
            'hour' => '22',
            'impressions' => '2',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          23 =>
          array (
            'day' => '2007-07-31',
            'hour' => '23',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          24 =>
          array (
            'day' => '2007-08-01',
            'hour' => '0',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          25 =>
          array (
            'day' => '2007-08-01',
            'hour' => '1',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          26 =>
          array (
            'day' => '2007-08-01',
            'hour' => '2',
            'impressions' => '2',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          27 =>
          array (
            'day' => '2007-08-01',
            'hour' => '3',
            'impressions' => '3',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          28 =>
          array (
            'day' => '2007-08-01',
            'hour' => '4',
            'impressions' => '4',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          29 =>
          array (
            'day' => '2007-08-01',
            'hour' => '5',
            'impressions' => '5',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          30 =>
          array (
            'day' => '2007-08-01',
            'hour' => '6',
            'impressions' => '6',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          31 =>
          array (
            'day' => '2007-08-01',
            'hour' => '7',
            'impressions' => '7',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          32 =>
          array (
            'day' => '2007-08-01',
            'hour' => '8',
            'impressions' => '8',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          33 =>
          array (
            'day' => '2007-08-01',
            'hour' => '9',
            'impressions' => '9',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          34 =>
          array (
            'day' => '2007-08-01',
            'hour' => '10',
            'impressions' => '10',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          35 =>
          array (
            'day' => '2007-08-01',
            'hour' => '11',
            'impressions' => '11',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          36 =>
          array (
            'day' => '2007-08-01',
            'hour' => '12',
            'impressions' => '12',
            'clicks' => '2',
            'total_revenue' => '3.3500',
          ),
          37 =>
          array (
            'day' => '2007-08-01',
            'hour' => '13',
            'impressions' => '11',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          38 =>
          array (
            'day' => '2007-08-01',
            'hour' => '14',
            'impressions' => '10',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          39 =>
          array (
            'day' => '2007-08-01',
            'hour' => '15',
            'impressions' => '9',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          40 =>
          array (
            'day' => '2007-08-01',
            'hour' => '16',
            'impressions' => '8',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          41 =>
          array (
            'day' => '2007-08-01',
            'hour' => '17',
            'impressions' => '7',
            'clicks' => '1',
            'total_revenue' => '1.6700',
          ),
          42 =>
          array (
            'day' => '2007-08-01',
            'hour' => '18',
            'impressions' => '6',
            'clicks' => '1',
            'total_revenue' => '1.7300',
          ),
          43 =>
          array (
            'day' => '2007-08-01',
            'hour' => '19',
            'impressions' => '5',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          44 =>
          array (
            'day' => '2007-08-01',
            'hour' => '20',
            'impressions' => '4',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          45 =>
          array (
            'day' => '2007-08-01',
            'hour' => '21',
            'impressions' => '3',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          46 =>
          array (
            'day' => '2007-08-01',
            'hour' => '22',
            'impressions' => '2',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          47 =>
          array (
            'day' => '2007-08-01',
            'hour' => '23',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          48 =>
          array (
            'day' => '2007-08-02',
            'hour' => '0',
            'impressions' => '0',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          49 =>
          array (
            'day' => '2007-08-02',
            'hour' => '1',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => '0.0000',
          ),
          50 =>
          array (
            'day' => '2007-08-02',
            'hour' => '2',
            'impressions' => '2',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          51 =>
          array (
            'day' => '2007-08-02',
            'hour' => '3',
            'impressions' => '3',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          52 =>
          array (
            'day' => '2007-08-02',
            'hour' => '4',
            'impressions' => '4',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          53 =>
          array (
            'day' => '2007-08-02',
            'hour' => '5',
            'impressions' => '5',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          54 =>
          array (
            'day' => '2007-08-02',
            'hour' => '6',
            'impressions' => '6',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          55 =>
          array (
            'day' => '2007-08-02',
            'hour' => '7',
            'impressions' => '7',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          56 =>
          array (
            'day' => '2007-08-02',
            'hour' => '8',
            'impressions' => '8',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          57 =>
          array (
            'day' => '2007-08-02',
            'hour' => '9',
            'impressions' => '9',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          58 =>
          array (
            'day' => '2007-08-02',
            'hour' => '10',
            'impressions' => '10',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          59 =>
          array (
            'day' => '2007-08-02',
            'hour' => '11',
            'impressions' => '11',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          60 =>
          array (
            'day' => '2007-08-02',
            'hour' => '12',
            'impressions' => '12',
            'clicks' => '2',
            'total_revenue' => NULL,
          ),
          61 =>
          array (
            'day' => '2007-08-02',
            'hour' => '13',
            'impressions' => '11',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          62 =>
          array (
            'day' => '2007-08-02',
            'hour' => '14',
            'impressions' => '10',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          63 =>
          array (
            'day' => '2007-08-02',
            'hour' => '15',
            'impressions' => '9',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          64 =>
          array (
            'day' => '2007-08-02',
            'hour' => '16',
            'impressions' => '8',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          65 =>
          array (
            'day' => '2007-08-02',
            'hour' => '17',
            'impressions' => '7',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          66 =>
          array (
            'day' => '2007-08-02',
            'hour' => '18',
            'impressions' => '6',
            'clicks' => '1',
            'total_revenue' => NULL,
          ),
          67 =>
          array (
            'day' => '2007-08-02',
            'hour' => '19',
            'impressions' => '5',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          68 =>
          array (
            'day' => '2007-08-02',
            'hour' => '20',
            'impressions' => '4',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          69 =>
          array (
            'day' => '2007-08-02',
            'hour' => '21',
            'impressions' => '3',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          70 =>
          array (
            'day' => '2007-08-02',
            'hour' => '22',
            'impressions' => '2',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          71 =>
          array (
            'day' => '2007-08-02',
            'hour' => '23',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
        );
    }


    function _getRevenueArray3()
    {
        return array (
          0 =>
          array (
            'day' => '2007-07-31',
            'hour' => '0',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          1 =>
          array (
            'day' => '2007-07-31',
            'hour' => '4',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          2 =>
          array (
            'day' => '2007-07-31',
            'hour' => '8',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          3 =>
          array (
            'day' => '2007-07-31',
            'hour' => '12',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          4 =>
          array (
            'day' => '2007-07-31',
            'hour' => '16',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          5 =>
          array (
            'day' => '2007-07-31',
            'hour' => '20',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          6 =>
          array (
            'day' => '2007-08-01',
            'hour' => '0',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          7 =>
          array (
            'day' => '2007-08-01',
            'hour' => '4',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => '3.9000',
          ),
          8 =>
          array (
            'day' => '2007-08-01',
            'hour' => '8',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => '3.9000',
          ),
          9 =>
          array (
            'day' => '2007-08-01',
            'hour' => '12',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => '3.9000',
          ),
          10 =>
          array (
            'day' => '2007-08-01',
            'hour' => '16',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => '3.9000',
          ),
          11 =>
          array (
            'day' => '2007-08-01',
            'hour' => '20',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => '3.9000',
          ),
          12 =>
          array (
            'day' => '2007-08-02',
            'hour' => '0',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => '3.9500',
          ),
          13 =>
          array (
            'day' => '2007-08-02',
            'hour' => '4',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          14 =>
          array (
            'day' => '2007-08-02',
            'hour' => '8',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          15 =>
          array (
            'day' => '2007-08-02',
            'hour' => '12',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          16 =>
          array (
            'day' => '2007-08-02',
            'hour' => '16',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
          17 =>
          array (
            'day' => '2007-08-02',
            'hour' => '20',
            'impressions' => '1',
            'clicks' => '0',
            'total_revenue' => NULL,
          ),
        );
    }

}

?>
