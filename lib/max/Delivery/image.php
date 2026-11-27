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

function MAX_imageServe($aCreative, $filename)
{
    // Check if the browser sent a If-Modified-Since header and if the image was
    // modified since that date
    if (!isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ||
        $aCreative['t_stamp'] > strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        MAX_header("Last-Modified: " . gmdate('D, d M Y H:i:s', $aCreative['t_stamp']) . ' GMT');
        MAX_header('Content-Type: ' . MAX_imageGetContentType($filename));
        MAX_header('X-Content-Type-Options: nosniff');
        echo $aCreative['contents'];
    } else {
        // Send "Not Modified" status header
        MAX_sendStatusCode(304);
    }
}

/**
 * Returns the content type of a stored creative, based on its file extension
 *
 * @param string $filename
 * @return string
 */
function MAX_imageGetContentType($filename)
{
    return match (MAX_imageGetContentTypeByExtension($filename)) {
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'avif' => 'image/avif',
        'swf' => 'application/x-shockwave-flash',
        'dcr' => 'application/x-director',
        'rpm' => 'audio/x-pn-realaudio-plugin',
        'mov' => 'video/quicktime',
        default => 'application/octet-stream',
    };
}

/**
 * Returns the banner content type for a file name, based on its extension
 *
 * @param string $filename
 * @param bool $alt True to only allow content types suitable for alt images
 * @return string The content type, or an empty string if not supported
 */
function MAX_imageGetContentTypeByExtension($filename, $alt = false)
{
    return match (strtolower(substr((string) strrchr($filename, '.'), 1))) {
        'jpeg', 'jpg' => 'jpeg',
        'png' => 'png',
        'gif' => 'gif',
        'webp' => 'webp',
        'avif' => 'avif',
        'swf' => $alt ? '' : 'swf',
        'dcr' => $alt ? '' : 'dcr',
        'rpm' => $alt ? '' : 'rpm',
        'mov' => $alt ? '' : 'mov',
        default => '',
    };
}
