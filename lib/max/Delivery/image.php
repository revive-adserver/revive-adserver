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

$file = '/lib/OA/Delivery/image.php';
###START_STRIP_DELIVERY
if (isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

/**
 * @package    MaxDelivery
 * @subpackage image
 *
 * This library defines functions that need to be available to
 * the ai delivery script
 *
 */

function MAX_imageServe($aCreative, $filename, $contenttype)
{
    // Check if the browser sent a If-Modified-Since header and if the image was
    // modified since that date
    if (!isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ||
        $aCreative['t_stamp'] > strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        MAX_header("Last-Modified: " . gmdate('D, d M Y H:i:s', $aCreative['t_stamp']) . ' GMT');
        if (isset($contenttype) && $contenttype != '') {
            match ($contenttype) {
                'swf' => MAX_header('Content-type: application/x-shockwave-flash; name=' . $filename),
                'dcr' => MAX_header('Content-type: application/x-director; name=' . $filename),
                'rpm' => MAX_header('Content-type: audio/x-pn-realaudio-plugin; name=' . $filename),
                'mov' => MAX_header('Content-type: video/quicktime; name=' . $filename),
                'webp' => MAX_header('Content-type: image/webp; name=' . $filename),
                'avif' => MAX_header('Content-type: image/avif; name=' . $filename),
                default => MAX_header('Content-type: image/' . $contenttype . '; name=' . $filename),
            };
        }
        echo $aCreative['contents'];
    } else {
        // Send "Not Modified" status header
        MAX_sendStatusCode(304);
    }
}
