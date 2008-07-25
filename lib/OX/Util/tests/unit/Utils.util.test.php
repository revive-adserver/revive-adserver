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

require_once(MAX_PATH . '/lib/OX/Util/Utils.php');

class OX_Util_UtilsTest 
    extends UnitTestCase
{
    function testGetCampaignType()
    {
        $aTestValues = array(-1 => OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE, 0 => OX_CAMPAIGN_TYPE_REMNANT);
        for ($i = 1; $i <= 10; $i++) {
            $aTestValues[$i] = OX_CAMPAIGN_TYPE_CONTRACT_NORMAL; 
        }
        
        foreach ($aTestValues as $priority => $expectedResult) {
            $result = OX_Util_Utils::getCampaignType($priority);
            $this->assertEqual($expectedResult, $result);            
        }
    }
    
    
    function testGetCampaignTranslationKey()
    {
        $aTestValues = array(-1 => 'strExclusiveContract', 0 => 'strRemnant');
        for ($i = 1; $i <= 10; $i++) {
            $aTestValues[$i] = 'strStandardContract'; 
        }
        
        foreach ($aTestValues as $priority => $expectedResult) {
            $result = OX_Util_Utils::getCampaignTypeTranslationKey($priority);
            $this->assertEqual($expectedResult, $result);            
        }
    }
    
}
?>