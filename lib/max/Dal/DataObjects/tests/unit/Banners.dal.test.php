<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Banners.php';
require_once 'DataObjectsUnitTestCase.php';

/**
 * A class for testing non standard DataObjects_Banners methods
 *
 * @package    MaxDal
 * @subpackage TestSuite
 *
 * @TODO No tests written yet...
 */
class DataObjects_BannersTest extends DataObjectsUnitTestCase
{
    /**
     * The constructor method.
     */
    function DataObjects_BannersTest()
    {
        $this->UnitTestCase();
    }
    
    function testDuplicate()
    {
        // use a data generator here!
        $aBanner = array(
            'active' => 't',
            'weight' => '1',
            'height' => '2',
            'seq' => '1',
            'target' => '_blank',
            'url' => 'http://example.com',
            'alt' => 'some text',
            'description' => 'banner description',
        );
        
        // create new banner
        $doBanners1 = MAX_DB::factoryDO('banners');
        $doBanners1->setFrom($aBanner);
        $id1 = $doBanners1->insert();
        $this->assertTrue(!empty($id1));
        
        $doBanners2 = MAX_DB::staticGetDO('banners', $id1);
        $this->assertIsA($doBanners2, 'DataObjects_Banners');
        
        $id2 = $doBanners2->duplicate();
        $this->assertTrue(!empty($id2));
        $this->assertNotEqual($id1, $id2);
        
        $doBanners1 = MAX_DB::staticGetDO('banners', $id1);
        $doBanners2 = MAX_DB::staticGetDO('banners', $id2);
        $doBanners1->description = null;
        $doBanners1->bannerid = null;
        
        $doBanners2->description = null;
        $doBanners2->bannerid = null;
        
        $this->assertEqualDataObjects($doBanners1, $doBanners2);
    }
}
