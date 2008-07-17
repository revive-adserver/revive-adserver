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

require_once MAX_PATH . '/etc/changes/migration_tables_core_128.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * Test for migration class #128.
 *
 * @package    changes
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openx.org>
 */
class Migration_tables_core_128Test extends MigrationTest
{
    function testMigrateData()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(127, array('banners', 'acls', 'channel', 'acls_channel'));

        $toInt['f'] = 0;
        $toInt['t'] = 1;
        $aAValues = array(
            array('bannerid' => 1, 'transparent' => "f",
                'contenttype' => 'swf',
                'htmlcache' => <<<EOF
<!--[if !IE]> --><object type='application/x-shockwave-flash' data='{url_prefix}/adimage.php?filename=test.swf&amp;contenttype=swf&amp;alink1={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openx.org&amp;atar1=_blank&amp;alink2={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openx.org&amp;atar2=_self' width='468' height='60'> <!-- <![endif]--> <!--[if IE]> <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='468' height='60'> <param name='movie' value='{url_prefix}/adimage.php?filename=test.swf&amp;contenttype=swf&amp;alink1={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openx.org&amp;atar1=_blank&amp;alink2={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openx.org&amp;atar2=_self' /> <!--><!----> <param name='quality' value='high' /> <param name='allowScriptAccess' value='always' />  <p>This is <strong>alternative</strong> content.</p> </object> <!-- <![endif]-->
EOF
            ),
            array('bannerid' => 2, 'transparent' => "t"),
            array('bannerid' => 3, 'transparent' => "f"),
            array('bannerid' => 4, 'transparent' => "f"),
            array('bannerid' => 5, 'transparent' => "t"),
            array('bannerid' => 6,
                'storagetype' => 'html',
                'autohtml' => 't',
                'htmltemplate' => <<<EOF
<script type="text/javascript"><!--
google_ad_client = "pub-XXXX";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_channel ="";
google_color_border = "0066cc";
google_color_bg = "FFFFFF";
google_color_link = "000000";
google_color_url = "666666";
google_color_text = "333333";
//--></script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
EOF
            ),
            array('bannerid' => 7,
                'storagetype' => 'html',
                'autohtml' => 'f',
                'htmltemplate' => <<<EOF
<script type="text/javascript"><!--
google_ad_client = "pub-XXXX";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_channel ="";
google_color_border = "0066cc";
google_color_bg = "FFFFFF";
google_color_link = "000000";
google_color_url = "666666";
google_color_text = "333333";
//--></script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
EOF
            ),
        );
        foreach ($aAValues as $aValues) {
            $aValues += array(
                'htmltemplate'       => '',
                'htmlcache'          => '',
                'bannertext'         => '',
                'compiledlimitation' => '',
                'append'             => ''
            );
            $sql = OA_DB_Sql::sqlForInsert('banners', $aValues);
            $this->oDbh->exec($sql);
        }

        $this->upgradeToVersion(128);

        $table = $this->oDbh->quoteIdentifier($prefix.'banners',true);
        $rsBanners = DBC::NewRecordSet("
            SELECT bannerid, transparent, parameters, autohtml, htmlcache, adserver
            FROM {$table}
            ORDER BY bannerid");
        $rsBanners->find();
        $this->assertEqual(count($aAValues), $rsBanners->getRowCount());
        for ($idxBanner = 0; $idxBanner < count($aAValues); $idxBanner++) {
            $this->assertTrue($rsBanners->fetch());
            $this->assertEqual($aAValues[$idxBanner]['bannerid'], $rsBanners->get('bannerid'));
            if ($idxBanner < 5) {
                // SWF tests
                $this->assertEqual($toInt[$aAValues[$idxBanner]['transparent']], $rsBanners->get('transparent'));
                if ($idxBanner == 0) {
                    $params = $rsBanners->get('parameters');
                    $this->assertNotEqual($params, '');
                    $params = unserialize($params);
                    $this->assertEqual($params, array('swf' => array(
                        1 => array(
                            'link' => 'http://www.openx.org',
                            'tar'  => '_blank'
                        ),
                        2 => array(
                            'link' => 'http://www.openx.org',
                            'tar'  => '_self'
                        ))
                    ));
                }
            } else {
                // HTML tests
                $this->assertEqual($aAValues[$idxBanner]['autohtml'], $rsBanners->get('autohtml'));
                if ($aAValues[$idxBanner]['autohtml'] == 't') {
                    $this->assertTrue(preg_match("#src='{url_prefix}/ag.php'#", $rsBanners->get('htmlcache')));
                    $this->assertEqual($rsBanners->get('adserver'), 'google');
                } else {
                    $this->assertFalse(preg_match("#src='{url_prefix}/ag.php'#", $rsBanners->get('htmlcache')));
                    $this->assertNotEqual($rsBanners->get('adserver'), 'google');
                }
            }
        }
        $this->assertFalse($rsBanners->fetch());
    }

    function testMigrateAcls()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(127, array('banners', 'acls', 'channel', 'acls_channel'));


