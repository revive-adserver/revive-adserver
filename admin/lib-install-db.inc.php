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



// Define
define ('phpAds_databaseUpgradeSupported', true);
define ('phpAds_databaseCreateSupported', true);
define ('phpAds_tableTypesSupported', true);




/*********************************************************/
/* Create the database                                   */
/*********************************************************/

function phpAds_checkDatabase ()
{
	// Get the database structure
	$dbstructure = phpAds_prepareDatabaseStructure();
	
	// Get table names
	$res = phpAds_dbQuery("SHOW TABLES");
	while ($row = phpAds_dbFetchRow($res))
		$availabletables[] = $row[0];
	
	$result = false;
	
	for (reset($dbstructure);
		$key = key($dbstructure);
		next($dbstructure))
	{
		if (is_array($availabletables) && in_array ($key, $availabletables))
		{
			// Table exists
			$result = true;
		}
	}
	
	return $result;
}



/*********************************************************/
/* Upgrade the database to the latest structure          */
/*********************************************************/

function phpAds_upgradeDatabase ($tabletype = '')
{
	// Get the database structure
	$dbstructure = phpAds_prepareDatabaseStructure();
	
	// Get table names
	$res = phpAds_dbQuery("SHOW TABLES");
	while ($row = phpAds_dbFetchRow($res))
		$availabletables[] = $row[0];
	
	for (reset($dbstructure);
		$key = key($dbstructure);
		next($dbstructure))
	{
		if (is_array($availabletables) && in_array ($key, $availabletables))
		{
			// Table exists, upgrade
			phpAds_upgradeTable ($key, $dbstructure[$key]);
		}
		else
		{
			// Table doesn't exists, create
			phpAds_createTable ($key, $dbstructure[$key], $tabletype);
		}
	}
	
	// Split banners into two tables and
	// generate banner html cache
	phpAds_upgradeSplitBanners();
	
	return true;
}



/*********************************************************/
/* Create the database                                   */
/*********************************************************/

function phpAds_createDatabase ($tabletype = '')
{
	// Get the database structure
	$dbstructure = phpAds_prepareDatabaseStructure();
	
	// Get table names
	$res = phpAds_dbQuery("SHOW TABLES");
	while ($row = phpAds_dbFetchRow($res))
		$availabletables[] = $row[0];
	
	for (reset($dbstructure);
		$key = key($dbstructure);
		next($dbstructure))
	{
		if (is_array($availabletables) && in_array ($key, $availabletables))
		{
			// Table exists, drop it
			phpAds_dropTable ($key);
		}
		
		// Table doesn't exists, create
		phpAds_createTable ($key, $dbstructure[$key], $tabletype);
	}
	
	return true;
}




/*********************************************************/
/* Upgrade a table to the latest structure               */
/*********************************************************/

