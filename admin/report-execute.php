<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");


if (isset($plugin) && $plugin != '')
{
	$filename = 'report-plugins/'.$plugin.'.plugin.php';
	
	if (file_exists($filename))
	{
		include ($filename);
		$plugininfo = $plugin_info_function();
		
		// Check security
		phpAds_checkAccess($plugininfo["plugin-authorize"]);
		
		$plugin_execute_function = $plugininfo["plugin-execute"];
		$plugin_import 			 = $plugininfo["plugin-import"];
		$plugin_variables		 = array();
		
		for (reset($plugin_import);$key=key($plugin_import);next($plugin_import))
		{
			if (isset($$key) && $$key != '')
				$plugin_variables[] = "'".$$key."'";
			else
				$plugin_variables[] = "''";
		}
		
		$executestring = $plugin_execute_function."(".implode(",", $plugin_variables).");";
		eval ($executestring);
	}
}

?>
