<?php // $Id$

/************************************************************************/
/* phpPgAds                                                             */
/* ========                                                             */
/*                                                                      */
/* Copyright (c) 2001 by the phpPgAds developers                        */
/* http://sourceforge.net/projects/phppgads                             */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



$phpAds_settings_write_cache = array();
$phpAds_settings_update_cache = array();

$phpAds_configFilepath = phpAds_path.'/config.inc.php';



/*********************************************************/
/* Public: Determine if the config file is writable      */
/*********************************************************/

function phpAds_isConfigWritable ()
{
	global $phpAds_configFilepath;
	return (@fclose(@fopen($phpAds_configFilepath, 'a')));
}



/*********************************************************/
/* Public: Edit a setting                                */
/*********************************************************/

function phpAds_SettingsWriteAdd($key, $value)
{
	global $phpAds_settings_write_cache;
	
	$phpAds_settings_write_cache[$key] = $value;
	return true;
}



/*********************************************************/
/* Public: Store all edited settings                     */
/*********************************************************/

function phpAds_SettingsWriteFlush()
{
	global $phpAds_config;
	global $phpAds_settings_information, $phpAds_settings_write_cache;
	
	$sql = array();
	$config_inc = array();
	
	while (list($k, $v) = each($phpAds_settings_write_cache))
	{
		$k_sql  = $phpAds_settings_information[$k]['sql'];
		$k_type = $phpAds_settings_information[$k]['type'];
		
		if ($k_sql)
			$sql[] = "$k = '$v'";
		else
		{
			if ($k_type == 'boolean')
				$v = $v == 't';
			elseif ($k_type != 'array')
				$v = stripslashes($v);
			
			$config_inc[] = array($k,
				$v,
				$k_type);
		}
	}
	
	if (count($sql))
	{
		$query = "UPDATE ".$phpAds_config['tbl_config']." SET ".join(", ", $sql);
		$res = @phpAds_dbQuery($query);
		
		if (@phpAds_dbAffectedRows($res) < 1)
		{
			$query = "INSERT INTO ".$phpAds_config['tbl_config']." SET ".join(", ", $sql);
			@phpAds_dbQuery($query);
		}
	}
	
	if (count($config_inc))
	{
		if (!phpAds_ConfigFilePrepare())
			return false;
		
		while(list(, $v) = each($config_inc))
			phpAds_ConfigFileSet($v[0], $v[1], $v[2]);
		
		return phpAds_ConfigFileFlush();
	}
	
	return true;
}



/*********************************************************/
/* Public: Clear the config file                         */
/*********************************************************/

function phpAds_ConfigFileClear ()
{
	global $phpAds_configFilepath;
	
	$config		= @fopen($phpAds_configFilepath,'w');
	$template   = @fopen(phpAds_path.'/misc/config.template.php','r');
	
	if ($config && $template)
	{
		// Write the contents of the template to the config file
		@fwrite ($config, @fread($template, filesize(phpAds_path.'/misc/config.template.php')));
		
		@fclose($template);
		@fclose($config);
	}
}



/*********************************************************/
/* Public: Import settings from the config file          */
/*********************************************************/

