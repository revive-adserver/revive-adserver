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

require_once MAX_PATH . '/lib/max/Delivery/adRender.php';

/**
 * A class for testing the ad.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 *
 */
class Test_DeliveryAdRender extends UnitTestCase
{
    /**
     * TODO: need data
     *
     */
    public function test_MAX_adRender()
    {
        //		$this->sendMessage('test_MAX_adRender');

        //		require_once MAX_PATH . '/lib/max/Delivery/common.php';
        // note: following code to extract test data from db
        //      require_once MAX_PATH . '/lib/max/Delivery/tests/data/test_adRenderImage.php';
        //	    $return = _adRenderImage($aBanner, $zoneId, $source, $target, $ct0, $withText, $logClick, $logView, $richMedia, $loc, $referer, $context);
        //		$this->assertEqual($return, $result);

        // Silly test, test patch OX-2091
        require MAX_PATH . '/lib/max/Delivery/tests/data/test_adRenderImage.php';

        $this->assertFalse(isset($aBanner['bannerContent']));
        $this->assertFalse(isset($aBanner['logUrl']));
        $this->assertFalse(isset($aBanner['clickUrl']));

        $return = MAX_adRender($aBanner);

        $this->assertTrue($aBanner['bannerContent']);
        $this->assertTrue($aBanner['logUrl']);
        $this->assertTrue($aBanner['clickUrl']);
    }

    public function test_MAX_adRender_destMagicMacros()
    {
        require MAX_PATH . '/lib/max/Delivery/tests/data/test_adRenderImage.php';

        $aBanner['url'] .= '/?foo={foo}';
        $_REQUEST['foo'] = 'bar';
        $return = MAX_adRender($aBanner);

        $this->assertPattern('#foo%3Dbar#', $aBanner['clickUrl']);
    }

    /**
     * render an ad of type image
     *
     */
    public function test_adRenderImage()
    {
        $this->sendMessage('test_adRenderImage');

        require_once MAX_PATH . '/lib/max/Delivery/common.php';

        // note: following code to extract test data from db
        // require_once MAX_PATH . '/lib/OA/Dal/Delivery/'.$GLOBALS['_MAX']['CONF']['database']['type'].'.php';
        // OA_Dal_Delivery_connect();
        // $aBanner = (array)OA_Dal_Delivery_getAd(7);
        // $prn    = print_r($aBanner, TRUE);

        require MAX_PATH . '/lib/max/Delivery/tests/data/test_adRenderImage.php';

        $return = _adRenderImage($aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $richMedia, $loc, $referer, $useAppend);
        $this->assertEqual($return, $expect);
    }

    /**
     * @todo further test cases:
     *     presence of individual elements;
     *     processed HTML e.g. macro replacements {clickurl};
     *     logging beacon
     *
     * render an ad of type HTML
     *
     */
    public function test_adRenderHtml()
    {
        $this->sendMessage('test_adRenderHtml');

        $GLOBALS['_MAX']['CONF']['logging']['adImpressions'] = '';

        require_once MAX_PATH . '/lib/max/Delivery/tests/data/test_adRenderHtml.php';
        $ret = _adRenderHtml($aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $loc, $referer);
        $this->assertEqual($ret, $expect);
    }

    /**
     * @todo test for append & prepend
     *
     * render an ad of type Text
     *
     */
    public function test_adRenderText()
    {
        $this->sendMessage('test_adRenderText');
        // Test that it should generate ad without beacon
        $GLOBALS['_MAX']['CONF']['logging']['adImpressions'] = '';
        require_once MAX_PATH . '/lib/max/Delivery/tests/data/test_adRenderText.php';
        $return = _adRenderText($aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $richMedia, $loc, $referer);
        $this->assertEqual($return, $expectNoBeacon);

        // Test that it should generate ad beacon
        $GLOBALS['_MAX']['CONF']['logging']['adImpressions'] = true;
        require_once MAX_PATH . '/lib/max/Delivery/tests/data/test_adRenderText.php';
        $return = _adRenderText($aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $richMedia, $loc, $referer);
        $this->assertEqual($return, $expect);
    }

