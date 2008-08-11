<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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

$file = '/lib/OA/Delivery/marketplace.php';
###START_STRIP_DELIVERY
if(isset($GLOBALS['_MAX']['FILES'][$file])) {
    return;
}
###END_STRIP_DELIVERY
$GLOBALS['_MAX']['FILES'][$file] = true;

require_once MAX_PATH . '/lib/max/Delivery/javascript.php';

/**
 * @package    MaxDelivery
 * @subpackage marketplace
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 * This library defines functions that need to be available to
 * marketplace-enabled delivery engine scripts
 *
 */

function MAX_marketplaceEnabled()
{
    return !empty($GLOBALS['_MAX']['CONF']['pluginGroupComponents']['bidService']);
}

/**
 * A function to check if a ping to the ID service is needed
 *
 * @todo Use a cookie
 * @return boolean
 */
function MAX_marketplaceNeedsIndium()
{
    $aConf = $GLOBALS['_MAX']['CONF'];
    return MAX_marketplaceEnabled() && empty($_COOKIE['In']);
}

function MAX_marketplaceProcess($scriptFile, $aAd, $aZoneInfo = array(), $aParams = array())
{
    $output = '';
    $aConf = $GLOBALS['_MAX']['CONF'];
    if (MAX_marketplaceEnabled()) { // Need also to check if marketplace is enabled at zone level
        if (!empty($aAd['html']) && !empty($aAd['width']) && !empty($aAd['height'])) {

            $cb = mt_rand(0, PHP_INT_MAX);

            $floorPrice = $aConf['bidService']['defaultFloorPrice'];

            $baseUrl = 'http://'.$aConf['bidService']['thoriumHost'];
            $urlParams = array(
                'pid=OpenXDemo',
                'tag_type=1',
                'f='.urlencode($floorPrice),
                's='.urlencode($aAd['width'].'x'.$aAd['height']),
            );

            if ($aConf['logging']['adImpressions']) {
                $beaconHtml = MAX_adRenderImageBeacon($aAd['logUrl'].'&fromMarketplace=1');
                $beaconHtml = str_replace($aAd['aSearch'], $aAd['aReplace'], $beaconHtml);
            } else {
                $beaconHtml = '';
            }

            switch ($scriptFile) {
                case 'js':
                    $uniqid = substr(md5(uniqid('', 1)), 0, 8);

                    $ntVar  = 'OXT_'.$uniqid;
                    $nfVar  = 'OXF_'.$uniqid;
                    $mktVar = 'OXM_'.$uniqid;

                    $output = "\n";
                    $output .= MAX_javascriptToHTML($aAd['html'], $nfVar, false);
                    $output .= "\n";
                    $output .= MAX_javascriptToHTML($beaconHtml, $ntVar, false);
                    $output .= "\n";

                    $url = $baseUrl.'/jsox?'.join('&', $urlParams);
                    $url .= '&nt='.urlencode($ntVar);
                    $url .= '&nf='.urlencode($nfVar);
                    $url .= '&cb'.$cb;

                    $html = '<script type="text/javascript" src="'.htmlspecialchars($url).'"></script>';

                    $output .= MAX_javascriptToHTML($html, $mktVar);
                    break;
                case 'frame':
                case 'spc':
                    $oVar = 'OXM_'.substr(md5(uniqid('', 1)), 0, 8);

                    $output = '<script type="text/javascript">';
                    $output .= "\n";
                    $output .= "{$oVar} = {\"t\":".
                        MAX_javascriptEncodeJsonField($beaconHtml).
                        ",\"f\":".
                        MAX_javascriptEncodeJsonField($aAd['html']).
                        "}\n";
                    $output .= "</script>\n";

                    $url = $baseUrl.'/json?'.join('&', $urlParams);
                    $url .= '&o='.urlencode($oVar);
                    $url .= '&cb'.$cb;

                    $output .= '<script type="text/javascript" src="'.htmlspecialchars($url).'"></script>';
                    break;
            }
       }
    }

    return $output;
}

function MAX_marketplaceLogGetIds()
{
    $aAdIds = array();
    if (!empty($_GET['fromMarketplace'])) {
        $aAdIds[0] = -1;
    }
    return $aAdIds;
}

?>
