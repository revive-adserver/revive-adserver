<?php // $Revision: 3831 $

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Set define to prevent duplicate include
define ('LIBLOCKS_INCLUDED', true);


// Lock types
define('phpAds_lockMaintenance',	1);
define('phpAds_lockPriority',		2);
define('phpAds_lockDistributed',	3);


function phpAds_maintenanceGetLock($type = phpAds_lockMaintenance, $wait = 0)
{
	$lock = array(
		'type' => 'db',
		'id' => addslashes("pan{$type}.".$GLOBALS['phpAds_config']['instance_id'])
	);
	
	$wait = (int)$wait;
	
	if (phpAds_dbResult(phpAds_dbQuery("SELECT GET_LOCK('{$lock['id']}', {$wait})"), 0, 0))
		return $lock;
	return false;
}

function phpAds_maintenanceReleaseLock($lock)
{
	switch ($lock['type'])
	{
		case 'db':
			phpAds_dbQuery("DO RELEASE_LOCK('{$lock['id']}')");
			break;
	}
}

?>