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



function phpAds_maintenanceGetLock()
{
	$lock = array(
		'type' => 'db',
		'id' => addslashes('pan.'.$GLOBALS['phpAds_config']['instance_id'])
	);
	
	if (phpAds_dbResult(phpAds_dbQuery("SELECT GET_LOCK('{$lock['id']}', 0)"), 0, 0))
		return $lock;
	
	return false;
}

function phpAds_maintenanceReleaseLock($lock)
{
	switch ($lock['type'])
	{
		case 'db':
			phpAds_dbQuery("DO RELEASE('{$lock['id']}')");
			break;
	}
}

?>