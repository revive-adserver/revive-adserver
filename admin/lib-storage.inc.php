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



// Include FTP emulation library 
// if extension is not present
if (!function_exists("ftp_connect"))
	require ("lib-ftp.inc.php");



/*********************************************************/
/* Store a file on the webserver                         */
/*********************************************************/

function phpAds_ImageStore ($storagetype, $name, $buffer, $overwrite = false)
{
	global $phpAds_config;
	
	// Make name web friendly
	$name = basename ($name);
	$name = strtolower ($name);
	$name = str_replace (" ", "_", $name);
	$name = str_replace ("'", "", $name);
	
	if ($storagetype == 'web')
	{
		if ($phpAds_config['type_web_mode'] == 0)
		{
			// Local mode
			if ($overwrite == false)
				$name = phpAds_LocalUniqueName ($name);
			
			// Write the file
			if ($fp = @fopen($phpAds_config['type_web_dir']."/".$name, 'wb'))
			{
				@fwrite ($fp, $buffer);
				@fclose ($fp);
				
				// Add read permissions to group and others: this is especially
				// required when using suPHP
				@chmod($phpAds_config['type_web_dir']."/".$name, 0644);
				
				$stored_url = $name;
			}
		}
		else
		{
			// FTP mode
			$server = parse_url($phpAds_config['type_web_ftp']);
			
			// Decode URL parts
			$server['user'] = urldecode($server['user']);
			$server['pass'] = urldecode($server['pass']);
			$server['path'] = urldecode($server['path']);
			
			if ($server['path'] != "" && substr($server['path'], 0, 1) == "/") $server['path'] = substr ($server['path'], 1);
			
			if ($server['scheme'] == 'ftp')
			{
				$stored_url = phpAds_FTPStore ($server, $name, $buffer, $overwrite);
			}
		}
	}
	
	if ($storagetype == 'sql')
	{
		if ($overwrite == false)
			$name = phpAds_SqlUniqueName ($name);
		
		$res = phpAds_dbQuery ("
			REPLACE INTO 
				".$phpAds_config['tbl_images']."
			SET
				filename = '".$name."',
				contents = '".addslashes($buffer)."',
				t_stamp = now()
		");
		
		$stored_url = $name;
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

function phpAds_ImageDuplicate ($storagetype, $name)
{
	global $phpAds_config;
	
	// Strip existing path
	$name = basename($name);
	
	
	if ($storagetype == 'web')
	{
		if ($phpAds_config['type_web_mode'] == 0)
		{
			// Local mode
			$duplicate = phpAds_LocalUniqueName ($name);
			
			if (@copy ($phpAds_config['type_web_dir']."/".$name, $phpAds_config['type_web_dir']."/".$duplicate))
			{
				$stored_url = $duplicate;
			}
		}
		else
		{
			// FTP mode
			$server = parse_url($phpAds_config['type_web_ftp']);
			
			// Decode URL parts
			$server['user'] = urldecode($server['user']);
			$server['pass'] = urldecode($server['pass']);
			$server['path'] = urldecode($server['path']);
			
			if ($server['path'] != "" && substr($server['path'], 0, 1) == "/") $server['path'] = substr ($server['path'], 1);
			
			if ($server['scheme'] == 'ftp')
			{
				$stored_url = phpAds_FTPDuplicate ($server, $name);
			}
		}
	}
	
	if ($storagetype == 'sql')
	{
		if ($buffer = phpAds_ImageRetrieve ($storagetype, $name))
			$stored_url = phpAds_ImageStore ($storagetype, $name, $buffer);
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
/* Retrieve a file on the webserver                      */
/*********************************************************/

function phpAds_ImageRetrieve ($storagetype, $name)
{
	global $phpAds_config;
	
	// Strip existing path
	$name = basename($name);
	
	if ($storagetype == 'web')
	{
		if ($phpAds_config['type_web_mode'] == 0)
		{
			// Local mode
			$result = @fread(@fopen($phpAds_config['type_web_dir']."/".$name, 'rb'),
					  @filesize($phpAds_config['type_web_dir']."/".$name));
		}
		else
		{
			// FTP mode
			$server = parse_url($phpAds_config['type_web_ftp']);
			
			// Decode URL parts
			$server['user'] = urldecode($server['user']);
			$server['pass'] = urldecode($server['pass']);
			$server['path'] = urldecode($server['path']);
			
			if ($server['path'] != "" && substr($server['path'], 0, 1) == "/") $server['path'] = substr ($server['path'], 1);
			
			if ($server['scheme'] == 'ftp')
			{
				$result = phpAds_FTPRetrieve ($server, $name);
			}
		}
	}
	
	if ($storagetype == 'sql')
	{
		$res = phpAds_dbQuery ("
			SELECT
				contents
			FROM
				".$phpAds_config['tbl_images']."
			WHERE
				filename = '".$name."'
		");
		
		if ($row = phpAds_dbFetchArray($res))
		{
			$result = $row['contents'];
		}
	}
	
	if (isset($result) && $result != '')
	{
		return ($result);
	}
	else
	{
		return false;
	}
}


/*********************************************************/
/* Remove a file from the webserver                      */
/*********************************************************/

function phpAds_ImageDelete ($storagetype, $name)
{
	global $phpAds_config;
	
	if ($storagetype == 'web')
	{
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
			
			// Decode URL parts
			$server['user'] = urldecode($server['user']);
			$server['pass'] = urldecode($server['pass']);
			$server['path'] = urldecode($server['path']);
			
			if ($server['path'] != "" && substr($server['path'], 0, 1) == "/") $server['path'] = substr ($server['path'], 1);
			
			if ($server['scheme'] == 'ftp')
			{
				phpAds_FTPDelete ($server, $name);
			}
		}
	}
	
	if ($storagetype == 'sql')
	{
		$res = phpAds_dbQuery ("
			DELETE FROM 
				".$phpAds_config['tbl_images']."
			WHERE
				filename = '".$name."'
		");
	}
}


/*********************************************************/
/* Get size of the file                                  */
/*********************************************************/

function phpAds_ImageSize ($storagetype, $name)
{
	global $phpAds_config;
	
	// Strip existing path
	$name = basename($name);
	
	if ($storagetype == 'web')
	{
		if ($phpAds_config['type_web_mode'] == 0)
		{
			// Local mode
			$result = @filesize($phpAds_config['type_web_dir']."/".$name);
		}
		else
		{
			// FTP mode
			$server = parse_url($phpAds_config['type_web_ftp']);
			
			// Decode URL parts
			$server['user'] = urldecode($server['user']);
			$server['pass'] = urldecode($server['pass']);
			$server['path'] = urldecode($server['path']);
			
			if ($server['path'] != "" && substr($server['path'], 0, 1) == "/") $server['path'] = substr ($server['path'], 1);
			
			if ($server['scheme'] == 'ftp')
			{
				$result = phpAds_FTPSize ($server, $name);
			}
		}
	}
	
	if ($storagetype == 'sql')
	{
		$res = phpAds_dbQuery ("
			SELECT
				contents
			FROM
				".$phpAds_config['tbl_images']."
			WHERE
				filename = '".$name."'
		");
		
		if ($row = phpAds_dbFetchArray($res))
		{
			$result = strlen($row['contents']);
		}
	}
	
	if (isset($result) && $result != '')
	{
		return ($result);
	}
	else
	{
		return false;
	}
}



/*********************************************************/
/* SQL storage functions                                 */
/*********************************************************/

function phpAds_SqlUniqueName ($name)
{
	global $phpAds_config;
	
	$extension = substr($name, strrpos($name, ".") + 1);
	$base	   = substr($name, 0, strrpos($name, "."));
	
	$res = phpAds_dbQuery ("SELECT filename FROM ".$phpAds_config['tbl_images']." WHERE filename='".$base.".".$extension."'");
	if (phpAds_dbNumRows($res) == 0)
	{
		return ($base.".".$extension);
	}
	else
	{
		if (eregi("^(.*)_([0-9]+)$", $base, $matches))
		{
			$base = $matches[1];
			$i = $matches[2];
		}
		else
			$i = 1;
		
		$found = false;
		
		while ($found == false)
		{
			$i++;
			
			$res = phpAds_dbQuery ("SELECT filename FROM ".$phpAds_config['tbl_images']." WHERE filename='".$base."_".$i.".".$extension."'");
			if (phpAds_dbNumRows($res) == 0)
			{
				$found = true;
			}
		}
		
		return ($base."_".$i.".".$extension);
	}
}



/*********************************************************/
/* Local storage functions                               */
/*********************************************************/

function phpAds_LocalUniqueName ($name)
{
	global $phpAds_config;
	
	$extension = substr($name, strrpos($name, ".") + 1);
	$base	   = substr($name, 0, strrpos($name, "."));
	
	
	if (@file_exists($phpAds_config['type_web_dir']."/".$base.".".$extension) == false)
	{
		return ($base.".".$extension);
	}
	else
	{
		if (eregi("^(.*)_([0-9]+)$", $base, $matches))
		{
			$base = $matches[1];
			$i = $matches[2];
		}
		else
			$i = 1;
		
		$found = false;
		
		
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

function phpAds_FTPStore ($server, $name, $buffer, $overwrite = false)
{
	global $phpAds_config;
	
	$conn_id = @ftp_connect($server['host']);
	
	if ($server['pass'] && $server['user'])
		$login = @ftp_login ($conn_id, $server['user'], $server['pass']);
	else
		$login = @ftp_login ($conn_id, "anonymous", $phpAds_config['admin_email']);
	
	
	if (($conn_id) || ($login))
	{
		if ($overwrite == false)
			$name = phpAds_FTPUniqueName ($conn_id, $server['path'], $name);
		
		// Change path
		if ($server['path'] != "") @ftp_chdir ($conn_id, $server['path']);
		
		// Create temporary file
		$tempfile = @tmpfile();
		@fwrite ($tempfile, $buffer);
		@rewind ($tempfile);
		
		// Upload the temporary file
		if (@ftp_fput ($conn_id, $name, $tempfile, FTP_BINARY))
		{
			$stored_url = $name;
		}
		
		@fclose ($tempfile);
		@ftp_quit($conn_id);
	}
	
	if (isset($stored_url)) return ($stored_url);
}


function phpAds_FTPDuplicate ($server, $name)
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
		if (@ftp_fget ($conn_id, $tempfile, $name, FTP_BINARY))
		{
			// Go to the beginning of the temporary file
			@rewind ($tempfile);
			
			// Upload temporary file
			$name = phpAds_FTPUniqueName ($conn_id, $server['path'], $name);
			
			if (@ftp_fput ($conn_id, $name, $tempfile, FTP_BINARY))
			{
				$stored_url = $name;
			}
		}
		
		@fclose($tempfile);
		@ftp_quit($conn_id);
	}
	
	if (isset($stored_url)) return ($stored_url);
}


function phpAds_FTPRetrieve ($server, $name)
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
		if ($tempfile && @ftp_fget ($conn_id, $tempfile, $name, FTP_BINARY))
		{
			// Go to the beginning of the temporary file
			rewind ($tempfile);
			
			$result = '';
			while (!feof($tempfile))
				$result .= fread ($tempfile, 8192);
		}
		
		@fclose($tempfile);
		@ftp_quit($conn_id);
	}
	
	if (isset($result)) return ($result);
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


function phpAds_FTPSize ($server, $name)
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
		
		$result = @ftp_size ($conn_id, $name);
		
		@fclose($tempfile);
		@ftp_quit($conn_id);
	}
	
	if (isset($result)) return ($result);
}


function phpAds_FTPUniqueName ($conn_id, $path, $name)
{
	if ($path != "")
	{
		if (substr($path, 0, 1) == "/") $path = substr ($path, 1);
		@ftp_chdir ($conn_id, $path);
	}
	
	$extension = substr($name, strrpos($name, ".") + 1);
	$base	   = substr($name, 0, strrpos($name, "."));
	
	
	if (@ftp_size ($conn_id, $base.".".$extension) < 1)
	{
		return ($base.".".$extension);
	}
	else
	{
		if (eregi("^(.*)_([0-9]+)$", $base, $matches))
		{
			$base = $matches[1];
			$i = $matches[2];
		}
		else
			$i = 1;
		
		$found = false;
		
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