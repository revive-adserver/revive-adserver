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

require_once MAX_PATH . '/lib/Max.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once OX_PATH . '/lib/OX.php';
require_once OX_PATH . '/lib/pear/Date.php';

/**
 * A class for performing integration testing the OA_Maintenance_Statistics_AdServer class.
 *
 * Currently plugins such as arrivals are not tested at all. This test will fail if arrivals
 * are installed as stats will need arrival tables along with changes to core tables. It is
 * possible to create the arrivals tables but it is not possible to update the core tables yet.
 * The solution at the moment is to remove the plugins/maintenance/arrivals folder and ignore
 * the testing of arrivals.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 *
 * @TODO Update to use a mocked DAL, instead of a real database?
 */
class Test_OA_Maintenance_Statistics_AdServer extends UnitTestCase
{
    var $oDbh;
    var $doBanners = null;
    var $doCampaigns = null;
    var $doCampaignsTrackers = null;
    var $doClients = null;
    var $doAcls = null;
    var $doChannel = null;
    var $doAclsChannel = null;
    var $doAffiliates = null;
    var $doZones = null;
    var $doTrackers = null;
    var $tblDRAR;
    var $tblDRAI;
    var $tblDRTI;


    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Statistics_AdServer()
    {
        $this->UnitTestCase();
        $this->oDbh =& OA_DB::singleton();
        $this->doBanners   = OA_Dal::factoryDO('banners');
        $this->doCampaigns = OA_Dal::factoryDO('campaigns');
        $this->doCampaignsTrackers = OA_Dal::factoryDO('campaigns_trackers');
        $this->doClients = OA_Dal::factoryDO('clients');
        $this->doAcls = OA_Dal::factoryDO('acls');
        $this->doAclsChannel = OA_Dal::factoryDO('acls_channel');
        $this->doChannel = OA_Dal::factoryDO('channel');
        $this->doAffiliates = OA_Dal::factoryDO('affiliates');
        $this->doZones = OA_Dal::factoryDO('zones');
        $this->doTrackers = OA_Dal::factoryDO('trackers');
        $conf =& $GLOBALS['_MAX']['CONF'];
        $this->tblDRAR = $this->oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_raw_ad_request'],true);
        $this->tblDRAI = $this->oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_raw_ad_impression'],true);
        $this->tblDRTI = $this->oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['data_raw_tracker_impression'],true);
    }

    function _insertBanner($aData)
    {
        $this->doBanners->active='t';
        $this->doBanners->contenttype='';
        $this->doBanners->pluginversion=0;
        $this->doBanners->storagetype='html';
        $this->doBanners->filename='';
        $this->doBanners->imageurl='';
        $this->doBanners->htmltemplate='<h3>Test Banner</h3>';
        $this->doBanners->htmlcache='<h3>Test Banner</h3>';
        $this->doBanners->width=0;
        $this->doBanners->height=0;
        $this->doBanners->weight=1;
        $this->doBanners->seq=0;
        $this->doBanners->target='';
        $this->doBanners->url='http://example.com/';
        $this->doBanners->alt='';
        $this->doBanners->status='';
        $this->doBanners->bannertext='';
        $this->doBanners->description='Banner';
        $this->doBanners->autohtml='t';
        $this->doBanners->adserver='';
        $this->doBanners->block=0;
        $this->doBanners->capping=0;
        $this->doBanners->session_capping=0;
        $this->doBanners->compiledlimitation='';
        $this->doBanners->append='';
        $this->doBanners->appendtype=0;
        $this->doBanners->bannertype=0;
        $this->doBanners->alt_filename='';
        $this->doBanners->alt_imageurl='';
        $this->doBanners->alt_contenttype='';
        foreach ($aData AS $key => $val)
        {
            $this->doBanners->$key = $val;
        }
        return DataGenerator::generateOne($this->doBanners);
    }

    function _insertCampaign($aData)
    {
        $this->doCampaigns->campaignname = 'Test Advertiser - Default Campaign';
        $this->doCampaigns->views = -1;
        $this->doCampaigns->clicks = -1;
        $this->doCampaigns->conversions = -1;
        $this->doCampaigns->expire = OA_Dal::noDateValue();
        $this->doCampaigns->activate = OA_Dal::noDateValue();
        $this->doCampaigns->active = 't';
        $this->doCampaigns->priority = 'l';
        $this->doCampaigns->weight = 1;
        $this->doCampaigns->target_impression = 1;
        $this->doCampaigns->target_click = 0;
        $this->doCampaigns->target_conversion = 0;
        $this->doCampaigns->anonymous = 'f';
        $this->doCampaigns->companion = 0;
        $this->doCampaigns->updated = null;
        foreach ($aData AS $key => $val)
        {
            $this->doCampaigns->$key = $val;
        }
        return DataGenerator::generateOne($this->doCampaigns);
    }

    function _insertCampaignsTracker($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doCampaignsTrackers->$key = $val;
        }
        return DataGenerator::generateOne($this->doCampaignsTrackers);
    }

    function _insertClients($aData)
    {
        $this->doClients->agencyid=0;
        $this->doClients->clientname='Test Advertiser';
        $this->doClients->contact='Test Contact';
        $this->doClients->email='test1@example.com';
        $this->doClients->clientusername='';
        $this->doClients->clientpassword='';
        $this->doClients->permissions=0;
        $this->doClients->language='';
        $this->doClients->report='t';
        $this->doClients->reportinterval=7;
        $this->doClients->reportlastdate='2004-11-26';
        $this->doClients->reportdeactivate='t';
        foreach ($aData AS $key => $val)
        {
            $this->doClients->$key = $val;
        }
        return DataGenerator::generateOne($this->doClients);
    }

    function _insertAcls($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doAcls->$key = $val;
        }
        return DataGenerator::generateOne($this->doAcls);
    }

    function _insertChannel($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doChannel->$key = $val;
        }
        return DataGenerator::generateOne($this->doChannel);
    }

    function _insertAclsChannel($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doAclsChannel->$key = $val;
        }
        return DataGenerator::generateOne($this->doAclsChannel);
    }

    function _insertPublisher($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doAffiliates->$key = $val;
        }
        return DataGenerator::generateOne($this->doAffiliates);
    }

    function _insertZone($aData)
    {
        $this->doZones->description='';
        $this->doZones->delivery=0;
        $this->doZones->zonetype=3;
        $this->doZones->category='';
        $this->doZones->width=-1;
        $this->doZones->height=-1;
        $this->doZones->ad_selection='';
        $this->doZones->chain='';
        $this->doZones->prepend='';
        $this->doZones->append='';
        $this->doZones->appendtype=0;
        $this->doZones->inventory_forecast_type=0;
        $this->doZones->what='';
        foreach ($aData AS $key => $val)
        {
            $this->doZones->$key = $val;
        }
        return DataGenerator::generateOne($this->doZones);
    }

    function _insertTracker($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doTrackers->$key = $val;
        }
        return DataGenerator::generateOne($this->doTrackers);
    }

    function _insertDataRawTracker($aData)
    {
        $query = "
            INSERT INTO
            {$this->tblDRAR}
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
                '{$aData[0]}',
                '{$aData[1]}',
                '{$aData[2]}',
                 {$aData[3]},
                 {$aData[4]},
                 {$aData[5]},
                '{$aData[6]}',
                '{$aData[7]}',
                '{$aData[8]}',
                '{$aData[9]}',
                '{$aData[10]}',
                '{$aData[12]}',
                '{$aData[13]}',
                '{$aData[14]}',
                '{$aData[15]}',
                '{$aData[16]}',
                '{$aData[17]}',
                '{$aData[18]}',
                '{$aData[19]}',
                '{$aData[20]}',
                '{$aData[21]}'
                )";
        return $this->oDbh->exec($query);
    }

    function _insertDataRawAdImpression($aData)
    {
        $query = "
            INSERT INTO
                {$this->tblDRAI}
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
                (
                '{$aData[0]}',
                '{$aData[1]}',
                '{$aData[2]}',
                 {$aData[3]},
                 {$aData[4]},
                 {$aData[5]},
                '{$aData[6]}',
                '{$aData[7]}',
                '{$aData[8]}',
                '{$aData[9]}',
                '{$aData[10]}',
                '{$aData[11]}',
                '{$aData[12]}',
                '{$aData[13]}',
                '{$aData[14]}',
                '{$aData[15]}',
                '{$aData[16]}',
                '{$aData[17]}',
                '{$aData[18]}',
                '{$aData[19]}',
                '{$aData[20]}',
                '{$aData[21]}'
                )";
        return $this->oDbh->exec($query);
    }

    /**
     * The main test method.
     */
    function testClass()
    {
        $oTable =& OA_DB_Table_Core::singleton();
        $oTable->createAllTables();

        //create the clients
        $aData = array(
            'clientname'=>'Test Advertiser 1'
        );
        $idClient1 = $this->_insertClients($aData);
        $aData = array(
            'clientname'=>'Test Advertiser 2'
        );
        $idClient2 = $this->_insertClients($aData);

        // create the campaigns
        $aData = array(
            'clientid'=>$idClient1
        );
        $idCampaign1 = $this->_insertCampaign($aData);
        $aData = array(
            'clientid'=>$idClient1
        );
        $idCampaign2 = $this->_insertCampaign($aData);
        $aData = array(
            'clientid'=>$idClient1
        );
        $idCampaign3 = $this->_insertCampaign($aData);
        $aData = array(
            'clientid'=>$idClient2
        );
        $idCampaign4 = $this->_insertCampaign($aData);
        $aData = array(
            'clientid'=>$idClient2
        );
        $idCampaign5 = $this->_insertCampaign($aData);
        $aData = array(
            'clientid'=>$idClient2
        );
        $idCampaign6 = $this->_insertCampaign($aData);

        // create the campaign trackers
        $aData = array(
                        'campaignid'=>$idCampaign1,
                        'trackerid'=>$idCamTracker1,
                        'viewwindow'=>86400,
                        'clickwindow'=>0,
                        'status'=>1
                      );
        $idCamTracker1 = $this->_insertCampaignsTracker($aData);
        $aData = array(
                        'campaignid'=>$idCampaign2,
                        'trackerid'=>$idCamTracker1,
                        'viewwindow'=>86400,
                        'clickwindow'=>0,
                        'status'=>1
                      );
        $idCamTracker2 = $this->_insertCampaignsTracker($aData);
        $aData = array(
                        'campaignid'=>$idCampaign3,
                        'trackerid'=>$idCamTracker1,
                        'viewwindow'=>86400,
                        'clickwindow'=>0,
                        'status'=>4
                      );
        $idCamTracker3 = $this->_insertCampaignsTracker($aData);

        // create the banners
        $aData = array(
                        'campaignid'=>$idCampaign1,
                       );
        $idBanner1 = $this->_insertBanner($aData);
        $aData = array(
                        'campaignid'=>$idCampaign2,
                       );
        $idBanner2 = $this->_insertBanner($aData);
        $aData = array(
                        'campaignid'=>$idCampaign3,
                       );
        $idBanner3 = $this->_insertBanner($aData);
        $aData = array(
                        'campaignid'=>$idCampaign4,
                       );
        $idBanner4 = $this->_insertBanner($aData);
        $aData = array(
                        'campaignid'=>$idCampaign5,
                       );
        $idBanner5 = $this->_insertBanner($aData);
        $aData = array(
                        'campaignid'=>$idCampaign6,
                       );
        $idBanner6 = $this->_insertBanner($aData);

        $aData = array(
                        'trackername'=>'Test Advertiser 1 - Default Tracker',
                        'description'=>'',
                        'clientid'=>$idClient1,
                        'viewwindow'=>86400,
                        'clickwindow'=>0,
                        'blockwindow'=>0,
                        'appendcode'=>''
                     );
        $idTracker1 = $this->_insertTracker($aData);

        $aData = array(
                        'name' => 'Test Publisher 1'
        );
        $idPublisher1 = $this->_insertPublisher($aData);

        $aData = array(
                        'name' => 'Test Publisher 2'
        );
        $idPublisher2 = $this->_insertPublisher($aData);

        $aData = array(
                        'affiliateid'=>$idPublisher1,
                        'zonename'=>'Test Publisher 1 - Default',
                      );
        $idZone1 = $this->_insertZone($aData);

        $aData = array(
                        'affiliateid'=>$idPublisher2,
                        'zonename'=>'Test Publisher 2 - Default',
                      );
        $idZone2 = $this->_insertZone($aData);

        $aData = array(
                        'agencyid'=>0,
                        'affiliateid'=>$idPublisher1,
                        'name'=>'Test Channel - Page Url',
                        'description'=>'',
                        'compiledlimitation'=>'MAX_checkSite_Pageurl(\'example\', \'=~\')',
                        'acl_plugins'=>'Site:Pageurl',
                        'active'=>'1',
                        'comments'=>'',
                        'updated'=>OA_Dal::noDateValue(),
                        'acls_updated'=>'2007-01-08 12:09:17'
                      );
        $idChannel1 = $this->_insertChannel($aData);

        $aData = array(
                        'agencyid'=>0,
                        'affiliateid'=>$idPublisher1,
                        'name'=>'Test Channel - Referrer',
                        'description'=>'Test Channel - referrer = www.referrer.com',
                        'compiledlimitation'=>'MAX_checkSite_Referingpage(\'refer.com\', \'=~\')',
                        'acl_plugins'=>'Site:Referingpage',
                        'active'=>'1',
                        'comments'=>'',
                        'updated'=>OA_Dal::noDateValue(),
                        'acls_updated'=>'2007-01-08 12:32:27'
                      );
        $idChannel2 = $this->_insertChannel($aData);

        $aData = array(
                        'bannerid'=>$idBanner6,
                        'logical'=>'and',
                        'type'=>'Site:Channel',
                        'comparison'=>'==',
                        'data'=>'1',
                        'executionorder'=>0
                      );
        $idAcls1 = $this->_insertAcls($aData);
        $aData = array(
                        'bannerid'=>$idBanner6,
                        'logical'=>'and',
                        'type'=>'Site:Channel',
                        'comparison'=>'==',
                        'data'=>'2',
                        'executionorder'=>1,
                      );
        $idAcls1 = $this->_insertAcls($aData);

        $aData = array(
            'channelid'=>$idChannel1,
            'logical'=>'and',
            'type'=>'Site:Pageurl',
            'comparison'=>'=~',
            'data'=>'example',
            'executionorder'=>0
        );
        $idAclsChannel1 = $this->_insertAclsChannel($aData);

        $aData = array(
            'channelid'=>$idChannel1,
            'logical'=>'and',
            'type'=>'Site:Referingpage',
            'comparison'=>'=~',
            'data'=>'refer.com',
            'executionorder'=>1,
        );
        $idAclsChannel2 = $this->_insertAclsChannel($aData);

        $aData = array(
                        'campaignid'=>$idCampaign6,
                        'compiledlimitation'=>"(MAX_checkSite_Channel('{$idChannel1}', '==')) and (MAX_checkSite_Channel('$idChannel2', '=='))",
                        'acl_plugins'=>'Site:Channel',
                       );
        $idBanner7 = $this->_insertBanner($aData);
        $channelIds = "|{$idChannel1}|$idChannel2|";
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',$idBanner2,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',$idBanner4,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',$idBanner5,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',$idBanner1,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',$idBanner1,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',$idBanner5,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',$idBanner1,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',$idBanner5,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',$idBanner1,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',$idBanner5,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',$idBanner1,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',$idBanner2,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',$idBanner4,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',$idBanner4,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',$idBanner5,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawTracker($aData);


        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',$idBanner2,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:47',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',$idBanner4,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:50',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:51',$idBanner5,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',$idBanner1,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:52',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',$idBanner1,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:53',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',$idBanner5,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:54',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',$idBanner1,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:55',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',$idBanner5,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:56',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',$idBanner1,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',$idBanner5,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:57',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',$idBanner1,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:58',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',$idBanner2,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:07:59',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',$idBanner4,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:00',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',$idBanner4,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',$idBanner3,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',$idBanner5,0,$idZone1,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);
        $aData = array(
            '7030ec9e03911a66006cba951848e454','','2004-11-26 12:08:01',$idBanner6,0,$idZone2,'',$channelIds,'en-us,en','127.0.0.1','','',0,'localhost','/test.html','','','','Mozilla/5.0 (X11; U; Linux i686; rv:1.7.3) Gecko/20041001 Firefox/0.10.1','Linux','Firefox',0
        );
        $this->_insertDataRawAdImpression($aData);

        $query = "
            INSERT INTO
                {$this->tblDRTI}
                (
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
                    'singleDB',
                    '7030ec9e03911a66006cba951848e454',
                    '',
                    '2004-11-26 12:10:42',
                    $idTracker1,
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
        $rows = $this->oDbh->exec($query);

        // Set up the config as desired for testing
        $conf['maintenance']['operationInterval'] = 60;
        $conf['maintenance']['compactStats'] = false;
        // Set the "current" time
        $oDateNow = new Date('2004-11-28 12:00:00');
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('now', $oDateNow);
        // Create and run the class
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateStatistics();
        // Test the results
        $aRow = $this->_countRows('data_intermediate_ad_connection');
        $this->assertEqual($aRow['number'], 1);
        $aRow = $this->_countRows('data_intermediate_ad_variable_value');
        $this->assertEqual($aRow['number'], 0);
        $aRow = $this->_countRows('data_intermediate_ad');
        $this->assertEqual($aRow['number'], 6);
        $aRow = $this->_countRows('data_summary_ad_hourly');
        $this->assertEqual($aRow['number'], 6);
        $aRow = $this->_countRows('data_summary_zone_impression_history');
        $this->assertEqual($aRow['number'], 2);
        $aRow = $this->_countRows('data_raw_ad_click');
        $this->assertEqual($aRow['number'], 0);
        $aRow = $this->_countRows('data_raw_ad_impression');
        $this->assertEqual($aRow['number'], 30);
        $aRow = $this->_countRows('data_raw_ad_request');
        $this->assertEqual($aRow['number'], 30);
        $aRow = $this->_countRows('data_raw_tracker_impression');
        $this->assertEqual($aRow['number'], 1);
        $aRow = $this->_countRows('data_raw_tracker_variable_value');
        $this->assertEqual($aRow['number'], 0);
        // Reset the testing environment
        TestEnv::restoreEnv();
    }

    function _countRows($table)
    {
        $conf =& $GLOBALS['_MAX']['CONF'];
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                ".$this->oDbh->quoteIdentifier($conf['table']['prefix'].$table,true);
        $rc = $this->oDbh->query($query);
        return $rc->fetchRow();
    }

}

?>