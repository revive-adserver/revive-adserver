<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Define SWF tags
define ('swf_tag_identify', 		 chr(0x46).chr(0x57).chr(0x53));
define ('swf_tag_compressed', 		 chr(0x43).chr(0x57).chr(0x53));
define ('swf_tag_geturl',   		 chr(0x83));
define ('swf_tag_null',     		 chr(0x00));
define ('swf_tag_actionpush', 		 chr(0x96));
define ('swf_tag_actiongetvariable', chr(0x1C));
define ('swf_tag_actiongeturl2', 	 chr(0x9A).chr(0x01));
define ('swf_tag_actiongetmember', 	 chr(0x4E));


// Define preferences
$swf_variable		= 'alink';		// The name of the ActionScript variable used for urls
$swf_target_var		= 'atar';		// The name of the ActionScript variable used for targets



/*********************************************************/
/* Get the Flash version of the banner                   */
/*********************************************************/

function phpAds_SWFVersion($buffer)
{
	if (substr($buffer, 0, 3) == swf_tag_identify ||
		substr($buffer, 0, 3) == swf_tag_compressed)
		return ord(substr($buffer, 3, 1));
	else
		return false;
}



/*********************************************************/
/* Is the Flash file compressed?                         */
/*********************************************************/

function phpAds_SWFCompressed($buffer)
{
	if (substr($buffer, 0, 3) == swf_tag_compressed)
		return true;
	else
		return false;
}



/*********************************************************/
/* Compress Flash file                                   */
/*********************************************************/

function phpAds_SWFCompress($buffer)
{
	$version = ord(substr($buffer, 3, 1));
	
	if (function_exists('gzcompress') &&
	    substr($buffer, 0, 3) == swf_tag_identify &&
		$version >= 3)
	{
		// When compressing an old file, update
		// version, otherwise keep existing version
		if ($version < 6) $version = 6;
		
		$output  = 'C';
		$output .= substr ($buffer, 1, 2);
		$output .= chr($version);
		$output .= substr ($buffer, 4, 4);
		$output .= gzcompress (substr ($buffer, 8));
		
		return ($output);
	}
	else
		return ($buffer);
}



/*********************************************************/
/* Decompress Flash file                                 */
/*********************************************************/

function phpAds_SWFDecompress($buffer)
{
	if (function_exists('gzuncompress') &&
		substr($buffer, 0, 3) == swf_tag_compressed &&
		ord(substr($buffer, 3, 1)) >= 6)
	{
		$output  = 'F';
		$output .= substr ($buffer, 1, 7);
		$output .= gzuncompress (substr ($buffer, 8));
		
		return ($output);
	}
	else
		return ($buffer);
}



/*********************************************************/
/* Upgrade version of a Flash file                       */
/*********************************************************/

function phpAds_SWFUpgrade($buffer)
{
	$version = ord(substr($buffer, 3, 1));
	
	if ($version < 5)
	{
		 $version = 5;
		
		$output = substr ($buffer, 0, 3);
		$output .= chr($version);
		$output .= substr ($buffer, 4, 4);
		$output .= substr ($buffer, 8);
		
		return ($output);
	}
	else
		return ($buffer);
}



/*********************************************************/
/* Get the dimensions of the Flash banner                */
/*********************************************************/

function phpAds_SWFBits($buffer, $pos, $count)
{
	$result = 0;
	
	for ($loop = $pos; $loop < $pos + $count; $loop++)
		$result = $result + ((((ord($buffer[(int)($loop / 8)])) >> (7 - ($loop % 8))) & 0x01) << ($count - ($loop - $pos) - 1));
	
	return $result;
}

function phpAds_SWFDimensions($buffer)
{
	// Decompress if file is a Flash MX compressed file
	if (phpAds_SWFCompressed($buffer))
		$buffer = phpAds_SWFDecompress($buffer);
	
	// Get size of rect structure
	$bits   = phpAds_SWFBits ($buffer, 64, 5);
	
	// Get rect
	$width  = (int)((phpAds_SWFBits ($buffer, 69 + $bits, $bits) - phpAds_SWFBits ($buffer, 69, $bits)) / 20);
	$height = (int)((phpAds_SWFBits ($buffer, 69 + (3 * $bits), $bits) - phpAds_SWFBits ($buffer, 69 + (2 * $bits), $bits)) / 20);
	
	
	return (
		array($width, $height)
	);
}



/*********************************************************/
/* Get info about the hardcoded urls                     */
/*********************************************************/

