<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/AdServer.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once 'Date.php';

/**
 * A class for performing integration testing the MAX_Maintenance_Statistics_AdServer class.
 *
 * Currently plugins such as arrivals are not tested at all. This test will fail if arrivals
 * are installed as stats will need arrival tables along with changes to core tables. It is
 * possible to create the arrivals tables but it is not possible to update the core tables yet.
 * The solution at the moment is to remove the plugins/maintenance/arrivals folder and ignore
 * the testing of arrivals.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @TODO Update to use a mocked DAL, instead of a real database?
 */
class Maintenance_TestOfMaintenanceStatisticsAdServer extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMaintenanceStatisticsAdServer()
    {
        $this->UnitTestCase();
    }

    /**
     * The main test method.
     */
    function testClass()
    {
        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = 'max_';
        $oDbh = &OA_DB::singleton();
        $oTable = &OA_DB_Table_Core::singleton();
        // Create the required tables
        $oTable->createTable('banners');
        $oTable->createTable('campaigns');
        $oTable->createTable('campaigns_trackers');
        $oTable->createTable('clients');
        $oTable->createTable('data_intermediate_ad');
        $oTable->createTable('data_intermediate_ad_connection');
        $oTable->createTable('data_intermediate_ad_variable_value');
        $oTable->createTable('data_raw_ad_click');
        $oTable->createTable('data_raw_ad_impression');
        $oTable->createTable('data_raw_ad_request');
        $oTable->createTable('data_raw_tracker_impression');
        $oTable->createTable('data_raw_tracker_variable_value');
        $oTable->createTable('data_summary_ad_hourly');
        $oTable->createTable('data_summary_zone_impression_history');
        $oTable->createTable('log_maintenance_statistics');
        $oTable->createTable('trackers');
        $oTable->createTable('userlog');
        $oTable->createTable('variables');
        $oTable->createTable('zones');
        $oTable->createTable('channel');
        $oTable->createTable('acls');
        $oTable->createTable('acls_channel');

        // Insert the test data
        $query = "
            INSERT INTO
                max_banners
                (
                    bannerid,
                    campaignid,
                    active,
                    contenttype,
                    pluginversion,
                    storagetype,
                    filename,
                    imageurl,
                    htmltemplate,
                    htmlcache,
                    width,
                    height,
                    weight,
                    seq,
                    target,
                    url,
                    alt,
                    status,
                    bannertext,
                    description,
                    autohtml,
                    adserver,
                    block,
                    capping,
                    session_capping,
                    compiledlimitation,
                    append,
                    appendtype,
                    bannertype,
                    alt_filename,
                    alt_imageurl,
                    alt_contenttype
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'text',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'integer',
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,1,'t','',0,'html','','','<h3>Test Banner 1</h3>','<h3>Test Banner 1</h3>',0,0,1,0,'',
            'http://example.com/','','','','Banner 1','t','',0,0,0,'','',0,0,'','',''
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,2,'t','',0,'html','','','<h3>Test Banner 2</h3>','<h3>Test Banner 2</h3>',0,0,1,0,'',
            'http://example.com/','','','','Banner 2','t','',0,0,0,'','',0,0,'','',''
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,3,'t','',0,'html','','','<h3>Test Banner 3</h3>','<h3>Test Banner 3</h3>',0,0,1,0,'',
            'http://example.com/','','','','Banner 3','t','',0,0,0,'','',0,0,'','',''
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,4,'t','',0,'html','','','<h3>Test Banner 4</h3>','<h3>Test Banner 4</h3>',0,0,1,0,'',
            'http://example.com/','','','','Banner 4','t','',0,0,0,'','',0,0,'','',''
        );
        $rows = $st->execute($aData);
        $aData = array(
            5,5,'t','',0,'html','','','<h3>Test Banner 5</h3>','<h3>Test Banner 5</h3>',0,0,1,0,'',
            'http://example.com/','','','','Banner 5','t','',0,0,0,'','',0,0,'','',''
        );
        $rows = $st->execute($aData);
        $aData = array(
            6,6,'t','',0,'html','','','<h3>Test Banner 6</h3>','<h3>Test Banner 6</h3>',0,0,1,0,'',
            'http://example.com/','','','','Banner 6','t','',0,0,0,'','',0,0,'','',''
        );
        $rows = $st->execute($aData);

        $query = "
            INSERT INTO
                max_campaigns
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    target_click,
                    target_conversion,
                    anonymous,
                    companion
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'integer',
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'text',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'text',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,'Test Advertiser 1 - Default Campaign 1',1,-1,-1,-1,OA_Dal::noDateValue(),OA_Dal::noDateValue(),'t','l',1,0,0,0,'f',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,'Test Advertiser 1 - Default Campaign 2',1,-1,-1,-1,OA_Dal::noDateValue(),OA_Dal::noDateValue(),'t','l',1,0,0,0,'f',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,'Test Advertiser 1 - Default Campaign 3',1,-1,-1,-1,OA_Dal::noDateValue(),OA_Dal::noDateValue(),'t','l',1,0,0,0,'f',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,'Test Advertiser 2 - Default Campaign 1',2,-1,-1,-1,OA_Dal::noDateValue(),OA_Dal::noDateValue(),'t','l',1,0,0,0,'f',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            5,'Test Advertiser 2 - Default Campaign 2',2,-1,-1,-1,OA_Dal::noDateValue(),OA_Dal::noDateValue(),'t','l',1,0,0,0,'f',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            6,'Test Advertiser 2 - Default Campaign 3',2,-1,-1,-1,OA_Dal::noDateValue(),OA_Dal::noDateValue(),'t','l',1,0,0,0,'f',0
        );
        $rows = $st->execute($aData);

        $query = "
            INSERT INTO
                max_campaigns_trackers
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,1,1,86400,0,1
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,2,1,86400,0,1
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,3,1,86400,0,4
        );
        $rows = $st->execute($aData);

        $query = "
            INSERT INTO
            max_clients
            (
                clientid,
                agencyid,
                clientname,
                contact,
                email,
                clientusername,
                clientpassword,
                permissions,
                language,
                report,
                reportinterval,
                reportlastdate,
                reportdeactivate
            )
        VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'text',
            'text',
            'integer',
            'timestamp',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,0,'Test Advertiser 1','Test Contact 1','test1@example.com','','',0,'','t',7,'2004-11-26','t'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,0,'Test Advertiser 2','Test Contact 2','test2@example.com','','',0,'','t',7,'2004-11-26','t'
        );
        $rows = $st->execute($aData);

        $query = "
            INSERT INTO
                max_data_raw_ad_request
                (
                    viewer_id,
                    viewer_session_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    channel,
                    channel_ids,
                    language,
                    ip_address,
                    host_name,
                    country,
                    https,
                    domain,
                    page,
                    query,
                    referer,
                    search_term,
                    user_agent,
                    os,
                    browser,
                    max_https
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'integer',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',2,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',4,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',5,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',1,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',1,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',5,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',1,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',5,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',1,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',5,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',1,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',2,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',4,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',4,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',5,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);

        $query = "
            INSERT INTO
                max_data_raw_ad_impression
                (
                    viewer_id,
                    viewer_session_id,
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    channel,
                    channel_ids,
                    language,
                    ip_address,
                    host_name,
                    country,
                    https,
                    domain,
                    page,
                    query,
                    referer,
                    search_term,
                    user_agent,
                    os,
                    browser,
                    max_https
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'text',
            'integer',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',2,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',4,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',5,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',1,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',1,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',5,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',1,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',5,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',1,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',5,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',1,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',2,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',4,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',4,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',3,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',5,0,1,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',6,0,2,'','|1|2|','en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $rows = $st->execute($aData);

        $query = "
            INSERT INTO
                max_data_raw_tracker_impression
                (
                    server_raw_tracker_impression_id,
                    server_raw_ip,
                    viewer_id,
                    viewer_session_id,
                    date_time,
                    tracker_id,
                    channel,
                    channel_ids,
                    language,
                    ip_address,
                    host_name,
                    country,
                    https,
                    domain,
                    page,
                    query,
                    referer,
                    search_term,
                    user_agent,
                    os,
                    browser,
                    max_https
                )
            VALUES
                (
                    1,
                    'singleDB',
                    '7030ec9e03911a66006cba951848e454',
                    '',
                    '2004-11-26 12:10:42',
                    1,
                    NULL,
                    '|3|4|',
                    'en-us,en',
                    '127.0.0.1',
                    '',
                    '',
                    0,
                    'localhost',
                    '/test.html',
                    '',
                    '',
                    '',
                    'Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1',
                    'Linux',
                    'Firefox',
                    0
                )";
        $rows = $oDbh->exec($query);

        $query = "
            INSERT INTO
                max_trackers
                (
                    trackerid,
                    trackername,
                    description,
                    clientid,
                    viewwindow,
                    clickwindow,
                    blockwindow,
                    appendcode
                )
            VALUES
                (
                    1,
                    'Test Advertiser 1 - Default Tracker',
                    '',
                    1,
                    86400,
                    0,
                    0,
                    ''
                )";
        $rows = $oDbh->exec($query);

        $query = "
            INSERT INTO
                max_zones
                (
                    zoneid,
                    affiliateid,
                    zonename,
                    description,
                    delivery,
                    zonetype,
                    category,
                    width,
                    height,
                    ad_selection,
                    chain,
                    prepend,
                    append,
                    appendtype,
                    forceappend,
                    inventory_forecast_type
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'text',
            'text',
            'integer',
            'integer',
            'text',
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'text',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,1,'Test Publisher 1 - Default','',0,3,'',-1,-1,'','','','',0,'f',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,2,'Test Publisher 2 - Default','',0,3,'',-1,-1,'','','','',0,'f',0
        );
        $rows = $st->execute($aData);

        $query = "
            INSERT INTO
                max_channel
                (
                    channelid,
                    agencyid,
                    affiliateid,
                    name,
                    description,
                    compiledlimitation,
                    acl_plugins,
                    active,
                    comments,
                    updated,
                    acls_updated
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'text',
            'timestamp',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,0,1,'Test Channel - Page Url','','MAX_checkSite_Pageurl(\'example\', \'=~\')','Site:Pageurl',1,'',OA_Dal::noDateValue(),'2007-01-08 12:09:17'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,0,1,'Test Channel - Referrer','Test Channel - referrer = www.referrer.com','MAX_checkSite_Referingpage(\'refer.com\', \'=~\')','Site:Referingpage',1,'',OA_Dal::noDateValue(),'2007-01-08 12:32:27'
        );
        $rows = $st->execute($aData);

        $query = "
            INSERT INTO
                max_acls
                (
                    bannerid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'text',
            'text',
            'text',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            7,'and','Site:Channel','==','1',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            7,'and','Site:Channel','==','2',1
        );
        $rows = $st->execute($aData);

        $query = "
            INSERT INTO
                max_acls_channel
                (
                    channelid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'text',
            'text',
            'text',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,'and','Site:Pageurl','=~','example',0
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,'and','Site:Referingpage','=~','refer.com',0
        );
        $rows = $st->execute($aData);

        $query = "
            INSERT INTO
                max_banners
                (
                    bannerid,
                    campaignid,
                    active,
                    contenttype,
                    pluginversion,
                    storagetype,
                    filename,
                    imageurl,
                    htmltemplate,
                    htmlcache,
                    width,
                    height,
                    weight,
                    seq,
                    target,
                    url,
                    alt,
                    status,
                    bannertext,
                    description,
                    autohtml,
                    adserver,
                    block,
                    capping,
                    session_capping,
                    compiledlimitation,
                    acl_plugins,
                    append,
                    appendtype,
                    bannertype,
                    alt_filename,
                    alt_imageurl,
                    alt_contenttype
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'text',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'integer',
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            7,
            6,
            't',
            '',
            0,
            'html',
            '',
            '',
            '<h3>Test Banner 7</h3>',
            '<h3>Test Banner 7</h3>',
            0,
            0,
            1,
            0,
            '',
            'http://example.com/',
            '',
            '',
            '',
            'Banner 7',
            't',
            '',
            0,
            0,
            0,
            '(MAX_checkSite_Channel(\'1\', \'==\')) and (MAX_checkSite_Channel(\'2\', \'==\'))',
            'Site:Channel',
            '',
            0,
            0,
            '',
            '',
            ''
        );
        $rows = $st->execute($aData);

        // Set up the config as desired for testing
        $conf['maintenance']['operationInterval'] = 60;
        $conf['maintenance']['compactStats'] = false;
        $conf['modules']['Tracker'] = true;
        $conf['table']['split'] = false;
        // Set the "current" time
        $oDateNow = new Date('2004-11-28 12:00:00');
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('now', $oDateNow);
        // Create and run the class
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateStatistics();
        // Test the results
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 30);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 30);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>