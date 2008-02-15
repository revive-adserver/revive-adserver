<?php

/*
+---------------------------------------------------------------------------+
| OpenX v2.3                                                              |
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
$Id $
*/


include_once MAX_PATH . '/www/admin/lib-banner.inc.php';

/**
 * A class for testing the rebuild banner cache code
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 * @author
 */
class Test_OA_Admin_BannerCache extends UnitTestCase
{
    var $aBanners;

    function Test_OA_Admin_BannerCache()
    {
        $this->UnitTestCase();
        $this->aBanners[] = $this->_getBanner1();
        $this->aBanners[] = $this->_getBanner2();
        $this->aBanners[] = $this->_getBanner3();
        $this->aBanners[] = $this->_getBanner4();
        $this->aBanners[] = $this->_getBanner5();
        $this->aBanners[] = $this->_getBanner6();
        $this->aBanners[] = $this->_getBanner7();
    }

    function test_getBannerCache()
    {
        $GLOBALS['_MAX']['PREF']['auto_alter_html_banners_for_click_tracking'] = true;

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
         $aBanner['autohtml'] =  't';
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
         $aBanner['autohtml'] =  't';
         $aBanner['storagetype'] = 'html';
         $aBanner['filename'] = '';
         $aBanner['imageurl'] = '';
         $aBanner['htmltemplate'] ='<a href=\'http://www.openx.org/download.html\' target=\'_blank\'>Download Openads</a>';
         $aBanner['htmlcache'] ='';
         $aBanner['target'] = '_new';
         $aBanner['url'] = 'http://www.openx.org';
         $aBanner['adserver'] = '';
         $aBanner['expected'] = "<a href='{clickurl}http://www.openx.org/download.html'  target='{target}'>Download Openads</a>";
         return $aBanner;
    }

    function _getBanner3()
    {
         $aBanner['bannerid'] = 3;
         $aBanner['active'] =  't';
         $aBanner['contenttype'] =  'txt';
         $aBanner['autohtml'] =  't';
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
         $aBanner['bannerid'] = 4;
         $aBanner['active'] =  't';
         $aBanner['contenttype'] =  'swf';
         $aBanner['autohtml'] =  't';
         $aBanner['storagetype'] = 'sql';
         $aBanner['filename'] = 'openads_468x60-hard-coded_3.swf';
         $aBanner['imageurl'] = '';
         $aBanner['htmltemplate'] ='<object classid=\'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\' codebase=\'http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version={pluginversion:4;0;0;0}\' width=\'{width}\' height=\'{height}\'><param name=\'movie\' value=\'{imageurl}{swf_con}{swf_param}\'><param name=\'quality\' value=\'high\'><param name=\'allowScriptAccess\' value=\'always\'>[transparent]<param name=\'wmode\' value=\'transparent\'>[/transparent]<embed src=\'{imageurl}{swf_con}{swf_param}\' quality=high [transparent]wmode=\'transparent\' [/transparent]width=\'{width}\' height=\'{height}\' type=\'application/x-shockwave-flash\' pluginspace=\'http://www.adobe.com/go/getflashplayer\' allowScriptAccess=\'always\'></embed></object>[bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]';
         $aBanner['htmlcache'] ='';
         $aBanner['target'] = '_blank';
         $aBanner['url'] = 'http://www.openx.org/';
         $aBanner['adserver'] = '';
         $aBanner['expected'] = $aBanner['htmltemplate'];
         return $aBanner;
    }

    function _getBanner5()
    {
         $aBanner['bannerid'] = 5;
         $aBanner['active'] =  't';
         $aBanner['contenttype'] =  'swf';
         $aBanner['autohtml'] =  't';
         $aBanner['storagetype'] = 'url';
         $aBanner['filename'] = '';
         $aBanner['imageurl'] = 'http://www.unanimis.co.uk/templates/unanimis_yb_new/images/intro.swf';
         $aBanner['htmltemplate'] ='<object classid=\'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\' codebase=\'http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version={pluginversion:4;0;0;0}\' width=\'{width}\' height=\'{height}\'><param name=\'movie\' value=\'{imageurl}{swf_con}{swf_param}\'><param name=\'quality\' value=\'high\'><param name=\'allowScriptAccess\' value=\'always\'>[transparent]<param name=\'wmode\' value=\'transparent\'>[/transparent]<embed src=\'{imageurl}{swf_con}{swf_param}\' quality=high [transparent]wmode=\'transparent\' [/transparent]width=\'{width}\' height=\'{height}\' type=\'application/x-shockwave-flash\' pluginspace=\'http://www.adobe.com/go/getflashplayer\' allowScriptAccess=\'always\'></embed></object>[bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]';
         $aBanner['htmlcache'] ='';
         $aBanner['target'] = '_blank';
         $aBanner['url'] = 'http://www.openx.org';
         $aBanner['adserver'] = '';
         $aBanner['expected'] = $aBanner['htmltemplate'];
         return $aBanner;
    }