function phpAds_SWFInfo($buffer)
{
	global $swf_variable, $swf_target_var;
		
	// Decompress if file is a Flash MX compressed file
	if (phpAds_SWFCompressed($buffer))
		$buffer = phpAds_SWFDecompress($buffer);
	
	$parameters = array();
	$linkcount = 1;
	
	while (preg_match('/								# begin
							(?<=\x00)					# match if preceded by a swf_tag_null
							(?:
								\x83						# match a swf_tag_geturl
								..							# match a UI16  (combined length)
								(
									(?:https?:\/\/|javascript:).+?		# match the url
								)
								\x00						# match a swf_tag_null
								(
									.*?						# match the target
								)
								\x00						# match a swf_tag_null
							|							# or
								\x96						# match a swf_tag_actionpush
								..							# match a U16 word (length)
								\x00						# match a swf_tag_null
								(
									(?:https?:\/\/|javascript:).+?		# match the url
								)
								\x00						# match a swf_tag_null
								\x96						# match a swf_tag_actionpush
								..							# match a UI16 (length)
								\x00						# match a swf_tag_null
								(
									.*?						# match the target
								)
								\x00						# match a swf_tag_null
								\x9A\x01					# match a swf_tag_geturl2
							)
						/sx', $buffer, $m))
	{
		if ($m[0]{0} == chr(0x83))
		{
			$parameter_url = $m[1];
			$parameter_target = $m[2];
		}
		else
		{
			$parameter_url = $m[3];
			$parameter_target = $m[4];
		}

		$parameters[$linkcount] = array(
			$parameter_url, $parameter_target
		);
		
		$buffer = str_replace($m[0], '', $buffer);
		
		$linkcount++;
	}
	
	if (count($parameters))
		return ($parameters);
	else
		return false;
}



/*********************************************************/
/* Convert hard coded urls                               */
/*********************************************************/

function phpAds_SWFConvert($buffer, $compress, $allowed)
{
	global $swf_variable, $swf_target_var;
	
	// Decompress if file is a Flash MX compressed file
	if (phpAds_SWFCompressed($buffer))
		$buffer = phpAds_SWFDecompress($buffer);
	
	
	$parameters = array();
	$linkcount = 1;
	$allowedcount = 1;
	$final = $buffer;
	
	$tag_preg = '';
	for ($i = 0; $i < 64; $i++)
		$tag_preg .= sprintf('\\x%02X', 0x80 | $i);
	
	while (preg_match('/								# begin
							^
							(
							.+?							# match anything from the start
							\x00						# match a swf_tag_null
							)
							(
								\x83						# match a swf_tag_geturl
								..							# match a UI16  (combined length)
								(
									(?:https?:\/\/|javascript:).+?		# match the url
								)
								\x00						# match a swf_tag_null
								(
									.*?						# match the target
								)
								\x00						# match a swf_tag_null
							|							# or
								\x96						# match a swf_tag_actionpush
								..							# match a U16 word (length)
								\x00						# match a swf_tag_null
								(
									(?:https?:\/\/|javascript:).+?		# match the url
								)
								\x00						# match a swf_tag_null
								\x96						# match a swf_tag_actionpush
								..							# match a UI16 (length)
								\x00						# match a swf_tag_null
								(
									.*?						# match the target
								)
								\x00						# match a swf_tag_null
								\x9A\x01					# match a swf_tag_geturl2
							)
						/sx', $buffer, $m))
	{
		$geturl_part = $m[2];

		if (!preg_match('/^.*?(....)([\x06\x08][\xBF'.$tag_preg.'])/s', strrev($m[1]), $m))
			die('Error!!');

		foreach ($m as $k => $v)
			$m[$k] = strrev($v);

		$original = $replacement = $m[0].$geturl_part;
		$object_tag = $m[2];
		if ($object_tag{0} == chr(0xBF))
		{
			$object_extended = true;
			$object_len = current(unpack('V', $m[1]));
		}
		else
		{
			$object_extended = false;
			$object_len = ord($object_tag{0}) & 0x3F;
		}

		$geturl2_part = swf_tag_actionpush.
							chr(strlen('_root')+2).
							swf_tag_null.
						swf_tag_null.
							'_root'.
						swf_tag_null.
	
						swf_tag_actiongetvariable.
	
						swf_tag_actionpush.
							chr(strlen($swf_variable.$linkcount)+2).
							swf_tag_null.
						swf_tag_null.
							$swf_variable.
							$linkcount.
						swf_tag_null.
	
						swf_tag_actiongetmember.
	
						swf_tag_actionpush.
							chr(strlen('_root')+2).
							swf_tag_null.
						swf_tag_null.
							'_root'.
						swf_tag_null.
	
						swf_tag_actiongetvariable.
	
						swf_tag_actionpush.
							chr(strlen($swf_target_var.$linkcount)+2).
							swf_tag_null.
						swf_tag_null.
							$swf_target_var.
							$linkcount.
						swf_tag_null.
	
						swf_tag_actiongetmember.
	
						swf_tag_actiongeturl2;
	
		$replacement = str_replace($geturl_part, $geturl2_part, $replacement);	
	
		$object_len2 = $object_len + strlen($geturl2_part) - strlen($geturl_part);
	
		$replacement = substr($replacement, $object_extended ? 6 : 2);
		
		
		if ($object_len2 < 0x3F)
			$replacement = chr(0x80 | $object_len2).$object_tag{1}.$replacement;
		else
			$replacement = chr(0xBF).$object_tag{1}.pack('V', $object_len2).$replacement;

		// Is this link allowed to be converted?
		if (in_array($allowedcount, $allowed))
		{
			// Convert
			$final = str_replace($original, $replacement, $final);

			// Fix file size
			$file_size = current(unpack('V', substr($final, 4, 4))) + strlen($replacement) - strlen($original);
			$final = substr($final, 0, 4).pack('V', $file_size).substr($final, 8);

			$parameters[$linkcount] = $allowedcount;
			
			$linkcount++;
		}
		
		$allowedcount++;
	
		$buffer = str_replace($original, '', $buffer);
	}
	
	
	if ($compress == true)
		$final = phpAds_SWFCompress($final);
	else
		$final = phpAds_SWFUpgrade($final);		
	
	return (array($final, $parameters));
}

?>