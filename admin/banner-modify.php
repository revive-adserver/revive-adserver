<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-storage.inc.php");
require ("lib-zones.inc.php");
require ("lib-statistics.inc.php");
require ("../lib-priority.inc.php");


// Register input variables
phpAds_registerGlobal ('returnurl', 'duplicate', 'moveto_x', 'moveto', 'applyto_x', 'applyto');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($bannerid) && $bannerid != '')
{
	if (isset($moveto_x) && $moveto != '')
	{
		// Move the banner
		$res = phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_banners']." SET clientid = '".$moveto."' WHERE bannerid = '".$bannerid."'") or phpAds_sqlDie();
		
		// Rebuild priorities
		phpAds_PriorityCalculate ();
		
		// Rebuild zone cache
		if ($phpAds_config['zone_cache'])
			phpAds_RebuildZoneCache ();
		
		// Get new clientid
		$clientid = phpAds_getParentID ($moveto);
		
		Header ("Location: ".$returnurl."?clientid=".$clientid."&campaignid=".$moveto."&bannerid=".$bannerid);
	}
	elseif (isset($applyto_x) && $applyto != '')
	{
		// Apply display limitation to
		
		// Delete old limitations
	   	$res = phpAds_dbQuery("
			DELETE FROM
				".$phpAds_config['tbl_acls']."
			WHERE
				bannerid = ".$applyto."
		") or phpAds_sqlDie();
		
		// Load source limitation
		$res = phpAds_dbQuery("
		   SELECT
	   	      *
	   	   FROM
	   	      ".$phpAds_config['tbl_acls']."
	   	   WHERE
	   	      bannerid = '".$bannerid."'
   	    ") or phpAds_sqlDie();
		
	   	while ($row = phpAds_dbFetchArray($res))
	   	{
	   		$values_fields = '';
	   		$values = '';
	   		
			$row['bannerid'] = $applyto;
	   		
			while (list($name, $value) = each($row))
			{
				$values_fields .= "$name, ";
				$values .= "'".addslashes($value)."', ";
			}
			
 			$values_fields = ereg_replace(", $", "", $values_fields);
			$values = ereg_replace(", $", "", $values);
			
			phpAds_dbQuery("
				INSERT INTO
					".$phpAds_config['tbl_acls']."
					($values_fields)
				VALUES
					($values)
			") or phpAds_sqlDie();
		}
		
		// Get compiledlimitation from source
		$res = phpAds_dbQuery("
			SELECT 
				compiledlimitation
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				bannerid = '".$bannerid."'
		") or phpAds_sqlDie();
		
	   	if ($row = phpAds_dbFetchArray($res))
		{
			$res = phpAds_dbQuery("
				UPDATE 
					".$phpAds_config['tbl_banners']."
				SET
					compiledlimitation = '".addslashes($row['compiledlimitation'])."'
				WHERE
					bannerid = '".$applyto."'
			") or phpAds_sqlDie();
		}
		
		Header ("Location: ".$returnurl."?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$applyto);
	}
	elseif (isset($duplicate) && $duplicate == 'true')
	{
		// Duplicate the banner
		
		$res = phpAds_dbQuery("
			SELECT
		   		*
			FROM
				".$phpAds_config['tbl_banners']."
			WHERE
				bannerid = '".$bannerid."'
		") or phpAds_sqlDie();
		
		if ($row = phpAds_dbFetchArray($res))
		{
			// Remove bannerid
			unset($row['bannerid']);
			
			
			// Duplicate stored banner
			if ($row['storagetype'] == 'web' || $row['storagetype'] == 'sql')
				$row['filename'] = phpAds_ImageDuplicate ($row['storagetype'], $row['filename']);
			
			
			// Clone banner
	   		$values_fields = '';
	   		$values = '';
			
			while (list($name, $value) = each($row))
			{
				$values_fields .= "$name, ";
				$values .= "'".addslashes($value)."', ";
			}
			
			$values_fields = ereg_replace(", $", "", $values_fields);
			$values = ereg_replace(", $", "", $values);
			
	   		$res = phpAds_dbQuery("
		   		INSERT INTO
		   			".$phpAds_config['tbl_banners']."
		   			($values_fields)
		   		VALUES
		   			($values)
	   		") or phpAds_sqlDie();
			
			$new_bannerid = phpAds_dbInsertID();
			
		   	
			if ($phpAds_config['acl'])
			{
				// Clone display limitations
			   	$res = phpAds_dbQuery("
			   	   SELECT
			   	      *
			   	   FROM
			   	      ".$phpAds_config['tbl_acls']."
			   	   WHERE
			   	      bannerid = '".$bannerid."'
		   	    ") or phpAds_sqlDie();
				
			   	while ($row = phpAds_dbFetchArray($res))
			   	{
			   		$values_fields = '';
			   		$values = '';
			   		
					$row['bannerid'] = $new_bannerid;
			   		
					while (list($name, $value) = each($row))
					{
						$values_fields .= "$name, ";
						$values .= "'".addslashes($value)."', ";
					}
					
   					$values_fields = ereg_replace(", $", "", $values_fields);
					$values = ereg_replace(", $", "", $values);
					
					phpAds_dbQuery("
						INSERT INTO
							".$phpAds_config['tbl_acls']."
							($values_fields)
						VALUES
							($values)
					") or phpAds_sqlDie();
				}
			}
		}
		
		// Rebuild priorities
		phpAds_PriorityCalculate ();
		
		// Rebuild zone cache
		if ($phpAds_config['zone_cache'])
			phpAds_RebuildZoneCache ();
		
		Header ("Location: ".$returnurl."?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$new_bannerid);
	}
	else
	{
		Header ("Location: ".$returnurl."?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid);
	}
}

?>