<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

// Register input variables
phpAds_registerGlobal (
    'size',
    'text',
    'dest'
);

/**
 * MAX_Admin_Invocation_Affiliate class is a class for placingInvocationForm(s)
 * and generating invocation codes for affiliates
 *
 */
class MAX_Admin_Invocation_Affiliate extends MAX_Admin_Invocation {

    /**
     * Place invocation form - generate form with group of options for every plugin,
     * look into max/docs/developer/plugins.zuml for more details
     *
     * @param array $extra
     * @param boolean $zone_invocation
     *
     * @return string  Generated invocation form
     */
    function placeInvocationForm($extra = '', $zone_invocation = false)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];

        $globalVariables = array(
            'affiliateid', 'size', 'text', 'dest'
        );

        $buffer = '';

        $this->zone_invocation = $zone_invocation;

        foreach($globalVariables as $makeMeGlobal) {
            global $$makeMeGlobal;
            // also make this variable a class attribute
            // so plugins could have an access to these values and modify them
            $this->$makeMeGlobal = &$$makeMeGlobal;
        }

        $invocationTypes = &MAX_Plugin::getPlugins('invocationTags');
        foreach($invocationTypes as $pluginKey => $invocationType) {
            if ($invocationType->affiliatePlugin == true) {
                $available[$pluginKey] = $invocationType->affiliatePlugin;
                $names[$pluginKey] = $invocationType->getName();
                $invocationTypes[$pluginKey]->maxInvocation =& $this;
            }
        }
        
        $affiliateid = $this->affiliateid;
        
        $size = isset($size) ? $size : 'all';
        
        if (preg_match('/^(\d+)x(\d+)$/D', $size, $matches)) {
            $width  = $matches[1];
            $height = $matches[2];
        } elseif ($size == 'text') {
            $width  = $height = 0;
        } else {
            $width  = $height = -1;
            $size   = 'all';
        }
    
        $res = phpAds_dbQuery("
            SELECT
                zoneid,
                zonename,
                width,
                height,
                delivery
            FROM
                {$conf['table']['prefix']}{$conf['table']['zones']}
            WHERE
                affiliateid={$affiliateid}
            ") or phpAds_sqlDie();
        
        $aZones = array();
        while ($row = phpAds_dbFetchArray($res)) {
            $aZones[$row['zoneid']] = $row;
        }
    
        echo "
            <script type='text/javascript'>
            <!--
            function MAX_htmlspecialchars(str)
            {
                str = str.replace(/&/g, '&amp;');
                str = str.replace(/</g, '&lt;');
                str = str.replace(/>/g, '&gt;');
                str = str.replace(/\"/g, '&quot;');
                return str;
            }
            function regenerateTextAd(id, ar)
            {
                var oCode = findObj('bannercode_' + id);
                var oHtml = findObj('bannerhtml_' + id);
                var oText = findObj('text_' + id);
                var oDest = findObj('dest_' + id);
                
                if (ar) {
                    var sep = oDest.value.indexOf('?') >= 0 ? '&' : '?';
                    oCode.value = oCode.value.replace(new RegExp('(<a href=\\').*?(\\\\?|&|&amp;)(m3_data=)', 'g'), '$1' + MAX_htmlspecialchars(oDest.value + sep) + '$3');
                } else {
                    oCode.value = oCode.value.replace(new RegExp('(__maxdest=)[^\\']*', 'g'), '$1' + MAX_htmlspecialchars(oDest.value));
                }

                oCode.value = oCode.value.replace(new RegExp('^(<a[^>]+>).*(</a>)$', 'g'), '$1' + MAX_htmlspecialchars(oText.value) + '$2');
                oHtml.innerHTML = oCode.value;
            }
            //-->
            </script>
        ";    
    
        if (isset($invocationTypes['ar'])) {
            $arrivalAds[] = array();
            $res = phpAds_dbQuery("SELECT bannerid AS ad_id FROM {$conf['table']['prefix']}{$conf['table']['banners']} WHERE arrival_capable = 't'");
            while ($row = phpAds_dbFetchArray($res)) {
                $arrivalAds[$row['ad_id']] = true;
            }
        }
    
        $aSizes = array();
        $buffer = '';
        foreach ($aZones as $zoneId => $zone) {
            $zoneAds = OA_Dal_Delivery_getZoneLinkedAds($zoneId);
    
            // Set ZoneID
            $this->zoneid = $zoneId;
            
            $adVarNames = array('xAds', 'ads', 'lAds');
            foreach ($adVarNames as $var) {
                foreach ($zoneAds[$var] as $adId => $ad) {
                    if ($ad['type'] == 'txt') {
                        $bannersize = 'Text banner';
                        $aSizes['0x0'] = true;
                    } else {
                        $bannersize = $ad['width'].'x'.$ad['height'];
                        $aSizes[$bannersize] = array('width' => $ad['width'], 'height' => $ad['height']);
                        $bannersize = 'Banner size: '.$bannersize;
                    }
                    
                    // Exclude not matching banners
                    if (($width > 0 && ($width != $ad['width'] || $height != $ad['height'])) || ($width == 0 && $ad['type'] != 'txt')) {
                        continue;
                    }
    
                    if (isset($invocationTypes['ar']) && isset($arrivalAds[$ad['ad_id']])) {
                        $ad    = $invocationTypes['ar']->prepareBannerForArrivals($ad);
                        $dest  = $invocationTypes['ar']->getDestination($ad);
    
                        $bannercode = MAX_adRender($ad, $zoneId, '', '', '', true, $dest, false, true, '', '', '');
                        $bannerhtml = $bannercode;
                        
                        $regenType = 1;
                    } else {
                        if (empty($ad['url'])) {
                            $ad['url'] = '#';
                        }
        
                        $bannercode = MAX_adRender($ad, $zoneId, '', '', '', true, true, false, true, '', '', '');
                        $bannerhtml = MAX_adRender($ad, $zoneId, '', '', '', true, false, false, true, '', '', '');
                        
                        $regenType = 0;
                    }
                    
                    if ($ad['contenttype'] == 'swf') {
                        $bannercode = MAX_flashGetFlashObjectExternal() . $bannercode;
                        $bannerhtml = MAX_flashGetFlashObjectExternal() . $bannerhtml;
                    }
    
                    if ($ad['url'] == '#') {
                        $ad['url'] = '';
                    }
    
                    $codeId = "{$zoneId}_{$adId}";
    
                    $buffer .= "
                        <table border='1' style='width: 700px; margin-bottom: 2em'>
                            <tr>
                                <td colspan='2'><strong>{$zone['zonename']}:</strong> {$ad['name']}</td>
                            </tr>
                            <tr>
                                <td style='width: 350px'>";
                    if (strpos ($_SERVER['HTTP_USER_AGENT'], 'MSIE') > 0 && strpos ($_SERVER['HTTP_USER_AGENT'], 'Opera') < 1) {
                        $buffer .= "<table border='0' style='width: 100%'><tr><td align='left'><em>Code:</em></td><td align='right'><img src='images/icon-clipboard.gif' align='absmiddle'>&nbsp;";
                        $buffer .= "<a href='javascript:max_CopyClipboard(\"bannercode_{$codeId}\");'>{$GLOBALS['strCopyToClipboard']}</a></td></tr></table>";
                    } else {
                        $buffer .= "Code:";
                    }
                    $buffer .= "</td>
                                <td style='width: 350px' align='center'><em>Preview ({$bannersize})</em></td>
                            </tr>
                            <tr>
                                <td><textarea style='width: 350px; height: 250px' class='code-gray' name='bannercode_{$codeId}' id='bannercode_{$codeId}'>" . htmlspecialchars($bannercode) . "</textarea></td>
                                ";
                    
                    if ($ad['type'] == 'txt') {
                        $buffer .= "
                                <td align='center'>
                                    <p id='bannerhtml_{$codeId}'>{$bannerhtml}</p>
                                    <p>&nbsp;</p>
                                    <hr>
                                    <p>&nbsp;</p>
                                    <form action='' method='get' onsubmit='return false'>
                                        <table border='0'>
                                            <tr><td align='right'><strong>Text:</strong>&nbsp;</td><td><input type='text' name='text_{$codeId}' onfocus='regenerateTextAd(\"{$codeId}\", ".$regenType.")' onkeyup='regenerateTextAd(\"{$codeId}\", ".$regenType.")' onblur='regenerateTextAd(\"{$codeId}\", ".$regenType.")' value='".htmlspecialchars($ad['bannertext'])."' /></td></tr>
                                            <tr><td align='right'><strong>Destination URL:&nbsp;</td><td></strong><input type='text' name='dest_{$codeId}' onfocus='regenerateTextAd(\"{$codeId}\", ".$regenType.")' onkeyup='regenerateTextAd(\"{$codeId}\", ".$regenType.")' onblur='regenerateTextAd(\"{$codeId}\", ".$regenType.")' value='".htmlspecialchars($ad['url'])."' /></td></tr>
                                        </table>
                                    </form>
                                    <script type='text/javascript'>regenerateTextAd(\"{$codeId}\", ".$regenType.");</script>
                                </td>";
                    } else {
                        $buffer .=     "
                                <td align='center'>
                                    <div style='overflow: auto; height: 250px'>
                                        <table border='0' cellspacing='0' cellpadding='0'>
                                            <tr><td style='height: 250px' valign='middle'>{$bannerhtml}</td></tr>
                                        </table>
                                    </div>
                                </td>";            
                    }
                    
                    $buffer .= "
                            </tr>
                        </table>
                    ";
                }
            }
        }
        
        if (file_exists(MAX_PATH . '/www/admin/affiliate-invocation-help.php')) {
            echo "
                <br />
                <br />
                <a href='#' onclick='help_window(\"affiliate-invocation-help.php\"); return false;' style='border: 1px solid red; padding: 2px;'><b>How to build tracking tags...</b></a>
                <br />
                <br />
                <br />
            ";
        } else {
            echo "
                <br />
            ";
        }
    
        echo "
            <br />
            <form action='' method='get'>
                <input type='hidden' name='affiliateid' value='{$affiliateid}' />
                <b>Banner type:</b> <select name='size' onchange='this.form.submit()' tabindex='".($tabindex++)."'>
                    <option value='all'".($width == -1 ? ' selected="selected"' : '').">All</option>
            ";
    
        if (isset($aSizes['0x0'])) {
            echo "<option value='text'".($width == 0 ? ' selected="selected"' : '').">Text banner</option>";
            unset($aSizes['0x0']);
        }
        
        foreach (array_keys($phpAds_IAB) as $key)
        {
            if (!isset($aSizes[$phpAds_IAB[$key]['width'].'x'.$phpAds_IAB[$key]['height']])) {
                continue;
            }
            unset($aSizes[$phpAds_IAB[$key]['width'].'x'.$phpAds_IAB[$key]['height']]);
            
            $selected = $phpAds_IAB[$key]['width'] == $width && $phpAds_IAB[$key]['height'] == $height;
            echo "<option value='".$phpAds_IAB[$key]['width']."x".$phpAds_IAB[$key]['height']."'".
                ($selected ? 'selected="selected"' : '').">".$key."</option>";
        }
        
        ksort($aSizes);
        foreach ($aSizes as $key => $value) {
            $selected = $value['width'] == $width && $value['height'] == $height;
            echo "<option value='".$key."'".($selected ? 'selected="selected"' : '').">".'Custom'.' ('.str_replace('x', ' x ',$key).")</option>";
        }
        
        echo "
                </select>
            </form>
            ";
    
        phpAds_ShowBreak();
    
        echo '<br />';
        echo $buffer;
    }
}

?>
