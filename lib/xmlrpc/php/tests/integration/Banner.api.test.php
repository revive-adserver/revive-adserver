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
        $this->assertNotEqual($doImages->contents, $gif);
        $this->assertNotEqual($doImages->contents, $swf);
    }

}

?>