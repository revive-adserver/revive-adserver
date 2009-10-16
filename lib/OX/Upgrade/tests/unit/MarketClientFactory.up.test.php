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
$Id: MarketClientFactory.up.test.php 42753 2009-09-07 12:33:35Z lukasz.wikierski $
*/

require_once MAX_PATH . '/lib/OX/Upgrade/MarketClientFactory.php';


/**
 * A class for testing the market client factory 
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_InstallConfigTest extends UnitTestCase 
{
    
    function testGetMarketClient()
    {
        $result = OX_Upgrade_MarketClientFactory::getMarketClient();
        $this->assertIsA($result, 'OX_Dal_Market_RegistrationClient');
    }
    
}

?>