    function _getBanner6()
    {
         $aBanner['bannerid'] = 6;
         $aBanner['active'] =  't';
         $aBanner['contenttype'] =  'gif';
         $aBanner['autohtml'] =  't';
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

    function _getBanner7()
    {
         $aBanner['bannerid'] = 7;
         $aBanner['active'] =  't';
         $aBanner['contenttype'] =  'html';
         $aBanner['autohtml'] =  't';
         $aBanner['storagetype'] = 'html';
         $aBanner['filename'] = '';
         $aBanner['imageurl'] = '';
         $aBanner['htmltemplate'] = '<a href="" target="">Click Here</a>';
         $aBanner['htmlcache'] ='';
         $aBanner['target'] = '_blank';
         $aBanner['url'] = 'http://www.openx.org/';
         $aBanner['adserver'] = 'fake';
         $aBanner['expected'] = "<a href=\"\" >Click Here</a>";
         return $aBanner;
    }
}

/*
*************************** 1. row ***************************
    bannerid: 1
htmltemplate: [targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]<img src=\'{imageurl}\' width=\'{width}\' height=\'{height}\' alt=\'{alt}\' title=\'{alt}\' border=\'0\'[nourl][status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status][/nourl]>[targeturl]</a>[/targeturl][bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]
   htmlcache: [targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]<img src=\'{imageurl}\' width=\'{width}\' height=\'{height}\' alt=\'{alt}\' title=\'{alt}\' border=\'0\'[nourl][status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status][/nourl]>[targeturl]</a>[/targeturl][bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]
*************************** 2. row ***************************
    bannerid: 2
htmltemplate: <a href=\'http://www.openx.org/download.html\' target=\'_blank\'>Download Openads</a>
   htmlcache: <a href=\'{clickurl}http://www.openx.org/download.html\'  target=\'{target}\'>Download Openads</a>
*************************** 3. row ***************************
    bannerid: 3
htmltemplate: [targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl]
   htmlcache: [targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl]
*************************** 4. row ***************************
    bannerid: 4
htmltemplate: <object classid=\'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\' codebase=\'http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version={pluginversion:4,0,0,0}\' width=\'{width}\' height=\'{height}\'><param name=\'movie\' value=\'{imageurl}{swf_con}{swf_param}\'><param name=\'quality\' value=\'high\'><param name=\'allowScriptAccess\' value=\'always\'>[transparent]<param name=\'wmode\' value=\'transparent\'>[/transparent]<embed src=\'{imageurl}{swf_con}{swf_param}\' quality=high [transparent]wmode=\'transparent\' [/transparent]width=\'{width}\' height=\'{height}\' type=\'application/x-shockwave-flash\' pluginspace=\'http://www.adobe.com/go/getflashplayer\' allowScriptAccess=\'always\'></embed></object>[bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]
   htmlcache: <object classid=\'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\' codebase=\'http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version={pluginversion:4,0,0,0}\' width=\'{width}\' height=\'{height}\'><param name=\'movie\' value=\'{imageurl}{swf_con}{swf_param}\'><param name=\'quality\' value=\'high\'><param name=\'allowScriptAccess\' value=\'always\'>[transparent]<param name=\'wmode\' value=\'transparent\'>[/transparent]<embed src=\'{imageurl}{swf_con}{swf_param}\' quality=high [transparent]wmode=\'transparent\' [/transparent]width=\'{width}\' height=\'{height}\' type=\'application/x-shockwave-flash\' pluginspace=\'http://www.adobe.com/go/getflashplayer\' allowScriptAccess=\'always\'></embed></object>[bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]
*************************** 5. row ***************************
    bannerid: 5
htmltemplate: <object classid=\'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\' codebase=\'http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version={pluginversion:4,0,0,0}\' width=\'{width}\' height=\'{height}\'><param name=\'movie\' value=\'{imageurl}{swf_con}{swf_param}\'><param name=\'quality\' value=\'high\'><param name=\'allowScriptAccess\' value=\'always\'>[transparent]<param name=\'wmode\' value=\'transparent\'>[/transparent]<embed src=\'{imageurl}{swf_con}{swf_param}\' quality=high [transparent]wmode=\'transparent\' [/transparent]width=\'{width}\' height=\'{height}\' type=\'application/x-shockwave-flash\' pluginspace=\'http://www.adobe.com/go/getflashplayer\' allowScriptAccess=\'always\'></embed></object>[bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]
   htmlcache: <object classid=\'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\' codebase=\'http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version={pluginversion:4,0,0,0}\' width=\'{width}\' height=\'{height}\'><param name=\'movie\' value=\'{imageurl}{swf_con}{swf_param}\'><param name=\'quality\' value=\'high\'><param name=\'allowScriptAccess\' value=\'always\'>[transparent]<param name=\'wmode\' value=\'transparent\'>[/transparent]<embed src=\'{imageurl}{swf_con}{swf_param}\' quality=high [transparent]wmode=\'transparent\' [/transparent]width=\'{width}\' height=\'{height}\' type=\'application/x-shockwave-flash\' pluginspace=\'http://www.adobe.com/go/getflashplayer\' allowScriptAccess=\'always\'></embed></object>[bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]
*************************** 6. row ***************************
    bannerid: 6
htmltemplate: [targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]<img src=\'{imageurl}\' width=\'{width}\' height=\'{height}\' alt=\'{alt}\' title=\'{alt}\' border=\'0\'[nourl][status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status][/nourl]>[targeturl]</a>[/targeturl][bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]
   htmlcache: [targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]<img src=\'{imageurl}\' width=\'{width}\' height=\'{height}\' alt=\'{alt}\' title=\'{alt}\' border=\'0\'[nourl][status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status][/nourl]>[targeturl]</a>[/targeturl][bannertext]<br>[targeturl]<a href=\'{targeturl}\' target=\'{target}\'[status] onMouseOver="self.status=\'{status}\'; return true;" onMouseOut="self.status=\'\';return true;"[/status]>[/targeturl]{bannertext}[targeturl]</a>[/targeturl][/bannertext]
*************************** 7. row ***************************
    bannerid: 7
htmltemplate: <a href="" target="">Click Here</a>
   htmlcache: <a href="" >Click Here</a>
*/



?>