    /**
     * Test1: external image with no params and not using alt image
     * Test2: local image with no params and not using alt image
     * Test3: local image with no params and using alt image
     * Test4: local image with params and not using alt image
     *
     * build a file URL
     *
     */
    public function test_adRenderBuildFileUrl()
    {
        $this->sendMessage('test_adRenderBuildFileUrl');
        // Test1
        $aBanner = ['filename' => 'myfile.jpg',
            'alt_filename' => 'myaltfile.jpg',
            'imageurl' => 'http://www.somewhere.com/myimageurl.jpg',
            'type' => 'url',
            'contenttype' => '',
        ];
        $useAlt = false;
        $params = '';
        $ret = _adRenderBuildFileUrl($aBanner, $useAlt, $params);
        $this->assertEqual($ret, 'http://www.somewhere.com/myimageurl.jpg');
        // Test2
        $aBanner['type'] = 'web';
        $useAlt = false;
        $params = '';
        $GLOBALS['_MAX']['CONF']['webpath']['images'] = 'www.max.net/www/images';
        $ret = _adRenderBuildFileUrl($aBanner, $useAlt, $params);
        $this->assertEqual($ret, 'http://www.max.net/www/images/myfile.jpg');
        // Test3
        $useAlt = true;
        $params = '';
        $ret = _adRenderBuildFileUrl($aBanner, $useAlt, $params);
        $this->assertEqual($ret, 'http://www.max.net/www/images/myaltfile.jpg');
        // Test4
        $useAlt = false;
        $params = 'a=1&b=2';
        $ret = _adRenderBuildFileUrl($aBanner, $useAlt, $params);
        $this->assertEqual($ret, 'http://www.max.net/www/images/myfile.jpg?a=1&b=2');
    }

    /**
     * build an image URL prefix
     *
     */
    public function test_adRenderBuildImageUrlPrefix()
    {
        $this->sendMessage('test_adGetImageUrlPrefix');

        $GLOBALS['_MAX']['CONF']['webpath']['images'] = 'www.max.net/www/images';
        $ret = _adRenderBuildImageUrlPrefix();
        $this->assertEqual($ret, 'http://www.max.net/www/images');
    }

    /**
     * build a log URL
     *
     */
    public function test_adRenderBuildLogURL()
    {
        $this->sendMessage('test_adRenderBuildLogURL');

        require_once MAX_PATH . '/lib/max/Delivery/common.php';

        $aBanner = [
            'ad_id' => '9999',
            'placement_id' => '111',
            'url' => 'http://www.somewhere.com',
            'contenttype' => '',
        ];
        $zoneId = 1;
        $source = 'test';
        $loc = 'http://www.example.com/page.php?name=value';
        $referer = 'http://www.example.com/referer.php?name=value';
        $amp = '&amp;';
        $return = _adRenderBuildLogURL($aBanner, $zoneId, $source, $loc, $referer, $amp);
        $expect = "http://" . $GLOBALS['_MAX']['CONF']['webpath']['delivery'] . "/lg.php?bannerid=9999&amp;campaignid=111&amp;zoneid=1&amp;source=test&amp;loc=http%3A%2F%2Fwww.example.com%2Fpage.php%3Fname%3Dvalue&amp;referer=http%3A%2F%2Fwww.example.com%2Freferer.php%3Fname%3Dvalue&amp;cb={random}";
        $this->assertTrue(str_starts_with($return, $expect . '&amp;'));
        parse_str(str_replace('&amp;', '&', explode('?', $return, 2)[1]), $params);
        $previousGet = $_GET;
        $_GET = $params;
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->assertTrue(OX_Delivery_Common_checkLogSignature($params[$conf['var']['adId']], $params[$conf['var']['zoneId']]));
        $_GET = $previousGet;
    }

