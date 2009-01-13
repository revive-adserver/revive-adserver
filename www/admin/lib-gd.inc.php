<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Define defaults
$phpAds_GDImageFormat = '';

/*-------------------------------------------------------*/
/* Determine the image format supported by GD            */
/*-------------------------------------------------------*/

function phpAds_GDImageFormat()
{
	$conf = $GLOBALS['_MAX']['CONF'];
	global $phpAds_GDImageFormat;

	// Determine php version
	$phpversion = ereg_replace ("([^0-9])", "", phpversion());
	$phpversion = $phpversion / pow (10, strlen($phpversion) - 1);

	if ($phpversion >= 4.02 || ($phpversion >= 3.018 && $phpversion < 4.0))
	{
		// Determine if GD is installed
		if (extension_loaded("gd"))
		{
			// Use ImageTypes() to dermine image format
		    if (ImageTypes() & IMG_PNG)
		        $phpAds_GDImageFormat = "png";

		    elseif (ImageTypes() & IMG_JPG)
		        $phpAds_GDImageFormat = "jpeg";

		    elseif (ImageTypes() & IMG_GIF)
		        $phpAds_GDImageFormat = "gif";

		    else
		        $phpAds_GDImageFormat = "none";
		}
		else
	        $phpAds_GDImageFormat = "none";
	}
	elseif ($phpversion >= 4)
	{
		// No way to determine image format
		$phpAds_GDImageFormat = "gif"; // assume gif?
	}
	else
	{
	    // Use Function_Exists to determine image format

	    if (function_exists("imagepng"))
	        $phpAds_GDImageFormat = "png";

		elseif (function_exists("imagejpeg"))
	        $phpAds_GDImageFormat = "jpeg";

	    elseif (function_exists("imagegif"))
	        $phpAds_GDImageFormat = "gif";

	    else
	        $phpAds_GDImageFormat = "none";
	}


	// Override detected GD foramt
	if (isset($pref['override_gd_imageformat']) && $pref['override_gd_imageformat'] != '')
		$phpAds_GDImageFormat = $pref['override_gd_imageformat'];

	return ($phpAds_GDImageFormat);
}



/*-------------------------------------------------------*/
/* Send the correct Content-type header                  */
/*-------------------------------------------------------*/

function phpAds_GDContentType()
{
	global $phpAds_GDImageFormat;

	if ($phpAds_GDImageFormat == '') $phpAds_GDImageFormat = phpAds_GDImageFormat();

	Header("Content-type: $phpAds_GDImageFormat");
}



/*-------------------------------------------------------*/
/* Send the image to the browser in the correct format   */
/*-------------------------------------------------------*/

function phpAds_GDShowImage(&$im)
{
	global $phpAds_GDImageFormat;

	if ($phpAds_GDImageFormat == '') $phpAds_GDImageFormat = phpAds_GDImageFormat();

	switch ($phpAds_GDImageFormat)
	{
		case "gif":
			ImageGIF($im);
			break;
		case "jpeg":
			ImageJPEG($im);
			break;
		case "png":
			ImagePNG($im);
			break;
		default:
			break; 	// No GD installed
	}
}

?>