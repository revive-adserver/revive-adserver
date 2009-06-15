<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: adlayer_en.php 33995 2009-03-18 23:04:15Z chris.nutting $
*/

$conf = $GLOBALS['_MAX']['CONF'];

$words = array(
    'Interstitial or Floating DHTML Tag' => 'Interstitial or Floating DHTML Tag',
    'Allow Interstitial or Floating DHTML Tags' => 'Allow Interstitial or Floating DHTML Tags',
    'Third Party Comment' => "
  * Don't forget to replace the '{clickurl}' text with
  * the click tracking URL if this ad is to be delivered through a 3rd
  * party (non-Max) adserver.
  *",

    'Cache Buster Comment' => "
  * Replace all instances of {random} with
  * a generated random number (or timestamp).
  *",

    'SSL Backup Comment' => "",

    'SSL Delivery Comment' => "
  * This tag has been generated for use on a non-SSL page. If this tag
  * is to be placed on an SSL page, change the
  *   'http://{$conf['webpath']['delivery']}/...'
  * to
  *   'https://{$conf['webpath']['deliverySSL']}/...'
  *",
);

// The simple and geocities plugins require access to some images
if (isset($GLOBALS['layerstyle']) &&
    ($GLOBALS['layerstyle'] == 'geocities' || $GLOBALS['layerstyle'] == 'simple')) {
    $words['Comment'] = '
  *------------------------------------------------------------*
  * This interstitial invocation code requires the images from:
  * /www/images/layerstyles/'.$GLOBALS['layerstyle'].'/...
  * To be accessible via: http(s)://' . $conf['webpath']['images'] . '/layerstyles/'.$GLOBALS['layerstyle'].'/...
  *------------------------------------------------------------*';
} else {
    $words['Comment'] = '';
}
?>
