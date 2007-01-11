<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require	("config.inc.php");
require ("libraries/lib-io.inc.php");
require ("libraries/lib-db.inc.php");


// Register input variables
phpAds_registerGlobal ('filename', 'contenttype');


// Open a connection to the database
phpAds_dbConnect();


if (isset($filename) && $filename != '')
{
	$res = phpAds_dbQuery("
		SELECT
			contents,
			UNIX_TIMESTAMP(t_stamp) AS t_stamp
		FROM
			".$phpAds_config['tbl_images']."
		WHERE
			filename = '".$filename."'
		");
	
	if (phpAds_dbNumRows($res) == 0)
	{
		// Filename not found, show default banner
		if ($phpAds_config['default_banner_url'] != "")
		{
			header("Location: ".$phpAds_config['default_banner_url']);
		}
	}
	else
	{
		// Filename found, dump contents to browser
		$row = phpAds_dbFetchArray($res);
		
		// Check if the browser sent a If-Modified-Since header and if the image was
		// modified since that date
		if (!isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ||
			$row['t_stamp'] > strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']))
		{
			header ("Last-Modified: ".gmdate('D, d M Y H:i:s', $row['t_stamp']).' GMT');
			
			if (isset($contenttype) && $contenttype != '')
			{
				switch ($contenttype)
				{
					case 'swf': header('Content-Type: application/x-shockwave-flash; name='.$filename); break;
					case 'dcr': header('Content-Type: application/x-director; name='.$filename); break;
					case 'rpm': header('Content-Type: audio/x-pn-realaudio-plugin; name='.$filename); break;
					case 'mov': header('Content-Type: video/quicktime; name='.$filename); break;
					default:	header('Content-Type: image/'.$contenttype.'; name='.$filename); break;
				}
			}
			
			header ('Content-Length: '.strlen($row['contents']));
			echo $row['contents'];
		}
		else
		{
			// Send "Not Modified" status header
			if (php_sapi_name() == 'cgi')
			{
				// PHP as CGI, use Status: [status-number]
				header ('Status: 304 Not Modified');
			}
			else
			{
				// PHP as module, use HTTP/1.x [status-number]
				header ($_SERVER['SERVER_PROTOCOL'].' 304 Not Modified');
			}
		}
	}
}
else
{
	// Filename not specified, show default banner
	
	if ($phpAds_config['default_banner_url'] != "")
	{
		header("Location: ".$phpAds_config['default_banner_url']);
	}
}

phpAds_dbClose();

?>