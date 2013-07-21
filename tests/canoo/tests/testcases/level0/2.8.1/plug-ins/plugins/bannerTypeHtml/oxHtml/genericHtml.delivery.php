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
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @abstract
 */
function Plugin_BannerTypeHTML_xHtml_genericHtml_delivery(&$aBanner, $zoneId=0, $source='', $ct0='', $withText=false, $logClick=true, $logView=true, $useAlt=false, $loc, $referer)
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
