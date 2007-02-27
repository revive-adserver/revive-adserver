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

class MAX_Permission
{
    /**
     * Checks if the type of user may access this page.
     *
     * @param int $allowed  Bitwise usertype value
     */
	function checkAccess($allowed)
	{
		if (!MAX_Permission::hasAccess($allowed)) {
			global $session;
		    global $strNotAdmin, $strAccessDenied;
	        phpAds_PageHeader(0);
	        phpAds_Die($strAccessDenied, $strNotAdmin);
		}
	}
	
	/**
	 * Checks if user is allowed to perform action
	 *
	 * @param inst $allowed  Bitwise permissions value
	 */
	function checkIsAllowed($allowed)
	{
		if (!MAX_Permission::isAllowed($allowed)) {
			global $strNotAdmin, $strAccessDenied;
			phpAds_PageHeader("2");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
	}
	
	/**
	 * Checks the user is allowed to access the requested object.
	 *
	 * @param string $objectTable  the DB table of object
	 * @param int $id  the primary key of object
	 */
	function checkAccessToObject($objectTable, $id)
	{
		if (!MAX_Permission::hasAccessToObject($objectTable, $id)) {
			global $strNotAdmin, $strAccessDenied;
			phpAds_PageHeader("2");
			phpAds_Die($strAccessDenied, $strNotAdmin);
		}
	}
	
	function hasAccess($allowed)
	{
		global $session;
	    if (!($allowed & $session['usertype'])) {
			return false;
	    }
	    return true;
	}
	
	function isAllowed($allowed)
	{
		if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
		    // TODO: refactor this
			return true;
		}
	    global $session;
    	return ($allowed & (int) $session['permissions']);
	}
	
	function hasAccessToObject($objectTable, $id)
	{
		if (phpAds_isUser(phpAds_Admin)) {
			return true;
		}
		if (empty($id)) {
		    // when a new object is created
		    return true;
		}
		$do = MAX_DB::factoryDO($objectTable);
		if (!$do) {
			return false;
		}
		$key = $do->getFirstPrimaryKey();
		if (!$key) {
			return false;
		}
		$do->$key = $id;
		$userTable = MAX_Permission::getUserTypeTable();
		if (!$userTable) {
			return false;
		}
		$userId = phpAds_getUserID();
		if ($objectTable == $userTable) {
		    // user has access to itself
		    return ($id == $userId);
		}
		return $do->belongToUser($userTable, $userId);
	}
	
	function getUserTypeTable()
	{
		if (phpAds_isUser(phpAds_Client) || phpAds_isUser(phpAds_Advertiser)) {
			return 'clients';
		}
		if (phpAds_isUser(phpAds_Affiliate) || phpAds_isUser(phpAds_Publisher)) {
			return 'affiliates';
		}
		if (phpAds_isUser(phpAds_Agency)) {
			return 'agency';
		}
		return null;
	}
}


?>