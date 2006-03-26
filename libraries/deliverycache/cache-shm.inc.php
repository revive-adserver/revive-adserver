<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set define to prevent duplicate include
define ('LIBVIEWCACHE_INCLUDED', true);


define ('phpAds_shmopID', 0xff3);
define ('phpAds_shmopIndexSize', 4096);
define ('phpAds_shmopSegmentSize', 65536);


function phpAds_cacheFetch ($name)
{
	// First read cache structure from shared memory
	$shm_id = @shmop_open(phpAds_shmopID, "a", 0, 0);
	
	if ($shm_id)
	{
		// Get the size of the structure
		$size = @shmop_read ($shm_id, 0, 4);
		$size = hexdec ($size);
		
		if ($size > 0)
		{
			// Read the structure
			$structure = @shmop_read ($shm_id, 4, $size);
			$structure = unserialize($structure);
			@shmop_close ($shm_id);
			
			if (isset($structure[$name]))
			{
				$seg_id = @shmop_open(phpAds_shmopID + $structure[$name], "a", 0, 0);
				
				if ($seg_id) 
				{
					// Get the size of the structure
					$cache_size = @shmop_read ($seg_id, 0, 4);
					$cache_size = hexdec ($cache_size);
					$cache_data = @shmop_read ($seg_id, 4, $cache_size);
					@shmop_close($seg_id);
					
					return (unserialize($cache_data));
				}
				else
					return false;
			}
			else
				return false;
		}
		else
		{
			@shmop_close ($shm_id);
			return false;
		}
	}
	else
		return false;
}

function phpAds_cacheStore ($name, $cache)
{
	// First read cache structure from shared memory
	$struc_id = shmop_open(phpAds_shmopID, "c", 0644, phpAds_shmopIndexSize);
	
	if ($struc_id)
	{
		// Get the size of the structure
		$size = @shmop_read ($struc_id, 0, 4);
		$size = hexdec ($size);
		
		// Fetch the structure
		if ($size > 0)
		{
			$structure = shmop_read ($struc_id, 4, $size);
			$structure = unserialize($structure);
		}
		else
		{
			$structure = array();
		}
		
		
		// Get highest segment id
		$highest = 0;
		reset ($structure);
		while (list($k, $v) = each ($structure))
			if ($v > $highest) $highest = $v;
		
		// Get lowest unused segment id
		for ($i = 1; $i <= $highest + 1; $i++)
		{
			if (!in_array($i, $structure))
			{
				$segment = $i;
				break;
			}
		}
		
		if (isset($structure[$name]))
			$delete = $structure[$name];
		else
			$delete = false;
		
		$seg_id = shmop_open(phpAds_shmopID + $segment, "c", 0644, phpAds_shmopSegmentSize);
		
		if ($seg_id)
		{
			// Store data
			$seg_data = serialize($cache);
			$seg_size = strlen($seg_data);
			$seg_size = sprintf ('%04X', $seg_size);
			
			shmop_write($seg_id, $seg_size, 0);
			shmop_write($seg_id, $seg_data, 4);
			shmop_close($seg_id);
			
			
			// Update structure
			$structure[$name] = $segment;
			
			// Store the structure
			$struc_data = serialize ($structure);
			$struc_size = strlen($struc_data);
			$struc_size = sprintf ('%04X', $struc_size);
			
			shmop_write($struc_id, $struc_size, 0);
			shmop_write($struc_id, $struc_data, 4);
			shmop_close($struc_id);
			
			
			// Delete old segment
			if ($delete)
			{
				$del_id = shmop_open(phpAds_shmopID + $delete, "w", 0, 0);
				shmop_delete($del_id);
				shmop_close($del_id);
			}
			
			return true;
		}
		else
		{
			shmop_close($struc_id);
			return false;
		}
	}
	else
	{
		return false;
	}
}


function phpAds_cacheDelete ($name = '')
{
	// First read cache structure from shared memory
	$struc_id = shmop_open(phpAds_shmopID, "c", 0644, phpAds_shmopIndexSize);
	
	if ($struc_id)
	{
		// Get the size of the structure
		$size = @shmop_read ($struc_id, 0, 4);
		$size = hexdec ($size);
		
		// Fetch the structure
		if ($size > 0)
		{
			$structure = shmop_read ($struc_id, 4, $size);
			$structure = unserialize($structure);
		}
		else
			return false;
		
		
		if ($name != '' && isset($structure[$name]))
		{
			$delete = $structure[$name];
			
			// Update structure
			unset($structure[$name]);
			
			// Store the structure
			$struc_data = serialize ($structure);
			$struc_size = strlen($struc_data);
			$struc_size = sprintf ('%04X', $struc_size);
			
			shmop_write($struc_id, $struc_size, 0);
			shmop_write($struc_id, $struc_data, 4);
			shmop_close($struc_id);
			
			// Delete old segment
			$del_id = shmop_open(phpAds_shmopID + $delete, "w", 0, 0);
			shmop_delete($del_id);
			shmop_close($del_id);
			
			return true;
		}
		
		if ($name == '')
		{
			while (list($k, $v) = each($structure))
			{
				// Delete old segment
				$del_id = shmop_open(phpAds_shmopID + $v, "w", 0, 0);
				shmop_delete($del_id);
				shmop_close($del_id);
			}
			
			$structure = array();
			
			// Store the structure
			$struc_data = serialize ($structure);
			$struc_size = strlen($struc_data);
			$struc_size = sprintf ('%04X', $struc_size);
			
			shmop_write($struc_id, $struc_size, 0);
			shmop_write($struc_id, $struc_data, 4);
			shmop_close($struc_id);
			
			return true;
		}
	}
	
	return false;
}


function phpAds_cacheInfo ()
{
	// First read cache structure from shared memory
	$struc_id = shmop_open(phpAds_shmopID, "c", 0644, phpAds_shmopIndexSize);
	
	if ($struc_id)
	{
		// Get the size of the structure
		$size = @shmop_read ($struc_id, 0, 4);
		$size = hexdec ($size);
		
		// Fetch the structure
		if ($size > 0)
		{
			$structure = shmop_read ($struc_id, 4, $size);
			$structure = unserialize($structure);
			shmop_close($struc_id);
		}
		else
			return false;
		
		$result = array();
		
		while (list($k, $v) = each($structure))
		{
			// Delete old segment
			$info_id = shmop_open(phpAds_shmopID + $v, "a", 0, 0);
			
			// Get the size of the structure
			$result[$k] = @shmop_read ($info_id, 0, 4);
			$result[$k] = hexdec ($result[$k]);
			
			shmop_close($info_id);
		}
		
		return $result;
	}
	
	return false;
}


?>