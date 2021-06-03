<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * @package    MaxDelivery
 * @subpackage TestSuite Data
 */

$aBanner	= array('ad_id'=>'9999',
					'placement_id' => '111',
					'url'=>'http://www.somewhere.com',
					'contenttype'=>''
					);
$zoneId		= 0 ;
$source 	= '';
$loc 		= '';
$referer 	= '';


// break a known result structure down into individual elements
$aPattern['struct']     = "(?P<divB><div (?P<divB_attrib>id='beacon_\{random\}'[\w\W\s]+)>"
                        . "(?P<divB_content><img (?P<divB_img_attrib>[\w\W\s]+)>)"
                        . "<\/div>)"
                        . "";

//$aPattern['beac']	= "<div id='beacon_\d+' [\w\W\d\s]+><\/div>";

?>