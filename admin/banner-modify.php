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
require ("lib-storage.inc.php");
require ("lib-zones.inc.php");
require ("../lib-priority.inc.php");


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
		
		// Rebuild zone cache
		if ($phpAds_config['zone_cache'])
			phpAds_RebuildZoneCache ();
		
		// Rebuild priorities
		phpAds_PriorityCalculate ();
		
		Header ("Location: ".$returnurl."?campaignid=".$moveto."&bannerid=".$bannerid);
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
	   	      bannerid = ".$bannerid."
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
		
		Header ("Location: ".$returnurl."?campaignid=".$campaignid."&bannerid=".$applyto);
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
				bannerid = ".$bannerid."
		") or phpAds_sqlDie();
		
		if ($row = phpAds_dbFetchArray($res))
		{
			// Remove bannerid
			unset($row['bannerid']);
			
			// Duplicate webserver stored banner
			if ($row['format'] == 'web')
				$row['banner'] = phpAds_ImageDuplicate ($row['banner']);
			
			
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
			   	      bannerid = ".$bannerid."
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
		
		// Rebuild zone cache
		if ($phpAds_config['zone_cache'])
			phpAds_RebuildZoneCache ();
		
		// Rebuild priorities
		phpAds_PriorityCalculate ();
		
		Header ("Location: ".$returnurl."?campaignid=".$campaignid."&bannerid=".$new_bannerid);
	}
}

?>
