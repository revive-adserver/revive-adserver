<?php

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/* $Name$ $Revision$													*/
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require("config.inc.php");
require("view.inc.php");
require("acl.inc.php");


// Set header information
header("Content-type: application/x-javascript");
require("nocache.inc.php");


// Get the banner
view_js("$what",$clientID,"$target","$source","$withText","$context");

?>