function phpAds_upgradeTable ($name, $structure)
{
	$columns = $structure['columns'];
	if (isset($structure['primary'])) $primary = $structure['primary'];
	if (isset($structure['index']))   $index   = $structure['index'];
	if (isset($structure['unique']))  $unique  = $structure['unique'];
	
	// Get existing columns
		$availablecolumns[$row['Field']] = $row;
	
	// Change case of all columns to lower
	$res = phpAds_dbQuery("DESCRIBE ".$name);
	while ($row = phpAds_dbFetchArray($res))
	{
		if ($row['Field'] != strtolower($row['Field']))
		{
			// Change case
			$check = $row['Type'];
			if ($row['Default'] != '') $check .= " DEFAULT '".$row['Default']."'";
			if ($row['Null'] != 'YES') $check .= " NOT NULL";
			if (ereg('auto_increment', $row['Extra'])) $check .= " AUTO_INCREMENT";
			
			$query = "ALTER TABLE ".$name." CHANGE COLUMN ".$row['Field']." ".strtolower($row['Field'])." ".$check;
			
			phpAds_dbQuery($query);
		}
	}
	
	
	// Get existing columns
	$res = phpAds_dbQuery("DESCRIBE ".$name);
	while ($row = phpAds_dbFetchArray($res))
		$availablecolumns[$row['Field']] = $row;
	
	
	// Get existing indexes
	$res = phpAds_dbQuery("SHOW INDEX FROM ".$name);
	while ($row = phpAds_dbFetchArray($res))
		if ($row['Key_name'] != 'PRIMARY')
		{
			if ($row['Non_unique'] == 0)
				$availableunique[$row['Key_name']][] = $row['Column_name'];
			else
				$availableindex[$row['Key_name']][] = $row['Column_name'];
		}
		else
			$availableprimary[] = $row['Column_name'];
	
	
	// Check columns
	for (reset($columns); $key = key($columns);	next($columns))
	{
		$createdefinition = $key." ".$columns[$key];
		
		if (isset($availablecolumns[$key]) && is_array($availablecolumns[$key]))
		{
			// Column exists, check if it need updating
			$check = $availablecolumns[$key]['Type'];
			if ($availablecolumns[$key]['Default'] != '') $check .= " DEFAULT '".$availablecolumns[$key]['Default']."'";
			if ($availablecolumns[$key]['Null'] != 'YES') $check .= " NOT NULL";
			if (ereg('auto_increment', $availablecolumns[$key]['Extra'])) $check .= " AUTO_INCREMENT";
			
			if ($check != $columns[$key])
			{
				// Check if the column is a boolean
				if (ereg("enum\('t','f'\)", $columns[$key]) && $availablecolumns[$key]['Type'] == "enum('true','false')")
				{
					// Boolean found
					
					// Change to intermediate type first
					$intermediate = "enum('true','false','t','f')";
					if ($availablecolumns[$key]['Default'] != '') $intermediate .= " DEFAULT '".$availablecolumns[$key]['Default']."'";
					if ($availablecolumns[$key]['Null'] != 'YES') $intermediate .= " NOT NULL";
					if (ereg('auto_increment', $availablecolumns[$key]['Extra'])) $intermediate .= " AUTO_INCREMENT";
					phpAds_dbQuery("ALTER TABLE ".$name." MODIFY COLUMN ".$key." ".$intermediate);
					
					// Change values
					phpAds_dbQuery("UPDATE ".$name." SET ".$key." = 't' WHERE ".$key." = 'true'");
					phpAds_dbQuery("UPDATE ".$name." SET ".$key." = 'f' WHERE ".$key." = 'false'");
					
					// Okay, now continue and change the type to the new boolean
				}
				
				phpAds_dbQuery("ALTER TABLE ".$name." MODIFY COLUMN ".$createdefinition);
			}
		}
		else
		{
			// Column doesn't exist, create it
			phpAds_dbQuery("ALTER TABLE ".$name." ADD COLUMN ".$createdefinition);
		}
	}
	
	
	// Check Primary
	if (is_array($primary) && sizeof($primary) > 0)
	{
		phpAds_dbQuery("ALTER TABLE ".$name." DROP PRIMARY KEY");
		phpAds_dbQuery("ALTER TABLE ".$name." ADD PRIMARY KEY (".implode(",", $primary).")");
	}
	
	
	// Check Indexes
	if (is_array($index) && sizeof($index) > 0)
	{
		for (reset($index); $key = key($index);	next($index))
		{
			if (!isset($availableindex[$key]) || !is_array($availableindex[$key]))
			{
				// Index does not exist, so create it
				phpAds_dbQuery("ALTER TABLE ".$name." ADD INDEX ".$key." (".implode(",", $index[$key]).")");
			}
		}
	}
	
	
	// Check Unique Indexes
	if (is_array($unique) && sizeof($unique) > 0)
	{
		for (reset($unique); $key = key($unique); next($unique))
		{
			if (!isset($availableunique[$key]) || !is_array($availableunique[$key]))
			{
				// Index does not exist, so create it
				phpAds_dbQuery("ALTER TABLE ".$name." ADD UNIQUE ".$key." (".implode(",", $unique[$key]).")");
			}
		}
	}
}



/*********************************************************/
/* Create a table                                        */
/*********************************************************/

