<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@openads.org>
 */
class Migration_128Test extends MigrationTest
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
<!--[if !IE]> --><object type='application/x-shockwave-flash' data='{url_prefix}/adimage.php?filename=test.swf&amp;contenttype=swf&amp;alink1={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openads.org&amp;atar1=_blank&amp;alink2={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openads.org&amp;atar2=_self' width='468' height='60'> <!-- <![endif]--> <!--[if IE]> <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://fpdownload.adobe.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='468' height='60'> <param name='movie' value='{url_prefix}/adimage.php?filename=test.swf&amp;contenttype=swf&amp;alink1={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openads.org&amp;atar1=_blank&amp;alink2={url_prefix}/adclick.php%3Fbannerid={bannerid}%26zoneid={zoneid}%26source={source}%26dest=http%3A%2F%2Fwww.openads.org&amp;atar2=_self' /> <!--><!----> <param name='quality' value='high' /> <param name='allowScriptAccess' value='always' />  <p>This is <strong>alternative</strong> content.</p> </object> <!-- <![endif]--> 
EOF
            ),
            array('bannerid' => 2, 'transparent' => "t"),
            array('bannerid' => 3, 'transparent' => "f"),
            array('bannerid' => 4, 'transparent' => "f"),
            array('bannerid' => 5, 'transparent' => "t")
        );
        foreach ($aAValues as $aValues) {
            $sql = OA_DB_Sql::sqlForInsert('banners', $aValues);
            $this->oDbh->exec($sql);
        }
        
        $this->upgradeToVersion(128);

        $rsBanners = DBC::NewRecordSet("
            SELECT bannerid, transparent, parameters
            FROM {$prefix}banners
            ORDER BY bannerid");
        $rsBanners->find();
        $this->assertEqual(count($aAValues), $rsBanners->getRowCount());
        for ($idxBanner = 0; $idxBanner < count($aAValues); $idxBanner++) {
            $this->assertTrue($rsBanners->fetch());
            $this->assertEqual($aAValues[$idxBanner]['bannerid'], $rsBanners->get('bannerid'));
            $this->assertEqual($toInt[$aAValues[$idxBanner]['transparent']], $rsBanners->get('transparent'));
            if ($idxBanner == 0) {
                $params = $rsBanners->get('parameters');
                $this->assertNotEqual($params, '');
                $params = unserialize($params);
                $this->assertEqual($params, array(
                    1 => array(
                        'link' => 'http://www.openads.org',
                        'tar'  => '_blank'
                    ),
                    2 => array(
                        'link' => 'http://www.openads.org',
                        'tar'  => '_self'
                    )
                ));
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
            array('domain', '!=', 'www.openads.org'),
            array('language', '!=', '(hr)|(nl)'),
            array('language', '!=', '(en)'),
            array('continent', '==', 'AF'),
            array('country', '==', 'PL,GB'),
            array('browser', '==', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('browser', '!=', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('os', '==', '(Win)|(Windows CE)|(Mac)|(Linux)|(BSD)|(SunOS)|(IRIX)|(AIX)|(Unix)'),
            array('useragent', '==', 'ahahaha'),
            array('referer', '==', 'blabblah'),
            array('source', '==', 'www.openads.org'),
        );
        $aExpectedData = array(
            array('Time:Day', '=~', '0,1'),
            array('Time:Day', '=~', '0,1,4'),
            array('Time:Day', '=~', ''),
            array('Time:Hour', '=~', '5,6'),
            array('Time:Hour', '=~', '5'),
            array('Time:Date', '>=', '20070510'),
            array('Client:Ip', '==', '150.254.170.189'),
            array('Client:Domain', '!=', 'www.openads.org'),
            array('Client:Language', '!~', 'hr,nl'),
            array('Client:Language', '!~', 'en'),
            array('Geo:Continent', '=~', 'AF'),
            array('Geo:Country', '=~', 'PL,GB'),
            array('Client:Useragent', '=x', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('Client:Useragent', '!x', '(^Mozilla/5.*Gecko)|(Opera)|(MSN)'),
            array('Client:Useragent', '=x', '(Win)|(Windows CE)|(Mac)|(Linux)|(BSD)|(SunOS)|(IRIX)|(AIX)|(Unix)'),
            array('Client:Useragent', '=x', 'ahahaha'),
            array('Site:Referingpage', '=~', 'blabblah'),
            array('Site:Source', '=x', 'www.openads.org'),
        );
        
        $sql = OA_DB_Sql::sqlForInsert('banners', array('bannerid' => 1));
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
        $cLimitations = $idx;
        
        $this->upgradeToVersion(128);
        
        $rsAcls = DBC::NewRecordSet("
        SELECT type, comparison, data
        FROM {$prefix}acls
        ORDER BY executionorder");
        $this->assertTrue($rsAcls->find());
        
        for ($idx = 0; $idx < $cLimitations; $idx++) {
            $expected = $aExpectedData[$idx][0] . "|" . $aExpectedData[$idx][1] . "|" . $aExpectedData[$idx][2];
            $this->assertTrue($rsAcls->fetch());
            $this->assertEqual($aExpectedData[$idx][0], $rsAcls->get('type'), "%s IN TYPE FOR: $expected");
            $this->assertEqual($aExpectedData[$idx][1], $rsAcls->get('comparison'), "%s IN COMPARISON FOR: $expected" );
            $this->assertEqual($aExpectedData[$idx][2], $rsAcls->get('data'));
        }
        $this->assertFalse($rsAcls->fetch());
    }
}