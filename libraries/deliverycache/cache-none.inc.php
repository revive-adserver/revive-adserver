<?php // $Revision$

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
define ('LIBVIEWCACHE_INCLUDED', true);


function phpAds_cacheFetch ($name)
{
	return false;
}

function phpAds_cacheStore ($name, $cache)
{
	return false;
}

function phpAds_cacheDelete ($name = '')
{
	return true;
}

function phpAds_cacheInfo ()
{
	return false;
}


?>