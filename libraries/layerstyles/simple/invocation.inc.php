<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
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
phpAds_registerGlobal ('target', 'align', 'padding', 'closebutton', 'backcolor', 'bordercolor',
					   'valign', 'closetime', 'shifth', 'shiftv', 'nobg', 'noborder');



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_placeLayerSettings ()
{
	global $align, $valign, $closetime, $padding;
	global $shifth, $shiftv, $closebutton;
	global $backcolor, $bordercolor;
	global $nobg, $noborder;
	global $tabindex;
	
	if (!isset($align)) $align = 'right';
	if (!isset($valign)) $valign = 'top';
	if (!isset($closetime)) $closetime = '-';
	if (!isset($padding)) $padding = '2';
	if (!isset($shifth)) $shifth = 0;
	if (!isset($shiftv)) $shiftv = 0;
	if (!isset($closebutton)) $closebutton = 'f';
	if (!isset($backcolor)) $backcolor = '#FFFFFF';
	if (!isset($bordercolor)) $bordercolor = '#000000';
	if (!isset($nobg)) $nobg = 'f';
	if (!isset($noborder)) $noborder = 'f';
	
	echo "<tr><td height='30' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strHAlignment']."</td><td width='370'>";
	echo "<select name='align' style='width:175px;' tabindex='".($tabindex++)."'>";
		echo "<option value='left'".($align == 'left' ? ' selected' : '').">".$GLOBALS['strLeft']."</option>";
		echo "<option value='center'".($align == 'center' ? ' selected' : '').">".$GLOBALS['strCenter']."</option>";
		echo "<option value='right'".($align == 'right' ? ' selected' : '').">".$GLOBALS['strRight']."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strVAlignment']."</td><td width='370'>";
	echo "<select name='valign' style='width:175px;' tabindex='".($tabindex++)."'>";
		echo "<option value='top'".($valign == 'top' ? ' selected' : '').">".$GLOBALS['strTop']."</option>";
		echo "<option value='middle'".($valign == 'middle' ? ' selected' : '').">".$GLOBALS['strMiddle']."</option>";
		echo "<option value='bottom'".($valign == 'bottom' ? ' selected' : '').">".$GLOBALS['strBottom']."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strShowCloseButton']."</td><td width='370'>";
	echo "<select name='closebutton' style='width:175px;' tabindex='".($tabindex++)."'>";
		echo "<option value='t'".($closebutton == 't' ? ' selected' : '').">".$GLOBALS['strYes']."</option>";
		echo "<option value='f'".($closebutton == 'f' ? ' selected' : '').">".$GLOBALS['strNo']."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strAutoCloseAfter']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='closetime' size='' value='".(isset($closetime) ? $closetime : '-')."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrSeconds']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	
	echo "<tr><td height='30' colspan='3'>&nbsp;</td></tr>";
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strBannerPadding']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='padding' size='' value='".$padding."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strHShift']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='shifth' size='' value='".$shifth."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strVShift']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='shiftv' size='' value='".$shiftv."' style='width:60px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strBackgroundColor']."</td><td width='370'>";
		echo "<table border='0' cellspacing='0' cellpadding='0'>";
		echo "<tr><td width='22'>";
		echo "<table border='0' cellspacing='1' cellpadding='0' bgcolor='#000000'><tr>";
		echo "<td id='backcolor_box' bgcolor='".$backcolor."'><img src='images/spacer.gif' width='16' height='16'></td>";
		echo "</tr></table></td><td>";
		echo "<input type='text' class='flat' name='backcolor' id='backcolor' size='10' maxlength='7' tabindex='".($tabindex++)."' value='".$backcolor."' onFocus='this.oldvalue = this.value' onChange='c_update(this.id, this.value)'".($nobg == 't' ? ' disabled' : '').">";
		echo "</td><td align='right' width='262'>";
		echo "<div id='backcolor_cp' class='colorpicker'></div>";
		phpAds_settings_cp_map('backcolor');
		echo "</td></tr></table>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strBorderColor']."</td><td width='370'>";
		echo "<table border='0' cellspacing='0' cellpadding='0'>";
		echo "<tr><td width='22'>";
		echo "<table border='0' cellspacing='1' cellpadding='0' bgcolor='#000000'><tr>";
		echo "<td id='bordercolor_box' bgcolor='".$bordercolor."'><img src='images/spacer.gif' width='16' height='16'></td>";
		echo "</tr></table></td><td>";
		echo "<input type='text' class='flat' name='bordercolor' id='bordercolor' size='10' maxlength='7' tabindex='".($tabindex++)."' value='".$bordercolor."' onFocus='this.oldvalue = this.value' onChange='c_update(this.id, this.value)'".($noborder == 't' ? ' disabled' : '').">";
		echo "</td><td align='right' width='262'>";
		echo "<div id='bordercolor_cp' class='colorpicker'></div>";
		phpAds_settings_cp_map('bordercolor');
        echo "</td></tr></table>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td colspan='2'>";
	echo "<input type='checkbox' name='nobg' value='t' tabindex='".($tabindex++)."' onClick='this.form.backcolor.disabled=this.checked;backDiv.style.display=this.checked?\"none\":\"\"'".($nobg == 't' ? ' checked' : '').">&nbsp;";
	echo 'Transparent background';
	echo "</td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td colspan='2'>";
	echo "<input type='checkbox' name='noborder' value='t' tabindex='".($tabindex++)."' onClick='this.form.bordercolor.disabled=this.checked;borderDiv.style.display=this.checked?\"none\":\"\"'".($noborder == 't' ? ' checked' : '').">&nbsp;";
	echo 'No border';
	echo "</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_generateLayerCode ($parameters)
{
	global $phpAds_config;
	global $align, $valign, $closetime, $padding;
	global $shifth, $shiftv, $closebutton;
	global $backcolor, $bordercolor;
	global $nobg, $noborder;
	
	$parameters[] = 'layerstyle=simple';
	$parameters[] = 'align='.(isset($align) ? $align : 'right');
	$parameters[] = 'valign='.(isset($valign) ? $valign : 'top');
	$parameters[] = 'padding='.(isset($padding) ? (int)$padding : '2');
	
	if (isset($closetime) && $closetime > 0)
		$parameters[] = 'closetime='.$closetime;
	if (isset($padding)) 
		$parameters[] = 'padding='.$padding;
	if (isset($shifth))
		$parameters[] = 'shifth='.$shifth;
	if (isset($shiftv))
		$parameters[] = 'shiftv='.$shiftv;
	if (isset($closebutton))
		$parameters[] = 'closebutton='.$closebutton;
	if (isset($backcolor))
		$parameters[] = 'backcolor='.substr($backcolor, 1);
	if (isset($bordercolor))
		$parameters[] = 'bordercolor='.substr($bordercolor, 1);
	if (isset($nobg))
		$parameters[] = 'nobg='.$nobg;
	if (isset($noborder))
		$parameters[] = 'noborder='.$noborder;
	
	$buffer = "<script language='JavaScript' type='text/javascript' src='".$phpAds_config['url_prefix']."/adlayer.php";
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