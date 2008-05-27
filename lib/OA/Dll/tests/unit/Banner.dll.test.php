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

require_once MAX_PATH . '/lib/OA/Dll/Advertiser.php';
require_once MAX_PATH . '/lib/OA/Dll/AdvertiserInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Campaign.php';
require_once MAX_PATH . '/lib/OA/Dll/CampaignInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/Banner.php';
require_once MAX_PATH . '/lib/OA/Dll/BannerInfo.php';
require_once MAX_PATH . '/lib/OA/Dll/tests/util/DllUnitTestCase.php';

/**
 * A class for testing DLL Banner methods
 *
 * @package    OpenXDll
 * @subpackage TestSuite
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */


class OA_Dll_BannerTest extends DllUnitTestCase
{
    /**
     * @var int
     */
    var $agencyId;

    /**
     * Errors
     *
     */
    var $unknownIdError = 'Unknown bannerId Error';
    var $unknownFormatError = 'Unrecognized image file format';

    var $binaryGif;
    var $binarySwf;

    /**
     * The constructor method.
     */
    function OA_Dll_BannerTest()
    {
        $this->UnitTestCase();
        Mock::generatePartial(
            'OA_Dll_Banner',
            'PartialMockOA_Dll_Banner',
            array('checkPermissions')
        );
        Mock::generatePartial(
            'OA_Dll_Campaign',
            'PartialMockOA_Dll_Campaign',
            array('checkPermissions')
        );
        Mock::generatePartial(
            'OA_Dll_Advertiser',
            'PartialMockOA_Dll_Advertiser',
            array('checkPermissions', 'getDefaultAgencyId')
        );

        $this->binaryGif = "GIF89a\001\0\001\0\200\0\0\377\377\377\0\0\0!\371\004\0\0\0\0\0,\0\0\0\0\001\0\001\0\0\002\002D\001\0;";
        $this->binarySwf = file_get_contents(MAX_PATH . '/lib/OA/Creative/tests/data/swf-link.swf');
    }

    function setUp()
    {
        $this->agencyId = DataGenerator::generateOne('agency');
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
    }

