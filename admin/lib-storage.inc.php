<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer                                 */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include FTP emulation library 
// if extension is not present
if (!function_exists("ftp_connect"))
	require ("lib-ftp.inc.php");



/*********************************************************/
/* Store a file on the webserver                         */
/*********************************************************/

function phpAds_Store ($localfile, $name)
{
	global $phpAds_config;
	
	$extension = substr($name, strrpos($name, ".") + 1);
	$base	   = substr($name, 0, strrpos($name, "."));
	
	if ($phpAds_config['type_web_mode'] == 0)
	{
		// Local mode
		$name = phpAds_LocalUniqueName ($base, $extension);
		
		if (@copy ($localfile, $phpAds_config['type_web_dir']."/".$name))
		{
			$stored_url = $phpAds_config['type_web_url']."/".$name;
		}
	}
	else
	{
		// FTP mode
		$server = parse_url($phpAds_config['type_web_ftp']);
		if ($server['path'] != "" && substr($server['path'], 0, 1) == "/") $server['path'] = substr ($server['path'], 1);
		
		if ($server['scheme'] == 'ftp')
		{
			$stored_url = phpAds_FTPStore ($server, $base, $extension, $localfile);
		}
	}
	
	if (isset($stored_url) && $stored_url != '')
	{
		return ($stored_url);
	}
	else
	{
		return false;
	}
}



/*********************************************************/
/* Duplicate a file on the webserver                     */
/*********************************************************/

function phpAds_StoreDuplicate ($name)
{
	global $phpAds_config;
	
	// Strip existing path
	$name      = basename($name);
	
	// Split into extention and base
	$extension = substr($name, strrpos($name, ".") + 1);
	$base	   = substr($name, 0, strrpos($name, "."));
	
	if ($phpAds_config['type_web_mode'] == 0)
	{
		// Local mode
		$duplicate = phpAds_LocalUniqueName ($base, $extension);
		
		if (@copy ($phpAds_config['type_web_dir']."/".$name, $phpAds_config['type_web_dir']."/".$duplicate))
		{
			$stored_url = $phpAds_config['type_web_url']."/".$duplicate;
		}
	}
	else
	{
		// FTP mode
		$server = parse_url($phpAds_config['type_web_ftp']);
		if ($server['path'] != "" && substr($server['path'], 0, 1) == "/") $server['path'] = substr ($server['path'], 1);
		
		if ($server['scheme'] == 'ftp')
		{
			$stored_url = phpAds_FTPDuplicate ($server, $base, $extension);
		}
	}
	
	if (isset($stored_url) && $stored_url != '')
	{
		return ($stored_url);
	}
	else
	{
		return false;
	}
}



/*********************************************************/
/* Remove a file from the webserver                      */
/*********************************************************/

function phpAds_Cleanup ($name)
{
	global $phpAds_config;
	
	if ($phpAds_config['type_web_mode'] == 0)
	{
		if (@file_exists($phpAds_config['type_web_dir']."/".$name))
		{
			@unlink ($phpAds_config['type_web_dir']."/".$name);
		}
	}
	else
	{
		// FTP mode
		$server = parse_url($phpAds_config['type_web_ftp']);
		if ($server['path'] != "" && substr($server['path'], 0, 1) == "/") $server['path'] = substr ($server['path'], 1);
		
		if ($server['scheme'] == 'ftp')
		{
			phpAds_FTPDelete ($server, $name);
		}
	}
}






/*********************************************************/
/* Local storage functions                               */
/*********************************************************/

function phpAds_LocalUniqueName ($base, $extension)
{
	global $phpAds_config;
	
	if ($path != "") @ftp_chdir ($conn_id, $path);
	
	$base = strtolower ($base);
	$base = str_replace (" ", "_", $base);
	$extension = strtolower ($extension);
	
	if (@file_exists($phpAds_config['type_web_dir']."/".$base.".".$extension) == false)
	{
		return ($base.".".$extension);
	}
	else
	{
		$found = false;
		$i = 1;
		
		while ($found == false)
		{
			$i++;
			if (@file_exists($phpAds_config['type_web_dir']."/".$base."_".$i.".".$extension) == false)
			{
				$found = true;
			}
		}
		
		return ($base."_".$i.".".$extension);
	}
}






