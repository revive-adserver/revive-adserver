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



/*********************************************************/
/* Store a file on the webserver                         */
/*********************************************************/

function phpAds_Store ($localfile, $name)
{
	global $phpAds_type_web_mode, $phpAds_type_web_dir;
	global $phpAds_type_web_ftp, $phpAds_type_web_url;
	
	$extension = substr($name, strrpos($name, ".") + 1);
	$base	   = substr($name, 0, strrpos($name, "."));
	
	if ($phpAds_type_web_mode == "0")
	{
		// Local mode
		$name = phpAds_LocalUniqueName ($base, $extension);
		
		if (@copy ($localfile, $phpAds_type_web_dir."/".$name))
		{
			$stored_url = $phpAds_type_web_url."/".$name;
		}
	}
	else
	{
		// FTP mode
		$server = parse_url($phpAds_type_web_ftp);
		if ($server['path'] != "" && substr($server['path'], 0, 1) == "/") $server['path'] = substr ($server['path'], 1);
		
		if ($server['scheme'] == 'ftp')
		{
			// PHP FTP Module
			if (function_exists("ftp_connect"))
			{
				$stored_url = phpAds_FTPStore ($server, $base, $extension, $localfile);
			}
			
			// PHP CURL Module
			elseif (function_exists("curl_init"))
			{
				$stored_url = phpAds_CURLStore ($server, $base, $extension, $localfile);
			}
			
			// PHP Fopen wrappers
			else
			{
				$stored_url = phpAds_FOPENStore ($server, $base, $extension, $localfile);
			}
		}
	}
	
	if (isset($stored_url) && $stored_url != '')
	{
		return ($stored_url);
	}
	else
	{
		// Error
	}
}


/*********************************************************/
/* Remove a file from the webserver                      */
/*********************************************************/

function phpAds_Cleanup ($name)
{
	global $phpAds_type_web_mode, $phpAds_type_web_dir;
	global $phpAds_type_web_ftp, $phpAds_type_web_url;
	
	if ($phpAds_type_web_mode == "0")
	{
		if (@file_exists($phpAds_type_web_dir."/".$name))
		{
			@unlink ($phpAds_type_web_dir."/".$name);
		}
	}
	else
	{
		// FTP mode
		$server = parse_url($phpAds_type_web_ftp);
		if ($server['path'] != "" && substr($server['path'], 0, 1) == "/") $server['path'] = substr ($server['path'], 1);
		
		if ($server['scheme'] == 'ftp')
		{
			// PHP FTP Module
			if (function_exists("ftp_connect"))
			{
				phpAds_FTPDelete ($server, $name);
			}
			
			// PHP fsockopen
			else
			{
				//phpAds_FSOCKDelete ($server, $name);
			}
		}
	}
}






/*********************************************************/
/* Local storage functions                               */
/*********************************************************/

