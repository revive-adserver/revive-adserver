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
        $this->initDatabase(127, array('banners'));
        
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

        $rsBanners = DBC::NewRecordSet("SELECT bannerid, transparent, parameters FROM banners ORDER BY bannerid");
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
}