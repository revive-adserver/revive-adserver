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
 * This function generates the code to show an "HTML" ad (usually 3rd party adserver code)
 *
 * @param array   $aBanner      The ad-array for the ad to render code for
 * @param int     $zoneId       The zone ID of the zone used to select this ad (if zone-selected)
 * @param string  $source       The "source" parameter passed into the adcall
 * @param string  $ct0          The 3rd party click tracking URL to redirect to after logging
 * @param int     $withText     Should "text below banner" be appended to the generated code
 * @param bookean $logClick     Should this click be logged (clicks in admin should not be logged)
 * @param boolean $logView      Should this view be logged (views in admin should not be logged
 *                              also - 3rd party callback logging should not be logged at view time)
 * @param boolean $useAlt       Should the backup file be used for this code
 * @param boolean $richMedia    Does this invocation method allow for serving 3rd party/html ads
 * @param string  $loc          The "current page" URL
 * @param string  $referer      The "referring page" URL
 *
 * @return string               The HTML to display this ad
 */
function Plugin_BannerTypeHTML_delivery_adRender(&$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $useAlt=false, $richMedia=true, $loc, $referer)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $prepend = !empty($aBanner['prepend']) ? $aBanner['prepend'] : '';
    $append = !empty($aBanner['append']) ? $aBanner['append'] : '';
    $code = !empty($aBanner['htmlcache']) ? $aBanner['htmlcache'] : '';
    $aBanner['bannerContent'] = $aBanner['htmltemplate'];

    // Parse PHP code
    if ($conf['delivery']['execPhp'])
    {
        if (preg_match ("#(\<\?php(.*)\?\>)#isU", $code, $parser_regs))
        {
            // Extract PHP script
            $parser_php     = $parser_regs[2];
            $parser_result     = '';

            // Replace output function
            $parser_php = preg_replace ("#echo([^;]*);#i", '$parser_result .=\\1;', $parser_php);
            $parser_php = preg_replace ("#print([^;]*);#i", '$parser_result .=\\1;', $parser_php);
            $parser_php = preg_replace ("#printf([^;]*);#i", '$parser_result .= sprintf\\1;', $parser_php);

            // Split the PHP script into lines
            $parser_lines = explode (";", $parser_php);
            for ($parser_i = 0; $parser_i < sizeof($parser_lines); $parser_i++)
            {
                if (trim ($parser_lines[$parser_i]) != '')
                    eval (trim ($parser_lines[$parser_i]).';');
            }

            // Replace the script with the result
            $code = str_replace ($parser_regs[1], $parser_result, $code);
        }
    }

    // Get the text below the banner
    $bannerText = !empty($aBanner['bannertext']) ? "$clickTag{$aBanner['bannertext']}$clickTagEnd" : '';
    // Get the image beacon...
    if ((strpos($code, '{logurl}') === false) && (strpos($code, '{logurl_enc}') === false)) {
        $beaconTag = ($logView && $conf['logging']['adImpressions']) ? _adRenderImageBeacon($aBanner, $zoneId, $source, $loc, $referer) : '';
    } else {
        $beaconTag = '';
    }
    return $prepend . $code . $bannerText . $beaconTag . $append;
}

?>
