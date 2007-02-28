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
	
	/**
	 * Checks if user has access to specific area (for example admin or agency area)
	 * Parametere is on of or sum of any of constants eg: phpAds_Admin + phpAds_Agency
	 * Permissions are defined in www/admin/lib-permissions.inc.php file
	 *
	 * @param integer $allowed
	 * @return boolean  True if has access
	 */
	function hasAccess($allowed)
	{
		global $session;
	    if (!($allowed & $session['usertype'])) {
			return false;
	    }
	    return true;
	}
	
	/**
	 * Checks if user is allowed to perform specific action.
	 * eg: phpAds_ModifyInfo
	 * Permissions are defined in www/admin/lib-permissions.inc.php file
	 *
	 * @param unknown_type $allowed
	 * @return unknown
	 */
	function isAllowed($allowed)
	{
		if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
		    // Admin and Agency types of users are allowed to do any changes
		    // (if they only have access to it)
			return true;
		}
	    global $session;
    	return ($allowed & (int) $session['permissions']);
	}
	
	/**
	 * Check if looged user has access to DataObject (defined by it's table name)
	 *
	 * @param string $objectTable  Table name
	 * @param int $id  Id (or empty if new is created)
	 * @return boolean  True if has access
	 */
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
	
	/**
	 * Return user table for logged user
	 *
	 * @return string
	 */
	function getUserTypeTable()
	{
		if (phpAds_isUser(phpAds_Client)) {
			return 'clients';
		}
		if (phpAds_isUser(phpAds_Affiliate)) {
			return 'affiliates';
		}
		if (phpAds_isUser(phpAds_Agency)) {
			return 'agency';
		}
		return null;
	}
	
	/**
	 * Checks if username is still available and if
	 * it is allowed to use.
	 *
	 * @param string $oldName
	 * @param string $newName
	 * @return boolean  True if allowed
	 */
	function isUsernameAllowed($oldName, $newName)
	{
	    if (!empty($oldName) && $oldName == $newName) {
	        return true;
	    }
	    global $pref;
	    if ((strtolower($pref['admin']) == strtolower($newName))) {
	        // cmpare with "admin" name
	        return false;
	    }
	    // check against all users in system
	    $userTables = array('affiliates', 'clients', 'agency');
	    foreach($userTables as $table) {
	        $doUser = MAX_DB::factoryDO($table);
	        if (!PEAR::isError($doUser) && $doUser->userExists($newName)) {
	            return false;
	        }
	    }
	    return true;
	}
	
	function getUniqueUserNames($removeName = null)
	{
        global $pref;
	    $uniqueUsers = array($pref['admin']);
        
	    $userTables = array('affiliates', 'clients', 'agency');
	    foreach($userTables as $table) {
	        $doUser = MAX_DB::factoryDO($table);
	        if (PEAR::isError($doUser)) {
	            return false;
	        }
	        $newUniqueNames = $doUser->getUniqueUsers();
	        $uniqueUsers = array_merge($uniqueUsers, $newUniqueNames);
	    }
	    
	    if (!empty($removeName)) {
	        $key = array_search($removeName, $uniqueUsers);
	        if (is_numeric($key)) {
	            unset($uniqueUsers[$key]);
	        }
	    }
        return $uniqueUsers;
	}
}


?>