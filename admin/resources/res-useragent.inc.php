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


// This is by no means a complete list of all useragents. If you have 
// corrections or additions to this list, please send them to niels@creatype.nl

$operatingsystems = array (
		'Windows' => 'Win',
		'Windows CE' => 'Windows CE',
		'MacOS' => 'Mac',
		'Linux' => 'Linux',
		'BSD' => 'BSD',
		'Sun' => 'SunOS',
		'IRIX' => 'IRIX',
		'AIX' => 'AIX',
		'Unix' => 'Unix',
	);

$useragents = array (
		'IE 4' => 'MSIE 4.*\)$',
		'IE 5' => 'MSIE 5.*\)$',
		'IE 6' => 'MSIE 6.*\)$',
		'Netscape 3' => '^Mozilla/3.*\([^c][^o][^m].*\)$',
		'Netscape 4' => '^Mozilla/4.*\([^c][^o][^m].*\)$',
		'Netscape 6+' => '^Mozilla/5.*Gecko',
		'Opera' => 'Opera',
		'AOL' => 'AOL',
		'MSN' => 'MSN',
		'WebTV' => 'WebTV',
		'Konqueror' => 'Konqueror',
		'OmniWeb' => 'Omni',
		'iCab' => 'iCab'
	);

?>