function phpAds_createTable ($name, $structure, $tabletype = '')
{
	$columns = $structure['columns'];
	if (isset($structure['primary'])) $primary = $structure['primary'];
	if (isset($structure['index']))   $index   = $structure['index'];
	if (isset($structure['unique']))  $unique  = $structure['unique'];
	
	// Create empty array
	$createdefinitions = array();
	
	// Add columns
	for (reset($columns); $key = key($columns);	next($columns))
		$createdefinitions[] = $key." ".$columns[$key];
	
	if (isset($primary) && is_array($primary))
		$createdefinitions[] = "PRIMARY KEY (".implode(",", $primary).")";
	
	if (isset($index) && is_array($index))
	{
		for (reset($index);$key=key($index);next($index))
			$createdefinitions[] = "KEY $key (".implode(",", $index[$key]).")";
	}
	
	if (isset($unique) && is_array($unique))
	{
		for (reset($unique);$key=key($unique);next($unique))
			$createdefinitions[] = "UNIQUE $key (".implode(",", $unique[$key]).")";
	}
	
	if (is_array($createdefinitions) &&
		sizeof($createdefinitions) > 0)
	{
		$query  = "CREATE TABLE $name (";
		$query .= implode (", ", $createdefinitions);
		$query .= ")";
		
		// Tabletype
		if ($tabletype != '')
			$query .= " TYPE=".$tabletype;
		
		phpAds_dbQuery($query);
	}
}



/*********************************************************/
/* Drop an existing table                                */
/*********************************************************/

function phpAds_dropTable ($name)
{
	return phpAds_dbQuery("DROP TABLE ".$name);
}


/*********************************************************/
/* Get table types                                       */
/*********************************************************/

function phpAds_getTableTypes ()
{
	// Assume MySQL always supports MyISAM table types
	
	/* 
	$types['MYISAM'] = 'MyISAM';
	
	$res = phpAds_dbQuery("SHOW VARIABLES");
	while ($row = phpAds_dbFetchRow($res))
	{
		if ($row[0] == 'have_bdb' && $row[1] == 'YES')
			$types['BDB'] = 'Berkeley DB';
		
		if ($row[0] == 'have_gemini' && $row[1] == 'YES')
			$types['GEMINI'] = 'NuSphere Gemini';
		
		if ($row[0] == 'have_innodb' && $row[1] == 'YES')
			$types['INNODB'] = 'InnoDB';
	}
	*/
	
	$types['MYISAM'] = 'MyISAM';
	$types['BDB'] = 'Berkeley DB';
	$types['GEMINI'] = 'NuSphere Gemini';
	$types['INNODB'] = 'InnoDB';
	
	return $types;
}



/*********************************************************/
/* Get the default table type                            */
/*********************************************************/

function phpAds_getTableTypeDefault ()
{
	/*
	$res = phpAds_dbQuery("SHOW VARIABLES");
	while ($row = phpAds_dbFetchRow($res))
	{
		if ($row[0] == 'table_type')
			return $row[1];
	}
	
	return false;
	*/
	
	return 'MYISAM';
}



/*********************************************************/
/* Read the database structure from a sql file           */
/*********************************************************/

function phpAds_readDatabaseStructure ()
{
	global $phpAds_config;
	
	$sql = join("", file(phpAds_path."/misc/all.sql"));
	
	// Stripping comments
	$sql = ereg_replace("$-- [^\n]*\n", "\n", $sql);
	$sql = ereg_replace("$#[^\n]*\n", "\n", $sql);
	
	// Stripping (CR)LFs
	//$sql = str_replace("\r?\n\r?", "", $sql);
	$sql = str_replace("\n", " ", $sql);
	$sql = str_replace("\r", " ", $sql);
	
	
	// Unifying duplicate blanks
	$sql = ereg_replace("[[:blank:]]+", " ", $sql);
	
	$sql = explode(";", $sql);
	
	// Replacing table names to match config.inc.php
	for ($i=0;$i<sizeof($sql);$i++)
	{
		if (ereg ("CREATE TABLE (phpads_[^\(]*) \(", $sql[$i], $regs))
		{
			$tablename = str_replace ("phpads_", "tbl_", $regs[1]);
			
			if (isset($phpAds_config[$tablename]))
				$sql[$i] = str_replace ($regs[1], $phpAds_config[$tablename], $sql[$i]);
		}
	}
	
	// Create an array with an element for each query
	return $sql;
}



/*********************************************************/
/* Parse the an sql file and return all queries          */
/*********************************************************/

