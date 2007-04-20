<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Permission/User.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

/*
 * A class for testing the MAX_Permission_User class.
 *
 * @package    MaxPlugin
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class MAX_Permission_UserTest extends DalUnitTestCase
{
    function MAX_Permission_UserTest()
    {
        $this->UnitTestCase();
    }


    function testGetDoAffiliates()
    {
        $username = 'scott';
        $md5 = 'tiger';
        $aExpectedData = array(
            'usertype' => phpAds_Affiliate,
            'loggedin' => 't',
            'agencyid' => 10,
            'username' => $username,
            'permissions' => 4,
            'language' => 'en',
            'needs_to_agree' => 0,
            'help_file' => 'help'
        );

        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->username = $username;
        $doAffiliates->password = $md5;
        $doAffiliates->agencyid = $aExpectedData['agencyid'];
        $doAffiliates->permissions = $aExpectedData['permissions'];
        $doAffiliates->language = $aExpectedData['language'];
        $doAffiliates->last_accepted_agency_agreement = '2006-10-10';
        $affiliateId = $doAffiliates->insert();
        $aExpectedData['userid'] = $affiliateId;
        $doAffiliatesExtra = OA_Dal::factoryDO('affiliates_extra');
        $doAffiliatesExtra->affiliateid = $affiliateId;
        $doAffiliatesExtra->help_file = 'help';
        $doAffiliatesExtra->insert();

        $doAffiliates = MAX_Permission_User::findAndGetDoUser($username, $md5);
        $aAffiliateData = MAX_Permission_User::getAAffiliateData($doAffiliates);
        $this->assertEqual($aExpectedData, $aAffiliateData);
    }
}
?>