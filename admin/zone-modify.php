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



// Include required files
require ("config.php");
require ("lib-storage.inc.php");
require ("lib-statistics.inc.php");


// Register input variables
phpAds_registerGlobal ('returnurl', 'moveto', 'duplicate');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($zoneid) && $zoneid != '')
{
	if (isset($moveto) && $moveto != '')
	{
		// Move the zone
		$res = phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_zones']." SET affiliateid = '".$moveto."' WHERE zoneid = '".$zoneid."'") or phpAds_sqlDie();

		// Prevent HTTP response splitting
		if (strpos($returnurl, "\r\n") === false)
		{
			$url = stripslashes($returnurl);
		
			header ("Location: ".$returnurl."?affiliateid=".$moveto."&zoneid=".$zoneid);
			exit;
		}
	}
	elseif (isset($duplicate) && $duplicate == 'true')
	{
		// Duplicate the zone
		
		$res = phpAds_dbQuery("
			SELECT
		   		*
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '".$zoneid."'
		") or phpAds_sqlDie();
		
		
		if ($row = phpAds_dbFetchArray($res))
		{
			// Get names
			if (ereg("^(.*) \([0-9]+\)$", $row['zonename'], $regs))
				$basename = $regs[1];
			else
				$basename = $row['zonename'];
			
			$names = array();
			
			$res = phpAds_dbQuery("
				SELECT
			   		*
				FROM
					".$phpAds_config['tbl_zones']."
			") or phpAds_sqlDie();
			
			while ($name = phpAds_dbFetchArray($res))
				$names[] = $name['zonename'];
			
			
			// Get unique name
			$i = 2;
			
			while (in_array($basename.' ('.$i.')', $names))
				$i++;
			
			$row['zonename'] = $basename.' ('.$i.')';
			
			
			// Remove bannerid
			unset($row['zoneid']);
	   		
			$values = array();
			
			while (list($name, $value) = each($row))
				$values[] = $name." = '".addslashes($value)."'";
			
	   		$res = phpAds_dbQuery("
		   		INSERT INTO
		   			".$phpAds_config['tbl_zones']."
				SET
					".implode(", ", $values)."
	   		") or phpAds_sqlDie();
			
			$new_zoneid = phpAds_dbInsertID();
			
			Header ("Location: ".$returnurl."?affiliateid=".$affiliateid."&zoneid=".$new_zoneid);
			exit;
		}
	}
}

// Prevent HTTP response splitting
if (strpos($returnurl, "\r\n") === false)
{
	$url = stripslashes($returnurl);

	header ("Location: ".$returnurl."?affiliateid=".$affiliateid."&zoneid=".$zoneid);
}

?>