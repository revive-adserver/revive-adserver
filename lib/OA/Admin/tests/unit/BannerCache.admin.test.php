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


include_once MAX_PATH . '/www/admin/lib-banner.inc.php';

/**
 * A class for testing the rebuild banner cache code
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 */
class Test_OA_Admin_BannerCache extends UnitTestCase
{
    var $aBanners;

    function __construct()
    {
        parent::__construct();
    }

    function test_getBannerCache()
    {
        $this->aBanners[] = $this->_getBanner1();
        $this->aBanners[] = $this->_getBanner2();
        $this->aBanners[] = $this->_getBanner3();
        $this->aBanners[] = $this->_getBanner4();
        $this->aBanners[] = $this->_getBanner5();
        foreach ($this->aBanners AS $k => $aBanner)
        {
            $expected = $aBanner['expected'];
            $result = phpAds_getBannerCache($aBanner);
            $this->assertEqual($expected,$result);
        }
    }

    function _getBanner1()
    {
         $aBanner['bannerid'] = 1;
         $aBanner['active'] =  't';
         $aBanner['contenttype'] =  'png';
         $aBanner['storagetype'] = 'sql';
         $aBanner['filename'] = 'openads_468x60.png';
         $aBanner['imageurl'] = '';
         $aBanner['htmltemplate'] ='[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]<img src=\'{imageurl}\' width=\'{width}\' height=\'{height}\' alt=\'{alt}\' title=\'{alt}\' border=\'0\'[nourl][status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status][/nourl]>[targeturl]</a>[/targeturl][bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]';
         $aBanner['htmlcache'] ='';
         $aBanner['target'] = '_blank';
         $aBanner['url'] = 'http://www.openx.org/';
         $aBanner['adserver'] = '';
         $aBanner['expected'] = $aBanner['htmltemplate'];
         return $aBanner;
    }

    function _getBanner2()
    {
         $aBanner['bannerid'] = 2;
         $aBanner['active'] =  't';
         $aBanner['contenttype'] =  'html';
         $aBanner['storagetype'] = 'html';
         $aBanner['filename'] = '';
         $aBanner['imageurl'] = '';
         $aBanner['htmltemplate'] ='<a href=\'http://www.openx.org/download.html\' target=\'_blank\'>Download Openads</a>';
         $aBanner['htmlcache'] ='';
         $aBanner['target'] = '_new';
         $aBanner['url'] = 'http://www.openx.org';
         $aBanner['adserver'] = '';
         $aBanner['expected'] = "<a href='{clickurl_html}".urlencode('http://www.openx.org/download.html')."' target='{target}'>Download Openads</a>";
         return $aBanner;
    }

    function _getBanner3()
    {
         $aBanner['bannerid'] = 3;
         $aBanner['active'] =  't';
         $aBanner['contenttype'] =  'txt';
         $aBanner['storagetype'] = 'txt';
         $aBanner['filename'] = '';
         $aBanner['imageurl'] = '';
         $aBanner['htmltemplate'] = '[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl]';
         $aBanner['htmlcache'] = '';
         $aBanner['target'] = '_blank';
         $aBanner['url'] = 'http://www.openx.org/download.html';
         $aBanner['adserver'] = '';
         $aBanner['expected'] = $aBanner['htmltemplate'];
         return $aBanner;
    }

    function _getBanner4()
    {
         $aBanner['bannerid'] = 6;
         $aBanner['active'] =  't';
         $aBanner['contenttype'] =  'gif';
         $aBanner['storagetype'] = 'url';
         $aBanner['filename'] = '';
         $aBanner['imageurl'] = 'http://i.m3.net/m3_test_468x60.gif';
         $aBanner['htmltemplate'] ='[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]<img src=\'{imageurl}\' width=\'{width}\' height=\'{height}\' alt=\'{alt}\' title=\'{alt}\' border=\'0\'[nourl][status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status][/nourl]>[targeturl]</a>[/targeturl][bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]';
         $aBanner['htmlcache'] ='';
         $aBanner['target'] = '_blank';
         $aBanner['url'] = 'http://www.m3.net';
         $aBanner['adserver'] = '';
         $aBanner['expected'] = $aBanner['htmltemplate'];
         return $aBanner;
    }

    function _getBanner5()
    {
         $aBanner['bannerid'] = 7;
         $aBanner['active'] =  't';
         $aBanner['contenttype'] =  'html';
         $aBanner['storagetype'] = 'html';
         $aBanner['filename'] = '';
         $aBanner['imageurl'] = '';
         $aBanner['htmltemplate'] = '<a href="" target="">Click Here</a>';
         $aBanner['htmlcache'] ='';
         $aBanner['target'] = '_blank';
         $aBanner['url'] = 'http://www.openx.org/';
         $aBanner['adserver'] = 'fake';
         $aBanner['expected'] = "<a href=\"\" target=\"\">Click Here</a>";
         return $aBanner;
    }
}
