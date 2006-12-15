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

/**
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */

define('ADSERVER_FULL_TEST_BANNERS', "INSERT INTO
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
        (1,1,'t','',0,'html','','','<h3>Test Banner 1</h3>','<h3>Test Banner 1</h3>',0,0,1,0,'',
         'http://example.com/','','','','Banner 1','t','',0,0,0,'','',0,0,'','',''),
        (2,2,'t','',0,'html','','','<h3>Test Banner 2</h3>','<h3>Test Banner 2</h3>',0,0,1,0,'',
         'http://example.com/','','','','Banner 2','t','',0,0,0,'','',0,0,'','',''),
        (3,3,'t','',0,'html','','','<h3>Test Banner 3</h3>','<h3>Test Banner 3</h3>',0,0,1,0,'',
         'http://example.com/','','','','Banner 3','t','',0,0,0,'','',0,0,'','',''),
        (4,4,'t','',0,'html','','','<h3>Test Banner 4</h3>','<h3>Test Banner 4</h3>',0,0,1,0,'',
         'http://example.com/','','','','Banner 4','t','',0,0,0,'','',0,0,'','',''),
        (5,5,'t','',0,'html','','','<h3>Test Banner 5</h3>','<h3>Test Banner 5</h3>',0,0,1,0,'',
         'http://example.com/','','','','Banner 5','t','',0,0,0,'','',0,0,'','',''),
        (6,6,'t','',0,'html','','','<h3>Test Banner 6</h3>','<h3>Test Banner 6</h3>',0,0,1,0,'',
         'http://example.com/','','','','Banner 6','t','',0,0,0,'','',0,0,'','','')");

define('ADSERVER_FULL_TEST_CAMPAIGNS', "INSERT INTO
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
        (1,'Test Advertiser 1 - Default Campaign 1',1,-1,-1,-1,'0000-00-00','0000-00-00','t','l',1,0,0,0,'f',0),
        (2,'Test Advertiser 1 - Default Campaign 2',1,-1,-1,-1,'0000-00-00','0000-00-00','t','l',1,0,0,0,'f',0),
        (3,'Test Advertiser 1 - Default Campaign 3',1,-1,-1,-1,'0000-00-00','0000-00-00','t','l',1,0,0,0,'f',0),
        (4,'Test Advertiser 2 - Default Campaign 1',2,-1,-1,-1,'0000-00-00','0000-00-00','t','l',1,0,0,0,'f',0),
        (5,'Test Advertiser 2 - Default Campaign 2',2,-1,-1,-1,'0000-00-00','0000-00-00','t','l',1,0,0,0,'f',0),
        (6,'Test Advertiser 2 - Default Campaign 3',2,-1,-1,-1,'0000-00-00','0000-00-00','t','l',1,0,0,0,'f',0)");

define('ADSERVER_FULL_TEST_CAMPAIGNS_TRACKERS', "INSERT INTO
        max_campaigns_trackers
    VALUES
        (1,1,1,86400,0,1),(2,2,1,86400,0,1),(3,3,1,86400,0,4)");

define('ADSERVER_FULL_TEST_CLIENTS', "INSERT INTO
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
        (1,0,'Test Advertiser 1','Test Contact 1','test1@example.com','','',0,'','t',7,'2004-11-26','t'),
        (2,0,'Test Advertiser 2','Test Contact 2','test2@example.com','','',0,'','t',7,'2004-11-26','t')");

define('ADSERVER_FULL_TEST_AD_IMPRESSIONS', "INSERT INTO
        max_data_raw_ad_impression
    ( `viewer_id` , `viewer_session_id` , `date_time` , `ad_id` , `creative_id` , `zone_id` , `channel` , `language` , `ip_address` , `host_name` , `country` , `https` , `domain` , `page` , `query` , `referer` , `search_term` , `user_agent` , `os` , `browser` , `max_https` )
    VALUES
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',2,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',4,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',5,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',1,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',1,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',5,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',1,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',5,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',1,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',5,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',1,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',2,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',4,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',4,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',5,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0)");

define('ADSERVER_FULL_TEST_AD_REQUESTS', "INSERT INTO
        max_data_raw_ad_request
    ( `viewer_id` , `viewer_session_id` , `date_time` , `ad_id` , `creative_id` , `zone_id` , `channel` , `language` , `ip_address` , `host_name` , `country` , `https` , `domain` , `page` , `query` , `referer` , `search_term` , `user_agent` , `os` , `browser` , `max_https` )
    VALUES
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',2,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',4,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',5,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',1,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',1,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',5,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',1,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',5,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',1,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',5,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',1,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',2,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',4,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',4,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',3,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',5,0,1,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0),
        ('7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',6,0,2,'','en-us,en;q=0.5','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0)");

define('ADSERVER_FULL_TEST_TRACKER_IMPRESSIONS', "INSERT INTO
        max_data_raw_tracker_impression
    ( server_raw_tracker_impression_id , server_raw_ip , viewer_id , viewer_session_id , date_time , tracker_id , channel , language , ip_address , host_name , country , https , domain , page , query , referer , search_term , user_agent , os , browser , max_https )
    VALUES
        (1,'singleDB','7030ec9e03911a66006cba951848e454','','2004-11-26 12:10:42',1,NULL,'en-us,en;q=0.5',
         '127.0.0.1','','',0,'localhost','/test.html','','','',
         'Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0)");

define('ADSERVER_FULL_TEST_TRACKERS', "INSERT INTO
        max_trackers
    ( `trackerid` , `trackername` , `description` , `clientid` , `viewwindow` , `clickwindow` , `blockwindow` , `appendcode` )
    VALUES
        (1,'Test Advertiser 1 - Default Tracker','',1,86400,0,0,'')");

define('ADSERVER_FULL_TEST_ZONES', "INSERT INTO
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
        (1,1,'Test Publisher 1 - Default','',0,3,'',-1,-1,'','','','',0,'f',0),
        (2,2,'Test Publisher 2 - Default','',0,3,'',-1,-1,'','','','',0,'f',0)");

?>
