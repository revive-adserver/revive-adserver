<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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
$Id $
*/

require_once MAX_PATH . '/lib/max/Delivery/log.php';
require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';

/**
 * A class for testing the log.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@opends.org>
 */
class Delivery_TestOfLogDB extends UnitTestCase
{
    var $msg;

    /**
     * The constructor method.
     */
    function Delivery_TestOfLogDB()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the MAX_Delivery_log_logAdRequest() function.
     *
     */
    function test_MAX_Delivery_log_logAdRequest()
    {
        $oDbh = OA_DB::singleton();
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['data_raw_ad_request'],true);
        $query = "SELECT * FROM {$table}";

        $aExpected['viewerId']   = '01010101010101';
        $aExpected['adId']       = '1';
        $aExpected['creativeId'] = '1';
        $aExpected['zoneId']     = '1';

        $this->msg = 'Test 1: ';
        $this->_clearLogInfo();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdRequest($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 0);

        $this->msg = 'Test 2: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoUserAgent();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdRequest($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 1);

        $this->msg = 'Test 3: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoHttps();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdRequest($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 2);

        $this->msg = 'Test 4: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoRefererLoc();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdRequest($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 3);

        $this->msg = 'Test 5: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoChannels();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdRequest($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 4);

        $this->msg = 'Test 6: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoRefererNormal();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdRequest($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 5);

