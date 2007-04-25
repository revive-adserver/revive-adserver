<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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



/*-------------------------------------------------------*/
/* Get the Flash version of the banner                   */
/*-------------------------------------------------------*/

function phpAds_SWFVersion($buffer)
{
	if (substr($buffer, 0, 3) == swf_tag_identify ||
		substr($buffer, 0, 3) == swf_tag_compressed)
		return ord(substr($buffer, 3, 1));
	else
		return false;
}



/*-------------------------------------------------------*/
/* Is the Flash file compressed?                         */
/*-------------------------------------------------------*/

function phpAds_SWFCompressed($buffer)
{
	if (substr($buffer, 0, 3) == swf_tag_compressed)
		return true;
	else
		return false;
}



/*-------------------------------------------------------*/
/* Compress Flash file                                   */
/*-------------------------------------------------------*/

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



/*-------------------------------------------------------*/
/* Decompress Flash file                                 */
/*-------------------------------------------------------*/

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



/*-------------------------------------------------------*/
/* Upgrade version of a Flash file                       */
/*-------------------------------------------------------*/

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



/*-------------------------------------------------------*/
/* Get the dimensions of the Flash banner                */
/*-------------------------------------------------------*/

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



/*-------------------------------------------------------*/
/* Get info about the hardcoded urls                     */
/*-------------------------------------------------------*/

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



/*-------------------------------------------------------*/
/* Convert hard coded urls                               */
/*-------------------------------------------------------*/

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
		$geturl_part	= $m[2];
		$previous_part	= $m[1];

		$allowed_types = array(12, 26, 34); // DoAction, PlaceObject2, DefineButton2
		$original = '';
		for ($len = 2; $len < strlen($previous_part); $len++)
		{
			$recordheader = substr($previous_part, -$len);
			$object_tag = substr($recordheader, 0, 2);
			$expected_len = strlen($geturl_part) + $len;

			$tag_type = (ord($object_tag{1}) << 2 | (ord($object_tag{0}) & ~0x3F) >> 6) & 0xFF;

			if (!in_array($tag_type, $allowed_types))
				continue;

			// Check for long RECORDHEADER
			if ($len > 6 && (ord($object_tag{0}) & 0x3F) == 0x3F)
			{
				$object_extended = true;
				$object_len = unpack('V', substr($recordheader, 2, 4));
				$object_len = current($object_len);
				$expected_len -= 6;
			}
			else
			{
				$object_extended = false;
				$object_len = ord($object_tag{0}) & 0x3F;
				$expected_len -= 2;
			}

			if ($object_len >= $expected_len)
			{
				$original = $replacement = $recordheader.$geturl_part;
				break;
			}
		}

		if (!strlen($original))
			die("Error: unsupported tag");

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

						swf_tag_actiongeturl2.

						swf_tag_null.

						swf_tag_null;


		if (preg_match('/(\x9B(..).*?)(..)$/s', $previous_part, $m))
		{
			$fheader_len = unpack('v', $m[2]);
			$fheader_len = current($fheader_len);
			$fbody_len = unpack('v', $m[3]);
			$fbody_len = current($fbody_len);
			if ($fheader_len == strlen($m[1]) - 1)
			{
				// getURL is inside an ActionDefineFunction
				$fbody_len += strlen($geturl2_part) - strlen($geturl_part);
				$geturl_part	= $m[0].$geturl_part;
				$geturl2_part	= $m[1].pack('v', $fbody_len).$geturl2_part;
			}
		}

		$replacement = str_replace($geturl_part, $geturl2_part, $replacement);

		$object_len2 = $object_len + strlen($geturl2_part) - strlen($geturl_part);

		$replacement = substr($replacement, $object_extended ? 6 : 2);

		if ($object_len2 < 0x3F)
			$replacement = chr(0x80 | $object_len2).$object_tag{1}.$replacement;
		else
			$replacement = chr(ord($object_tag{0}) | 0x3F).$object_tag{1}.pack('V', $object_len2).$replacement;

		// Is this link allowed to be converted?
		if (in_array($allowedcount, $allowed))
		{
			// Convert
			$final = str_replace($original, $replacement, $final);

			// Fix file size
			$file_size = unpack('V', substr($final, 4, 4));
			$file_size = current($file_size) + strlen($replacement) - strlen($original);

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

function hex_dump($str)
{
	for ($i=0; $i<strlen($str);$i++)
		printf('%02X', ord(substr($str, $i, 1)));

	echo "\n";
}


?>