<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer <niels@creatype.nl>             */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("../config.inc.php");
require ("../dblib.php");
require ("../nocache.inc.php");
require ("../admin/lib-statistics.inc.php");

// Set time limit and ignore user abort
if (!get_cfg_var ('safe_mode')) 
{
	set_time_limit (300);
	ignore_user_abort(1);
}


// Load language strings
require("../language/$phpAds_language.inc.php");


// Make database connection
db_connect();


$adminreport = "";

include ("maintenance-reports.php");
include ("maintenance-activation.php");

if ($adminreport != "")
{
	// mail admin report to admin
}

?>