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

// Required files

// Define constant used to place code generator
define('phpAds_adLayerLoaded', true);

// Register input variables
MAX_commonRegisterGlobalsArray(['ltr', 'loop', 'speed', 'pause', 'shiftv', 'transparent', 'backcolor',
                       'limited', 'lmargin', 'rmargin']);


/**
 *
 * Layerstyle for invocation tag plugin
 *
 */
class Plugins_oxInvocationTags_Adlayer_Layerstyles_Floater_Invocation extends Plugins_InvocationTags_OxInvocationTags_adlayer
{
    /*-------------------------------------------------------*/
    /* Place ad-generator settings                           */
    /*-------------------------------------------------------*/

    public function placeLayerSettings()
    {
        global $ltr, $loop, $speed, $pause, $shiftv, $transparent, $backcolor;
        global $limited, $lmargin, $rmargin;
        global $tabindex;

        if (!isset($ltr)) {
            $ltr = 't';
        }
        if (!isset($loop)) {
            $loop = 'n';
        }
        if (!isset($speed)) {
            $speed = 3;
        }
        if (!isset($pause)) {
            $pause = 10;
        }
        if (!isset($shiftv)) {
            $shiftv = 0;
        }
        if (!isset($limited)) {
            $limited = 'f';
        }
        if (!isset($transparent)) {
            $transparent = 't';
        }
        if (!isset($backcolor)) {
            $backcolor = '#FFFFFF';
        }

        if ($limited == 't') {
            if (!isset($lmargin) || !isset($rmargin)) {
                $limited = 'f';
                $lmargin = $rmargin = '';
            }
        }

        $buffer = '';

        $buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
        $buffer .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%'></td></tr>";
        $buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Direction") . "</td><td width='370'>";
        $buffer .= "<select name='ltr' style='width:175px;' tabindex='" . ($tabindex++) . "'>";
        $buffer .= "<option value='t'" . ($ltr == 't' ? ' selected' : '') . ">" . $this->translate("Left to right") . "</option>";
        $buffer .= "<option value='f'" . ($ltr == 'f' ? ' selected' : '') . ">" . $this->translate("Right to left") . "</option>";
        $buffer .= "</select>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Looping") . "</td><td width='370'>";
        $buffer .= "<select name='loop' style='width:175px;' tabindex='" . ($tabindex++) . "'>";
        $buffer .= "<option value='n'" . ($loop == 'n' ? ' selected' : '') . ">" . $this->translate("Always active") . "</option>";
        for ($i = 1;$i <= 10;$i++) {
            $buffer .= "<option value='" . $i . "'" . ($loop == $i ? ' selected' : '') . ">" . $i . "</option>";
        }
        $buffer .= "</select>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Speed") . "</td><td width='370'>";
        $buffer .= "<select name='speed' style='width:60px;' tabindex='" . ($tabindex++) . "'>";
        for ($i = 1;$i <= 5;$i++) {
            $buffer .= "<option value='" . $i . "'" . ($speed == $i ? ' selected' : '') . ">" . $i . "</option>";
        }
        $buffer .= "</select>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Pause") . "</td><td width='370'>";
        $buffer .= "<input class='flat' type='text' name='pause' size='' value='" . htmlspecialchars($pause, ENT_QUOTES) . "' style='width:60px;' tabindex='" . ($tabindex++) . "'> " . $GLOBALS['strSeconds'] . "</td></tr>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Vertical shift") . "</td><td width='370'>";
        $buffer .= "<input class='flat' type='text' name='shiftv' size='' value='" . htmlspecialchars($shiftv, ENT_QUOTES) . "' style='width:60px;' tabindex='" . ($tabindex++) . "'> " . $GLOBALS['strAbbrPixels'] . "</td></tr>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Limited") . "</td><td width='370'>";
        $buffer .= "<select name='limited' style='width:60px;' tabindex='" . ($tabindex++) . "' onChange='this.form.lmargin.disabled = this.selectedIndex ? true : false; this.form.rmargin.disabled = this.selectedIndex ? true : false'>";
        $buffer .= "<option value='t'" . ($limited == 't' ? ' selected' : '') . ">" . $GLOBALS['strYes'] . "</option>";
        $buffer .= "<option value='f'" . ($limited == 'f' ? ' selected' : '') . ">" . $GLOBALS['strNo'] . "</option>";
        $buffer .= "</select>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Left margin") . "</td><td width='370'>";
        $buffer .= "<input class='flat' type='text' name='lmargin' size='' tabindex='" . ($tabindex++) . "' value='" . htmlspecialchars($lmargin, ENT_QUOTES) . "' style='width:60px;'" . ($limited == 'f' ? ' disabled' : '') . "> " . $GLOBALS['strAbbrPixels'] . "</td></tr>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Right margin") . "</td><td width='370'>";
        $buffer .= "<input class='flat' type='text' name='rmargin' size='' tabindex='" . ($tabindex++) . "' value='" . htmlspecialchars($rmargin, ENT_QUOTES) . "' style='width:60px;'" . ($limited == 'f' ? ' disabled' : '') . "> " . $GLOBALS['strAbbrPixels'] . "</td></tr>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Transparent background") . "</td><td width='370'>";
        $buffer .= "<select name='transparent' style='width:60px;' onChange='this.form.backcolor.disabled = this.selectedIndex ? false : true' tabindex='" . ($tabindex++) . "'>";
        $buffer .= "<option value='t'" . ($transparent == 't' ? ' selected' : '') . ">" . $GLOBALS['strYes'] . "</option>";
        $buffer .= "<option value='f'" . ($transparent == 'f' ? ' selected' : '') . ">" . $GLOBALS['strNo'] . "</option>";
        $buffer .= "</select>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        $this->settings_cp_map();

        $buffer .= "<tr><td width='30'>&nbsp;</td>";
        $buffer .= "<td width='200'>" . $this->translate("Background color") . "</td><td width='370'>";
        $buffer .= "<table border='0' cellspacing='0' cellpadding='0'>";
        $buffer .= "<tr><td width='22'>";
        $buffer .= "<table border='0' cellspacing='1' cellpadding='0' bgcolor='#000000'><tr>";
        $buffer .= "<td id='backcolor_box' bgcolor='" . $backcolor . "'><img src='" . OX::assetPath() . "/images/spacer.gif' width='16' height='16'></td>";
        $buffer .= "</tr></table></td><td>";
        $buffer .= "<input type='text' class='flat' name='backcolor' size='10' maxlength='7' tabindex='" . ($tabindex++) . "' value='" . htmlspecialchars($backcolor, ENT_QUOTES) . "'" . ($transparent == 't' ? ' disabled' : '') . " onFocus='current_cp = this; current_cp_oldval = this.value; current_box = backcolor_box' onChange='c_update()'>";
        $buffer .= "</td><td align='right' width='218'>";
        $buffer .= "<div onMouseOver='current_cp = backcolor; current_box = backcolor_box' onMouseOut='current_cp = null'><img src='" . OX::assetPath() . "/images/colorpicker.png' width='193' height='18' align='absmiddle' usemap='#colorpicker' border='0'><img src='" . OX::assetPath() . "/images/spacer.gif' width='22' height='1'></div>";
        $buffer .= "</td></tr></table>";
        $buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

        return $buffer;
    }



    /*-------------------------------------------------------*/
    /* Place ad-generator settings                           */
    /*-------------------------------------------------------*/

    public function generateLayerCode(&$mi)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        global $ltr, $loop, $speed, $pause, $shiftv, $transparent, $backcolor;
        global $limited, $lmargin, $rmargin;

        if (!isset($limited)) {
            $limited = 'f';
        }
        if ($limited == 't') {
            if (!isset($lmargin) || !isset($rmargin)) {
                $limited = 'f';
                $lmargin = $rmargin = '';
            }
        }
        if (!empty($mi->charset)) {
            $mi->parameters[] = 'charset=' . urlencode($mi->charset);
        }
        $mi->parameters[] = 'layerstyle=floater';
        $mi->parameters[] = 'ltr=' . (isset($ltr) ? $ltr : 't');
        $mi->parameters[] = 'loop=' . (isset($loop) ? $loop : 'n');
        $mi->parameters[] = 'speed=' . (isset($speed) ? $speed : 3);
        $mi->parameters[] = 'pause=' . (isset($pause) ? $pause : 10);
        $mi->parameters[] = 'shiftv=' . (isset($shiftv) ? $shiftv : 0);
        $mi->parameters[] = 'transparent=' . (isset($transparent) ? $transparent : 't');
        if (!isset($transparent)) {
            $transparent = 't';
        }
        if (!isset($backcolor)) {
            $backcolor = '#FFFFFF';
        }
        if ($transparent != 't') {
            $mi->parameters[] = 'backcolor=' . urlencode($backcolor);
        }
        $mi->parameters[] = 'limited=' . $limited;
        if ($limited == 't') {
            $mi->parameters[] = 'lmargin=' . $lmargin;
            $mi->parameters[] = 'rmargin=' . $rmargin;
        }
        $scriptUrl = MAX_commonConstructDeliveryUrl($conf['file']['layer'], $mi->https);
        if (sizeof($mi->parameters) > 0) {
            $scriptUrl .= "?" . implode("&amp;", $mi->parameters);
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



    /*-------------------------------------------------------*/
    /* Dec2Hex                                               */
    /*-------------------------------------------------------*/

    public function toHex($d)
    {
        return strtoupper(sprintf("%02x", $d));
    }



    /*-------------------------------------------------------*/
    /* Add scripts and map for color pickers                 */
    /*-------------------------------------------------------*/

    public function settings_cp_map()
    {
        static $done = false;

        if (!$done) {
            $done = true; ?>
    <script type="text/javascript">
    <!--// <![CDATA[
    var current_cp = null;
    var current_cp_oldval = null;
    var current_box = null;

    function c_pick(value)
    {
    	if (current_cp)
    	{
    		current_cp.value = value;
    		c_update();
    	}
    }

    function c_update()
    {
    	if (!current_cp.value.match(/^#[0-9a-f]{6}$/gi))
    	{
    		current_cp.value = current_cp_oldval;
    		return;
    	}

    	current_cp.value.toUpperCase();
    	current_box.style.backgroundColor = current_cp.value;
    }

    // ]]> -->
    </script>
    <?php
            echo "<map name=\"colorpicker\">\n";

            $x = 2;

            for ($i = 1; $i <= 255 * 6; $i += 8) {
                if ($i > 0 && $i <= 255 * 1) {
                    $incColor = '#FF' . $this->toHex($i) . '00';
                } elseif ($i > 255 * 1 && $i <= 255 * 2) {
                    $incColor = '#' . $this->toHex(255 - ($i - 255)) . 'FF00';
                } elseif ($i > 255 * 2 && $i <= 255 * 3) {
                    $incColor = '#00FF' . $this->toHex($i - (2 * 255));
                } elseif ($i > 255 * 3 && $i <= 255 * 4) {
                    $incColor = '#00' . $this->toHex(255 - ($i - (3 * 255))) . 'FF';
                } elseif ($i > 255 * 4 && $i <= 255 * 5) {
                    $incColor = '#' . $this->toHex($i - (4 * 255)) . '00FF';
                } elseif ($i > 255 * 5 && $i < 255 * 6) {
                    $incColor = '#FF00' . $this->toHex(255 - ($i - (5 * 255)));
                }

                echo "<area shape='rect' coords='$x,0," . ($x + 1) . ",9' href='javascript:c_pick(\"$incColor\")' />\n";
                $x++;
            }

            $x = 2;

            for ($j = 0; $j < 255; $j += 1.34) {
                $i = round($j);
                $incColor = '#' . $this->toHex($i) . $this->toHex($i) . $this->toHex($i);
                echo "<area shape='rect' coords='$x,11," . ($x + 1) . ",20' href='javascript:c_pick(\"$incColor\")' />\n";
                $x++;
            }

            echo "</map>";
        }
    }
}

?>