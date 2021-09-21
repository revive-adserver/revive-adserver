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

require_once MAX_PATH . '/etc/changes/migration_tables_core_128.php';
require_once MAX_PATH . '/lib/OA/DB/Sql.php';
require_once MAX_PATH . '/etc/changes/tests/unit/MigrationTest.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * Test for migration class #128.
 *
 * @package    changes
 * @subpackage TestSuite
 */
class Migration_tables_core_128Test extends MigrationTest
{
    public function testMigrateData()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(127, ['banners', 'acls', 'channel', 'acls_channel']);

        $toInt['f'] = 0;
        $toInt['t'] = 1;
        $aAValues = [
            ['bannerid' => 1, 'transparent' => "f",
                'contenttype' => 'swf',
                'htmlcache' => <<<EOF
<!--[if !IE]> --><object type='application/x-shockwave-flash' data='{url_prefix}/adimage.php?filename=test.swf&amp;contenttype=swf&amp;alink1={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openx.org&amp;atar1=_blank&amp;alink2={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openx.org&amp;atar2=_self' width='468' height='60'> <!-- <![endif]--> <!--[if IE]> <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='468' height='60'> <param name='movie' value='{url_prefix}/adimage.php?filename=test.swf&amp;contenttype=swf&amp;alink1={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openx.org&amp;atar1=_blank&amp;alink2={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openx.org&amp;atar2=_self' /> <!--><!----> <param name='quality' value='high' /> <param name='allowScriptAccess' value='always' />  <p>This is <strong>alternative</strong> content.</p> </object> <!-- <![endif]-->
EOF
            ],
            ['bannerid' => 2, 'transparent' => "t"],
            ['bannerid' => 3, 'transparent' => "f"],
            ['bannerid' => 4, 'transparent' => "f"],
            ['bannerid' => 5, 'transparent' => "t"],
            ['bannerid' => 6,
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
            ],
            ['bannerid' => 7,
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
            ],
        ];
        foreach ($aAValues as $aValues) {
            $aValues += [
                'htmltemplate' => '',
                'htmlcache' => '',
                'bannertext' => '',
                'compiledlimitation' => '',
                'append' => ''
            ];
            $sql = OA_DB_Sql::sqlForInsert('banners', $aValues);
            $this->oDbh->exec($sql);
        }

        $this->upgradeToVersion(128);

        $table = $this->oDbh->quoteIdentifier($prefix . 'banners', true);
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
                    $this->assertEqual($params, ['swf' => [
                        1 => [
                            'link' => 'http://www.openx.org',
                            'tar' => '_blank'
                        ],
                        2 => [
                            'link' => 'http://www.openx.org',
                            'tar' => '_self'
                        ]]
                    ]);
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

