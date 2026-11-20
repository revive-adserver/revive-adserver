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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';

class Test_BannerPreview extends UnitTestCase
{
    private $savedSession;

    public function setUp()
    {
        $this->savedSession = $GLOBALS['session'] ?? null;
        Language_Loader::load('default');
    }

    public function tearDown()
    {
        $GLOBALS['session'] = $this->savedSession;
        DataGenerator::cleanUp();
    }

    private function getFrame(string $html): DOMElement
    {
        $document = new DOMDocument();
        $document->loadHTML($html);
        $this->assertEqual($document->getElementsByTagName('iframe')->length, 1);
        $this->assertEqual($document->getElementsByTagName('script')->length, 0);

        return $document->getElementsByTagName('iframe')->item(0);
    }

    private function loginAs(string $accountType): void
    {
        $GLOBALS['session']['user'] = (object) ['aAccount' => ['account_type' => $accountType]];
    }

    public function testCreativeIsOnlyLoadedInsideSandbox()
    {
        $banner = OA_Dal::factoryDO('banners');
        $banner->description = "Preview '\"><script>parent.compromised = true</script>";
        $banner->storagetype = 'html';
        $banner->htmlcache = '<script>parent.compromised = true</script>';
        $banner->width = 468;
        $banner->height = 60;
        $bannerId = DataGenerator::generateOne($banner, true);

        $frame = $this->getFrame(MAX_bannerPreview($bannerId));
        $this->assertIdentical($frame->getAttribute('sandbox'), 'allow-scripts allow-popups allow-popups-to-escape-sandbox');
        $this->assertIdentical($frame->getAttribute('referrerpolicy'), 'no-referrer');
        $this->assertIdentical($frame->getAttribute('loading'), 'lazy');
        $this->assertIdentical($frame->getAttribute('src'), MAX::constructURL(MAX_URL_ADMIN, 'banner-preview.php?bannerid=' . $bannerId));
        $this->assertIdentical($frame->getAttribute('title'), $banner->description);
        $this->assertIdentical($frame->getAttribute('width'), '468');
        $this->assertIdentical($frame->getAttribute('height'), '60');
        $this->assertFalse($frame->hasAttribute('data-revive-preview-autosize'));
    }

    public function testFrameUsesAbsoluteAdminUrl()
    {
        $bannerId = DataGenerator::generateOne('banners', true);

        // Plugin pages live below www/admin/plugins/, so a relative URL would not resolve
        $src = $this->getFrame(MAX_bannerPreview($bannerId))->getAttribute('src');
        $this->assertPattern('#^https?://#', $src);
        $this->assertPattern('#/banner-preview\.php\?bannerid=' . $bannerId . '$#', $src);
    }

    public function testUnspecifiedDimensionsUsePreviewDefaultsAndAutosize()
    {
        foreach (['html' => 250, 'txt' => 100] as $type => $expectedHeight) {
            $banner = OA_Dal::factoryDO('banners');
            $banner->storagetype = $type;
            $banner->width = -1;
            $banner->height = -1;
            $bannerId = DataGenerator::generateOne($banner, true);

            $frame = $this->getFrame(MAX_bannerPreview($bannerId));
            $this->assertIdentical($frame->getAttribute('width'), '300');
            $this->assertIdentical($frame->getAttribute('height'), (string) $expectedHeight);
            $this->assertIdentical($frame->getAttribute('data-revive-preview-autosize'), '1');
        }
    }

    public function testPreviewSize()
    {
        $this->assertIdentical(MAX_bannerPreviewSize(['type' => 'html', 'width' => 728, 'height' => 90]), [728, 90, false]);
        $this->assertIdentical(MAX_bannerPreviewSize(['type' => 'html', 'width' => -1, 'height' => -1]), [300, 250, true]);
        $this->assertIdentical(MAX_bannerPreviewSize(['storagetype' => 'txt', 'width' => 0, 'height' => 0]), [300, 100, true]);
        $this->assertIdentical(MAX_bannerPreviewSize(['type' => 'html', 'width' => 728, 'height' => -1]), [728, 250, true]);
    }

