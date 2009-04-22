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
$Id: invocation.inc.php 25933 2008-09-18 15:12:50Z chris.nutting $
*/

// Define constant used to place code generator
define('phpAds_adLayerLoaded', true);


// Register input variables
MAX_commonRegisterGlobalsArray(array('align', 'collapsetime', 'padding', 'closetext'));


/**
 *
 * Layerstyle for invocation tag plugin
 *
 */
class Plugins_oxInvocationTags_Adlayer_Layerstyles_Geocities_Invocation extends Plugins_InvocationTags_OxInvocationTags_adlayer
{

    /*-------------------------------------------------------*/
    /* Place ad-generator settings                           */
    /*-------------------------------------------------------*/

    function placeLayerSettings ()
    {
    	global $align, $collapsetime, $padding, $closetext;
    	global $tabindex;

    	if (!isset($align)) $align = 'right';
    	if (!isset($collapsetime)) $collapsetime = '-';
    	if (!isset($padding)) $padding = '2';
    	if (!isset($closetext)) $closetext = $this->translate("[Close]");

    	$buffer = '';

    	$buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    	$buffer .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%'></td></tr>";
    	$buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".$this->translate("Alignment")."</td><td width='370'>";
    	$buffer .= "<select name='align' style='width:175px;' tabindex='".($tabindex++)."'>";
    	    $buffer .= "<option value='left'".($align == 'left' ? ' selected' : '').">".$this->translate("Left")."</option>";
    		$buffer .= "<option value='center'".($align == 'center' ? ' selected' : '').">".$this->translate("Center")."</option>";
    		$buffer .= "<option value='right'".($align == 'right' ? ' selected' : '').">".$this->translate("Right")."</option>";
    	$buffer .= "</select>";
    	$buffer .= "</td></tr>";
    	$buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".$this->translate("Close text")."</td><td width='370'>";
    		$buffer .= "<input class='flat' type='text' name='closetext' size='' value='".$closetext."' style='width:175px;' tabindex='".($tabindex++)."'></td></tr>";
    	$buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".$this->translate("Automatically collapse after")."</td><td width='370'>";
    		$buffer .= "<input class='flat' type='text' name='collapsetime' size='' value='".(isset($collapsetime) ? $collapsetime : '-')."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrSeconds']."</td></tr>";
    	$buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".$this->translate("Banner padding")."</td><td width='370'>";
    		$buffer .= "<input class='flat' type='text' name='padding' size='' value='".(isset($padding) ? $padding : '0')."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
    	$buffer .= "<tr><td width='30'><img src='" . OX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

    	return $buffer;
    }



    /*-------------------------------------------------------*/
    /* Place ad-generator settings                           */
    /*-------------------------------------------------------*/

    function generateLayerCode(&$mi)
    {
    	$conf = $GLOBALS['_MAX']['CONF'];
    	global $align, $collapsetime, $padding, $closetext;

    	$mi->parameters[] = 'layerstyle=geocities';
    	$mi->parameters[] = 'align='.(isset($align) ? $align : 'right');
    	$mi->parameters[] = 'padding='.(isset($padding) ? (int)$padding : '2');

    	if (isset($closetext)) {
    	    $mi->parameters[] = 'closetext='.urlencode($closetext);
    	}
        if (!empty($mi->charset)) {
    	    $mi->parameters[] = 'charset='.urlencode($mi->charset);
    	}

    	if (isset($collapsetime) && $collapsetime > 0) {
    		$mi->parameters[] = 'collapsetime='.$collapsetime;
    	}

    	$buffer = "<script type='text/javascript' src='".MAX_commonConstructDeliveryUrl($conf['file']['layer']);
    	if (sizeof($mi->parameters) > 0)
    		$buffer .= "?".implode ("&", $mi->parameters);
    	$buffer .= "'></script>";

    	return $buffer;
    }



    /*-------------------------------------------------------*/
    /* Return $show var for generators                       */
    /*-------------------------------------------------------*/

    function getlayerShowVar ()
    {
    	return array (
            'spacer'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
    		'what'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
    		//'acid'        => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
    		'campaignid'  => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
    		'target'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
    		'source'      => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
    		'charset'     => MAX_PLUGINS_INVOCATION_TAGS_STANDARD,
    		'layerstyle'  => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
    		'layercustom' => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM
    	);
    }
}

?>