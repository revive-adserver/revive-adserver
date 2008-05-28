<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('campaign-zone.html');

$websiteCount = 2;
$zoneCount = 7;

$runOfNetwork = false;


$websites = array();
for ($i = 0; $i < $websiteCount; $i++) {
	$zones = array();
	for ($j = 0; $j < $zoneCount; $j++) {
		array_push($zones, array(id=> $j, linked => ($j % 3) == 0, name => "Home page top", ctr => 0.003, cr => 0.001, ecpm => 0.23, category => "Finance", description => ""));
	}
	
	array_push($websites, array(id => $i, linked => false, name => "www.test.com", ctr => 0.08, cr => 0.02, ecpm => 3.45, category => "Finance", description => "", zones => $zones));
}
/*
$websites = array(
  array(id => 1, linked => false, name => "www.test.com", ctr => 0.08, cr => 0.02, ecpm => 3.45, category => "Finance", description => "", zones =>
    array(
	    array(id=> 1, linked => false, name => "Home page top", ctr => 0.003, cr => 0.001, ecpm => 0.23, category => "Finance", description => ""),
	    array(id=> 2, linked => true, name => "Home page side", ctr => 0.003, cr => 0.001, ecpm => 0.23, category => "Finance", description => ""),
	    array(id=> 3, linked => false, name => "Content page top", ctr => 0.003, cr => 0.001, ecpm => 0.23, category => "Finance", description => "")
	  )
 ),
  array(id => 2, linked => true, name => "www.abc.com", ctr => 0.08, cr => 0.02, ecpm => 3.45, category => "Sports", description => "", zones =>
    array(
      array(id=> 1, linked => true, name => "Content page top", ctr => 0.003, cr => 0.001, ecpm => 0.23, category => "Sports", description => "")
    )
 )
);
*/

$oTpl->assign('websites', $websites);
$oTpl->assign('runOfNetwork', $runOfNetwork);

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
