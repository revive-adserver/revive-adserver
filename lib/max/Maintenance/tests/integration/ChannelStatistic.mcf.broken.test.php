<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/Channel/ChannelStatistic.php';

require_once 'Date.php';
require_once 'Date/Span.php';

/**
 * A class for performing an integration test of the Prioritisation Engine
 * via a test of the AdServer class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfChannelStatistic extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfChannelStatistic()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        $this->errorLevel = error_reporting(E_ALL);
    }

    function tearDown()
    {
        error_reporting($this->errorLevel);
    }

    /**
     * A method to perform basic end-to-end integration testing of the ChannelStatistic class.
     */
    function testChannelStatisticBasic()
    {
        require_once MAX_PATH . '/lib/max/Dal/tests/unit/DalForecasting.dal.test.php';

        $GLOBALS['_MAX']['CONF']['table']['split'] = true;

        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = MAX_DB::singleton();

        $oServiceLocator = &ServiceLocator::instance();
        $oOperationInterval = &new OperationInterval();

        // Prepare data
        //Dal_TestOfDalForecasting::generateStatsOne();
        //Dal_TestOfDalForecasting::generateStatsTwo();
        $this->generateStats();

        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('now', new Date('2005-08-02 12:28:24'));

        // Run maintenance - should run twice
        $chStat = new MAX_Maintenance_Forecasting_Channel_ChannelStatistic();
        $ret = $chStat->run();
        $this->assertEqual($ret, 2);

        $ret = $dbh->getAll("SELECT * FROM {$conf['table']['prefix']}{$conf['table']['data_summary_channel_hourly']}");
        $this->assertTrue(is_array($ret));

        $ret = $dbh->getAll("SELECT * FROM {$conf['table']['prefix']}{$conf['table']['log_maintenance_forecasting']}");
        $this->assertTrue(is_array($ret));

        // Check summarized data
        $ret = $chStat->run();
        $this->assertEqual($ret, 0);
    }

    /**
     * A method to perform basic end-to-end integration testing of the ChannelStatistic class.
     */
    function testChannelStatisticForChannelOne()
    {
        $this->runTestChannelStatisticForChannel('_statsForChannelOne', '2005-08-02 10:59:59', 2);
    }

    function testChannelStatisticForChannelTwo()
    {
        $this->runTestChannelStatisticForChannel('_statsForChannelTwo', '2005-08-02 10:59:59', 1);
    }

    function testChannelStatisticForChannelThree()
    {
        $this->runTestChannelStatisticForChannel('_statsForChannelThree', '2005-08-02 10:59:59', 2, 1);
    }

    /**
     * Run above tests for different data: different impressions and channel limitations
     */
    function runTestChannelStatisticForChannel($statsMethodName, $date, $expectedImpressions, $expectedClicks = null)
    {
        TestEnv::restoreEnv();

        $GLOBALS['_MAX']['CONF']['table']['split'] = true;

        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = MAX_DB::singleton();

        $oServiceLocator = &ServiceLocator::instance();
        $oOperationInterval = &new OperationInterval();

        // Prepare data
        $this->generateStats($date);

        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('now', new Date('2005-08-02 12:28:24'));

        $this->_statsZone();
        $this->$statsMethodName();

        // Run maintenance
        $chStat = new MAX_Maintenance_Forecasting_Channel_ChannelStatistic();
        $ret = $chStat->run();
        // should run once
        $this->assertEqual($ret, 1);

        $ret = $dbh->getAll("SELECT * FROM {$conf['table']['prefix']}{$conf['table']['data_summary_channel_hourly']}");
        $this->assertTrue(is_array($ret));
        $this->assertEqual($ret[0]['impressions'], $expectedImpressions);

        if($expectedClicks !== null) {
            $this->assertEqual($ret[0]['clicks'], $expectedClicks);
        }
    }

    /**
     * A method to generate data for testing - insert data into raw table
     *
     * @access public
     */
    function generateStats($logMaintenanceDate = '2005-08-02 09:59:59')
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();

        $GLOBALS['_MAX']['CONF']['table']['split'] = true;

        $dataDate = new Date('2005-08-02 09:28:24');

        $tables = &Openads_Table_Core::singleton();
        $tables->createTable('data_raw_ad_impression', $dataDate);
        $tables->createTable('data_raw_ad_click', $dataDate);
        $tables->createTable('data_raw_ad_request', $dataDate);

        //  populate campaigns table
        $rawAdImpressionTable = $conf['table']['prefix'] . 'data_raw_ad_impression';
        if ($GLOBALS['_MAX']['CONF']['table']['split']) {
            $rawAdImpressionTable .= '_' . $dataDate->format('%Y%m%d');
        }

        //  populate campaigns table
        $rawAdRequestTable = $conf['table']['prefix'] . 'data_raw_ad_request';
        if ($GLOBALS['_MAX']['CONF']['table']['split']) {
            $rawAdRequestTable .= '_' . $dataDate->format('%Y%m%d');
        }

        // Add log maintenance
        $logTable = $conf['table']['prefix'] . 'log_maintenance_forecasting';
        $sql = "INSERT INTO $logTable
            ( log_maintenance_forecasting_id , start_run , end_run , operation_interval , duration , updated_to )
            VALUES (
            '1', '2005-08-02 08:55:00', '2005-08-02 08:57:00', '60', '120', '$logMaintenanceDate'
            );";
        $dbh->query($sql);
    }

    function _statsZone()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();

        //  populate campaigns table
        $campaignsTable = $conf['table']['prefix'] . 'campaigns';
        $sql = "INSERT INTO $campaignsTable
        (campaignid, campaignname,      clientid,   views,  clicks, conversions,    expire,             activate,       active,     priority,   weight, target_impression, anonymous)
        VALUES (4,   'test  campaign',  1,          500,      0,      401,          '0000-00-00',  '0000-00-00',   't',                '4',        2,      0,        'f')";
        $result = $dbh->query($sql);

        //  add a banner
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype)
            VALUES (1, 1, 't', 'txt', 0, 'txt', '', '', '', '', 0, 0, 1, 0, '', 'http://exapmle.com', '', 'asdf', 'tyerterty', '', 'f', '', 0, 0, 0, 'phpAds_aclCheckDate(\'20050502\', \'!=\') and phpAds_aclCheckClientIP(\'2.22.22.2\', \'!=\') and phpAds_aclCheckLanguage(\'(sq)|(eu)|(fo)|(fi)\', \'!=\')', '', 0, 0, '', '', '')";
        $result = $dbh->query($sql);

        //  add an agency record
        $agencyTable = $conf['table']['prefix'] . 'agency';
        $sql = "INSERT INTO $agencyTable (agencyid, name, contact, email, username, password, permissions, language, logout_url, active)
            VALUES (1, 'test agency', 'sdfsdfsdf', 'example@example.com', 'Agency name', 'passwd', 0, 'en_GB', 'logout.php', 1)";
        $result = $dbh->query($sql);

        //  add a client record (advertiser)
        $clientsTable = $conf['table']['prefix'] . 'clients';
        $sql = "INSERT INTO $clientsTable (clientid, agencyid, clientname, contact, email, clientusername, clientpassword, permissions, language, report, reportinterval, reportlastdate, reportdeactivate)
            VALUES (1, 1, 'test client', 'yes', 'example@example.com', 'Agency name', '', 59, '', 't', 7, '2005-03-21', 't')";
        $result = $dbh->query($sql);

        //  add an affiliate (publisher) record
        $publisherTable = $conf['table']['prefix'] . 'affiliates';
        $sql = "INSERT INTO $publisherTable (affiliateid, agencyid, name, mnemonic, contact, email, website, username, password, permissions, language, publiczones)
            VALUES (1, 1, 'test publisher', 'ABC', 'foo bar', 'foo@example.com', 'www.example.com', 'foo', 'bar', NULL, NULL, 'f')";
        $result = $dbh->query($sql);

        //  add zone records
        $zonesTable = $conf['table']['prefix'] . 'zones';
        $sql = "INSERT INTO $zonesTable (zoneid, affiliateid, zonename, description, delivery, zonetype, category, width, height, ad_selection, chain, prepend, append, appendtype, forceappend, inventory_forecast_type)
            VALUES (1, 1, 'Zone name - Default', '', 0, 3, '', 728, 90, '', '', '', '', 0, 'f', 0)";
        $result = $dbh->query($sql);

        //  add channels records
        $channelsTable = $conf['table']['prefix'] . 'channel';
        $sql = "
            INSERT INTO
                $channelsTable
                (
                    channelid,
                    agencyid,
                    affiliateid,
                    name,
                    description
                )
            VALUES
                ('1', '1', '1', 'Channel name', '')";
        $result = $dbh->query($sql);

        //  add ad_zone_assoc record
        $zonesAssocTable = $conf['table']['prefix'] . 'ad_zone_assoc';
        $sql = "INSERT INTO $zonesAssocTable VALUES (1, 1, 1, '0', 1)";
        $result = $dbh->query($sql);
    }

    /**
     * Add impressions and channel limitations for weekday = tuesday
     * Both two impressions should be included in statistics
     *
     */
    function _statsForChannelOne()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();

        $dataDate = new Date('2005-08-02 09:28:24');

        //  populate campaigns table
        $rawAdImpressionTable = $conf['table']['prefix'] . 'data_raw_ad_impression';
        if ($GLOBALS['_MAX']['CONF']['table']['split']) {
            $rawAdImpressionTable .= '_' . $dataDate->format('%Y%m%d');
        }

        // Add channels limitations
        $aclsChannelsTable = $conf['table']['prefix'] . 'acls_channel';
        $sql = "INSERT INTO $aclsChannelsTable (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'weekday', '==', '1,2,3', 0)";
        $dbh->query($sql);
        // Add channels limitations
        $aclsChannelsTable = $conf['table']['prefix'] . 'acls_channel';
        $sql = "INSERT INTO $aclsChannelsTable (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'source', '==', '(other)/localhost/*', 1)";
        $dbh->query($sql);

        // Add impressions
        $sql = "INSERT INTO $rawAdImpressionTable
            (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id, channel, language, ip_address, host_name, country, https, domain, page, query, referer, search_term, user_agent, os, browser, max_https)
            VALUES ('357826bf941721cb697a032a3d31a969', '', '2005-08-02 11:28:24', 2, 0,     1, '(other)/localhost/1/2/3', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', 'uk', 0, 'localhost', '/channelforecasting/zone.html', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.10) Gecko/20050720 Fedora/1.0.6-1.1.fc3 Firefox/1.0.6', '', '', 0);
         ";
        $dbh->query($sql);

        $sql = "INSERT INTO $rawAdImpressionTable
            (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id, channel, language, ip_address, host_name, country, https, domain, page, query, referer, search_term, user_agent, os, browser, max_https)
            VALUES ('357826bf941721cb697a032a3d31a969', '', '2005-08-02 11:28:25', 2, 0,     1, '(other)/localhost/1/2/3', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', 'uk', 0, 'localhost', '/channelforecasting/zone.html', '', '', '', 'Opera/8.0 (X11; Linux i686; U; en)', '', '', 0);
         ";
        $dbh->query($sql);

        $sql = "INSERT INTO $rawAdImpressionTable
            (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id, channel, language, ip_address, host_name, country, https, domain, page, query, referer, search_term, user_agent, os, browser, max_https)
            VALUES ('357826bf941721cb697a032a3d31a969', '', '2005-08-02 11:28:25', 2, 0,     1, '(other)/localhost2/1/2/3', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', 'uk', 0, 'localhost', '/channelforecasting/zone.html', '', '', '', 'Opera/8.0 (X11; Linux i686; U; en)', '', '', 0);
         ";
        $dbh->query($sql);
    }

    /**
     * Add impressions and channel limitations for weekday = tuesday (only sql limitation will be used)
     */
    function _statsForChannelTwo()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();

        $dataDate = new Date('2005-08-02 09:28:24');

        //  populate campaigns table
        $rawAdImpressionTable = $conf['table']['prefix'] . 'data_raw_ad_impression';
        if ($GLOBALS['_MAX']['CONF']['table']['split']) {
            $rawAdImpressionTable .= '_' . $dataDate->format('%Y%m%d');
        }

        // Add channels limitations
        $aclsChannelsTable = $conf['table']['prefix'] . 'acls_channel';
        $sql = "INSERT INTO $aclsChannelsTable (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'country_code', '==', 'uk', 0)";
        $dbh->query($sql);

        // Add impressions
        $sql = "INSERT INTO $rawAdImpressionTable
            (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id, channel, language, ip_address, host_name, country, https, domain, page, query, referer, search_term, user_agent, os, browser, max_https)
            VALUES ('357826bf941721cb697a032a3d31a969', '', '2005-08-02 11:28:24', 2, 0,     1, '(other)/localhost/1/2/3', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', 'uk', 0, 'localhost', '/channelforecasting/zone.html', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.10) Gecko/20050720 Fedora/1.0.6-1.1.fc3 Firefox/1.0.6', '', '', 0);
         ";
        $dbh->query($sql);

        $sql = "INSERT INTO $rawAdImpressionTable
            (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id, channel, language, ip_address, host_name, country, https, domain, page, query, referer, search_term, user_agent, os, browser, max_https)
            VALUES ('357826bf941721cb697a032a3d31a969', '', '2005-08-02 11:28:25', 2, 0,     1, '(other)/localhost/1/2/3', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', 'pl', 0, 'localhost', '/channelforecasting/zone.html', '', '', '', 'Opera/8.0 (X11; Linux i686; U; en)', '', '', 0);
         ";
        $dbh->query($sql);

        $sql = "INSERT INTO $rawAdImpressionTable
            (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id, channel, language, ip_address, host_name, country, https, domain, page, query, referer, search_term, user_agent, os, browser, max_https)
            VALUES ('357826bf941721cb697a032a3d31a969', '', '2005-08-02 11:28:25', 2, 0,     1, '(other)/localhost2/1/2/3', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', 'pl', 0, 'localhost', '/channelforecasting/zone.html', '', '', '', 'Opera/8.0 (X11; Linux i686; U; en)', '', '', 0);
         ";
        $dbh->query($sql);
    }

    /**
     * Add impressions and channel limitations for browser (sql and php limitations will be used)
     */
    function _statsForChannelThree()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();

        $dataDate = new Date('2005-08-02 09:28:24');

        $rawAdImpressionTable = $conf['table']['prefix'] . 'data_raw_ad_impression';
        if ($GLOBALS['_MAX']['CONF']['table']['split']) {
            $rawAdImpressionTable .= '_' . $dataDate->format('%Y%m%d');
        }
        $rawAdClicksTable = $conf['table']['prefix'] . 'data_raw_ad_click';
        if ($GLOBALS['_MAX']['CONF']['table']['split']) {
            $rawAdClicksTable .= '_' . $dataDate->format('%Y%m%d');
        }

        // Add channels limitations
        $aclsChannelsTable = $conf['table']['prefix'] . 'acls_channel';
        $sql = "INSERT INTO $aclsChannelsTable (channelid, logical, type, comparison, data, executionorder) VALUES (1, 'and', 'browser', '!=', 'Mozilla', 0)";
        $dbh->query($sql);

        // Add impressions
        $sql = "INSERT INTO $rawAdImpressionTable
            (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id, channel, language, ip_address, host_name, country, https, domain, page, query, referer, search_term, user_agent, os, browser, max_https)
            VALUES ('357826bf941721cb697a032a3d31a969', '', '2005-08-02 11:28:24', 2, 0,     1, '(other)/localhost/1/2/3', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', 'uk', 0, 'localhost', '/channelforecasting/zone.html', '', '', '', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.10) Gecko/20050720 Fedora/1.0.6-1.1.fc3 Firefox/1.0.6', '', '', 0);
         ";
        $dbh->query($sql);

        $sql = "INSERT INTO $rawAdImpressionTable
            (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id, channel, language, ip_address, host_name, country, https, domain, page, query, referer, search_term, user_agent, os, browser, max_https)
            VALUES ('357826bf941721cb697a032a3d31a969', '', '2005-08-02 11:28:25', 2, 0,     1, '(other)/localhost/1/2/3', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', 'pl', 0, 'localhost', '/channelforecasting/zone.html', '', '', '', 'Opera/8.0 (X11; Linux i686; U; en)', '', '', 0);
         ";
        $dbh->query($sql);

        $sql = "INSERT INTO $rawAdImpressionTable
            (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id, channel, language, ip_address, host_name, country, https, domain, page, query, referer, search_term, user_agent, os, browser, max_https)
            VALUES ('357826bf941721cb697a032a3d31a969', '', '2005-08-02 11:28:25', 2, 0,     1, '(other)/localhost2/1/2/3', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', 'pl', 0, 'localhost', '/channelforecasting/zone.html', '', '', '', 'Opera/8.0 (X11; Linux i686; U; en)', '', '', 0);
         ";
        $dbh->query($sql);

        $sql = "INSERT INTO $rawAdClicksTable
            (viewer_id, viewer_session_id, date_time, ad_id, creative_id, zone_id, channel, language, ip_address, host_name, country, https, domain, page, query, referer, search_term, user_agent, os, browser, max_https)
            VALUES ('357826bf941721cb697a032a3d31a969', '', '2005-08-02 11:28:25', 2, 0,     1, '(other)/localhost2/1/2/3', 'en-us,en;q=0.5', '127.0.0.1', '127.0.0.1', 'pl', 0, 'localhost', '/channelforecasting/zone.html', '', '', '', 'Opera/8.0 (X11; Linux i686; U; en)', '', '', 0);
         ";
        $dbh->query($sql);
    }
}

?>
