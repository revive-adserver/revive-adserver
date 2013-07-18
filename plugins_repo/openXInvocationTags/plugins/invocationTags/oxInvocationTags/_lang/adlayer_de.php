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

$conf = $GLOBALS['_MAX']['CONF'];

$words = array(
    'Interstitial or Floating DHTML Tag' => 'Interstitial oder schwebender DHTML Tag',
    'Allow Interstitial or Floating DHTML Tags' => 'Erlaube Interstitial oder schwebende DHTML Tags',
    'Third Party Comment' => "
  * Don't forget to replace the '{clickurl}' text with
  * the click tracking URL if this ad is to be delivered through a 3rd
  * party (non-Max) ad server.
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
