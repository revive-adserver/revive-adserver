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
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * TODO: need data
     *
     */
    function test_MAX_adRender()
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

    function test_MAX_adRender_destMagicMacros()
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
    function test_adRenderImage()
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
    function test_adRenderHtml()
    {
        $this->sendMessage('test_adRenderHtml');

        $GLOBALS['_MAX']['CONF']['logging']['adImpressions'] = '';
        $GLOBALS['_MAX']['CONF']['delivery']['execPhp'] = TRUE;

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
    function test_adRenderText()
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
    function test_adRenderBuildFileUrl()
    {
        $this->sendMessage('test_adRenderBuildFileUrl');
        // Test1
        $aBanner = array('filename' => 'myfile.jpg',
            'alt_filename' => 'myaltfile.jpg',
            'imageurl' => 'http://www.somewhere.com/myimageurl.jpg',
            'type' => 'url',
            'contenttype' => ''
        );
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
    function test_adRenderBuildImageUrlPrefix()
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
    function test_adRenderBuildLogURL()
    {
        $this->sendMessage('test_adRenderBuildLogURL');

        require_once MAX_PATH . '/lib/max/Delivery/common.php';

        $aBanner = array(
            'ad_id' => '9999',
            'placement_id' => '111',
            'url' => 'http://www.somewhere.com',
            'contenttype' => ''
        );
        $zoneId = 1;
        $source = 'test';
        $loc = 'http://www.example.com/page.php?name=value';
        $referer = 'http://www.example.com/referer.php?name=value';
        $amp = '&amp;';
        $return = _adRenderBuildLogURL($aBanner, $zoneId, $source, $loc, $referer, $amp);
        $expect = "http://" . $GLOBALS['_MAX']['CONF']['webpath']['delivery'] . "/lg.php?bannerid=9999&amp;campaignid=111&amp;zoneid=1&amp;source=test&amp;loc=http%3A%2F%2Fwww.example.com%2Fpage.php%3Fname%3Dvalue&amp;referer=http%3A%2F%2Fwww.example.com%2Freferer.php%3Fname%3Dvalue&amp;cb={random}";
        $this->assertEqual($return, $expect);
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
    function test_adRenderImageBeacon()
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
    function test_adRenderBuildParams()
    {
        $this->sendMessage('test_adRenderBuildParams');
        $aBanner = array('bannerid' => '9999',
            'url' => 'http://www.somewhere.com',
            'contenttype' => ''
        );
        $zoneId = 0;
        $source = '';
        $ct0 = '';
        $logClick = true;
        $conf = $GLOBALS['_MAX']['CONF'];

        $ret = _adRenderBuildParams($aBanner, $zoneId, $source, $ct0, $logClick);
        $this->assertEqual($ret, "2__{$conf['var']['adId']}=9999__{$conf['var']['zoneId']}=0__{$conf['var']['cacheBuster']}={random}");


        $this->sendMessage('test_adRenderBuildParams');
        $aBanner = array('bannerid' => '9999',
            'url' => 'http://www.example.com/?foo+bar',
            'contenttype' => ''
        );
        $zoneId = 0;
        $source = '';
        $ct0 = '';
        $logClick = true;
        $conf = $GLOBALS['_MAX']['CONF'];

        $ret = _adRenderBuildParams($aBanner, $zoneId, $source, $ct0, $logClick);
        $this->assertEqual($ret, "2__{$conf['var']['adId']}=9999__{$conf['var']['zoneId']}=0__{$conf['var']['cacheBuster']}={random}");

        // Ignore ct0
        $this->sendMessage('test_adRenderBuildParams');
        $aBanner = array('bannerid' => '9999',
            'url' => 'http://www.example.com/?foo+bar',
            'contenttype' => ''
        );
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
    function test_adRenderBuildClickUrl()
    {
        $this->sendMessage('test_adRenderBuildClickUrl');

        // following line suggests that this func not used
        require_once MAX_PATH . '/lib/max/Delivery/common.php';

        $aBanner = [
            'bannerid' => '9999',
            'contenttype' => ''
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
            'contenttype' => ''
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
            'contenttype' => ''
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

    function test_adRenderBuildClickQueryString()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $this->sendMessage('test_adRenderBuildClickQueryString');

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
        $this->assertEqual($ret, "{$conf['var']['adId']}=123&{$conf['var']['zoneId']}=456&source=whatever&{$conf['var']['signature']}={$sig}&{$conf['var']['dest']}={$dest}");

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
        $this->assertEqual($ret, "{$conf['var']['adId']}=123&{$conf['var']['zoneId']}=456&source=whatever&{$conf['var']['signature']}={$sig}&{$conf['var']['dest']}={$dest}");
    }

    function test_adRenderBuildClickQueryStringWithTimestamp()
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


    function test_adRenderBuildSignedClickUrl()
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

        $clickUrl = MAX_commonGetDeliveryUrl($GLOBALS['_MAX']['CONF']['file']['signedClick'])."?{$conf['var']['adId']}=123&{$conf['var']['zoneId']}=456";

        $ret = _adRenderBuildSignedClickUrl($aBanner, $zoneId, $source);
        $this->assertEqual($ret, $clickUrl);

        $ct0 = 'https://thridparty.click.tracking/click?foo=1&bar=2&dest=';

        $ret = _adRenderBuildSignedClickUrl($aBanner, $zoneId, $source, $ct0);
        $this->assertEqual($ret, $ct0.urlencode($clickUrl));
    }
}
