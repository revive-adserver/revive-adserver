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

        $aResponse = array(
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

        $oResponse = new XML_RPC_Response(XML_RPC_encode($aResponse));

        $oAdNetworks = $this->_newInstance();
        $this->_mockSendReference($oAdNetworks, $oResponse);

        $result = $oAdNetworks->subscribeWebsites($aWebsites);
        $this->assertTrue($result);

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
    }
}

?>