function phpAds_LocalUniqueName ($base, $extension)
{
	global $phpAds_type_web_dir;
	
	if ($path != "") @ftp_chdir ($conn_id, $path);
	
	$base = strtolower ($base);
	$base = str_replace (" ", "_", $base);
	$extension = strtolower ($extension);
	
	if (@file_exists($phpAds_type_web_dir."/".$base.".".$extension) == false)
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
			if (@file_exists($phpAds_type_web_dir."/".$base."_".$i.".".$extension) == false)
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
	global $phpAds_admin_email, $phpAds_type_web_url;
	
	$conn_id = @ftp_connect($server['host']);
	
	if ($server['pass'] && $server['user'])
		$login = @ftp_login ($conn_id, $server['user'], $server['pass']);
	else
		$login = @ftp_login ($conn_id, "anonymous", $phpAds_admin_email);
	
	if (($conn_id) || ($login))
	{
		$name = phpAds_FTPUniqueName ($conn_id, $server['path'], $base, $extension);
		if ($name != "")
		{
			if ($server['path'] != "") @ftp_chdir ($conn_id, $server['path']);
			
			if (@ftp_put ($conn_id, $name, $localfile, FTP_BINARY))
			{
				$stored_url = $phpAds_type_web_url."/".$name;
			}
		}
		
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
		$login = @ftp_login ($conn_id, "anonymous", $phpAds_admin_email);
	
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




/*********************************************************/
/* CURL module storage function                          */
/*********************************************************/

function phpAds_CURLStore ($server, $base, $extension, $localfile)
{
	global $phpAds_admin_email, $phpAds_type_web_url;
	
	if ($ch = @curl_init("ftp://".$server['host']."/".$server['path']."/"))
	{
		if ($server['pass'] && $server['user'])
			@curl_setopt($ch, CURLOPT_USERPWD, $server['user'].":".$server['pass']);
		
		@curl_setopt($ch, CURLOPT_FTPLISTONLY, 1);
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$list = @curl_exec($ch);
		@curl_close($ch);
		
		if (gettype($list) == 'string')
		{
			$name = phpAds_ArrayUniqueName(explode("\n", $list), $base, $extension);
			
			if ($name != "")
			{
				if ($ch = @curl_init("ftp://".$server['host']."/".$server['path']."/$name"))
				{
					if ($server['pass'] && $server['user'])
						@curl_setopt($ch, CURLOPT_USERPWD, $server['user'].":".$server['pass']);
					
					$fp = @fopen($localfile, "rb") or php_die();
					
					@curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localname));
					@curl_setopt($ch, CURLOPT_UPLOAD, 1);
					@curl_setopt($ch, CURLOPT_INFILE, $fp);
					
					@curl_exec($ch);
					@curl_close($ch);
					fclose($fp);
					
					// Tesing if upload was successful
					// Just a workaround because curl_exec doesn't return success
					if ($ch = @curl_init("ftp://".$server['host']."/".$server['path']."/"))
					{
						if ($server['pass'] && $server['user'])
							@curl_setopt($ch, CURLOPT_USERPWD, $server['user'].":".$server['pass']);
						
						@curl_setopt($ch, CURLOPT_FTPLISTONLY, 1);
						@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						
						$list = @curl_exec($ch);
						@curl_close($ch);
						$list = str_replace("\r", "", $list);
						
						if (phpAds_ArrayUniqueName(explode("\n", $list), $base, $extension) !=  $name)
							return ($phpAds_type_web_url."/".$name);
					}
				}
			}
		}
	}
}




/*********************************************************/
/* Fopen wrapper storage function                        */
/*********************************************************/

function phpAds_FOPENStore ($server, $base, $extension, $localfile)
{
	global $phpAds_admin_email, $phpAds_type_web_url;
	
	$base = uniqid(str_replace(" ", "_", strtolower($base))."_", true);
	$extension = strtolower($extension);
	$name = $base.".".$extension;
	
	$url = "ftp://".$server['user'].":".$server['pass']."@".$server['host']."/".$server['path']."/".$base.".".$extension;
	
	if (($localfile_data = @fread(@fopen($localfile, "rb"), @filesize($localfile))) && $ftp_fp = @fopen($url, "w"))
	{
		if (fwrite($ftp_fp, $localfile_data))
		{
			fclose($ftp_fp);
			return ($phpAds_type_web_url."/".$name);
		}
		fclose($ftp_fp);
	}
}





/*********************************************************/
/* Creates a unique filename                             */
/* $files is an array of existing filenames              */
/*********************************************************/

function phpAds_ArrayUniqueName($files, $base, $extension, $c = 0)
{
	if ($c == 0)
	{
		$base = str_replace(" ", "_", strtolower($base));
		$extension = strtolower($extension);
	}
	
	$count = count($files);
	$fname = $base.($c > 0 ? "_$c" : '').".".$extension;
	
	for ($x = 0; $x < $count && trim($fname) != trim($files[$x]); $x++);
	
	if ($x < $count)
	{
		// File exists
		$fname = phpAds_ArrayUniqueName($files, $base, $extension, $c+1);
	}
	
	return $fname;
}



?>