<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
require_once dirname(__FILE__) . '/../../oxMarketDelivery.delivery.php';
require_once MAX_PATH . '/lib/max/Delivery/adRender.php';

/**
 * A class for testing the oxMarketDelivery functions
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_deliveryAdRender_oxMarketDelivery_oxMarketDeliveryTest extends UnitTestCase
{
    function testOX_marketProcess()
    {
        $serverHttps = (isset($_SERVER['HTTPS'])) ? $_SERVER['HTTPS'] : null;
        
        // Prepare test data
        $adHtml = 'test banner';
        $aAd = array( 'width' => 468, 'height' => 60 );
        $aCampaignMarketInfo = array();
        $website_id = 12;
        $aWebsiteMarketInfo = array('website_id' => $website_id);
        $GLOBALS['_MAX']['CONF']['oxMarketDelivery']['brokerHost'] = 'brokerHost.org';

        // patter to check OX_marketProcess result and get t, f parameters and src for second script
        $pattern = '<script type="text/javascript">[[:space:]]OXM_(.*) = {"t":"(.*)","f":"(.*)"}[[:space:]]</script>[[:space:]]'.
                   '<script type="text/javascript" src="(.*)"></script>';
        
        // set https to on
        $_SERVER['HTTPS'] = 'on';
        
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);
        // check if response matches to pattern
        $this->assertTrue(ereg($pattern, $result, $aResult));
        // check ereg result
        $this->assertEqual(5,count($aResult));
        $this->assertFalse(empty($aResult[1]));
        $this->assertFalse(empty($aResult[2]));
        $this->assertEqual($adHtml, $aResult[3]);
        // Check market url
        $aUrl = parse_url($aResult[4]);
        $this->assertEqual('https', $aUrl['scheme']);
        $this->assertEqual('brokerHost.org', $aUrl['host']);
        $this->assertEqual('/json', $aUrl['path']);
        $aQuery = explode('&', html_entity_decode(($aUrl['query'])));
        $aUrlParams = array();
        foreach ($aQuery as $param) {
            $b = split('=', $param);
            $aUrlParams[$b[0]] = $b[1];
        }
        $this->assertEqual($aUrlParams['o'], 'OXM_'.$aResult[1]);
        $this->assertEqual($aUrlParams['pid'], $website_id);
        $this->assertEqual($aUrlParams['tag_type'], 1);
        $this->assertEqual($aUrlParams['f'], 0);
        $this->assertEqual($aUrlParams['s'], "468x60");
        $this->assertEqual($aUrlParams['s'], "468x60");
        $this->assertFalse(empty($aUrlParams['cb']));

        // set https to off
        $_SERVER['HTTPS'] = 'off';
        
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);
        
        // check if response matches to pattern
        $this->assertTrue(ereg($pattern, $result, $aResult));
        // check ereg result
        $this->assertEqual(5,count($aResult));
        $aUrl = parse_url($aResult[4]);
        $this->assertEqual('http', $aUrl['scheme']);
        $this->assertEqual('brokerHost.org', $aUrl['host']);
        $this->assertEqual('/json', $aUrl['path']);
        
        // unset https
        unset($_SERVER['HTTPS']);
        
        $result = OX_marketProcess($adHtml, $aAd, $aCampaignMarketInfo, $aWebsiteMarketInfo);
        
        // check if response matches to pattern
        $this->assertTrue(ereg($pattern, $result, $aResult));
        // check ereg result
        $this->assertEqual(5,count($aResult));
        $aUrl = parse_url($aResult[4]);
        $this->assertEqual('http', $aUrl['scheme']);
        $this->assertEqual('brokerHost.org', $aUrl['host']);
        $this->assertEqual('/json', $aUrl['path']);
        
        // restore setting
        $_SERVER['HTTPS'] = $serverHttps;
    }
    
}

