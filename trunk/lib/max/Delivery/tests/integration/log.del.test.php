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
        $aExpected['geotargeting'] = array();
        MAX_Delivery_log_logAdRequest($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 6);

        $query = "TRUNCATE TABLE {$table}";
        $oDbh->exec($query);
    }

    /**
     * A method to test the MAX_Delivery_log_logAdImpression() function.
     *
     */
    function test_MAX_Delivery_log_logAdImpression()
    {
        $oDbh = OA_DB::singleton();
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'],true);
        $query = "SELECT * FROM {$table}";

        $aExpected['viewerId']   = '01010101010101';
        $aExpected['adId']       = '1';
        $aExpected['creativeId'] = '1';
        $aExpected['zoneId']     = '1';

        $this->msg = 'Test 1: ';
        $this->_clearLogInfo();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdImpression($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 0);

        $this->msg = 'Test 2: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoUserAgent();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdImpression($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 1);

        $this->msg = 'Test 3: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoHttps();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdImpression($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 2);

        $this->msg = 'Test 4: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoRefererLoc();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdImpression($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 3);

        $this->msg = 'Test 5: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoChannels();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdImpression($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 4);

        $this->msg = 'Test 6: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoRefererNormal();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdImpression($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 5);

        $this->msg = 'Test 7: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoGeotargeting();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdImpression($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 6);

        $query = "TRUNCATE TABLE {$table}";
        $oDbh->exec($query);
    }

    /**
     * A method to test the MAX_Delivery_log_logAdClick() function.
     *
     */
    function test_MAX_Delivery_log_logAdClick()
    {
        $oDbh = OA_DB::singleton();
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['data_raw_ad_click'],true);
        $query = "SELECT * FROM {$table}";

        $aExpected['viewerId']   = '01010101010101';
        $aExpected['adId']       = '1';
        $aExpected['creativeId'] = '1';
        $aExpected['zoneId']     = '1';

        $this->msg = 'Test 1: ';
        $this->_clearLogInfo();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdClick($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 0);

        $this->msg = 'Test 2: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoUserAgent();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdClick($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 1);

        $this->msg = 'Test 3: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoHttps();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdClick($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 2);

        $this->msg = 'Test 4: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoRefererLoc();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdClick($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 3);

        $this->msg = 'Test 5: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoChannels();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdClick($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 4);

        $this->msg = 'Test 6: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoRefererNormal();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdClick($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 5);

        $this->msg = 'Test 7: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoGeotargeting();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logAdClick($aExpected['viewerId'], $aExpected['adId'], $aExpected['creativeId'], $aExpected['zoneId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 6);

        $query = "TRUNCATE TABLE {$table}";
        $oDbh->exec($query);
    }

    /**
     * A method to test the MAX_Delivery_log_logTrackerImpression() function.
     *
     */
    function test_MAX_Delivery_log_logTrackerImpression()
    {
        $oDbh = OA_DB::singleton();
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['data_raw_tracker_impression'],true);
        $query = "SELECT * FROM {$table}";

        $aExpected['viewerId']   = '01010101010101';
        $aExpected['trackerId']  = '1';

        $this->msg = 'Test 1: ';
        $this->_clearLogInfo();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logTrackerImpression($aExpected['viewerId'], $aExpected['trackerId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 0);

        $this->msg = 'Test 2: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoUserAgent();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logTrackerImpression($aExpected['viewerId'], $aExpected['trackerId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 1);

        $this->msg = 'Test 3: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoHttps();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logTrackerImpression($aExpected['viewerId'], $aExpected['trackerId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 2);

        $this->msg = 'Test 4: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoRefererLoc();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logTrackerImpression($aExpected['viewerId'], $aExpected['trackerId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 3);

        $this->msg = 'Test 5: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoChannels();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logTrackerImpression($aExpected['viewerId'], $aExpected['trackerId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 4);

        $this->msg = 'Test 6: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoRefererNormal();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logTrackerImpression($aExpected['viewerId'], $aExpected['trackerId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 5);

        $this->msg = 'Test 7: ';
        $this->_clearLogInfo();
        $this->_setupLogInfoGeotargeting();
        $aExpected = $this->_getExpected($aExpected);
        MAX_Delivery_log_logTrackerImpression($aExpected['viewerId'], $aExpected['trackerId']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertResults($aRows, $aExpected, 6);

        $query = "TRUNCATE TABLE {$table}";
        $oDbh->exec($query);
    }

    /**
     * A method to test the MAX_Delivery_log_logVariableValues() function.
     *
     * @todo MORE TEST CASES? different variable types and values?
     */
    function test_MAX_Delivery_log_logVariableValues()
    {
        $oDbh = OA_DB::singleton();
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $oDbh->quoteIdentifier($conf['table']['prefix'] . $conf['table']['data_raw_tracker_variable_value'],true);
        $query = "SELECT * FROM {$table}";

        $this->msg = 'Test 1: ';
        $aExpected = $this->_createVariableValueArray(array(1,2));
        $query = "SELECT * FROM {$table} WHERE tracker_variable_id IN (1,2)";
        MAX_Delivery_log_logVariableValues($aExpected['variables'], 1, 1, '127.0.0.0');
        unset($aExpected['variables']);
        $aRows = $oDbh->queryAll($query);
        $this->_assertVariableResults($aRows, $aExpected);

//        $this->msg = 'Test 2: ';
//        $aExpected = $this->_createVariableValueArray(array(3,4,5));
//        $query = "SELECT * FROM {$table} WHERE tracker_variable_id IN (3,4,5)";
//        MAX_Delivery_log_logVariableValues($aExpected['variables'], 1, 1, '127.0.0.0');
//        unset($aExpected['variables']);
//        $aRows = $oDbh->queryAll($query);
//        $this->_assertVariableResults($aRows, $aExpected);

        $query = "TRUNCATE TABLE {$table}";
        $oDbh->exec($query);
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
     * A method to compile the expected results of a test
     *
     * @param array $aExpected
     */
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

    /**
     * A method to setup some request variable for logging
     *
     * @param array $aIds
     * @return array
     */
    function _createVariableValueArray($aIds)
    {
        foreach ($aIds as $id)
        {
            $aExpected[] = array('serverRTId'      => 1,
                                 'serverRawIp'     => '127.0.0.0',
                                 'variableId'      => $id,
                                 'variableValue'   => $id,
                                 'dateTime'        => true
                                );
            $aExpected['variables'][$id] = array('variable_id'=>$id, 'name'=>'var'.$id, 'type'=>'int');
            $_GET['var'.$id]   = $id;
        }
        return $aExpected;
    }

    /**
     * A method to assert the results of variable logging test
     *
     * @param array $aActual
     * @param array $aExpected
     */
    function _assertVariableResults($aActual, $aExpected)
    {
        $count = count($aExpected);
        $this->assertIsA($aActual,'array',$this->msg.'failed to return array result');
        $this->assertEqual(count($aActual),$count, $this->msg.'failed to return correct number of records');
        for ($i=0;$i<$count;$i++)
        {
            $this->assertEqual($aExpected[$i]['variableId'] , $aActual[$i]['tracker_variable_id'],$this->msg.'incorrect tracker_variable_id');
            $this->assertEqual($aExpected[$i]['serverRTId'] , $aActual[$i]['server_raw_tracker_impression_id'],$this->msg.'incorrect server_raw_tracker_impression_id');
            $this->assertEqual($aExpected[$i]['serverRawIp'] , $aActual[$i]['server_raw_ip'],$this->msg.'incorrect server_raw_ip');
            $this->assertEqual($aExpected[$i]['variableValue'] , $aActual[$i]['value'],$this->msg.'incorrect value');
            $this->assertNotNull($aActual[$i]['date_time'],$this->msg.'invalid date_time');
        }
    }

    /**
     * A method to assert the results of a logging test
     *
     * @param array $aActual
     * @param array $aExpected
     */
    function _assertResults($aActual, $aExpected, $rowId)
    {
        $this->assertIsA($aActual,'array',$this->msg.'failed to return array result');
        $this->assertEqual($rowId+1, count($aActual), $this->msg.'incorrect number of rows returned');
        $this->_assertIds($aExpected, $aActual[$rowId]);
        $this->_assertZoneInfo($aExpected['zoneInfo'], $aActual[$rowId]);
        $this->_assertMaxHttps($aExpected['maxHttps'], $aActual[$rowId]);
        $this->_assertUserAgent($aExpected['userAgentInfo'], $aActual[$rowId]);
        $this->_assertGeotargeting($aExpected['geotargeting'], $aActual[$rowId]);
    }

    /**
     * A method to assert the results of a logging test: Ids
     *
     * @param array $aActual
     * @param array $aExpected
     */
    function _assertIds($aExpected, $aActual)
    {
        $this->assertIsA($aActual,'array',$this->msg.'failed to return array result');

        $this->assertEqual($aExpected['viewerId']  , $aActual['viewer_id'],$this->msg.'incorrect viewer_id');
        $this->assertEqual($aExpected['adId']      , $aActual['ad_id'],$this->msg.'incorrect ad_id');
        $this->assertEqual($aExpected['creativeId'], $aActual['creative_id'],$this->msg.'incorrect creative_id');
        $this->assertEqual($aExpected['zoneId']    , $aActual['zone_id'],$this->msg.'incorrect zone_id');
        $this->assertEqual($aExpected['trackerId'] , $aActual['tracker_id'],$this->msg.'incorrect tracker_id');
    }

    /**
     * A method to assert the results of a logging test: geotargeting
     *
     * @param array $aActual
     * @param array $aExpected
     */
    function _assertGeotargeting($aExpected, $aActual)
    {
        if (isset($aActual['country_code']))
        {
            $this->assertEqual($aExpected['country_code']   , $aActual['country_code'], $this->msg.'incorrect country_code');
        }
        if (isset($aActual['country_name']))
        {
            $this->assertEqual($aExpected['country_name']   , $aActual['country_name'], $this->msg.'incorrect country_name');
        }
        if (isset($aActual['isp']))
        {
            $this->assertEqual($aExpected['isp']            , $aActual['isp'], $this->msg.'incorrect isp');
        }
        $this->assertEqual($aExpected['region']         , $aActual['geo_region'], $this->msg.'incorrect region');
        $this->assertEqual($aExpected['city']           , $aActual['geo_city'], $this->msg.'incorrect city');
        $this->assertEqual($aExpected['postal_code']    , $aActual['geo_postal_code'], $this->msg.'incorrect postal_code');
        $this->assertEqual(floatval($aExpected['latitude'])       , $aActual['geo_latitude'], $this->msg.'incorrect latitude');
        $this->assertEqual(floatval($aExpected['longitude'])      , $aActual['geo_longitude'], $this->msg.'incorrect longitude');
        $this->assertEqual($aExpected['dma_code']       , $aActual['geo_dma_code'], $this->msg.'incorrect dma_code');
        $this->assertEqual($aExpected['area_code']      , $aActual['geo_area_code'], $this->msg.'incorrect area_code');
        $this->assertEqual($aExpected['organisation']   , $aActual['geo_organisation'], $this->msg.'incorrect organisation');
        $this->assertEqual($aExpected['netspeed']       , $aActual['geo_netspeed'], $this->msg.'incorrect netspeed');
    }

    /**
     * A method to assert the results of a logging test: zone info
     *
     * @param array $aActual
     * @param array $aExpected
     */
    function _assertZoneInfo($aExpected, $aActual)
    {
        $this->assertEqual($aExpected['channel_ids'], $aActual['channel_ids'],$this->msg.'incorrect channel_ids');
        $this->assertEqual($aExpected['host']       , $aActual['host_name'],$this->msg.'incorrect host');
        $this->assertEqual($aExpected['path']       , $aActual['page'],$this->msg.'incorrect path');
        $this->assertEqual($aExpected['query']      , $aActual['query'],$this->msg.'incorrect query');
        if (!is_null($aExpected['scheme']))
        {
            $this->assertEqual($aExpected['scheme'] , $aActual['https'],$this->msg.'incorrect scheme');
        }
        else
        {
            $this->assertFalse($aActual['https']    ,$this->msg.'incorrect scheme');  // https value could be null or 0
        }
    }

    /**
     * A method to assert the results of a logging test: user agent
     *
     * @param array $aActual
     * @param array $aExpected
     */
    function _assertUserAgent($aExpected, $aActual)
    {
        $this->assertEqual($aExpected['os']     , $aActual['os'],$this->msg.'incorrect os');
        $this->assertEqual($aExpected['browser'], $aActual['browser'],$this->msg.'incorrect browser');
    }

    /**
     * A method to assert the results of a logging test: secure http
     *
     * @param array $aActual
     * @param array $aExpected
     */
    function _assertMaxHttps($aExpected, $aActual)
    {
        $this->assertEqual($aExpected, $aActual['max_https'],$this->msg.'incorrect max_https');
    }
}

?>
