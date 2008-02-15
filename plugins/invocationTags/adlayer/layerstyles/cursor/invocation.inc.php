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



// Define constant used to place code generator
define('phpAds_adLayerLoaded', true);


// Register input variables
MAX_commonRegisterGlobalsArray(array('stickyness', 'offsetx', 'offsety', 'hide',
					   'transparancy', 'delay', 'trail'));

/**
 *
 * Layerstyle for invocation tag plugin
 *
 */
class Plugins_InvocationTags_Adlayer_Layerstyles_Cursor_Invocation
{

    /*-------------------------------------------------------*/
    /* Place ad-generator settings                           */
    /*-------------------------------------------------------*/

    function placeLayerSettings ()
    {
    	global $stickyness, $offsetx, $offsety, $hide, $transparancy, $delay, $trail;
    	global $tabindex;

    	if (!isset($trail)) $trail = '0';
    	if (!isset($stickyness)) $stickyness = 5;
    	if (!isset($offsetx)) $offsetx = 10;
    	if (!isset($offsety)) $offsety = 10;
    	if (!isset($hide)) $hide = '0';
    	if (!isset($transparancy)) $transparancy = 0;
    	if (!isset($delay)) $delay = 90;

    	$buffer = '';

    	$buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    	$buffer .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
    	$buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".MAX_Plugin_Translation::translate('Smooth movement', 'invocationTags')."</td><td width='370'>";
    	$buffer .= "<select name='trail' style='width:60px;' onChange='this.form.stickyness.disabled = this.selectedIndex ? true : false;' tabindex='".($tabindex++)."'>";
    	$buffer .= "<option value='1'".($trail == '1' ? ' selected' : '').">".$GLOBALS['strYes']."</option>";
    	$buffer .= "<option value='0'".($trail == '0' ? ' selected' : '').">".$GLOBALS['strNo']."</option>";
    	$buffer .= "</select>";
    	$buffer .= "<tr><td width='30'><img src='images/spacer.gif' height='5' width='100%'></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".MAX_Plugin_Translation::translate('Speed', 'invocationTags')."</td><td width='370'>";
    	$buffer .= "<select name='stickyness' style='width:60px;'".($trail == '0' ? ' disabled' : '')." tabindex='".($tabindex++)."'>";
    	for ($i=1;$i<=9;$i++) {
    		$buffer .= "<option value='".$i."'".($stickyness == $i ? ' selected' : '').">".$i."</option>";
    	}
    	$buffer .= "</select>";
    	$buffer .= "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";

    	$buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    	$buffer .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
    	$buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".MAX_Plugin_Translation::translate('Hide the banner when the cursor is not moving', 'invocationTags')."</td><td width='370'>";
    	$buffer .= "<select name='hide' style='width:60px;' tabindex='".($tabindex++)."' onChange='this.form.transparancy.disabled = this.selectedIndex ? true : false; this.form.delay.disabled = this.selectedIndex ? true : false;'>";
    	$buffer .= "<option value='1'".($hide == '1' ? ' selected' : '').">".$GLOBALS['strYes']."</option>";
    	$buffer .= "<option value='0'".($hide == '0' ? ' selected' : '').">".$GLOBALS['strNo']."</option>";
    	$buffer .= "</select>";
    	$buffer .= "<tr><td width='30'><img src='images/spacer.gif' height='5' width='100%'></td></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".MAX_Plugin_Translation::translate('Delay before banner is hidden', 'invocationTags')."</td><td width='370'>";
    	$buffer .= "<input class='flat' type='text' name='delay' size='' value='".$delay."' style='width:60px;'".($hide == '0' ? ' disabled' : '')." tabindex='".($tabindex++)."'> ms</td></tr>";
    	$buffer .= "<tr><td width='30'><img src='images/spacer.gif' height='5' width='100%'></td></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".MAX_Plugin_Translation::translate('Transparancy of the hidden banner', 'invocationTags')."</td><td width='370'>";
    	$buffer .= "<select name='transparancy' style='width:60px;'".($hide == '0' ? ' disabled' : '')." tabindex='".($tabindex++)."'>";
    	for ($i=0;$i<=9;$i++) {
    		$buffer .= "<option value='".($i * 10)."'".($transparancy == ($i * 10) ? ' selected' : '').">".($i * 10)." %</option>";
    	}
    	$buffer .= "</select>";
    	$buffer .= "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";

    	$buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    	$buffer .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
    	$buffer .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".MAX_Plugin_Translation::translate('Horizontal shift', 'invocationTags')."</td><td width='370'>";
    	$buffer .= "<input class='flat' type='text' name='offsetx' size='' value='".$offsetx."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
    	$buffer .= "<tr><td width='30'><img src='images/spacer.gif' height='5' width='100%'></td></tr>";

    	$buffer .= "<tr><td width='30'>&nbsp;</td>";
    	$buffer .= "<td width='200'>".MAX_Plugin_Translation::translate('Vertical shift', 'invocationTags')."</td><td width='370'>";
    	$buffer .= "<input class='flat' type='text' name='offsety' size='' value='".$offsety."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
    	$buffer .= "<tr><td width='30'><img src='images/spacer.gif' height='5' width='100%'></td></tr>";

    	return $buffer;
    }



    /*-------------------------------------------------------*/
    /* Place ad-generator settings                           */
    /*-------------------------------------------------------*/

    function generateLayerCode(&$mi)
    {
    	$conf = $GLOBALS['_MAX']['CONF'];
    	global $stickyness, $offsetx, $offsety, $hide, $transparancy, $delay, $trail;

    	$mi->parameters[] = 'layerstyle=cursor';
    	$mi->parameters[] = 'hide='.$hide;
    	$mi->parameters[] = 'trail='.$trail;
    	$mi->parameters[] = 'offsetx='.$offsetx;
    	$mi->parameters[] = 'offsety='.$offsety;

    	if ($trail == '1')
    		$mi->parameters[] = 'stickyness='.$stickyness;

    	if ($hide == '1')
    	{
    		$mi->parameters[] = 'transparancy='.$transparancy;
    		$mi->parameters[] = 'delay='.$delay;
    	}

    	$buffer = "<script type='text/javascript' src='http:".MAX_commonConstructPartialDeliveryUrl($conf['file']['layer']);
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
    		'layerstyle'  => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM,
    		'layercustom' => MAX_PLUGINS_INVOCATION_TAGS_CUSTOM
    	);
    }
}

?>