/*********************************************************/
/* FTP module storage function                           */
/*********************************************************/

function phpAds_FTPStore ($server, $base, $extension, $localfile)
{
	global $phpAds_config;
	
	$conn_id = @ftp_connect($server['host']);
	
	if ($server['pass'] && $server['user'])
		$login = @ftp_login ($conn_id, $server['user'], $server['pass']);
	else
		$login = @ftp_login ($conn_id, "anonymous", $phpAds_config['admin_email']);
	
	if (($conn_id) || ($login))
	{
		$name = phpAds_FTPUniqueName ($conn_id, $server['path'], $base, $extension);
		if ($name != "")
		{
			if ($server['path'] != "") @ftp_chdir ($conn_id, $server['path']);
			
			if (@ftp_put ($conn_id, $name, $localfile, FTP_BINARY))
			{
				$stored_url = $phpAds_config['type_web_url']."/".$name;
			}
		}
		
		@ftp_quit($conn_id);
	}
	
	if (isset($stored_url)) return ($stored_url);
}


function phpAds_FTPDuplicate ($server, $base, $extension)
{
	global $phpAds_config;
	
	$conn_id = @ftp_connect($server['host']);
	
	if ($server['pass'] && $server['user'])
		$login = @ftp_login ($conn_id, $server['user'], $server['pass']);
	else
		$login = @ftp_login ($conn_id, "anonymous", $phpAds_config['admin_email']);
	
	if (($conn_id) || ($login))
	{
		if ($server['path'] != "") @ftp_chdir ($conn_id, $server['path']);
		
		
		// Create temporary file
		$tempfile = @tmpfile();
		
		// Download file to the temporary file
		if (@ftp_fget ($conn_id, $tempfile, $base.'.'.$extension, FTP_BINARY))
		{
			// Go to the beginning of the temporary file
			@rewind ($tempfile);
			
			// Upload temporary file
			$name = phpAds_FTPUniqueName ($conn_id, $server['path'], $base, $extension);
			if ($name != "")
			{
				if (@ftp_fput ($conn_id, $name, $tempfile, FTP_BINARY))
				{
					$stored_url = $phpAds_config['type_web_url']."/".$name;
				}
			}
		}
		
		@fclose($tempfile);
		@ftp_quit($conn_id);
	}
	
	if (isset($stored_url)) return ($stored_url);
}


function phpAds_FTPDelete ($server, $name)
{
	$conn_id = @ftp_connect($server['host']);
	
	if ($server['pass'] && $server['user'])
		$login = @ftp_login ($conn_id, $server['user'], $server['pass']);
	else
		$login = @ftp_login ($conn_id, "anonymous", $phpAds_config['admin_email']);
	
	if (($conn_id) || ($login))
	{
		if ($server['path'] != "") @ftp_chdir ($conn_id, $server['path']);
		
		if (@ftp_size ($conn_id, $name) > 0)
		{
			@ftp_delete ($conn_id, $name);
		}
		
		@ftp_quit($conn_id);
	}
}

function phpAds_FTPUniqueName ($conn_id, $path, $base, $extension)
{
	if ($path != "")
	{
		if (substr($path, 0, 1) == "/") $path = substr ($path, 1);
		@ftp_chdir ($conn_id, $path);
	}
	
	$base = strtolower ($base);
	$base = str_replace (" ", "_", $base);
	$extension = strtolower ($extension);
	
	if (@ftp_size ($conn_id, $base.".".$extension) < 1)
	{
		return ($base.".".$extension);
	}
	else
	{
		$found = false;
		$i = 1;
		
		while ($found == false)
		{
			$i++;
			if (@ftp_size ($conn_id, $base."_".$i.".".$extension) < 1)
			{
				$found = true;
			}
		}
		
		return ($base."_".$i.".".$extension);
	}
}


?>