<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



/*********************************************************/
/* Compare two revisions                                 */
/*********************************************************/

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



/*********************************************************/
/* Check if the current files are modified or corrupt    */
/*********************************************************/

function phpAds_revisionCheck ()
{
	global $phpAds_version, $phpAds_productname;
	
	$fatal   = false;
	$error   = false;
	$files   = array();
	$message = array();
	$errors  = array();
	
	// Open revision file
	if ($revfile = fopen(phpAds_path.'/libraries/defaults/revisions.txt', 'r'))
	{
		// Determine the version of phpAdsNew
		$version = trim(fgets($revfile, 4096));
		
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
						
						if (trim($current_md5) != trim($md5))
						{
							// File changed, check revision!
							$result = phpAds_revisionCompare($rev, $current_rev);
							
							switch ($result)
							{
								case  1:	break;  // File has been patched with a newer revision... that's allowed!

								case  0:	if (isset($GLOBALS['strRevCorrupt']))
												$message[] = str_replace('{filename}', $filename, $GLOBALS['strRevCorrupt']);
											else	
												$message[] = "The file '".$filename."' is corrupt or has been modified. If you did not modify this file, please try to upload a new copy of this file to your server. If you modified this file yourself, you can safely ignore this warning."; 
											
											$files[] = $filename;
											break;

								case -1:	if (isset($GLOBALS['strRevTooOld']))
												$message[] = str_replace('{filename}', $filename, $GLOBALS['strRevTooOld']);
											else	
												$message[] = "The file '".$filename."' is older than the one that is supposed to be used with this version of phpAdsNew. Please try to upload a new copy of this file to the server."; 
											
											$files[] = $filename;
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
						if (isset($GLOBALS['strRevMissing']))
							$message[] = str_replace('{filename}', $filename, $GLOBALS['strRevMissing']);
						else	
							$message[] = "The file '".$filename." could not be checked because it is missing. Please try to upload a new copy of this file to the server.";
						
						$files[]  = $filename;
						$fatal = true;
					}
				}
			}
		}
		else
		{
			if ($version == 'CVS')
			{
				// CVS checkout: do not check anything, but display a warning
				if (isset($GLOBALS['strRevCVS']))
					$message[] = $GLOBALS['strRevCVS'];
				else	
					$message[] = 'You are trying to install a CVS checkout of '.$phpAds_productname.'. This is not an official release and may be unstable or even non-functional. Are you sure you want to continue?';			
			}
			else
			{
				// Revfile does not match version (no need for translation, because language file is not loaded yet)
				$errors[] = 'The integrity of your '.$phpAds_productname.' installation could not be checked because the file that contains the information does not match the version you are trying to install.';
				$error = true;
			}
		}
		
		fclose ($revfile);
	}
	else
	{
		// Revfile does not match version (no need for translation, because language file is not loaded yet)
		$errors[] = 'The integrity of your '.$phpAds_productname.' installation could not be checked because the file that contains the information could not be opened.';
		$error = true;
	}
	
	
	// Check for the availability of the english language files...
	if (!file_exists(phpAds_path.'/language/english/default.lang.php') ||
		!file_exists(phpAds_path.'/language/english/index.lang.php') ||
		!file_exists(phpAds_path.'/language/english/invocation.lang.php') ||
		!file_exists(phpAds_path.'/language/english/maintenance.lang.php') ||
		!file_exists(phpAds_path.'/language/english/report.lang.php') ||
		!file_exists(phpAds_path.'/language/english/settings-help.lang.php') ||
		!file_exists(phpAds_path.'/language/english/settings.lang.php') ||
		!file_exists(phpAds_path.'/language/english/userlog.lang.php'))
	{
		$errors[] = 'Some of the english language files are missing. Perhaps you deleted these files because you do not want to use english as the default language. phpAdsNew requires that the english language files are present at all times even if you use a different default language.';
		$error = true;
	}
	
	
	if ($error)
	{
		// An error occured, show error immediately and stop!
		return array(true, true, $errors);
	}
	else
	{
		if (count($message))
		{
			// Files needed for installation or update
			$needed = array ('/admin/upgrade.php', '/admin/install.php', '/libraries/lib-revisions.inc.php',
							 '/libraries/lib-io.inc.php', '/libraries/lib-dbconfig.inc.php', '/libraries/lib-db.inc.php',
							 '/admin/lib-install-db.inc.php', '/admin/lib-permissions.inc.php', '/admin/lib-gui.inc.php',
							 '/admin/lib-settings.inc.php');
			
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



/*********************************************************/
/* Create a new file containing revision info            */
/*********************************************************/

function phpAds_revisionCreate()
{
	global $phpAds_version;

	// Create a new file to store all revisions
	if ($revfile = fopen(phpAds_path.'/libraries/defaults/revisions.txt', 'w'))
	{
		// Determine the version of phpAdsNew
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



/*********************************************************/
/* Get the revision of a file                            */
/*********************************************************/

function phpAds_revisionGet ($filename)
{
	// Read the file
	$content = @implode ('', file ($filename));

	// Determine revision, matching both Revision and Id CVS tags
	if (preg_match('/\$(Revision:|Id: .*?,v) ([0-9]+(\.[0-9]+)+).*?\$/', $content, $matches))
	{
		// Remove newlines and linefeeds
		$content = str_replace ("\n", '', $content);
		$content = str_replace ("\r", '', $content);
	
		return array (
			$matches[2],
			md5($content)
		);
	}
	else
		return false;
}



/*********************************************************/
/* Get the revision of a complete directory tree         */
/*********************************************************/

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
				if ($file != 'config.inc.php' && $file[0] != '.')
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