function phpAds_ConfigFileUpdatePrepare ()
{
	global $phpAds_configFilepath;
	global $phpAds_settings_information, $phpAds_settings_update_cache;
	
	if ($confighandle = @fopen($phpAds_configFilepath,'r'))
	{
		// Read old config file into buffer
		$buffer = @fread($confighandle, filesize($phpAds_configFilepath));
		@fclose ($confighandle);
		
		// Determine config file format
		if (ereg("phpAds_config\[", $buffer))
		{
			// Post configmanager
			while (eregi("\n.phpAds_config\['([^']*)'\]([^;]*);", $buffer, $regs))
			{
				if (isset($phpAds_settings_information[$regs[1]]))
				{
					// Set variable name to lowercase
					$regs[1] = strtolower($regs[1]);
					
					// Remove 'From' header from admin_email_headers
					if ($regs[1] == 'admin_email_headers')
						$regs[2] = ereg_replace('From: .*\n', '', $regs[2]);
					
					// Don't trust url prefix, because the update might
					// occur in a different directory as the original installation
					if ($regs[1] == 'url_prefix')
					{
						$regs[2] = ' = \''.strtolower(eregi_replace("^([a-z]+)/.*$", "\\1://",
							       $GLOBALS['SERVER_PROTOCOL'])).$GLOBALS['HTTP_HOST'].
								   ereg_replace("/admin/upgrade.php(\?.*)?$", "", $GLOBALS['REQUEST_URI']).'\'';
					}
					
					eval ("$"."value ".$regs[2].";");
					settype ($value, $phpAds_settings_information[$regs[1]]['type']);
					
					$phpAds_settings_update_cache[$regs[1]] = $value;
				}
				$buffer = str_replace ($regs[0], '', $buffer);
			}
		}
		else
		{
			// Pre configmanager
			while (eregi("\n.phpAds_([a-z0-9_]*)[^=]*([^;]*);", $buffer, $regs))
			{
				// Check for renamed settings
				switch ($regs[1])
				{
					case 'hostname': 		$regs[1] = 'dbhost'; break;
					case 'mysqluser': 		$regs[1] = 'dbuser'; break;
					case 'pgsqluser': 		$regs[1] = 'dbuser'; break;
					case 'mysqlpassword': 	$regs[1] = 'dbpassword'; break;
					case 'pgsqlpassword': 	$regs[1] = 'dbpassword'; break;
					case 'db':		 		$regs[1] = 'dbname'; break;
					case 'random_retrieve': $regs[1] = 'retrieval_method'; break;
				}
				
				// Set variable name to lowercase
				$regs[1] = strtolower($regs[1]);
				
				if (isset($phpAds_settings_information[$regs[1]]))
				{
					// Remove 'From' header from admin_email_headers
					if ($regs[1] == 'admin_email_headers')
						$regs[2] = ereg_replace('From: .*\n', '', $regs[2]);
					
					// Empty name if left to default value
					if ($regs[1] == 'name' && ($regs[2] == 'phpPgAds' || $regs[2] == 'phpAdsNew'))
						$regs[2] = '';
					
					// Don't trust url prefix, because the update might
					// occur in a different directory as the original installation
					if ($regs[1] == 'url_prefix')
					{
						$regs[2] = ' = \''.strtolower(eregi_replace("^([a-z]+)/.*$", "\\1://",
							       $GLOBALS['SERVER_PROTOCOL'])).$GLOBALS['HTTP_HOST'].
								   ereg_replace("/admin/upgrade.php(\?.*)?$", "", $GLOBALS['REQUEST_URI']).'\'';
					}
					
					// Parse variables inside assignments
					while (ereg('\$phpAds_([a-zA-Z0-9_]+)', $regs[2], $varregs))
					{
						$regs[2] = str_replace($varregs[0],
							isset($phpAds_settings_update_cache[$varregs[1]]) ?
								$phpAds_settings_update_cache[$varregs[1]] :
								'', $regs[2]);
					}
					
					eval ("$"."value ".$regs[2].";");
					settype ($value, $phpAds_settings_information[$regs[1]]['type']);
					
					$phpAds_settings_update_cache[$regs[1]] = $value;
				}
				
				$buffer = str_replace ($regs[0], '', $buffer);
			}
		}
		
		return (true);
	}
	else
		return (false);
}



function phpAds_ConfigFileUpdateFlush()
{
	global $phpAds_settings_update_cache;
	
	for (reset($phpAds_settings_update_cache);
		 $key = key($phpAds_settings_update_cache);
		 next($phpAds_settings_update_cache))
	{
		phpAds_SettingsWriteAdd ($key, $phpAds_settings_update_cache[$key]);
	}
	
	// Before we start writing all the settings
	// start with a clean config file to make
	// sure we always have the latest version
	phpAds_ConfigFileClear();
	
	// Now write all the settings back to the
	// clean config file
	return phpAds_SettingsWriteFlush();
}



function phpAds_ConfigFileUpdateExport()
{
	global $phpAds_config;
	global $phpAds_settings_update_cache;
	
	for (reset($phpAds_settings_update_cache);
		 $key = key($phpAds_settings_update_cache);
		 next($phpAds_settings_update_cache))
	{
		// Overwrite existing values
		$phpAds_config[$key] = $phpAds_settings_update_cache[$key];
	}
}






/*********************************************************/
/* Private: Read the config file and start editing       */
/*********************************************************/

function phpAds_ConfigFilePrepare ()
{
	global $phpAds_configBuffer, $phpAds_configFilepath;
	
	if (phpAds_isConfigWritable ())
	{
		if ($confighandle = @fopen($phpAds_configFilepath,'r'))
		{
			$phpAds_configBuffer = @fread($confighandle, filesize($phpAds_configFilepath));
			@fclose ($confighandle);
			
			return (true);
		}
		else
			return (false);
	}
	else
		return (false);
}



/*********************************************************/
/* Private: Edit a setting                               */
/*********************************************************/

function phpAds_ConfigFileSet ($key, $value, $type)
{
	global $phpAds_configBuffer;
	
	// Prepare value
	if ($type == 'array' && is_array($value))
	{
		reset ($value);
		
		while (list ($akey, $aval) = each ($value)) 
		{
		    if (is_string ($aval))
				$value[$akey] = "'$aval'";
		}
		
		$value = "array (".implode (',', $value).")";
	}
	elseif ($type == 'string')
	{
		$value = "'$value'";
	}
	elseif ($type == 'boolean')
	{
		$value = ($value ? 'true' : 'false');
	}
	
	
	if (ereg(".phpAds_config\['".$key."'\][^=]*=[^;]*;", $phpAds_configBuffer, $regs))
	{
		$phpAds_configBuffer = str_replace ($regs[0], "\$phpAds_config['".$key."'] = ".$value.";", $phpAds_configBuffer);
	}
}



/*********************************************************/
/* Private: Write edited config file                     */
/*********************************************************/

function phpAds_ConfigFileFlush ()
{
	global $phpAds_configBuffer, $phpAds_configFilepath;
	
	if ($phpAds_configBuffer != '')
	{
		if ($confighandle = @fopen($phpAds_configFilepath,'w'))
		{
			$result = @fwrite ($confighandle, $phpAds_configBuffer);
			@fclose ($confighandle);
			
			return $result;
		}
		else
			return (false);
	}
	else
		return (false);
}


?>