function phpAds_prepareDatabaseStructure()
{
	$dbstructure = array();
	
	// Read the all.sql file
	$queries = phpAds_readDatabaseStructure ();
	
	
	for ($i=0;$i<sizeof($queries)-1;$i++)
	{
		if (ereg ("CREATE TABLE ([^\(]*) \((.*)\)", $queries[$i], $regs))
		{
			$tablename   = $regs[1];
			$definitions = $regs[2];
			
			$definitions = explode (", ", $definitions);
			
			for ($j=0;$j<sizeof($definitions);$j++)
			{
				$definition = trim($definitions[$j]);
				
				if (ereg("^PRIMARY KEY \((.*)\)$", $definition, $regs))
				{
					$items = explode(",", $regs[1]);
					for ($k=0;$k<sizeof($items);$k++)
						$dbstructure[$tablename]['primary'][] = $items[$k];
				}
				elseif (ereg("^(KEY|INDEX) ([^ ]*) \((.*)\)$", $definition, $regs))
				{
					$items = explode(",", $regs[3]);
					for ($k=0;$k<sizeof($items);$k++)
						$dbstructure[$tablename]['index'][$regs[2]][] = $items[$k];
				}
				elseif (ereg("^UNIQUE ([^ ]*) \((.*)\)$", $definition, $regs))
				{
					$items = explode(",", $regs[2]);
					for ($k=0;$k<sizeof($items);$k++)
						$dbstructure[$tablename]['unique'][$regs[1]][] = $items[$k];
				}
				elseif (ereg("^([^ ]*) (.*)$", $definition, $regs))
				{
					$dbstructure[$tablename]['columns'][$regs[1]] = $regs[2];
				}
			}
		}
	}
	
	return $dbstructure;
}


/*********************************************************/
/* Version specific updates                              */
/*********************************************************/

