<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

// Define usertypes bitwise, so 1, 2, 4, 8, 16, etc.
define ("phpAds_Admin", 1);
define ("phpAds_Client", 2);    // aka advertiser
define ("phpAds_Advertiser", 2); // formerly known as client
define ("phpAds_Affiliate", 4); // aka publisher
define ("phpAds_Publisher", 4); // formerly known as affiliate
define ("phpAds_Agency", 8);


/**
 * The namespace for user-related functions.
 */
class User
{
    /**
     * Returns an array of base user data for a specified username and user type.
     *
     * @param string $usertype
     * @param string $username
     * @return array
     */
    function getABaseUserData($usertype, $username)
    {
        return (array ("usertype"         => $usertype,
                       "loggedin"         => "t",
                       "agencyid"        => 0,
                       "username"         => $username)
               );
    }
    
    
    /**
     * Returns an array of user data for an admin user.
     *
     * @param string $username
     * @return array
     */
    function getAAdminData($username)
    {
        return User::getABaseUserData(phpAds_Admin, $username);
    }
    
    
    /**
     * Returns an array of user data initialized from the $doAbstractUser object.
     * It initializes base values as well as additional values not available
     * for admin user.
     *
     * @param DataObjects_AbstractUser $doUser
     * @return array
     */
    function getAUserData($doUser)
    {
        $aUserData = User::getABaseUserData(
            $doUser->getUserType(), $doUser->getSUsername());
        $aUserData['agencyid'] = $doUser->agencyid;
        $aUserData['userid'] = $doUser->getUserId();
        $aUserData['permissions'] = $doUser->permissions;
        $aUserData["language"] = $doUser->language;
        return $aUserData;
    }
    
    
    /**
     * Returns an array of data for an affiliate user.
     *
     * @param DataObjects_Affiliates $doAffiliate
     */
    function getAAffiliateData($doAffiliate)
    {
        $aAffiliateData = User::getAUserData($doAffiliate);
        $aAffiliateData["needs_to_agree"] = $doAffiliate->getNeedsToAgree();
        $aAffiliateData['help_file'] = $doAffiliate->e_help_file;
        return $aAffiliateData;
    }


    /**
     * Finds and returns a user object for a given $username and $md5digest
     * in the specified table. If the user can not be found, false is 
     * returned.
     *
     * @param string $table
     * @param string $username
     * @param string $password
     * @return DataObjects_AbstractUser
     */
    function getDoUser($table, $username, $md5digest)
    {
        $doUser = MAX_DB::factoryDO($table);
        $doUser->setSUsername($username);
        $doUser->setPassword($md5digest);
        $doUser->find();
        if ($doUser->fetch()) {
            return $doUser;
        }
        else {
            return false;
        }
    }
    
    
    /**
     * Finds and returns an agency data object for a given $username and
     * $md5digest. If the agency can not be found, false is returned.
     *
     * @param string $username
     * @param string $md5digest
     * @return DataObjects_Agency
     */
    function getDoAgency($username, $md5digest)
    {
        return User::getDoUser('agency', $username, $md5digest);
    }
    
    
    /**
     * Finds and returns a client data object for a given $username and
     * $md5digest. If the client can not be found, false is returned.
     *
     * @param string $username
     * @param string $md5digest
     * @return DataObjects_Clients
     */
    function getDoClients($username, $md5digest)
    {
        return User::getDoUser('clients', $username, $md5digest);
    }


    /**
     * Retrieve the Affiliate data object with data from both affiliates
     * and affiliates_extra tables. The values for affiliate_extra are prefixed
     * with 'e_'. If there is no affiliate with a specified
     * username and password then false is returned.
     *
     * @param string $username
     * @param string $md5digest
     * @return DataObjects_Affiliates
     */
    function getDoAffiliates($username, $md5digest)
    {
        $doAffiliates = MAX_DB::factoryDO('affiliates');
        $doAffiliates->username = $username;
        $doAffiliates->password = $md5digest;
        $doAffiliates_extra = MAX_DB::factoryDO('affiliates_extra');
        $doAffiliates->joinAdd($doAffiliates_extra);
        $doAffiliates->selectAs('e_');
        $doAffiliates->find();
        if ($doAffiliates->fetch()) {
            return $doAffiliates;
        }
        
        return false;
    }


    /**
     * Tries to match specified username and md5digest password to a user in the
     * Openads system. If the user is found it is returned. Otherwise, false is
     * returned.
     *
     * @param string $username
     * @param string $md5digest
     * @return DataObjects_AbstractUser
     */
    function findAndGetDoUser($username, $md5digest)
    {
        if ($doUser = User::getDoAgency($username, $md5digest)) {
            return $doUser;
        }
        elseif ($doUser = User::getDoClients($username, $md5digest)) {
            return $doUser;
        }
        elseif ($doUser = User::getDoAffiliates($username, $md5digest)) {
            return $doUser;
        }
        return false;
    }
}

?>