    public function test_adRenderBuildLogURLWithSignature()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $previousSecret = $conf['delivery']['secret'] ?? null;
        $previousValidity = $conf['delivery']['logUrlValidity'] ?? null;
        $previousNow = $GLOBALS['_MAX']['NOW'] ?? null;
        $previousGet = $_GET;
        $check = static function (array $params) use (&$conf): bool {
            $_GET = $params;
            return OX_Delivery_Common_checkLogSignature($params[$conf['var']['adId']], $params[$conf['var']['zoneId']]);
        };
        $conf['delivery']['secret'] = base64_encode('test-delivery-secret');
        $conf['delivery']['logUrlValidity'] = 0;
        $GLOBALS['_MAX']['NOW'] = 1600000000;

        foreach (['&', '&amp;'] as $amp) {
            $url = _adRenderBuildLogURL([
                'ad_id' => 123,
                'placement_id' => 456,
            ], 789, '', '', '', $amp);
            parse_str(str_replace('&amp;', '&', explode('?', $url, 2)[1]), $params);

            $this->assertFalse(isset($params[$conf['var']['timestamp']]));
            $this->assertTrue($check($params));
            $changed = $params;
            $changed[$conf['var']['creativeId']] = '1';
            $this->assertTrue($check($changed));
            $GLOBALS['_MAX']['NOW'] += 3600;
            $this->assertTrue($check($params));
            $GLOBALS['_MAX']['NOW'] = 1600000000;
        }

        $conf['delivery']['logUrlValidity'] = 60;
        $url = _adRenderBuildLogURL(['ad_id' => 123, 'placement_id' => 456], 789, '', '', '', '&');
        parse_str(explode('?', $url, 2)[1], $params);
        $this->assertEqual($params[$conf['var']['timestamp']], '1600000000');
        $this->assertTrue($check($params));
        $this->assertFalse(hash_equals(
            $params[$conf['var']['signature']],
            OX_Delivery_Common_getSignature([123, 789], $params[$conf['var']['timestamp']]),
        ));
        $GLOBALS['_MAX']['NOW'] += 61;
        $this->assertFalse($check($params));