    public function testPreviewWindowSize()
    {
        $this->assertIdentical(MAX_bannerPreviewWindowSize(['type' => 'html', 'width' => 468, 'height' => 60]), [532, 124]);
        $this->assertIdentical(MAX_bannerPreviewWindowSize(['type' => 'web', 'width' => 468, 'height' => 60, 'bannertext' => 'Below']), [532, 150]);
        // Unspecified size, e.g. VAST video banners: no more tiny 61x61 windows
        $this->assertIdentical(MAX_bannerPreviewWindowSize(['type' => 'html', 'width' => -3, 'height' => -3]), [364, 314]);
        $this->assertIdentical(MAX_bannerPreviewWindowSize(['storagetype' => 'txt', 'width' => 0, 'height' => 0]), [364, 164]);
    }

    public function testPreloadedBannerRowIsUsed()
    {
        // DataObject format, as used by campaign-banners.php; the banner doesn't exist in the database
        $aRow = [
            'bannerid' => 99999998,
            'campaignid' => 1,
            'description' => 'From the row',
            'alt' => '',
            'type' => 'html',
            'width' => 120,
            'height' => 600,
        ];

        $frame = $this->getFrame(MAX_bannerPreview($aRow['bannerid'], $aRow, false));
        $this->assertPattern('#bannerid=99999998$#', $frame->getAttribute('src'));
        $this->assertIdentical($frame->getAttribute('title'), 'From the row');
        $this->assertIdentical($frame->getAttribute('width'), '120');
        $this->assertIdentical($frame->getAttribute('height'), '600');
    }

    public function testTitleFallsBackToAltAndUntitled()
    {
        $aRow = ['ad_id' => 1, 'name' => '', 'alt' => 'Alt text', 'type' => 'html', 'width' => 1, 'height' => 1];
        $this->assertIdentical($this->getFrame(MAX_bannerPreview(1, $aRow, false))->getAttribute('title'), 'Alt text');

        $aRow['alt'] = '';
        $this->assertIdentical($this->getFrame(MAX_bannerPreview(1, $aRow, false))->getAttribute('title'), $GLOBALS['strUntitled']);
    }

    public function testAnonymousCampaignHidesBannerName()
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->anonymous = 't';
        $campaignId = DataGenerator::generateOne($doCampaigns, true);

        $banner = OA_Dal::factoryDO('banners');
        $banner->campaignid = $campaignId;
        $banner->description = 'Secret banner name';
        $bannerId = DataGenerator::generateOne($banner);

        $this->loginAs(OA_ACCOUNT_ADVERTISER);
        // Campaign looked up by the preview, and passed in by the caller
        foreach ([null, true] as $anonymous) {
            $html = MAX_bannerPreview($bannerId, null, $anonymous);
            $this->assertNoPattern('/Secret banner name/', $html);
            $this->assertIdentical($this->getFrame($html)->getAttribute('title'), $GLOBALS['strHiddenAd'] . ' ' . $bannerId);
        }

        $this->loginAs(OA_ACCOUNT_MANAGER);
        $this->assertIdentical($this->getFrame(MAX_bannerPreview($bannerId))->getAttribute('title'), 'Secret banner name');
    }

    public function testPreviewLink()
    {
        $aRow = ['ad_id' => 42, 'name' => 'x', 'type' => 'html', 'width' => -3, 'height' => -3];
        $document = new DOMDocument();
        $document->loadHTML(MAX_bannerPreviewLink(42, $aRow));
        $this->assertEqual($document->getElementsByTagName('iframe')->length, 0);
        $link = $document->getElementsByTagName('a')->item(0);
        $this->assertIdentical($link->getAttribute('href'), 'banner-htmlpreview.php?bannerid=42');
        $this->assertIdentical($link->textContent, $GLOBALS['strShowBanner']);
        $this->assertPattern('/width=364,height=314/', $link->getAttribute('onclick'));
    }

    public function testMissingBannerHasNoPreview()
    {
        $this->assertIdentical(MAX_bannerPreview(99999999), '');
        $this->assertIdentical(MAX_bannerPreviewLink(99999999), '');
    }
}