        $this->msg = 'Test 7: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoGeotargeting();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdRequest($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 6);
    }

    /**
     * A method to test the MAX_Delivery_log_logAdImpression() function.
     *
     * @TODO Not implemented.
     */
    function test_MAX_Delivery_log_logAdImpression()
    {

    }

    /**
     * A method to test the MAX_Delivery_log_logAdClick() function.
     *
     * @TODO Not implemented.
     */
    function test_MAX_Delivery_log_logAdClick()
    {

    }

    /**
     * A method to test the MAX_Delivery_log_logTrackerImpression() function.
     *
     * @TODO Not implemented.
     */
    function test_MAX_Delivery_log_logTrackerImpression()
    {

    }

    /**
     * A method to test the MAX_Delivery_log_logVariableValues() function.
     *
     * @TODO Not implemented.
     */
    function test_MAX_Delivery_log_logVariableValues()
    {

    }

    /**
     * A method to fake some logging info
     */
    function _clearLogInfo()
    {
        // Disable reverse lookups
        $GLOBALS['_MAX']['CONF']['logging']['reverseLookup'] = false;
        // Disable geotargeting
        $GLOBALS['_MAX']['CONF']['geotargeting']['type'] = false;
        // Disable sniffing
        $GLOBALS['_MAX']['CONF']['logging']['sniff'] = false;
        // Unset the $GLOBALS['_MAX']['CHANNELS'] array
        $GLOBALS['_MAX']['CHANNELS'] = '';
        // Set the remote IP address
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        // Unset the remote host name
        $_SERVER['REMOTE_HOST'] = '127.0.0.1';
        // Unset the user agent
        $_SERVER['HTTP_USER_AGENT'] = '';
        // Set a non-SSL port
        $_SERVER['SERVER_PORT'] = 80;

        $GLOBALS['_MAX']['CONF']['geotargeting']['saveStats'] = 'false';
        // Set null geotargeting info
        $GLOBALS['_MAX']['CLIENT_GEO']['country_code']  = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['country_name']  = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['region']        = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['city']          = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['postal_code']   = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['latitude']      = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['longitude']     = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['dma_code']      = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['area_code']     = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['organisation']  = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['isp']           = '';
        $GLOBALS['_MAX']['CLIENT_GEO']['netspeed']      = '';

        // Set a passed in referer location
        $_GET['loc'] = '';
        $_GET['source']='';
        $_GET['referer']='';

        // Clear array of channel ids
        $GLOBALS['_MAX']['CHANNELS'] = '';

        // Clear normal referer
        $_SERVER['HTTP_REFERER'] = '';

        // Disable sniffing
        $GLOBALS['_MAX']['CONF']['logging']['sniff'] = false;
        // Set the client parameters...
        $GLOBALS['_MAX']['CLIENT']['os']        = '';
        $GLOBALS['_MAX']['CLIENT']['long_name'] = '';
        $GLOBALS['_MAX']['CLIENT']['browser']   = '';
    }

    /**
     * A method to fake some logging info
     */
    function _setupLogInfoGeotargeting()
    {
        // Enable geotargeting
        $GLOBALS['_MAX']['CONF']['geotargeting']['saveStats'] = 'true';
        // Set some fake geotargeting info
        $GLOBALS['_MAX']['CLIENT_GEO']['country_code'] = 'US';
        $GLOBALS['_MAX']['CLIENT_GEO']['country_name'] = 'United States';
        $GLOBALS['_MAX']['CLIENT_GEO']['region'] = 'VA';
        $GLOBALS['_MAX']['CLIENT_GEO']['city'] = 'Herndon';
        $GLOBALS['_MAX']['CLIENT_GEO']['postal_code'] = '20171';
        $GLOBALS['_MAX']['CLIENT_GEO']['latitude'] = '38.9252';
        $GLOBALS['_MAX']['CLIENT_GEO']['longitude'] = '-77.3928';
        $GLOBALS['_MAX']['CLIENT_GEO']['dma_code'] = '42';
        $GLOBALS['_MAX']['CLIENT_GEO']['area_code'] = '00';
        $GLOBALS['_MAX']['CLIENT_GEO']['organisation'] = 'Foo';
        $GLOBALS['_MAX']['CLIENT_GEO']['isp'] = 'Bar';
        $GLOBALS['_MAX']['CLIENT_GEO']['netspeed'] = 'Unknown';
    }

    /**
     * A method to fake some referer location logging info
     */
    function _setupLogInfoRefererLoc()
    {
        // Set a passed in referer location
        $_GET['loc'] = 'http://www.example.com/test.html';
    }

    /**
     * A method to fake some channel logging info
     */
    function _setupLogInfoChannels()
    {
        // Set an array of channel ids
        $GLOBALS['_MAX']['CHANNELS'] = '|1|2|3|';
    }

    /**
     * A method to fake some referer logging info
     */
    function _setupLogInfoRefererNormal()
    {
        // Set a normal referer
        $_SERVER['HTTP_REFERER'] = 'https://example.com/test.php?foo=bar';
    }

    /**
     * A method to fake some user agent logging info
     */
    function _setupLogInfoUserAgent()
    {
        // Enable sniffing
        $GLOBALS['_MAX']['CONF']['logging']['sniff'] = true;
        // Set the client parameters...
        $GLOBALS['_MAX']['CLIENT']['os'] = '2k';
        $GLOBALS['_MAX']['CLIENT']['long_name'] = 'msie';
        $GLOBALS['_MAX']['CLIENT']['browser'] = 'ie';
    }

    /**
     * A method to fake some http scheme logging info
     */
    function _setupLogInfoHttps()
    {
        // Set the request to be "HTTPS"
        $_SERVER['SERVER_PORT'] = $GLOBALS['_MAX']['CONF']['openads']['sslPort'];
    }

    function _assertResults($aActual, $aExpected, $rowId)
    {
        $this->assertIsA($aActual,'array',$this->msg.'failed to return array result');
        $this->assertEqual($rowId+1, count($aActual), $this->msg.'incorrect number of rows returned');
        $this->_assertIds($aExpected, $aActual[$rowId]);
        $this->_assertZoneInfo($aExpected['zoneInfo'], $aActual[$rowId]);
        $this->_assertMaxHttps($aExpected['maxHttps'], $aActual[$rowId]);
        $this->_assertUserAgent($aExpected['userAgentInfo'], $aActual[$rowId]);
    }

    function _assertIds($aExpected, $aActual)
    {
        $this->assertIsA($aActual,'array',$this->msg.'failed to return array result');

        $this->assertEqual($aExpected['viewerId']  , $aActual['viewer_id'],$this->msg.'incorrect viewer_id');
        $this->assertEqual($aExpected['adId']      , $aActual['ad_id'],$this->msg.'incorrect ad_id');
        $this->assertEqual($aExpected['creativeId'], $aActual['creative_id'],$this->msg.'incorrect creative_id');
        $this->assertEqual($aExpected['zoneId']    , $aActual['zone_id'],$this->msg.'incorrect zone_id');
    }

    function _assertGeotargeting($aExpected, $aActual)
    {
        $this->assertEqual($aExpected['country_code']   , $aActual['country_code'], $this->msg.'incorrect country_code');
        $this->assertEqual($aExpected['country_name']   , $aActual['country_name'], $this->msg.'incorrect country_name');
        $this->assertEqual($aExpected['region']         , $aActual['region'], $this->msg.'incorrect region');
        $this->assertEqual($aExpected['city']           , $aActual['city'], $this->msg.'incorrect city');
        $this->assertEqual($aExpected['postal_code']    , $aActual['postal_code'], $this->msg.'incorrect postal_code');
        $this->assertEqual($aExpected['latitude']       , $aActual['latitude'], $this->msg.'incorrect latitude');
        $this->assertEqual($aExpected['longitude']      , $aActual['longitude'], $this->msg.'incorrect longitude');
        $this->assertEqual($aExpected['dma_code']       , $aActual['dma_code'], $this->msg.'incorrect dma_code');
        $this->assertEqual($aExpected['area_code']      , $aActual['area_code'], $this->msg.'incorrect area_code');
        $this->assertEqual($aExpected['organisation']   , $aActual['organisation'], $this->msg.'incorrect organisation');
        $this->assertEqual($aExpected['isp']            , $aActual['isp'], $this->msg.'incorrect isp');
        $this->assertEqual($aExpected['netspeed']       , $aActual['netspeed'], $this->msg.'incorrect netspeed');
    }

    function _assertZoneInfo($aExpected, $aActual)
    {
        $this->assertEqual($aExpected['channel_ids'], $aActual['channel_ids'],$this->msg.'incorrect channel_ids');
        $this->assertEqual($aExpected['host']       , $aActual['host_name'],$this->msg.'incorrect host');
        $this->assertEqual($aExpected['path']       , $aActual['page'],$this->msg.'incorrect path');
        $this->assertEqual($aExpected['query']      , $aActual['query'],$this->msg.'incorrect query');
        $this->assertEqual($aExpected['scheme']     , $aActual['https'],$this->msg.'incorrect scheme');
    }

    function _assertUserAgent($aExpected, $aActual)
    {
        $this->assertEqual($aExpected['os']     , $aActual['os'],$this->msg.'incorrect os');
        $this->assertEqual($aExpected['browser'], $aActual['browser'],$this->msg.'incorrect browser');
    }

    function _assertMaxHttps($aExpected, $aActual)
    {
        $this->assertEqual($aExpected, $aActual['max_https'],$this->msg.'incorrect max_https');
    }

    function _getExpected($aExpected)
    {
        list($geotargeting, $zoneInfo, $userAgentInfo, $maxHttps) = _prepareLogInfo();
        $zoneInfo['host'] = $_SERVER['REMOTE_HOST'];
        $aExpected['geotargeting']  = $geotargeting;
        $aExpected['zoneInfo']      = $zoneInfo;
        $aExpected['userAgentInfo'] = $userAgentInfo;
        $aExpected['maxHttps']      = $maxHttps;
        return $aExpected;
    }
}

?>
