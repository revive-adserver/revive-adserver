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


// Set define to prevent duplicate include
define ('LIBAPPEND_INCLUDED', true);


// Include zones library if needed
if (!defined('LIBZONES_INCLUDED'))
	require ("lib-zones.inc.php");


// Define appendtypes
define ("phpAds_AppendNone", 0);
define ("phpAds_AppendInterstitial", 1);
define ("phpAds_AppendPopup", 2);
define ("phpAds_AppendRaw", 3);

define ("phpAds_AppendKeyword", 0);
define ("phpAds_AppendZone", 1);
define ("phpAds_AppendBanner", 2);



/*********************************************************/
/* Fetch parameters from append code                     */
/*********************************************************/

function phpAds_ParseAppendCode ($append)
{
	global $phpAds_config;
	
	$ret = array(
				array(
					'what' => '', 
					'delivery' => phpAds_AppendPopup,
					'selection' => phpAds_AppendZone
				),
				array()
			);
	
	
	if (ereg("ad(popup|layer)\.php\?([^'\"]+)['\"]", $append, $match))
	{
		if (!empty($match[2]))
		{
			$ret[0]['delivery'] = ($match[1] == 'popup') ? phpAds_AppendPopup : phpAds_AppendInterstitial;
			
			$append = str_replace('&amp;', '&', $match[2]);
			
			if (ereg('[\?\&]?what=zone:([0-9]+)(&|$)', $append, $match))
			{
				$ret[0]['what'] = $match[1];
				$ret[0]['selection'] = phpAds_AppendZone;
			}
			elseif(ereg('[\?\&]?what=([0-9,]+)(&|$)', $append, $match))
			{
				$ret[0]['what'] = explode(',', $match[1]);
				$ret[0]['selection'] = phpAds_AppendBanner;
			}
			elseif(ereg('[\?\&]?what=([^&|^$]+)(&|$)', $append, $match))
			{
				$ret[0]['what'] = $match[1];
				$ret[0]['selection'] = phpAds_AppendKeyword;
			}
			else
			{
				$ret[0]['what'] = '';
				$ret[0]['selection'] = phpAds_AppendKeyword;
			}
				
			$append = explode('&', $append);
			while (list(, $v) = each($append))
			{
				$v = explode('=', $v);
				if (count($v) == 2)
					$ret[1][urldecode($v[0])] = urldecode($v[1]);
			}
		}
	}
	
	return $ret;
}

?>