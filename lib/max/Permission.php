<?php

class MAX_Permission
{
	function checkAccess($allowed)
	{
		if (!MAX_Permission::hasAccess($allowed)) {
			global $session;
		    global $strNotAdmin, $strAccessDenied;
	        phpAds_PageHeader(0);
	        phpAds_Die($strAccessDenied, $strNotAdmin);
		}
	}
	
	function checkIsAllowed($allowed)
	{
		if (!MAX_Permission::isAllowed($allowed)) {
			global $strNotAdmin, $strAccessDenied;
			phpAds_PageHeader("2");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
	}
	
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