function phpAds_upgradeSplitBanners ()
{
	global $phpAds_config;
	
	// Check if splitting is needed
	if (!isset($phpAds_config['config_version']) ||	$phpAds_config['config_version'] < 200.070)
	{
		// Fetch all banners
		$res = phpAds_dbQuery ("SELECT * FROM ".$phpAds_config['tbl_banners']);
		
		while ($row = phpAds_dbFetchArray($res))
		{
			$banners[] = $row;
		}
		
		for ($i=0; $i < count($banners); $i++)
		{
			// Requote fields
			$banners[$i]['alt'] 		= phpAds_htmlQuotes(stripslashes($banners[$i]['alt']));
			$banners[$i]['bannertext'] 	= phpAds_htmlQuotes(stripslashes($banners[$i]['bannertext']));
			
			// Resplit keywords
			if (isset($banners[$i]['keyword']) && $banners[$i]['keyword'] != '')
			{
				$keywordArray = split('[ ,]+', trim($banners[$i]['keyword']));
				$banners[$i]['keyword'] = implode(' ', $keywordArray);
			}
			
			// Determine storagetype
			switch ($banners[$i]['format'])
			{
				case 'url':		$banners[$i]['storagetype'] = 'url';	break;
				case 'html':	$banners[$i]['storagetype'] = 'html';	break;
				case 'web':		$banners[$i]['storagetype'] = 'web';	break;
				default:		$banners[$i]['storagetype'] = 'sql';	break;
			}
			
			switch ($banners[$i]['storagetype'])
			{
				case 'sql':
					
					// Determine contenttype
					$banners[$i]['contenttype']  = $banners[$i]['format'];
					
					// Store the file
					$banners[$i]['filename']	 = 'banner_'.$banners[$i]['bannerid'].'.'.$banners[$i]['contenttype'];
					$banners[$i]['filename'] 	 = phpAds_ImageStore($banners[$i]['storagetype'], $banners[$i]['filename'], $banners[$i]['banner']);
					$banners[$i]['imageurl']	 = $phpAds_config['url_prefix'].'/adimage.php?filename='.$banners[$i]['filename']."&contenttype=".$banners[$i]['contenttype'];
					
					$banners[$i]['htmltemplate'] = phpAds_getBannerTemplate($banners[$i]['contenttype']);
					$banners[$i]['htmlcache']    = addslashes(phpAds_getBannerCache($banners[$i]));
					$banners[$i]['htmltemplate'] = addslashes($banners[$i]['htmltemplate']);
					
					$banners[$i]['banner']		 = '';
					break;
				
				case 'web':
					// Get the contenttype
					$ext = substr($banners[$i]['banner'], strrpos($banners[$i]['banner'], ".") + 1);
					switch (strtolower($ext)) 
					{
						case 'jpeg': $banners[$i]['contenttype'] = 'jpeg';  break;
						case 'jpg':	 $banners[$i]['contenttype'] = 'jpeg';  break;
						case 'html': $banners[$i]['contenttype'] = 'html';  break;
						case 'png':  $banners[$i]['contenttype'] = 'png';   break;
						case 'gif':  $banners[$i]['contenttype'] = 'gif';   break;
						case 'swf':  $banners[$i]['contenttype'] = 'swf';   break;
					}
					
					// Store the file
					$banners[$i]['filename']	 = basename($banners[$i]['banner']);
					$banners[$i]['imageurl']	 = $banners[$i]['banner'];
					
					$banners[$i]['htmltemplate'] = phpAds_getBannerTemplate($banners[$i]['contenttype']);
					$banners[$i]['htmlcache']    = addslashes(phpAds_getBannerCache($banners[$i]));
					$banners[$i]['htmltemplate'] = addslashes($banners[$i]['htmltemplate']);
					
					$banners[$i]['banner']		 = '';
					break;
				
				case 'url':
					// Get the contenttype
					$ext = parse_url($banners[$i]['banner']);
					$ext = $ext['path'];
					$ext = substr($ext, strrpos($ext, ".") + 1);
					switch (strtolower($ext)) 
					{
						case 'jpeg': $banners[$i]['contenttype'] = 'jpeg';  break;
						case 'jpg':	 $banners[$i]['contenttype'] = 'jpeg';  break;
						case 'html': $banners[$i]['contenttype'] = 'html';  break;
						case 'png':  $banners[$i]['contenttype'] = 'png';   break;
						case 'gif':  $banners[$i]['contenttype'] = 'gif';   break;
						case 'swf':  $banners[$i]['contenttype'] = 'swf';   break;
					}
					
					$banners[$i]['imageurl']	 = $banners[$i]['banner'];
					
					$banners[$i]['htmltemplate'] = phpAds_getBannerTemplate($banners[$i]['contenttype']);
					$banners[$i]['htmlcache']    = addslashes(phpAds_getBannerCache($banners[$i]));
					$banners[$i]['htmltemplate'] = addslashes($banners[$i]['htmltemplate']);
					
					$banners[$i]['filename']	 = '';
					$banners[$i]['banner']		 = '';
					break;
				
				case 'html':
					// Get the contenttype
					$banners[$i]['contenttype']  = 'html';
					
					$banners[$i]['htmltemplate'] = $banners[$i]['banner'];
					$banners[$i]['htmlcache']    = addslashes(phpAds_getBannerCache($banners[$i]));
					$banners[$i]['htmltemplate'] = addslashes($banners[$i]['htmltemplate']);
					
					$banners[$i]['imageurl']	 = '';
					$banners[$i]['filename']	 = '';
					$banners[$i]['banner']		 = '';
					break;
			}
			
			// Update the banner
			$res = phpAds_dbQuery ("
				UPDATE
					".$phpAds_config['tbl_banners']."
				SET
					storagetype = '".$banners[$i]['storagetype']."',
					contenttype = '".$banners[$i]['contenttype']."',
					filename = '".$banners[$i]['filename']."',
					imageurl = '".$banners[$i]['imageurl']."',
					banner = '".$banners[$i]['banner']."',
					htmltemplate = '".$banners[$i]['htmltemplate']."',
					htmlcache = '".$banners[$i]['htmlcache']."',
					alt = '".$banners[$i]['alt']."',
					status = '".$banners[$i]['status']."',
					bannertext = '".$banners[$i]['bannertext']."',
					keyword = '".$banners[$i]['keyword']."'
				WHERE
					bannerid = ".$banners[$i]['bannerid']."
			");
		}
		
		// Delete unneeded columns
		$res = phpAds_dbQuery ("ALTER TABLE ".$phpAds_config['tbl_banners']." DROP COLUMN banner");
		$res = phpAds_dbQuery ("ALTER TABLE ".$phpAds_config['tbl_banners']." DROP COLUMN format");
	}
}



?>