    public function testMigrateAcls()
    {
        $prefix = $this->getPrefix();
        $this->initDatabase(127, ['banners', 'acls', 'channel', 'acls_channel']);


        $aTestData = [
            ['weekday', '==', '0,1'],
            ['weekday', '==', '0,1,4'],
            ['weekday', '==', ''],
            ['time', '==', '5,6'],
            ['time', '==', '5'],
            ['date', '>=', '20070510'],
            ['clientip', '==', '150.254.170.189'],
            ['domain', '!=', 'www.openx.org'],
            ['language', '!=', '(hr)|(nl)'],
            ['language', '!=', '(en)'],
            ['continent', '==', 'AF'],
            ['country', '==', 'PL,GB'],
            ['browser', '==', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'],
            ['browser', '!=', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'],
            ['os', '==', '(Win)|(Windows CE)|(Mac)|(Linux)|(BSD)|(SunOS)|(IRIX)|(AIX)|(Unix)'],
            ['useragent', '==', 'ahahaha'],
            ['referer', '==', 'blabblah'],
            ['source', '==', 'www.openx.org'],
            ['url', '==', 'www.openx.org/contacts.php'],
            ['postal_code', '==', '44100'],
            ['city', '==', 'ferrara'],
            ['fips_code', '==', 'GB08,GBN5'],
            ['region', '==', 'USAK,USAZ'],
            ['dma_code', '==', '501,502'],
            ['area_code', '==', '66099'],
            ['org_isp', '==', 'openads'],
            ['netspeed', '==', '1,2'],

            // Warning - The next limitations will be split
            ['fips_code', '==', 'IT01,IT02,IE01,IE02,DE01'],
            ['fips_code', '!=', 'GB08,IT01,IT02'],
        ];
        $aExpectedData = [
            ['Time:Day', '=~', '0,1'],
            ['Time:Day', '=~', '0,1,4'],
            ['Time:Day', '=~', ''],
            ['Time:Hour', '=~', '5,6'],
            ['Time:Hour', '=~', '5'],
            ['Time:Date', '>=', '20070510'],
            ['Client:Ip', '==', '150.254.170.189'],
            ['Client:Domain', '!=', 'www.openx.org'],
            ['Client:Language', '!~', 'hr,nl'],
            ['Client:Language', '!~', 'en'],
            ['Geo:Continent', '=~', 'AF'],
            ['Geo:Country', '=~', 'PL,GB'],
            ['Client:Useragent', '=x', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'],
            ['Client:Useragent', '!x', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'],
            ['Client:Useragent', '=x', '(Win)|(Windows CE)|(Mac)|(Linux)|(BSD)|(SunOS)|(IRIX)|(AIX)|(Unix)'],
            ['Client:Useragent', '=x', 'ahahaha'],
            ['Site:Referingpage', '=~', 'blabblah'],
            ['Site:Source', '=x', 'www.openx.org'],
            ['Site:Pageurl', '=~', 'www.openx.org/contacts.php'],
            ['Geo:Postalcode', '=~', '44100'],
            ['Geo:City', '=~', '|ferrara'],
            ['Geo:Region', '=~', 'GB|08,N5'],
            ['Geo:Region', '=~', 'US|AK,AZ'],
            ['Geo:Dma', '=~', '501,502'],
            ['Geo:Areacode', '=~', '66099'],
            ['Geo:Organisation', '=~', 'openads'],
            ['Geo:Netspeed', '=~', 'dialup,cabledsl'],

            // Warning - The next limitations were split, see below
            ['Geo:Region', '=~', 'DE|01', 'and'],
            ['Geo:Region', '!~', 'GB|08', 'and'],
            // Split results
            ['Geo:Region', '=~', 'IE|01,02', 'or'],
            ['Geo:Region', '=~', 'IT|01,02', 'or'],
            ['Geo:Region', '!~', 'IT|01,02', 'and'],
        ];

        $sql = OA_DB_Sql::sqlForInsert('banners', [
            'bannerid' => 1,
            'htmltemplate' => '',
            'htmlcache' => '',
            'bannertext' => '',
            'compiledlimitation' => '',
            'append' => ''
        ]);

        $this->oDbh->exec($sql);

        $aValues = [];
        $idx = 0;
        foreach ($aTestData as $testData) {
            $aValues = [
                'bannerid' => 1,
                'logical' => 'and',
                'type' => $testData[0],
                'comparison' => $testData[1],
                'data' => $testData[2],
                'executionorder' => $idx++];
            $sql = OA_DB_Sql::sqlForInsert('acls', $aValues);
            $this->oDbh->exec($sql);
        }

        $this->upgradeToVersion(128);
        $table = $this->oDbh->quoteIdentifier($prefix . 'acls', true);
        $rsAcls = DBC::NewRecordSet("
        SELECT type, comparison, data, logical
        FROM {$table}
        ORDER BY executionorder");
        $this->assertTrue($rsAcls->find());

        for ($idx = 0; $idx < count($aExpectedData); $idx++) {
            $expected = $aExpectedData[$idx][0] . "|" . $aExpectedData[$idx][1] . "|" . $aExpectedData[$idx][2];
            $this->assertTrue($rsAcls->fetch());
            $this->assertEqual($aExpectedData[$idx][0], $rsAcls->get('type'), "%s IN TYPE FOR: $expected");
            $this->assertEqual($aExpectedData[$idx][1], $rsAcls->get('comparison'), "%s IN COMPARISON FOR: $expected");
            $this->assertEqual($aExpectedData[$idx][2], $rsAcls->get('data'));
            if (!empty($aExpectedData[$idx][3])) {
                $this->assertEqual($aExpectedData[$idx][3], $rsAcls->get('logical'));
            }
        }
        $this->assertFalse($rsAcls->fetch());
    }

    // Tests for the various limitation upgrade methods

    public function testMAX_limitationsGetAUpgradeForString()
    {
        $this->checkUpgradeForString('==', 'blabla', '==', 'blabla');
        $this->checkUpgradeForString('=x', '^.*$', '==', '*');
        $this->checkUpgradeForString('!=', 'blabla', '!=', 'blabla');
        $this->checkUpgradeForString('=x', '^.*blabla$', '==', '*blabla');
        $this->checkUpgradeForString('=x', '^blabla.*$', '==', 'blabla*');
        $this->checkUpgradeForString('=~', 'blabla', '==', '*blabla*');
        $this->checkUpgradeForString('=~', 'blabla', '==', '*blabla****');
        $this->checkUpgradeForString('!~', 'blabla', '!=', '*blabla*');
        $this->checkUpgradeForString('=x', '^bla.*bla$', '==', 'bla*bla');
        $this->checkUpgradeForString('=x', '^.*bla.*bla.*$', '==', '*bla*bla*');
        $this->checkUpgradeForString('=x', '^bl.*ab.*la$', '==', 'bl*ab*la');
        $this->checkUpgradeForString('=x', '^bl.*ab.*la$', '==', 'bl*ab**la');
        $this->checkUpgradeForString('=x', '^bl.*ab.*la$', '==', 'bl*ab*****la');
        $this->checkUpgradeForString('!x', '^bl.*ab.*la$', '!=', 'bl*ab*la');
        $this->checkUpgradeForString('=x', '^bl.*a\\(b.*\\.l\\)a$', '==', 'bl*a(b*.l)a');
        $this->checkUpgradeForString('=~', 'blabla', '=~', 'blabla');
        $this->checkUpgradeForString('!~', 'blabla', '!~', 'blabla');
        $this->checkUpgradeForString('=x', '^http://victory\.com/index/blady/.*#strach$', '==', 'http://victory.com/index/blady/*#strach');
        $this->checkUpgradeForString('=x', '^\\(other\\)/business\\.scotsman\\.com/axappp.*$', '==', '(other)/business.scotsman.com/axappp*');
    }

    public function testMAX_limitationsGetAUpgradeForArray()
    {
        $sData = 'blabla,a';
        $aResult = MAX_limitationsGetAUpgradeForArray('==', $sData);
        $this->assertEqual('=~', $aResult['op']);
        $this->assertEqual($sData, $aResult['data']);
        $aResult = MAX_limitationsGetAUpgradeForArray('!=', $sData);
        $this->assertEqual('!~', $aResult['op']);
        $this->assertEqual($sData, $aResult['data']);
        $aResult = MAX_limitationsGetAUpgradeForArray('=~', $sData);
        $this->assertEqual('=~', $aResult['op']);
        $this->assertEqual($sData, $aResult['data']);
    }

    public function testMAX_limitationsGetAUpgradeForLanguage()
    {
        $this->checkUpgradeForLanguage('=~', 'pl', '==', '(pl)');
        $this->checkUpgradeForLanguage('=~', 'pl,en,fr', '==', '(pl)|(en)|(fr)');
        $this->checkUpgradeForLanguage('!~', 'pl,en,fr', '!=', '(pl)|(en)|(fr)');
    }

    public function checkUpgradeForLanguage($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetAUpgradeForLanguage', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }

    public function checkUpgradeForString($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetAUpgradeForString', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }

    public function testMAX_limitationsGetADowngradeForString()
    {
        $this->checkDowngradeForString('==', 'blabla', '==', 'blabla');
        $this->checkDowngradeForString('==', '*', '=x', '^.*$');
        $this->checkDowngradeForString('!=', 'blabla', '!=', 'blabla');
        $this->checkDowngradeForString('==', '*blabla', '=x', '^.*blabla$');
        $this->checkDowngradeForString('==', 'blabla*', '=x', '^blabla.*$');
        $this->checkDowngradeForString('==', '*blabla*', '=~', 'blabla');
        $this->checkDowngradeForString('!=', '*blabla*', '!~', 'blabla');
        $this->checkDowngradeForString('==', 'bla*bla', '=x', '^bla.*bla$');
        $this->checkDowngradeForString('==', '*bla*bla*', '=x', '^.*bla.*bla.*$');
        $this->checkDowngradeForString('==', 'bl*ab*la', '=x', '^bl.*ab.*la$');
        $this->checkDowngradeForString('!=', 'bl*ab*la', '!x', '^bl.*ab.*la$');
        $this->checkDowngradeForString('==', 'bl*a(b*.l)a', '=x', '^bl.*a\\(b.*\\.l\\)a$');
        $this->checkDowngradeForString('==', '*blabla*', '=~', 'blabla');
        $this->checkDowngradeForString('!=', '*blabla*', '!~', 'blabla');
        $this->checkDowngradeForString('==', 'http://victory.com/index/blady/*#strach', '=x', '^http://victory\.com/index/blady/.*#strach$');
        $this->checkDowngradeForString('==', '(other)/business.scotsman.com/axappp*', '=x', '^\\(other\\)/business\\.scotsman\\.com/axappp.*$');
    }

    public function testMAX_limitationsGetADowngradeForArray()
    {
        $sData = 'blabla,a';
        $this->checkDowngradeForArray('==', $sData, '=~', $sData);
        $this->checkDowngradeForArray('!=', $sData, '!~', $sData);
    }

    public function testMAX_limitationsGetADowngradeForLanguage()
    {
        $this->checkDowngradeForLanguage('==', '(pl)', '=~', 'pl');
        $this->checkDowngradeForLanguage('==', '(pl)|(en)|(fr)', '=~', 'pl,en,fr');
        $this->checkDowngradeForLanguage('!=', '(pl)|(en)|(fr)', '!~', 'pl,en,fr');
    }

    public function checkDowngradeForArray($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetADowngradeForArray', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }

    public function checkDowngradeForVariable($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetADowngradeForVariable', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }

    public function checkDowngradeForLanguage($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetADowngradeForLanguage', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }

    public function checkDowngradeForString($opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $this->checkUpgrade('MAX_limitationsGetADowngradeForString', $opExpected, $sDataExpected, $opOriginal, $sDataOriginal);
    }

    public function checkUpgrade($function, $opExpected, $sDataExpected, $opOriginal, $sDataOriginal)
    {
        $aResult = $function($opOriginal, $sDataOriginal);
        $opActual = $aResult['op'];
        $sDataActual = $aResult['data'];
        $this->assertEqual($opExpected, $opActual, "The value of operator for: '$opOriginal|$sDataOriginal' is $opActual.");
        $this->assertEqual($sDataExpected, $sDataActual, "The value of data for: '$opOriginal|$sDataOriginal' is $sDataActual instead of: $sDataExpected.");
    }
}
