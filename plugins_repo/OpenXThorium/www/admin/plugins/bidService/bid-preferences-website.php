<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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

// placeholder for alpha version
die('Not implemented in Thorium Alpha');

require_once 'bid-common.php';

phpAds_PageHeader("bid-preferences-website",'','../../');

$oTpl    = new OA_Plugin_Template('bid-preferences-website.html','bidService');

//TODO get that from DB, OXC ?
$aCreativeTypes = array(
    array('id' => 1, 'name' => 'Image', 'checked' => true),
    array('id' => 2, 'name' => 'Flash', 'checked' => true),
    array('id' => 3, 'name' => 'Text'),
    array('id' => 4, 'name' => 'Video', 'checked' => true),
    array('id' => 5, 'name' => 'DHTML'),
    array('id' => 6, 'name' => 'Video'),
    array('id' => 7, 'name' => 'Expandable'),
    array('id' => 8, 'name' => 'Audio'),
);

$aCreativeAttributes = array(
   array('id' => 1, 'name' => 'Alcohol'),
   array('id' => 2, 'name' => 'Audio/Video'),
   array('id' => 3, 'name' => 'Dating/Romance'),
   array('id' => 4, 'name' => 'Download'),
   array('id' => 5, 'name' => 'English', 'checked' => true),
   array('id' => 6, 'name' => 'Error Box', 'checked' => true),
   array('id' => 7, 'name' => 'Excessive Animation'),
   array('id' => 8, 'name' => 'Gambling'),
   array('id' => 9, 'name' => 'Holiday'),
   array('id' => 10, 'name' => 'Incentivized'),
   array('id' => 11, 'name' => 'Male Health', 'checked' => true),
   array('id' => 12, 'name' => 'Membership Club'),
   array('id' => 13, 'name' => 'Political'),
   array('id' => 14, 'name' => 'Suggestive'),
   array('id' => 15, 'name' => 'Tobacco'),
);


//split into groups
$optimalRowCount = 8;
$count = count($aCreativeAttributes);
if ($count <= $optimalRowCount) { //one column
    $aAttrCols[] = $aCreativeAttributes;
}
else if ($count > 40) { //no more than 4 cols
    $size = ceil($count / 4);
    $aAttrCols = array_chunk($aCreativeAttributes, $size);
}
else {
    $size = $optimalRowCount;
    $aAttrCols = array_chunk($aCreativeAttributes, $size);
}

$oTpl->assign('aCreativeTypes', $aCreativeTypes);
$oTpl->assign('aCreativeAttributes', $aAttrCols);

$oTpl->display();

phpAds_PageFooter();



?>