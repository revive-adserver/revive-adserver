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
 * A class for testing the Banner webservice API class
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_Api_XmlRpc_Banner extends Test_OA_Api_XmlRpc
{
    /**
     * @var int
     */
    var $campaignId;

    function setUp()
    {
		if (!$this->oApi) {
			return;
		}

		$oAdvertiser = new OA_Dll_AdvertiserInfo();
		$oAdvertiser->advertiserName = 'test advertiser';
		$advertiserId = $this->oApi->addAdvertiser($oAdvertiser);

		$oCampaign = new OA_Dll_CampaignInfo();
		$oCampaign->campaignName = 'test campaign';
		$oCampaign->advertiserId = $advertiserId;
		$this->campaignId = $this->oApi->addCampaign($oCampaign);

		$this->assertTrue($this->campaignId);
    }

    function testAddModify()
    {
        if (empty($this->campaignId)) {
            return;
        }

        $gif = "GIF89a\001\0\001\0\200\0\0\377\377\377\0\0\0!\371\004\0\0\0\0\0,\0\0\0\0\001\0\001\0\0\002\002D\001\0;";

        $oBanner = new OA_Dll_BannerInfo();
        $oBanner->bannerName  = 'test 1';
        $oBanner->campaignId  = $this->campaignId;
        $oBanner->storageType = 'sql';
        $oBanner->aImage = array(
            'filename' => '1x1.gif',
            'content'  => $gif
        );

        $bannerId = $this->oApi->addBanner($oBanner);

        $this->assertTrue($bannerId);

        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertTrue($doBanners->filename);

        $doImages  = OA_Dal::staticGetDO('images', $doBanners->filename);
        $this->assertEqual($doImages->contents, $gif);

        // Test modify
        $swf = file_get_contents(MAX_PATH . '/lib/OA/Creative/tests/data/swf-link.swf');
        $this->assertTrue($swf);
        $swfConv = file_get_contents(MAX_PATH . '/lib/OA/Creative/tests/data/converted-link.swf');
        $this->assertTrue($swfConv);

        $oBanner = new OA_Dll_BannerInfo();
        $oBanner->bannerId    = $bannerId;
        $oBanner->aImage = array(
            'filename' => 'test.swf',
            'content'  => $swf,
            'editswf'  => true
        );

        $this->assertTrue($this->oApi->modifyBanner($oBanner));

        $doBanners = OA_Dal::staticGetDO('banners', $bannerId);
        $this->assertTrue($doBanners->filename);

        $doImages  = OA_Dal::staticGetDO('images', $doBanners->filename);
        $this->assertTrue($doImages->contents);
        $this->assertEqual($doImages->contents, $swfConv);
    }

}

?>