        $aTestData = array(
            array('weekday', '==', '0,1'),
            array('weekday', '==', '0,1,4'),
            array('weekday', '==', ''),
            array('time', '==', '5,6'),
            array('time', '==', '5'),
            array('date', '>=', '20070510'),
            array('clientip', '==', '150.254.170.189'),
            array('domain', '!=', 'www.openx.org'),
            array('language', '!=', '(hr)|(nl)'),
            array('language', '!=', '(en)'),
            array('continent', '==', 'AF'),
            array('country', '==', 'PL,GB'),
            array('browser', '==', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('browser', '!=', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('os', '==', '(Win)|(Windows CE)|(Mac)|(Linux)|(BSD)|(SunOS)|(IRIX)|(AIX)|(Unix)'),
            array('useragent', '==', 'ahahaha'),
            array('referer', '==', 'blabblah'),
            array('source', '==', 'www.openx.org'),
            array('url', '==', 'www.openx.org/contacts.php'),
            array('postal_code', '==', '44100'),
            array('city', '==', 'ferrara'),
            array('fips_code', '==', 'GB08,GBN5'),
            array('region', '==', 'USAK,USAZ'),
            array('dma_code', '==', '501,502'),
            array('area_code', '==', '66099'),
            array('org_isp', '==', 'openads'),
            array('netspeed', '==', '1,2'),

            // Warning - The next limitations will be split
            array('fips_code', '==', 'IT01,IT02,IE01,IE02,DE01'),
            array('fips_code', '!=', 'GB08,IT01,IT02'),
        );
        $aExpectedData = array(
            array('Time:Day', '=~', '0,1'),
            array('Time:Day', '=~', '0,1,4'),
            array('Time:Day', '=~', ''),
            array('Time:Hour', '=~', '5,6'),
            array('Time:Hour', '=~', '5'),
            array('Time:Date', '>=', '20070510'),
            array('Client:Ip', '==', '150.254.170.189'),
            array('Client:Domain', '!=', 'www.openx.org'),
            array('Client:Language', '!~', 'hr,nl'),
            array('Client:Language', '!~', 'en'),
            array('Geo:Continent', '=~', 'AF'),
            array('Geo:Country', '=~', 'PL,GB'),
            array('Client:Useragent', '=x', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('Client:Useragent', '!x', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('Client:Useragent', '=x', '(Win)|(Windows CE)|(Mac)|(Linux)|(BSD)|(SunOS)|(IRIX)|(AIX)|(Unix)'),
            array('Client:Useragent', '=x', 'ahahaha'),
            array('Site:Referingpage', '=~', 'blabblah'),
            array('Site:Source', '=x', 'www.openx.org'),
            array('Site:Pageurl', '=~', 'www.openx.org/contacts.php'),
            array('Geo:Postalcode', '=~', '44100'),
            array('Geo:City', '=~', '|ferrara'),
            array('Geo:Region', '=~', 'GB|08,N5'),
            array('Geo:Region', '=~', 'US|AK,AZ'),
            array('Geo:Dma', '=~', '501,502'),
            array('Geo:Areacode', '=~', '66099'),
            array('Geo:Organisation', '=~', 'openads'),
            array('Geo:Netspeed', '=~', 'dialup,cabledsl'),

            // Warning - The next limitations were split, see below
            array('Geo:Region', '=~', 'DE|01', 'and'),
            array('Geo:Region', '!~', 'GB|08', 'and'),
            // Split results
            array('Geo:Region', '=~', 'IE|01,02', 'or'),
            array('Geo:Region', '=~', 'IT|01,02', 'or'),
            array('Geo:Region', '!~', 'IT|01,02', 'and'),
        );

        $sql = OA_DB_Sql::sqlForInsert('banners', array(
            'bannerid'           => 1,
            'htmltemplate'       => '',
            'htmlcache'          => '',
            'bannertext'         => '',
            'compiledlimitation' => '',
            'append'             => ''
        ));

        $this->oDbh->exec($sql);

        $aValues = array();
        $idx = 0;
        foreach ($aTestData as $testData) {
            $aValues = array(
                'bannerid' => 1,
                'logical' => 'and',
                'type' => $testData[0],
                'comparison' => $testData[1],
                'data' => $testData[2],
                'executionorder' => $idx++);
            $sql = OA_DB_Sql::sqlForInsert('acls', $aValues);
            $this->oDbh->exec($sql);
        }

        $this->upgradeToVersion(128);
        $table = $this->oDbh->quoteIdentifier($prefix.'acls',true);
        $rsAcls = DBC::NewRecordSet("
        SELECT type, comparison, data, logical
        FROM {$table}
        ORDER BY executionorder");
        $this->assertTrue($rsAcls->find());

        for ($idx = 0; $idx < count($aExpectedData); $idx++) {
            $expected = $aExpectedData[$idx][0] . "|" . $aExpectedData[$idx][1] . "|" . $aExpectedData[$idx][2];
            $this->assertTrue($rsAcls->fetch());
            $this->assertEqual($aExpectedData[$idx][0], $rsAcls->get('type'), "%s IN TYPE FOR: $expected");
            $this->assertEqual($aExpectedData[$idx][1], $rsAcls->get('comparison'), "%s IN COMPARISON FOR: $expected" );
            $this->assertEqual($aExpectedData[$idx][2], $rsAcls->get('data'));
            if (!empty($aExpectedData[$idx][3])) {
                $this->assertEqual($aExpectedData[$idx][3], $rsAcls->get('logical'));
            }
        }
        $this->assertFalse($rsAcls->fetch());
    }
}