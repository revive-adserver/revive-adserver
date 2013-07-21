<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/xmlrpc/php/tests/integration/Common.api.php';

/**
 * A class for testing the User webservice API class
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_Api_XmlRpc_Zone extends Test_OA_Api_XmlRpc
{
    /**
     * @var int
     */
    var $zoneId;

    function setUp()
    {
		if (!$this->oApi) {
			return;
		}

		$oPublisher = new OA_Dll_PublisherInfo();
		$oPublisher->publisherName = 'test publisher';
		$publisherId = $this->oApi->addPublisher($oPublisher);

		$oZone = new OA_Dll_ZoneInfo();
		$oZone->zoneName = 'test zone';
		$oZone->publisherId = $publisherId;
		$oZone->width  = 468;
		$oZone->height = 60;
		$this->zoneId = $this->oApi->addZone($oZone);

		$this->assertTrue($this->zoneId);
    }

	function tearDown()
	{
		if (!$this->zoneId) {
			return;
		}

		$this->assertTrue($this->oApi->deleteZone($this->zoneId));
	}

	function testLinkUnlinkBanner()
	{
		if (!$this->zoneId) {
			return;
		}

		$this->expectError();
        $this->assertFalse($this->oApi->linkBanner(-1, -1));

		$this->expectError();
        $this->assertFalse($this->oApi->linkBanner($this->zoneId, -1));

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->width  = 468;
        $doBanners->height = 60;
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $this->assertTrue($bannerId);

        $this->assertTrue($this->oApi->linkBanner($this->zoneId, $bannerId));
        $this->assertTrue($this->oApi->unlinkBanner($this->zoneId, $bannerId));

        $this->expectError();
        $this->assertFalse($this->oApi->unlinkBanner($this->zoneId, $bannerId));

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->width  = 234;
        $doBanners->height = 60;
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $this->assertTrue($bannerId);

        $this->expectError();
        $this->assertFalse($this->oApi->linkBanner($this->zoneId, $bannerId));
	}

	function testLinkUnlinkCampaign()
	{
		if (!$this->zoneId) {
			return;
		}

		$this->expectError();
        $this->assertFalse($this->oApi->linkCampaign(-1, -1));

		$this->expectError();
        $this->assertFalse($this->oApi->linkCampaign($this->zoneId, -1));

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->width  = 468;
        $doBanners->height = 60;
        $bannerId = DataGenerator::generateOne($doBanners, true);
        $this->assertTrue($bannerId);

        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
        $campaignId = $doBanners->campaignid;

        $this->assertTrue($this->oApi->linkCampaign($this->zoneId, $campaignId));
        $this->assertTrue($this->oApi->unlinkCampaign($this->zoneId, $campaignId));

        $this->expectError();
        $this->assertFalse($this->oApi->unlinkCampaign($this->zoneId, $campaignId));
	}

	function testGenerateTags()
	{
		if (!$this->zoneId) {
			return;
		}

		TestEnv::uninstallPluginPackage('openXInvocationTags');
		TestEnv::installPluginPackage('openXInvocationTags');
		$this->expectError();
        $this->assertFalse($this->oApi->generateTags(-1, 'foo'));

		$this->expectError();
        $this->assertFalse($this->oApi->generateTags($this->zoneId, 'foo'));

        $tag1 = $this->oApi->generateTags($this->zoneId, 'adjs');
        $tag2 = $this->oApi->generateTags($this->zoneId, 'adjs', array('source' => 'x'));

        $this->assertTrue($tag1);
        $this->assertTrue($tag2);
        $this->assertNotEqual($tag1, $tag2);
		TestEnv::uninstallPluginPackage('openXInvocationTags');
	}
}

?>