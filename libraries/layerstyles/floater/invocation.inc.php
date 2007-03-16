<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Prevent full path disclosure
if (!defined('phpAds_path')) die();



// Define constant used to place code generator
define('phpAds_adLayerLoaded', true);


// Register input variables
phpAds_registerGlobal ('ltr', 'loop', 'speed', 'pause', 'shiftv', 'transparent', 'backcolor',
					   'limited', 'lmargin', 'rmargin');



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_placeLayerSettings ()
{
	global $ltr, $loop, $speed, $pause, $shiftv, $transparent, $backcolor;
	global $limited, $lmargin, $rmargin;
	global $tabindex;
	
	if (!isset($ltr)) $ltr = 't';
	if (!isset($loop)) $loop = 'n';
	if (!isset($speed)) $speed = 3;
	if (!isset($pause)) $pause = 10;
	if (!isset($shiftv)) $shiftv = 0;
	if (!isset($limited)) $limited = 'f';
	if (!isset($transparent)) $transparent = 't';
	if (!isset($backcolor)) $backcolor = '#FFFFFF';
	
	if ($limited == 't')
	{
		if (!isset($lmargin) || !isset($rmargin))
		{
			$limited = 'f';
			$lmargin = $rmargin = '';
		}
	}
	
	echo "<tr><td height='30' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strDirection']."</td><td width='370'>";
	echo "<select name='ltr' style='width:175px;' tabindex='".($tabindex++)."'>";
		echo "<option value='t'".($ltr == 't' ? ' selected' : '').">".$GLOBALS['strLeftToRight']."</option>";
		echo "<option value='f'".($ltr == 'f' ? ' selected' : '').">".$GLOBALS['strRightToLeft'] ."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strLooping']."</td><td width='370'>";
	echo "<select name='loop' style='width:175px;' tabindex='".($tabindex++)."'>";
		echo "<option value='n'".($loop == 'n' ? ' selected' : '').">".$GLOBALS['strAlwaysActive']."</option>";
	for ($i=1;$i<=10;$i++)
		echo "<option value='".$i."'".($loop == $i ? ' selected' : '').">".$i."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strSpeed']."</td><td width='370'>";
	echo "<select name='speed' style='width:60px;' tabindex='".($tabindex++)."'>";
	for ($i=1;$i<=5;$i++)
		echo "<option value='".$i."'".($speed == $i ? ' selected' : '').">".$i."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strPause']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='pause' size='' value='".$pause."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strSeconds']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strVShift']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='shiftv' size='' value='".$shiftv."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strLimited']."</td><td width='370'>";
	echo "<select name='limited' style='width:60px;' tabindex='".($tabindex++)."' onChange='this.form.lmargin.disabled = this.selectedIndex ? true : false; this.form.rmargin.disabled = this.selectedIndex ? true : false'>";
		echo "<option value='t'".($limited == 't' ? ' selected' : '').">".$GLOBALS['strYes']."</option>";
		echo "<option value='f'".($limited == 'f' ? ' selected' : '').">".$GLOBALS['strNo']."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strLeftMargin']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='lmargin' size='' tabindex='".($tabindex++)."' value='".$lmargin."' style='width:60px;'".($limited == 'f' ? ' disabled' : '')."> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strRightMargin']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='rmargin' size='' tabindex='".($tabindex++)."' value='".$rmargin."' style='width:60px;'".($limited == 'f' ? ' disabled' : '')."> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strTransparentBackground']."</td><td width='370'>";
	echo "<select name='transparent' style='width:60px;' onChange='this.form.backcolor.disabled = this.selectedIndex ? false : true' tabindex='".($tabindex++)."'>";
		echo "<option value='t'".($transparent == 't' ? ' selected' : '').">".$GLOBALS['strYes']."</option>";
		echo "<option value='f'".($transparent == 'f' ? ' selected' : '').">".$GLOBALS['strNo']."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strBackgroundColor']."</td><td width='370'>";
		echo "<table border='0' cellspacing='0' cellpadding='0'>";
		echo "<tr><td width='22'>";
		echo "<table border='0' cellspacing='1' cellpadding='0' bgcolor='#000000'><tr>";
		echo "<td id='backcolor_box' bgcolor='".$backcolor."'><img src='images/spacer.gif' width='16' height='16'></td>";
		echo "</tr></table></td><td>";
		echo "<input type='text' class='flat' name='backcolor' id='backcolor' size='10' maxlength='7' tabindex='".($tabindex++)."' value='".$backcolor."' onFocus='this.oldvalue = this.value' onChange='c_update(this.id, this.value)'".($transparent == 't' ? ' disabled' : '').">";
		echo "</td><td align='right' width='262'>";
		echo "<div id='backcolor_cp' class='colorpicker'></div>";
		phpAds_settings_cp_map('backcolor');
		echo "</td></tr></table>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_generateLayerCode ($parameters)
{
	global $phpAds_config;
	global $ltr, $loop, $speed, $pause, $shiftv, $transparent, $backcolor;
	global $limited, $lmargin, $rmargin;
	
	if (!isset($limited)) $limited = 'f';
	
	if ($limited == 't')
	{
		if (!isset($lmargin) || !isset($rmargin))
		{
			$limited = 'f';
			$lmargin = $rmargin = '';
		}
	}
	
	$parameters[] = 'layerstyle=floater';
	$parameters[] = 'ltr='.(isset($ltr) ?  $ltr : 't');
	$parameters[] = 'loop='.(isset($loop) ?  $loop : 'n');
	$parameters[] = 'speed='.(isset($speed) ?  $speed : 3);
	$parameters[] = 'pause='.(isset($pause) ?  $pause : 10);
	$parameters[] = 'shiftv='.(isset($shiftv) ?  $shiftv : 0);
	$parameters[] = 'transparent='.(isset($transparent) ? $transparent : 't');
	
	if (!isset($transparent)) $transparent = 't';
	if (!isset($backcolor)) $backcolor = '#FFFFFF';
	
	if ($transparent != 't')
		$parameters[] = 'backcolor='.urlencode($backcolor);
	
	$parameters[] = 'limited='.$limited;
	
	if ($limited == 't')
	{
		$parameters[] = 'lmargin='.$lmargin;
		$parameters[] = 'rmargin='.$rmargin;
	}
	
	$buffer .= "<script type='text/javascript' src='".$phpAds_config['url_prefix']."/adlayer.php";
	if (sizeof($parameters) > 0)
		$buffer .= "?".implode ("&amp;", $parameters);
	$buffer .= "'></script>";
	
	return $buffer;
}



/*********************************************************/
/* Return $show var for generators                       */
/*********************************************************/

function phpAds_getlayerShowVar ()
{
	return array (
		'what' => true,
		'acid' => true,
		'target' => true,
		'source' => true,
		'layerstyle' => true,
		'layercustom' => true
	);
}



/*********************************************************/
/* Add scripts and map for color pickers                 */
/*********************************************************/

function phpAds_settings_cp_map($name)
{
	static $done = false;
	
	if (!$done)
	{
		$done = true;
?>
<script language="JavaScript">
<!--

function dec2hex(d) {
	var hex_chars = "0123456789ABCDEF";
	return hex_chars.charAt(d/16) + hex_chars.charAt(d%16);
}

function addColorPicker(o, p)
{
	var s;
	
	o = document.getElementById(o);
	
	for(var i=0; i <= 255*6; i+=6)
	{
		var r, g, b;
		
		if (i >= 0 && i <=255 * 1) {
			r = 255; g = i; b = 0;
		} else if (i > 255*1 && i <= 255*2) {
			r = 255-(i-255); g = 255; b = 0;
		} else if (i > 255*2 && i <= 255*3) {
			r = 0; g = 255; b = i-(2*255);
		} else if (i > 255*3 && i <= 255*4) {
			r = 0; g = 255-(i-(3*255)); b = 255;
		} else if (i > 255*4 && i <= 255*5) {
			r = i-(4*255); g = 0; b = 255;
		} else if (i > 255*5 && i < 255*6) {
			r = 255; g = 0; b = 255-(i-(5*255));
		}
	
		s = document.createElement('SPAN');
		s.onclick = new Function('c_update(\'' + p + '\', \'#' + dec2hex(r) + dec2hex(g) + dec2hex(b) + '\')');
		s.style.backgroundColor = 'rgb(' + r + ',' + g + ',' + b + ')';
		o.appendChild(s);
	}
	
	s = document.createElement('DIV');
	s.className = 'sep';
	o.appendChild(s);

	for(var i=0; i <= 255; i++)
	{
		s = document.createElement('SPAN');
		s.onclick = new Function('c_update(\'' + p + '\', \'#' + dec2hex(i) + dec2hex(i) + dec2hex(i) + '\')');
		s.style.backgroundColor = 'rgb(' + i + ',' + i + ',' + i + ')';
		o.appendChild(s);
	}		
	
	s = document.createElement('DIV');
	o.appendChild(s);
}

function c_update(cp, value)
{	
	var current_cp;
	var current_box;

	if ((current_cp = document.getElementById(cp)) && (current_box = document.getElementById(cp + '_box')))
	{
		if (!value.match(/^#[0-9a-f]{6}$/gi))
		{
			current_cp.value = current_cp.oldvalue;
			return;
		}
		
		current_cp.value = value.toUpperCase();
		current_box.style.backgroundColor = value;
	}
}

// -->
</script>
<?php
	}
?>
<script language="JavaScript">
<!--
addColorPicker('<?php echo $name.'_cp'; ?>', '<?php echo $name; ?>');

// Fix color when reload is hit
c_update('<?php echo $name; ?>', document.getElementById('<?php echo $name; ?>').value);
//-->
</script>
<?php
}

?>