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

$words =  array(
    'Interstitial or Floating DHTML Tag' => 'Etiqueta Interstitial o DHTML flotante',
    'Allow Interstitial or Floating DHTML Tags' => 'Permitir etiqueta Interstitial o DHTML flotante',
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
