<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once dirname(__FILE__) . '/../../../../../../var/config.php';
require_once dirname(__FILE__) . '/../../Cache.php';

class OX_oxMarket_Common_CacheTest extends UnitTestCase 
{
    function testLifeTime() 
    {
        $oCache = new OX_oxMarket_Common_Cache('test', 'oxMarket', 1);
        $oCache->setFileNameProtection(false);
        $oCache->clear();
        
        // File not exist
        $result = $oCache->load(false);
        $this->assertFalse($result);
        
        $data = 'test';
        $oCache->save($data);
        
        // File exists
        $result = $oCache->load(false);
        $this->assertEqual($result, $data);
        
        // Wait 3 seconds and set cache lifetime to 1 second
        sleep(3);
        $oCache = new OX_oxMarket_Common_Cache('test', 'oxMarket', 1);
        $oCache->setFileNameProtection(false);
        
        // File exists but is not valid
        $result = $oCache->load(false);
        $this->assertFalse($result);
        
        // Try to retrive cache ignoring lifetime
        $result = $oCache->load(true);
        $this->assertEqual($result, $data);
    }
    
    function testCacheDir() 
    {
        $oCache = new OX_oxMarket_Common_Cache('test', 'oxMarket');
        $oCache->clear();
        
        $result = $oCache->load(true);
        $this->assertFalse($result);
        
        $newCacheDir = dirname(__FILE__) . '/../data/'; 
        
        $oCache = new OX_oxMarket_Common_Cache('test', 'oxMarket', null, $newCacheDir);
        $oCache->setFileNameProtection(false);
        
        $result = $oCache->load(true);
        $this->assertEqual('test', $result);
    }
}

