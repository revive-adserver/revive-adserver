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

// Define constant used to place code generator
define('phpAds_adLayerLoaded', true);


// Register input variables
MAX_commonRegisterGlobalsArray(['stickyness', 'offsetx', 'offsety', 'hide',
                       'transparancy', 'delay', 'trail']);

/**
 *
 * Layerstyle for invocation tag plugin
 *
 */
class Plugins_oxInvocationTags_Adlayer_Layerstyles_Cursor_Invocation extends Plugins_InvocationTags_OxInvocationTags_adlayer
{
    /*-------------------------------------------------------*/
    /* Place ad-generator settings                           */
    /*-------------------------------------------------------*/

    public function placeLayerSettings()
    {
        global $stickyness, $offsetx, $offsety, $hide, $transparancy, $delay, $trail;
        global $tabindex;

        if (!isset($trail)) {
            $trail = '0';
        }
        if (!isset($stickyness)) {
            $stickyness = 5;
        }
        if (!isset($offsetx)) {
            $offsetx = 10;
        }
        if (!isset($offsety)) {
            $offsety = 10;
        }
        if (!isset($hide)) {
            $hide = '0';
        }
        if (!isset($transparancy)) {
            $transparancy = 0;
        }
        if (!isset($delay)) {
            $delay = 90;
        }

        $buffer = '';

        $buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
        $buffer .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%'></td></tr>";
        $buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Smooth movement") . "</td><td width='370'>";
        $buffer .= "<select name='trail' style='width:60px;' onChange='this.form.stickyness.disabled = this.selectedIndex ? true : false;' tabindex='" . ($tabindex++) . "'>";
        $buffer .= "<option value='1'" . ($trail == '1' ? ' selected' : '') . ">" . $GLOBALS['strYes'] . "</option>";
        $buffer .= "<option value='0'" . ($trail == '0' ? ' selected' : '') . ">" . $GLOBALS['strNo'] . "</option>";
        $buffer .= "</select>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Speed") . "</td><td width='370'>";
        $buffer .= "<select name='stickyness' style='width:60px;'" . ($trail == '0' ? ' disabled' : '') . " tabindex='" . ($tabindex++) . "'>";
        for ($i = 1;$i <= 9;$i++) {
            $buffer .= "<option value='" . $i . "'" . ($stickyness == $i ? ' selected' : '') . ">" . $i . "</option>";
        }
        $buffer .= "</select>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";

        $buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
        $buffer .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%'></td></tr>";
        $buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Hide the banner when the cursor is not moving") . "</td><td width='370'>";
        $buffer .= "<select name='hide' style='width:60px;' tabindex='" . ($tabindex++) . "' onChange='this.form.transparancy.disabled = this.selectedIndex ? true : false; this.form.delay.disabled = this.selectedIndex ? true : false;'>";
        $buffer .= "<option value='1'" . ($hide == '1' ? ' selected' : '') . ">" . $GLOBALS['strYes'] . "</option>";
        $buffer .= "<option value='0'" . ($hide == '0' ? ' selected' : '') . ">" . $GLOBALS['strNo'] . "</option>";
        $buffer .= "</select>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Delay before banner is hidden") . "</td><td width='370'>";
        $buffer .= "<input class='flat' type='text' name='delay' size='' value='" . htmlspecialchars($delay, ENT_QUOTES) . "' style='width:60px;'" . ($hide == '0' ? ' disabled' : '') . " tabindex='" . ($tabindex++) . "'> ms</td></tr>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Transparancy of the hidden banner") . "</td><td width='370'>";
        $buffer .= "<select name='transparancy' style='width:60px;'" . ($hide == '0' ? ' disabled' : '') . " tabindex='" . ($tabindex++) . "'>";
        for ($i = 0;$i <= 9;$i++) {
            $buffer .= "<option value='" . ($i * 10) . "'" . ($transparancy == ($i * 10) ? ' selected' : '') . ">" . ($i * 10) . " %</option>";
        }
        $buffer .= "</select>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>";

        $buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
        $buffer .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%'></td></tr>";
        $buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Horizontal shift") . "</td><td width='370'>";
        $buffer .= "<input class='flat' type='text' name='offsetx' size='' value='" . htmlspecialchars($offsetx, ENT_QUOTES) . "' style='width:60px;' tabindex='" . ($tabindex++) . "'> " . $GLOBALS['strAbbrPixels'] . "</td></tr>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Vertical shift") . "</td><td width='370'>";
        $buffer .= "<input class='flat' type='text' name='offsety' size='' value='" . htmlspecialchars($offsety, ENT_QUOTES) . "' style='width:60px;' tabindex='" . ($tabindex++) . "'> " . $GLOBALS['strAbbrPixels'] . "</td></tr>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        return $buffer;
    }



    /*-------------------------------------------------------*/
    /* Place ad-generator settings                           */
    /*-------------------------------------------------------*/

    public function generateLayerCode(&$mi)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        global $stickyness, $offsetx, $offsety, $hide, $transparancy, $delay, $trail;

        $mi->parameters[] = 'layerstyle=cursor';
        $mi->parameters[] = 'hide=' . $hide;
        $mi->parameters[] = 'trail=' . $trail;
        $mi->parameters[] = 'offsetx=' . $offsetx;
        $mi->parameters[] = 'offsety=' . $offsety;

        if (!empty($mi->charset)) {
            $mi->parameters[] = 'charset=' . urlencode($mi->charset);
        }
        if ($trail == '1') {
            $mi->parameters[] = 'stickyness=' . $stickyness;
        }

        if ($hide == '1') {
            $mi->parameters[] = 'transparancy=' . $transparancy;
            $mi->parameters[] = 'delay=' . $delay;
        }

        $scriptUrl = MAX_commonConstructDeliveryUrl($conf['file']['layer'], $mi->https);
        if (sizeof($mi->parameters) > 0) {
            $scriptUrl .= "?" . implode("&", $mi->parameters);
        }

        $buffer = "<script type='text/javascript'><!--//<![CDATA[
   var ox_u = '{$scriptUrl}';
   if (document.context) ox_u += '&context=' + escape(document.context);
   document.write(\"<scr\"+\"ipt type='text/javascript' src='\" + ox_u + \"'></scr\"+\"ipt>\");
//]]>--></script>";

        return $buffer;
    }



    /*-------------------------------------------------------*/
    /* Return $show var for generators                       */
    /*-------------------------------------------------------*/

    public function getlayerShowVar()
    {
        return [
            'spacer' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'what' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            //'acid'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'campaignid' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'target' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'source' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
              'charset' => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
            'layerstyle' => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
            'layercustom' => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM
        ];
    }
}
