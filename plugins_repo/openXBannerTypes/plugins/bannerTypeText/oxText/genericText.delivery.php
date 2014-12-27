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
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_BannerTypes
 */
function Plugin_BannerTypeText_oxText_genericText_delivery(&$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $useAlt=false, $richMedia=true, $loc, $referer)
{
    // This function won't ever be called, as this is the bundled default text type.
    // In any case, let's provide a reference to the function that's used instead.
    return _adRenderText($aBanner, $zoneId, $source, $ct0, $withText, $logClick, $logView, $useAlt, $richMedia, $loc, $referer);
}

?>