    /**
     * A method to test Add, Modify and Delete.
     */
    function testAddModifyDelete()
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser($this);
        $dllCampaignPartialMock   = new PartialMockOA_Dll_Campaign($this);
        $dllBannerPartialMock     = new PartialMockOA_Dll_Banner($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 2);

        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 1);

        $dllBannerPartialMock->setReturnValue('checkPermissions', true);
        $dllBannerPartialMock->expectCallCount('checkPermissions', 13);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        $oCampaignInfo = new OA_Dll_CampaignInfo();

        $oCampaignInfo->advertiserId = $oAdvertiserInfo->advertiserId;

        // Add
        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo),
                          $dllCampaignPartialMock->getLastError());

        $oBannerInfo = new OA_Dll_BannerInfo();
        $oBannerInfo->campaignId = $oCampaignInfo->campaignId;

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo),
                          $dllBannerPartialMock->getLastError());

        // Modify
        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo),
                          $dllBannerPartialMock->getLastError());

        // Delete
        $this->assertTrue($dllBannerPartialMock->delete($oBannerInfo->bannerId),
                          $dllBannerPartialMock->getLastError());


        // Add gif (SQL stored)
        $oBannerInfo2 = new OA_Dll_BannerInfo();
        $oBannerInfo2->campaignId = $oCampaignInfo->campaignId;
        $oBannerInfo2->storageType = 'sql';
        $oBannerInfo2->aImage = array(
            'filename' => '1x1.gif',
            'content'  => $this->binaryGif
        );

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo2),
                          $dllBannerPartialMock->getLastError());

        $doBanners = OA_Dal::staticGetDO('banners', $oBannerInfo2->bannerId);
        $this->assertEqual($doBanners->width, 1);
        $this->assertEqual($doBanners->height, 1);
        $this->assertEqual($doBanners->contenttype, 'gif');

        $doImages = OA_Dal::staticGetDO('images', $doBanners->filename);
        $this->assertEqual($doImages->contents, $this->binaryGif);

        // Modify to SWF
        $oBannerInfo2 = new OA_Dll_BannerInfo();
        $oBannerInfo2->bannerId = (int)$doBanners->bannerid;
        $oBannerInfo2->aImage = array(
            'filename' => 'foo.swf',
            'content'  => $this->binarySwf
        );

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo2),
                          $dllBannerPartialMock->getLastError());

        $doBanners = OA_Dal::staticGetDO('banners', $oBannerInfo2->bannerId);
        $this->assertEqual($doBanners->width, 468);
        $this->assertEqual($doBanners->height, 60);
        $this->assertEqual($doBanners->contenttype, 'swf');

        $doImages = OA_Dal::staticGetDO('images', $doBanners->filename);
        $this->assertEqual($doImages->contents, $this->binarySwf);

        $GLOBALS['_MAX']['CONF']['store']['mode']   = 'local';
        $GLOBALS['_MAX']['CONF']['store']['webDir'] = MAX_PATH . '/var';

        // Add gif (Web stored)
        $oBannerInfo2 = new OA_Dll_BannerInfo();
        $oBannerInfo2->campaignId = $oCampaignInfo->campaignId;
        $oBannerInfo2->storageType = 'web';
        $oBannerInfo2->aImage = array(
            'filename' => '1x1.gif',
            'content'  => $this->binaryGif
        );

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo2),
                          $dllBannerPartialMock->getLastError());

        $doBanners = OA_Dal::staticGetDO('banners', $oBannerInfo2->bannerId);
        $this->assertEqual($doBanners->width, 1);
        $this->assertEqual($doBanners->height, 1);
        $this->assertEqual($doBanners->contenttype, 'gif');

        $img = $GLOBALS['_MAX']['CONF']['store']['webDir'].'/'.$doBanners->filename;
        $this->assertEqual(file_get_contents($img), $this->binaryGif);

        $this->assertTrue(unlink($img));

        // Modify to SWF with backup gif
        $oBannerInfo2 = new OA_Dll_BannerInfo();
        $oBannerInfo2->bannerId = (int)$doBanners->bannerid;
        $oBannerInfo2->aImage = array(
            'filename' => 'foo.swf',
            'content'  => $this->binarySwf
        );
        $oBannerInfo2->aBackupImage = array(
            'filename' => 'foo.gif',
            'content'  => $this->binaryGif
        );

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo2),
                          $dllBannerPartialMock->getLastError());

        $doBanners = OA_Dal::staticGetDO('banners', $oBannerInfo2->bannerId);
        $this->assertEqual($doBanners->width, 468);
        $this->assertEqual($doBanners->height, 60);
        $this->assertEqual($doBanners->contenttype, 'swf');
        $this->assertEqual($doBanners->alt_contenttype, 'gif');

        $img = $GLOBALS['_MAX']['CONF']['store']['webDir'].'/'.$doBanners->filename;
        $this->assertEqual(file_get_contents($img), $this->binarySwf);
        $this->assertTrue(unlink($img));

        $img = $GLOBALS['_MAX']['CONF']['store']['webDir'].'/'.$doBanners->alt_filename;
        $this->assertEqual(file_get_contents($img), $this->binaryGif);
        $this->assertTrue(unlink($img));

        // Modify back to gif
        $oBannerInfo2 = new OA_Dll_BannerInfo();
        $oBannerInfo2->bannerId = (int)$doBanners->bannerid;
        $oBannerInfo2->aImage = array(
            'filename' => 'foo.gif',
            'content'  => $this->binaryGif
        );

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo2),
                          $dllBannerPartialMock->getLastError());

        $doBanners = OA_Dal::staticGetDO('banners', $oBannerInfo2->bannerId);
        $this->assertEqual($doBanners->width, 1);
        $this->assertEqual($doBanners->height, 1);
        $this->assertEqual($doBanners->contenttype, 'gif');
        $this->assertFalse($doBanners->alt_contenttype);

        $img = $GLOBALS['_MAX']['CONF']['store']['webDir'].'/'.$doBanners->filename;
        $this->assertEqual(file_get_contents($img), $this->binaryGif);
        $this->assertTrue(unlink($img));

        // Add swf (SQL stored, no conversion)
        $oBannerInfo2 = new OA_Dll_BannerInfo();
        $oBannerInfo2->campaignId = $oCampaignInfo->campaignId;
        $oBannerInfo2->storageType = 'sql';
        $oBannerInfo2->aImage = array(
            'filename' => 'test.swf',
            'content'  => $this->binarySwf
        );

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo2),
                          $dllBannerPartialMock->getLastError());

        $doBanners = OA_Dal::staticGetDO('banners', $oBannerInfo2->bannerId);
        $this->assertEqual($doBanners->width, 468);
        $this->assertEqual($doBanners->height, 60);
        $this->assertEqual($doBanners->contenttype, 'swf');
        $this->assertFalse($doBanners->parameters);
        $this->assertFalse($doBanners->url);
        $this->assertFalse($doBanners->target);

        $doImages = OA_Dal::staticGetDO('images', $doBanners->filename);
        $this->assertEqual($doImages->contents, $this->binarySwf);

        // Add swf (SQL stored, conversion)
        $oBannerInfo2 = new OA_Dll_BannerInfo();
        $oBannerInfo2->campaignId = $oCampaignInfo->campaignId;
        $oBannerInfo2->storageType = 'sql';
        $oBannerInfo2->aImage = array(
            'filename' => 'test.swf',
            'content'  => $this->binarySwf,
            'editswf'  => true
        );

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo2),
                          $dllBannerPartialMock->getLastError());

        $doBanners = OA_Dal::staticGetDO('banners', $oBannerInfo2->bannerId);
        $this->assertEqual($doBanners->width, 468);
        $this->assertEqual($doBanners->height, 60);
        $this->assertEqual($doBanners->contenttype, 'swf');
        $this->assertTrue($doBanners->parameters);
        $this->assertTrue($doBanners->url);
        $this->assertTrue($doBanners->target);

        $doImages = OA_Dal::staticGetDO('images', $doBanners->filename);
        $this->assertTrue($doImages->contents);
        $this->assertNotEqual($doImages->contents, $this->binarySwf);

        // Add mangled banner
        $oBannerInfo2 = new OA_Dll_BannerInfo();
        $oBannerInfo2->campaignId = $oCampaignInfo->campaignId;
        $oBannerInfo2->storageType = 'sql';
        $oBannerInfo2->aImage = array(
            'filename' => 'test.swf',
            'content'  => 'foobar'
        );

        $this->assertTrue((!$dllBannerPartialMock->modify($oBannerInfo2) &&
                          $dllBannerPartialMock->getLastError() == $this->unknownFormatError),
            $this->_getMethodShouldReturnError($this->unknownFormatError));

        // Modify not existing id
        $this->assertTrue((!$dllBannerPartialMock->modify($oBannerInfo) &&
                          $dllBannerPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        // Delete not existing id
        $this->assertTrue((!$dllBannerPartialMock->delete($oBannerInfo->bannerId) &&
                           $dllBannerPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllBannerPartialMock->tally();
    }

    /**
     * A method to test get and getList method.
     */
    function testGetAndGetList()
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser($this);
        $dllCampaignPartialMock   = new PartialMockOA_Dll_Campaign($this);
        $dllBannerPartialMock     = new PartialMockOA_Dll_Banner($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 2);

        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 1);

        $dllBannerPartialMock->setReturnValue('checkPermissions', true);
        $dllBannerPartialMock->expectCallCount('checkPermissions', 6);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        $oCampaignInfo = new OA_Dll_CampaignInfo();

        $oCampaignInfo->advertiserId = $oAdvertiserInfo->advertiserId;

        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo),
                          $dllCampaignPartialMock->getLastError());


        // Add
        $oBannerInfo1               = new OA_Dll_BannerInfo();
        $oBannerInfo1->bannerName   = 'test name 1';
        $oBannerInfo1->storageType  = 'url';
        $oBannerInfo1->imageURL     = 'image url';
        $oBannerInfo1->htmlTemplate = 'html Template';
        $oBannerInfo1->width        = 2;
        $oBannerInfo1->height       = 3;
        $oBannerInfo1->url          = 'url';
        $oBannerInfo1->campaignId   = $oCampaignInfo->campaignId;

        $oBannerInfo2               = new OA_Dll_BannerInfo();
        $oBannerInfo2->bannerName = 'test name 2';
        $oBannerInfo2->campaignId   = $oCampaignInfo->campaignId;
        // Add
        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo1),
                          $dllBannerPartialMock->getLastError());

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo2),
                          $dllBannerPartialMock->getLastError());

        $oBannerInfo1Get = null;
        $oBannerInfo2Get = null;
        // Get
        $this->assertTrue($dllBannerPartialMock->getBanner($oBannerInfo1->bannerId,
                                                                   $oBannerInfo1Get),
                          $dllBannerPartialMock->getLastError());
        $this->assertTrue($dllBannerPartialMock->getBanner($oBannerInfo2->bannerId,
                                                                   $oBannerInfo2Get),
                          $dllBannerPartialMock->getLastError());

        // Check field value
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'bannerName');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'storageType');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'imageURL');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'htmlTemplate');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'width');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'height');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'url');
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'campaignId');
        $this->assertFieldEqual($oBannerInfo2, $oBannerInfo2Get, 'bannerName');

        // Get List
        $aBannerList = array();
        $this->assertTrue($dllBannerPartialMock->getBannerListByCampaignId($oCampaignInfo->campaignId,
                                                                           $aBannerList),
                          $dllBannerPartialMock->getLastError());
        $this->assertEqual(count($aBannerList) == 2,
                           '2 records should be returned');
        $oBannerInfo1Get = $aBannerList[0];
        $oBannerInfo2Get = $aBannerList[1];
        if ($oBannerInfo1->bannerId == $oBannerInfo2Get->bannerId) {
            $oBannerInfo1Get = $aBannerList[1];
            $oBannerInfo2Get = $aBannerList[0];
        }
        // Check field value from list
        $this->assertFieldEqual($oBannerInfo1, $oBannerInfo1Get, 'bannerName');
        $this->assertFieldEqual($obannerInfo2, $obannerInfo2Get, 'bannerName');


        // Delete
        $this->assertTrue($dllBannerPartialMock->delete($oBannerInfo1->bannerId),
            $dllBannerPartialMock->getLastError());

        // Get not existing id
        $this->assertTrue((!$dllBannerPartialMock->getBanner($oBannerInfo1->bannerId,
                                                                     $oBannerInfo1Get) &&
                          $dllBannerPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllBannerPartialMock->tally();
    }

    /**
     * Method to run all tests for banner statistics
     *
     * @access private
     *
     * @param string $methodName  Method name in Dll
     */
    function _testStatistics($methodName)
    {
        $dllAdvertiserPartialMock = new PartialMockOA_Dll_Advertiser($this);
        $dllCampaignPartialMock = new PartialMockOA_Dll_Campaign($this);
        $dllBannerPartialMock = new PartialMockOA_Dll_Banner($this);

        $dllAdvertiserPartialMock->setReturnValue('getDefaultAgencyId', $this->agencyId);
        $dllAdvertiserPartialMock->setReturnValue('checkPermissions', true);
        $dllAdvertiserPartialMock->expectCallCount('checkPermissions', 2);

        $dllCampaignPartialMock->setReturnValue('checkPermissions', true);
        $dllCampaignPartialMock->expectCallCount('checkPermissions', 1);

        $dllBannerPartialMock->setReturnValue('checkPermissions', true);
        $dllBannerPartialMock->expectCallCount('checkPermissions', 5);

        $oAdvertiserInfo = new OA_Dll_AdvertiserInfo();
        $oAdvertiserInfo->advertiserName = 'test Advertiser name';
        $oAdvertiserInfo->agencyId       = $this->agencyId;

        $this->assertTrue($dllAdvertiserPartialMock->modify($oAdvertiserInfo),
                          $dllAdvertiserPartialMock->getLastError());

        $oCampaignInfo = new OA_Dll_CampaignInfo();

        $oCampaignInfo->advertiserId = $oAdvertiserInfo->advertiserId;

        // Add
        $this->assertTrue($dllCampaignPartialMock->modify($oCampaignInfo),
                          $dllCampaignPartialMock->getLastError());

        $oBannerInfo = new OA_Dll_BannerInfo();
        $oBannerInfo->campaignId = $oCampaignInfo->campaignId;

        $this->assertTrue($dllBannerPartialMock->modify($oBannerInfo),
                          $dllBannerPartialMock->getLastError());

        // Get no data
        $rsBannerStatistics = null;
        $this->assertTrue($dllBannerPartialMock->$methodName(
            $oBannerInfo->bannerId, new Date('2001-12-01'), new Date('2007-09-19'),
            $rsBannerStatistics), $dllBannerPartialMock->getLastError());

        $this->assertTrue(isset($rsBannerStatistics) &&
            ($rsBannerStatistics->getRowCount() == 0), 'No records should be returned');

        // Test for wrong date order
        $rsBannerStatistics = null;
        $this->assertTrue((!$dllBannerPartialMock->$methodName(
                $oBannerInfo->bannerId, new Date('2007-09-19'),  new Date('2001-12-01'),
                $rsBannerStatistics) &&
            $dllBannerPartialMock->getLastError() == $this->wrongDateError),
            $this->_getMethodShouldReturnError($this->wrongDateError));

        // Delete
        $this->assertTrue($dllBannerPartialMock->delete($oBannerInfo->bannerId),
            $dllBannerPartialMock->getLastError());

        // Test statistics for not existing id
        $rsBannerStatistics = null;
        $this->assertTrue((!$dllBannerPartialMock->$methodName(
                $oBannerInfo->bannerId, new Date('2001-12-01'),  new Date('2007-09-19'),
                $rsBannerStatistics) &&
            $dllBannerPartialMock->getLastError() == $this->unknownIdError),
            $this->_getMethodShouldReturnError($this->unknownIdError));

        $dllBannerPartialMock->tally();
    }

    /**
     * A method to test getBannerDailyStatistics.
     */
    function testDailyStatistics()
    {
        $this->_testStatistics('getBannerDailyStatistics');
    }

    /**
     * A method to test getBannerPublisherStatistics.
     */
    function testPublisherStatistics()
    {
        $this->_testStatistics('getBannerPublisherStatistics');
    }

    /**
     * A method to test getBannerZoneStatistics.
     */
    function testZoneStatistics()
    {
        $this->_testStatistics('getBannerZoneStatistics');
    }

}

?>
