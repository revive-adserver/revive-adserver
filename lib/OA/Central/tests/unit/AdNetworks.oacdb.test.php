<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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

require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the OA_Central_AdNetworks class.
 *
 * @package    Openads
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openads.org>
 */
class Test_OA_Central_AdNetworks extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_OA_Central_AdNetworks()
    {
        $this->UnitTestCase();

        $GLOBALS['_MAX']['PREF'] = array(
            'language'    => 'english',
            'instance_id' => sha1('foobar'),
            'sso_admin'   => 'foo',
            'sso_passwd'  => md5('bar'),
            'admin_email' => 'foo@example.com'
        );

    }

    function _mockSendReference(&$oAdNetworks, &$reference)
    {
        $oAdNetworks->oDal->oRpc->oXml->setReturnReference('send', $reference);
    }

    function _mockSendExpect(&$oAdNetworks, $args)
    {
        $oAdNetworks->oDal->oRpc->oXml->expect('send', $args);
    }
    /**
     * Create a new OA_Central_AdNetworks instance with a mocked Rpc class
     *
     * @return OA_Central_AdNetworks
     */
    function _newInstance()
    {
        Mock::generatePartial(
            'XML_RPC_Client',
            $oXmlRpc = 'XML_RPC_Client_'.md5(uniqid('', true)),
            array('send')
        );

        $oAdNetworks = new OA_Central_AdNetworks();
        $oAdNetworks->oDal->oRpc->oXml = new $oXmlRpc();

        return $oAdNetworks;
    }


    /**
     * A method to test the getCategories() method.
     */
    function testGetCategories()
    {
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


        // Test error
        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, new XML_RPC_Response(0, 1, 'testMock'));
        $result = $oAdNetworks->getCategories();
        $this->assertFalse($result);
    }


    function testSubscribe()
    {
        $aWebsites = array(
            array(
                'url'      => 'http://www.beccati.com',
                'category' => 1,
                'country'  => 'it',
                'language' => 2
            ),
            array(
                'url'      => 'http://www.openads.org',
                'category' => 2,
                'country'  => 'uk',
                'language' => 1
            )
        );

        $aResponse = $this->_subscribeArray();

        $oResponse = new XML_RPC_Response(XML_RPC_encode($aResponse));

        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, $oResponse);

        $result = $oAdNetworks->subscribeWebsites($aWebsites);
        $this->assertTrue($result);

        // Check counts
        $oDo = OA_Dal::factoryDO('clients');
        $this->assertEqual($oDo->count(), 2);
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
        $result = $oAdNetworks->subscribeWebsites($aWebsites);
        $this->assertTrue($result);

        // Check counts
        $oDo = OA_Dal::factoryDO('clients');
        $this->assertEqual($oDo->count(), 4);
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
        $oDo = OA_Dal::factoryDO('clients');
        $oDo->clientid = 3;
        $oDo->find();
        $oDo->fetch();
        $row = $oDo->toArray();
        $this->assertEqual($row['clientname'], 'Beccati.com (3)');
    }

    /**
     * Test getRevenue
     *
     * Note: needs to be the last test in the set!!!
     */
    function testGetRevenue()
    {
        // Force TimeZone
        if (is_callable('date_default_timezone_set')) {
            date_default_timezone_set('Europe/Rome');
        } else {
            putenv('TZ=Europe/Rome');
        }

        $aResponse = new XML_RPC_Value(array(
            1000 => new XML_RPC_Value(array(
                new XML_RPC_Value(array(
                    'start'   => new XML_RPC_Value('20070801T000000', $GLOBALS['XML_RPC_DateTime']),
                    'end'     => new XML_RPC_Value('20070801T235959', $GLOBALS['XML_RPC_DateTime']),
                    'revenue' => new XML_RPC_Value(23.45, $GLOBALS['XML_RPC_Double']),
                    'type'    => new XML_RPC_Value('CPC', $GLOBALS['XML_RPC_String'])
                ), $GLOBALS['XML_RPC_Struct'])
            ), $GLOBALS['XML_RPC_Array'])
        ), $GLOBALS['XML_RPC_Struct']);

        $oResponse = new XML_RPC_Response($aResponse);

        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, $oResponse);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->oac_banner_id = 1000;
        $bannerId = DataGenerator::generateOne($doBanners);
        $this->assertTrue($bannerId);

        foreach (array('2007-07-31', '2007-08-01', '2007-08-02') as $day) {
            for ($hour = 0; $hour < 24; $hour++) {
                $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
                $doDsah->day = $day;
                $doDsah->hour = $hour;
                $doDsah->ad_id = $bannerId;
                $doDsah->impressions = 12 - abs($hour - 12);
                $doDsah->clicks = floor($doDsah->impressions / 6);
                $doDsah->insert();
            }
        }

        $result = $oAdNetworks->getRevenue(1);
        $this->assertTrue($result);

        $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doDsah->orderBy('day, hour');
        $doDsah->find();
        $aStats = array();
        while ($doDsah->fetch()) {
            $aStats[] = array(
                'day' => $doDsah->day,
                'hour' => $doDsah->hour,
                'impressions' => $doDsah->impressions,
                'clicks' => $doDsah->clicks,
                'total_revenue' => $doDsah->total_revenue
            );
        }

        $this->assertEqual($aStats, $this->_getRevenueArray());
    }

    function _subscribeArray()
    {
        return array(
            array(
                'url'         => 'http://www.beccati.com',
                'advertisers' => array(
                    array(
                        'advertiser_id' => 1000,
                        'name'          => 'Beccati.com',
                        'campaigns'     => array(
                            array(
                                'campaign_id' => 2000,
                                'name'        => 'Campaign 1',
                                'weight'      => 1,
                                'capping'     => 0,
                                'banners'     => array(
                                    array(
                                        'banner_id' => 3000,
                                        'name' => 'Banner 1',
                                        'width' => 468,
                                        'height' => 60,
                                        'capping' => 0,
                                        'html' => '<script language=\'JavaScript\' type=\'text/javascript\' src=\'http://oa.beccati.com/adx.js\'></script>
<script language=\'JavaScript\' type=\'text/javascript\'>
<!--
   if (!document.phpAds_used) document.phpAds_used = \',\';
   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);

   document.write ("<" + "script language=\'JavaScript\' type=\'text/javascript\' src=\'");
   document.write ("http://oa.beccati.com/adjs.php?n=" + phpAds_random);
   document.write ("&amp;what=zone:1");
   document.write ("&amp;exclude=" + document.phpAds_used);
   if (document.referrer)
      document.write ("&amp;referer=" + escape(document.referrer));
   document.write ("\'><" + "/script>");
//-->
</script><noscript><a href=\'http://oa.beccati.com/adclick.php?n=a29f51cf\' target=\'_blank\'><img src=\'http://oa.beccati.com/adview.php?what=zone:1&amp;n=a29f51cf\' border=\'0\' alt=\'\'></a></noscript>
',
                                        'adserver' => ''
                                    ),
                                    array(
                                        'banner_id' => 3002,
                                        'name' => 'Banner 2',
                                        'width' => 125,
                                        'height' => 125,
                                        'capping' => 1,
                                        'html' => '<script language=\'JavaScript\' type=\'text/javascript\' src=\'http://oa.beccati.com/adx.js\'></script>
<script language=\'JavaScript\' type=\'text/javascript\'>
<!--
   if (!document.phpAds_used) document.phpAds_used = \',\';
   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);

   document.write ("<" + "script language=\'JavaScript\' type=\'text/javascript\' src=\'");
   document.write ("http://oa.beccati.com/adjs.php?n=" + phpAds_random);
   document.write ("&amp;what=zone:2");
   document.write ("&amp;exclude=" + document.phpAds_used);
   if (document.referrer)
      document.write ("&amp;referer=" + escape(document.referrer));
   document.write ("\'><" + "/script>");
//-->
</script><noscript><a href=\'http://oa.beccati.com/adclick.php?n=a29f51cf\' target=\'_blank\'><img src=\'http://oa.beccati.com/adview.php?what=zone:2&amp;n=a29f51cf\' border=\'0\' alt=\'\'></a></noscript>
',
                                        'adserver' => ''
                                    )
                                )
                            )
                        )
                    )
                )
            ),
            array(
                'url'         => 'http://www.openads.org',
                'advertisers' => array(
                    array(
                        'advertiser_id' => 1001,
                        'name'          => 'Beccati.com',
                        'campaigns'     => array(
                            array(
                                'campaign_id' => 2001,
                                'name'        => 'Campaign 1',
                                'weight'      => 1,
                                'capping'     => 0,
                                'banners'     => array(
                                    array(
                                        'banner_id' => 3001,
                                        'name' => 'Banner 1',
                                        'width' => 468,
                                        'height' => 60,
                                        'capping' => 0,
                                        'html' => '<script language=\'JavaScript\' type=\'text/javascript\' src=\'http://oa.beccati.com/adx.js\'></script>
<script language=\'JavaScript\' type=\'text/javascript\'>
<!--
   if (!document.phpAds_used) document.phpAds_used = \',\';
   phpAds_random = new String (Math.random()); phpAds_random = phpAds_random.substring(2,11);

   document.write ("<" + "script language=\'JavaScript\' type=\'text/javascript\' src=\'");
   document.write ("http://oa.beccati.com/adjs.php?n=" + phpAds_random);
   document.write ("&amp;what=zone:3");
   document.write ("&amp;exclude=" + document.phpAds_used);
   if (document.referrer)
      document.write ("&amp;referer=" + escape(document.referrer));
   document.write ("\'><" + "/script>");
//-->
</script><noscript><a href=\'http://oa.beccati.com/adclick.php?n=a29f51cf\' target=\'_blank\'><img src=\'http://oa.beccati.com/adview.php?what=zone:3&amp;n=a29f51cf\' border=\'0\' alt=\'\'></a></noscript>
',
                                        'adserver' => ''
                                    )
                                )
                            )
                        )
                    )
                )
            ),
        );
    }

    function _getRevenueArray()
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
            'total_revenue' => '3.3400',
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
            'total_revenue' => '1.7400',
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
}

?>