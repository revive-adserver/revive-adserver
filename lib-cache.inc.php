<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Bjoern Hoehrmann		                        */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



$now = gmdate("D, d M Y H:i:s") . " GMT";
header ("Date: $now");
header ("Expires: $now");
header ("Last-Modified: $now");
header ("Pragma: no-cache");
header ("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");

?>