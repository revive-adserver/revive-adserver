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


function phpAds_revisionCompare ($first, $second)
{
	// Check for the obvious... is it the same?
	if (trim($first) == trim($second))
		return (0);

	// Disect both revisions
	$first = explode ('.', trim($first));
	$second = explode ('.', trim($second));
	$it = min (count($first), count($second));
	
	for ($i = 0; $i < $it; $i++)
	{
		// Current digit of check is newer than actual
		if ($first[$i] > $second[$i])
			return (-1);
		
		// Current digit of check is older than actual
		if ($first[$i] < $second[$i])
			return (1);
			
		// Current digit of check is the same, continue
	}
	
	// If we end up here than all checked digits 
	// up till now are the same and one of the revisions
	// has some additional digits. The one with the
	// extra digits is automatically the newer revision.
	
	// Check is newer than actual because it has more digits
	if (count($first) > count($second))
		return (-1);
	
	// Check is older than actual because it has less digits
	if (count($first) < count($second))
		return (1);
}


function phpAds_revisionCheck ()
{
	$message = '';
	$fatal   = false;
	$error   = false;
	$files   = array();
	
	// Open revision file
	if ($revfile = fopen(phpAds_path.'/libraries/defaults/revisions.txt', 'r'))
	{
		// Determine the version of phpAdsNew
		include (phpAds_path.'/libraries/lib-dbconfig.inc.php');
		$version = fgets($revfile, 4096);
		
		if ($version == $phpAds_version)
		{
			while (!feof($revfile)) 
			{
			    $line = fgets($revfile, 4096);
				
				if (trim($line) != '')
				{
					list($filename, $rev, $md5) = explode ("\t", $line);
					
					// Get actual info from file
					if (@file_exists (phpAds_path.$filename))
					{
						list($current_rev, $current_md5) = phpAds_revisionGet (phpAds_path.$filename);
		
						// echo $filename." - ".$md5." - ".$current_md5."<br>";
						if (trim($current_md5) != trim($md5))
						{
							// File changed, check revision!
							$result = phpAds_revisionCompare($rev, $current_rev);
							
							switch ($result)
							{
								case  1:	break;  // File has been patched with a newer revision... that's allowed!

								case  0:	$message .= "The file '".$filename."' is corrupt or has been modified\n"; 
											$files[]  = $filename;
											break;

								case -1:	$message .= "The file '".$filename."' is older than the one distributed by phpAdsNew\n"; 
											$files[]  = $filename;
											$fatal = true; 
											break;
							}
						}
						else
						{
							// File is the same, no need to check revision
						}
					}
					else
					{
						$message .= "The file '".$filename." could not be checked because it is missing\n";
						$files[]  = $filename;
						$fatal = true;
					}
				}
			}
		}
		else
		{
			// Revfile does not match version
			$message = 'The integrity of your phpAdsNew installation could not be checked because the file that contains the information does not match the version you are trying to install.';
			$error = true;
		}
		
		fclose ($revfile);
	}
	else
	{
		// Revfile does not match version
		$message = 'The integrity of your phpAdsNew installation could not be checked because the file that contains the information could not be opened.';
		$error = true;
	}
	
	
	if ($error)
	{
		// An error occured, show error immediately and stop!
		return array(true, true, $message);
	}
	else
	{
		if ($message != '')
		{
			// Files needed for installation or update
			$needed = array ('/admin/update.php', '/admin/install.php', '/libraries/lib-revisions.inc.php');
			
			$direct = false;
			
			while (list (,$needle) = each ($needed))
				if (in_array($needle, $files))
					$direct = true;
			
			return array($direct, $fatal, $message);
		}
		else
		{
			// Everything is okay!
			return false;
		}
	}
}


function phpAds_revisionCreate()
{
	// Create a new file to store all revisions
	if ($revfile = fopen(phpAds_path.'/libraries/defaults/revisions.txt', 'w'))
	{
		// Determine the version of phpAdsNew
		include (phpAds_path.'/libraries/lib-dbconfig.inc.php');
		fwrite ($revfile, $phpAds_version."\n");
	
		// Open lowest level directory
		$result = phpAds_revisionScan ($revfile, phpAds_path."/");
		
		// Close revision file
		fclose($revfile);
		
		return $result;
	}
	else
		return false;
}


function phpAds_revisionGet ($filename)
{
	// Read the file
	$content = @implode ('', file ($filename));

	// Determine revision
	if (eregi('\$Revision$', $content, $matches))
	{
		// Remove newlines and linefeeds
		$content = str_replace ("\n", '', $content);
		$content = str_replace ("\r", '', $content);
	
		return array (
			$matches[1],
			md5($content)
		);
	}
	else
		return false;
}


function phpAds_revisionScan ($revfile, $path)
{
	if ($dir = opendir($path))
	{
		while (($file = readdir($dir)) !== false)
		{
			if (is_dir($path.$file))
			{ 
				if ($file != '.' && $file != '..' && $file != 'CVS' && $file != 'language')
				{
					phpAds_revisionScan ($revfile, $path.$file.'/');
				}
			}
			else
			{
				if ($file[0] != '.')
				{
					if ($result = phpAds_revisionGet ($path.$file))
					{
						list ($rev, $md5) = $result;
						fwrite ($revfile, str_replace (phpAds_path, '', $path.$file)."\t".$rev."\t".$md5."\n");
					}
				}
			}
		}
		
		return true;
	}
	else
		return false;
}

?>