        $_GET = $previousGet;
        $conf['delivery']['secret'] = $previousSecret;
        if ($previousValidity === null) {
            unset($conf['delivery']['logUrlValidity']);
        } else {
            $conf['delivery']['logUrlValidity'] = $previousValidity;
        }
        if ($previousNow === null) {
            unset($GLOBALS['_MAX']['NOW']);
        } else {
            $GLOBALS['_MAX']['NOW'] = $previousNow;
        }
    }

    public function test_adRenderBuildChainedTrackingFlags()
    {
        require_once MAX_PATH . '/lib/max/Delivery/common.php';

        $hadChain = array_key_exists('adChain', $GLOBALS['_MAX']);
        $previousChain = $GLOBALS['_MAX']['adChain'] ?? null;
        $previousDelimiter = $GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'] ?? null;
        $GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'] = '|';
        $GLOBALS['_MAX']['adChain'] = [
            [
                'ad_id' => 200, 'bannerid' => 200, 'placement_id' => 20, 'zoneid' => 2,
                'block_ad' => '', 'cap_ad' => '', 'session_cap_ad' => '',
                'block_campaign' => '', 'cap_campaign' => '', 'session_cap_campaign' => '',
                'block_zone' => '', 'cap_zone' => '', 'session_cap_zone' => '',
                'viewwindow' => false, 'tracker_status' => true, 'clickwindow' => false,
            ],
            [
                'ad_id' => 300, 'bannerid' => 300, 'placement_id' => 30, 'zoneid' => 3,
                'block_ad' => '', 'cap_ad' => '', 'session_cap_ad' => '',
                'block_campaign' => '', 'cap_campaign' => '', 'session_cap_campaign' => '',
                'block_zone' => '', 'cap_zone' => '', 'session_cap_zone' => '',
                'viewwindow' => true, 'tracker_status' => true, 'clickwindow' => true,
            ],
        ];

        $banner = [
            'ad_id' => 100, 'bannerid' => 100, 'placement_id' => 10, 'url' => 'https://example.test/',
            'block_ad' => '', 'cap_ad' => '', 'session_cap_ad' => '',
            'block_campaign' => '', 'cap_campaign' => '', 'session_cap_campaign' => '',
            'block_zone' => '', 'cap_zone' => '', 'session_cap_zone' => '',
            'viewwindow' => true, 'tracker_status' => true, 'clickwindow' => true,
        ];

        $logUrl = _adRenderBuildLogURL($banner, 1, '', '', '', '&');
        $this->assertPattern('/' . preg_quote($GLOBALS['_MAX']['CONF']['var']['lastView'] . '=1|0|1', '/') . '/', $logUrl);

        $clickBanner = $banner;
        unset($clickBanner['url']);
        $clickQuery = _adRenderBuildClickQueryString($clickBanner, 1);
        parse_str($clickQuery, $clickParams);
        $this->assertEqual($clickParams[$GLOBALS['_MAX']['CONF']['var']['lastClick']], '1|0|1');

        $params = _adRenderBuildParams($banner, 1);
        $this->assertPattern('/__' . preg_quote($GLOBALS['_MAX']['CONF']['var']['lastClick'], '/') . '=1\|0\|1/', $params);

        if ($hadChain) {
            $GLOBALS['_MAX']['adChain'] = $previousChain;
        } else {
            unset($GLOBALS['_MAX']['adChain']);
        }
        if ($previousDelimiter === null) {
            unset($GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER']);
        } else {
            $GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'] = $previousDelimiter;
        }
    }

    /**
     * @todo more test cases
     *     referer
     *     loc
     *     zoneid
     *     capping info
     *
     * render an image beacon
     *
     */
    public function test_adRenderImageBeacon()
    {
        $this->sendMessage('test_adRenderImageBeacon');

        require_once MAX_PATH . '/lib/max/Delivery/common.php';
        require_once MAX_PATH . '/lib/max/Delivery/tests/data/test_adRenderImageBeacon.php';

        $return = _adRenderImageBeacon($aBanner, $zoneId, $source, $loc, $referer);

        // break known structure into array of individual elements
        $i = preg_match_all('/' . $aPattern['struct'] . '/U', $return, $aMatch);
        $this->assertTrue($i, 'structure');
    }

    /**
     * build params
     *
     */
    public function test_adRenderBuildParams()
    {
        $this->sendMessage('test_adRenderBuildParams');
        $aBanner = ['bannerid' => '9999',
            'url' => 'http://www.somewhere.com',
            'contenttype' => '',
        ];
        $zoneId = 0;
        $source = '';
        $ct0 = '';
        $logClick = true;
        $conf = $GLOBALS['_MAX']['CONF'];

        $ret = _adRenderBuildParams($aBanner, $zoneId, $source, $ct0, $logClick);
        $this->assertEqual($ret, "2__{$conf['var']['adId']}=9999__{$conf['var']['zoneId']}=0__{$conf['var']['cacheBuster']}={random}");


        $this->sendMessage('test_adRenderBuildParams');
        $aBanner = ['bannerid' => '9999',
            'url' => 'http://www.example.com/?foo+bar',
            'contenttype' => '',
        ];
        $zoneId = 0;
        $source = '';
        $ct0 = '';
        $logClick = true;
        $conf = $GLOBALS['_MAX']['CONF'];

        $ret = _adRenderBuildParams($aBanner, $zoneId, $source, $ct0, $logClick);
        $this->assertEqual($ret, "2__{$conf['var']['adId']}=9999__{$conf['var']['zoneId']}=0__{$conf['var']['cacheBuster']}={random}");

        // Ignore ct0
        $this->sendMessage('test_adRenderBuildParams');
        $aBanner = ['bannerid' => '9999',
            'url' => 'http://www.example.com/?foo+bar',
            'contenttype' => '',
        ];
        $zoneId = 0;
        $source = '';
        $ct0 = 'http://www.openx.org/ck.php?foo=bar&dest=';
        $logClick = true;
        $conf = $GLOBALS['_MAX']['CONF'];

        $ret = _adRenderBuildParams($aBanner, $zoneId, $source, $ct0, $logClick);
        $this->assertEqual($ret, "2__{$conf['var']['adId']}=9999__{$conf['var']['zoneId']}=0__{$conf['var']['cacheBuster']}={random}");
    }

    /**
     * build click URL
     *
     */
    public function test_adRenderBuildClickUrl()
    {
        $this->sendMessage('test_adRenderBuildClickUrl');

        // following line suggests that this func not used
        require_once MAX_PATH . '/lib/max/Delivery/common.php';

        $aBanner = [
            'bannerid' => '9999',
            'contenttype' => '',
        ];
        $zoneId = 0;
        $source = '';
        $ct0 = '';
        $logClick = true;
        $conf = $GLOBALS['_MAX']['CONF'];
        $overrideDest = false;

        $ret = _adRenderBuildClickUrl($aBanner, $zoneId, $source, $ct0, $logClick, $overrideDest);
        $this->assertEqual($ret, "");

        $aBanner = [
            'bannerid' => '9999',
            'contenttype' => '',
        ];
        $zoneId = 0;
        $source = '';
        $ct0 = '';
        $logClick = true;
        $conf = $GLOBALS['_MAX']['CONF'];
        $overrideDest = true;

        $ret = _adRenderBuildClickUrl($aBanner, $zoneId, $source, $ct0, $logClick, $overrideDest);
        $this->assertEqual($ret, "http://{$GLOBALS['_MAX']['CONF']['webpath']['delivery']}/ck.php?{$conf['var']['params']}=2__{$conf['var']['adId']}=9999__{$conf['var']['zoneId']}=0__{$conf['var']['cacheBuster']}={random}");

        $aBanner = [
            'bannerid' => '9999',
            'url' => 'http://www.somewhere.com',
            'contenttype' => '',
        ];
        $zoneId = 0;
        $source = '';
        $ct0 = '';
        $logClick = true;
        $conf = $GLOBALS['_MAX']['CONF'];
        $overrideDest = false;

        $ret = _adRenderBuildClickUrl($aBanner, $zoneId, $source, $ct0, $logClick, $overrideDest);
        $this->assertEqual($ret, "http://{$GLOBALS['_MAX']['CONF']['webpath']['delivery']}/ck.php?{$conf['var']['params']}=2__{$conf['var']['adId']}=9999__{$conf['var']['zoneId']}=0__{$conf['var']['cacheBuster']}={random}");
    }

    public function test_adRenderBuildClickQueryString()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $this->sendMessage('test_adRenderBuildClickQueryString');

        // Also test that plugin hook addUrlParams is called
        $GLOBALS['_MAX']['CONF']['deliveryHooks']['addUrlParams'] = 'test:fake';

        function Plugin_test_fake_Delivery_addUrlParams($aAd)
        {
            return ['add' => 'url'];
        }

        $GLOBALS['_MAX']['CONF']['delivery']['secret'] = base64_encode('foobar');

        $aBanner = [
            'bannerid' => '123',
            'url' => 'http://www.example.com/{foo}/',
            'aMagicMacros' => [
                '{foo}' => 'bar',
            ],
        ];
        $zoneId = 456;
        $source = 'whatever';
        $logClick = true;
        $customDest = null;

        $sig = '04ab096c87353cde0ff112949728034bc8d4123ce6a36893135468db9b330a83';
        $dest = urlencode('http://www.example.com/bar/');

        $ret = _adRenderBuildClickQueryString($aBanner, $zoneId, $source, $logClick, $customDest);
        $this->assertEqual($ret, "{$conf['var']['adId']}=123&{$conf['var']['zoneId']}=456&source=whatever&add=url&{$conf['var']['signature']}={$sig}&{$conf['var']['dest']}={$dest}");

        $aBanner = [
            'bannerid' => '123',
            'aMagicMacros' => [
                '{foo}' => 'bar',
            ],
        ];
        $zoneId = 456;
        $source = 'whatever';
        $logClick = true;
        $customDest = 'http://www.example.com/{foo}/';

        $sig = '04ab096c87353cde0ff112949728034bc8d4123ce6a36893135468db9b330a83';
        $dest = urlencode('http://www.example.com/bar/');

        $ret = _adRenderBuildClickQueryString($aBanner, $zoneId, $source, $logClick, $customDest);
        $this->assertEqual($ret, "{$conf['var']['adId']}=123&{$conf['var']['zoneId']}=456&source=whatever&add=url&{$conf['var']['signature']}={$sig}&{$conf['var']['dest']}={$dest}");

        unset($GLOBALS['_MAX']['CONF']['deliveryHooks']['addUrlParams']);
    }

    public function test_adRenderBuildClickQueryStringWithTimestamp()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $this->sendMessage('test_adRenderBuildClickQueryStringWithTimestamp');

        $GLOBALS['_MAX']['CONF']['delivery']['secret'] = base64_encode('foobar');

        $GLOBALS['_MAX']['NOW'] = gmmktime(10, 0, 0, 2021, 1, 1);

        $aBanner = [
            'bannerid' => '123',
        ];
        $zoneId = 456;
        $source = 'whatever';
        $logClick = true;
        $customDest = null;

        $ret = _adRenderBuildClickQueryString($aBanner, $zoneId, $source, $logClick, $customDest);
        $this->assertEqual($ret, "{$conf['var']['adId']}=123&{$conf['var']['zoneId']}=456&source=whatever");

        $GLOBALS['_MAX']['CONF']['delivery']['clickUrlValidity'] = 100;

        $sig = '708082fb90b7f3ce7f96b13c7f4f1e69f05e6c3d8de86b6b5077071113fc63e4';

        $ret = _adRenderBuildClickQueryString($aBanner, $zoneId, $source, $logClick, $customDest);
        $this->assertEqual($ret, "{$conf['var']['adId']}=123&{$conf['var']['zoneId']}=456&source=whatever&{$conf['var']['timestamp']}={$GLOBALS['_MAX']['NOW'] }&{$conf['var']['signature']}={$sig}&{$conf['var']['dest']}=");
    }


    public function test_adRenderBuildSignedClickUrl()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $this->sendMessage('test_adRenderBuildSignedClickUrl');

        $GLOBALS['_MAX']['CONF']['delivery']['secret'] = base64_encode('foobar');
        $GLOBALS['_MAX']['CONF']['delivery']['clickUrlValidity'] = 0;

        $GLOBALS['_MAX']['NOW'] = gmmktime(10, 0, 0, 2021, 1, 1);

        $aBanner = [
            'bannerid' => '123',
        ];
        $zoneId = 456;
        $source = '';
        $ct0 = null;

        $clickUrl = MAX_commonGetDeliveryUrl($GLOBALS['_MAX']['CONF']['file']['signedClick']) . "?{$conf['var']['adId']}=123&{$conf['var']['zoneId']}=456";

        $ret = _adRenderBuildSignedClickUrl($aBanner, $zoneId, $source);
        $this->assertEqual($ret, $clickUrl);

        $ct0 = 'https://thridparty.click.tracking/click?foo=1&bar=2&dest=';

        $ret = _adRenderBuildSignedClickUrl($aBanner, $zoneId, $source, $ct0);
        $this->assertEqual($ret, $ct0 . urlencode($clickUrl));
    }
}
