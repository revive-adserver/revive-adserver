<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Define constant used to place code generator
define('phpAds_adLayerLoaded', true);


// Register input variables
phpAds_registerGlobal ('target', 'align', 'padding', 'closebutton', 'backcolor', 'bordercolor',
					   'valign', 'closetime', 'shifth', 'shiftv');



/*********************************************************/
/* Return HTML code for the layer                        */
/*********************************************************/

function phpAds_getLayerHTML ($output, $uniqid)
{
	global $phpAds_config, $target;
	global $align, $padding, $closebutton;
	global $backcolor, $bordercolor;
	
	if (!isset($padding)) $padding = '2';
	if (!isset($closebutton)) $closebutton = 'f';
	if (!isset($backcolor)) $backcolor = 'FFFFFF';
	if (!isset($bordercolor)) $bordercolor = '000000';
	
	// Calculate layer size (inc. borders)
	$layer_width = $output['width'] + 2 + $padding*2;
	$layer_height = $output['height'] + 2 + ($closebutton == 't' ? 11 : 0) + $padding*2;
	
	// Create imagepath
	$imagepath = $phpAds_config['url_prefix'].'/libraries/layerstyles/simple/images/';
	
	// return HTML code
	return '
<div id="phpads_'.$uniqid.'" style="position:absolute; width:'.$layer_width.'px; height:'.$layer_height.'px; z-index:99; left: 0px; top: 0px; visibility: hidden"> 
	<table cellspacing="0" cellpadding="0" style="border-style: solid; border-width: 1px; border-color: #'.$bordercolor.'">
'.($closebutton == 't' ?
'		<tr> 
			<td bgcolor="#'.$backcolor.'" align="right" style="padding: 2px"><a href="javascript:;" onClick="phpAds_simplepop_'.$uniqid.'(\'close\')" style="color:#0000ff"><img src="'.$imagepath.'close.gif" width="7" height="7" alt="Close" border="0"></a></td>
		</tr>
' : '').
'		<tr> 
			<td bgcolor="#'.$backcolor.'" align="center">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="'.$output['width'].'" height="'.$output['height'].'" align="center" valign="middle" style="padding: '.$padding.'px">'.$output['html'].'</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
';
}



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_placeLayerSettings ()
{
	global $align, $valign, $closetime, $padding;
	global $shifth, $shiftv, $closebutton;
	global $backcolor, $bordercolor;
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
	
	phpAds_settings_cp_map();
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strBackgroundColor']."</td><td width='370'>";
		echo "<table border='0' cellspacing='0' cellpadding='0'>";
		echo "<tr><td width='22'>";
		echo "<table border='0' cellspacing='1' cellpadding='0' bgcolor='#000000'><tr>";
		echo "<td id='backcolor_box' bgcolor='".$backcolor."'><img src='images/spacer.gif' width='16' height='16'></td>";
		echo "</tr></table></td><td>";
		echo "<input type='text' class='flat' name='backcolor' size='10' maxlength='7' tabindex='".($tabindex++)."' value='".$backcolor."' onFocus='current_cp = this; current_cp_oldval = this.value; current_box = backcolor_box' onChange='c_update()'>";
		echo "</td><td align='right' width='218'>";
		echo "<div onMouseOver='current_cp = backcolor; current_box = backcolor_box' onMouseOut='current_cp = null'><img src='images/colorpicker.png' width='193' height='18' align='absmiddle' usemap='#colorpicker' border='0'><img src='images/spacer.gif' width='22' height='1'></div>";
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
		echo "<input type='text' class='flat' name='bordercolor' size='10' maxlength='7' tabindex='".($tabindex++)."' value='".$bordercolor."' onFocus='current_cp = this; current_cp_oldval = this.value; current_box = bordercolor_box' onChange='c_update()'>";
		echo "</td><td align='right' width='218'>";
		echo "<div onMouseOver='current_cp = bordercolor; current_box = bordercolor_box' onMouseOut='current_cp = null'><img src='images/colorpicker.png' width='193' height='18' align='absmiddle' usemap='#colorpicker' border='0'><img src='images/spacer.gif' width='22' height='1'></div>";
        echo "</td></tr></table>";
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
/* Dec2Hex                                               */
/*********************************************************/

function toHex($d)
{
	return strtoupper(sprintf("%02x", $d));
}



/*********************************************************/
/* Add scripts and map for color pickers                 */
/*********************************************************/

function phpAds_settings_cp_map()
{
	static $done = false;
	
	if (!$done)
	{
		$done = true;
?>
<script language="JavaScript">
<!--
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

// -->
</script>
<?php
		echo "<map name=\"colorpicker\">\n";
		
		$x = 2;
		
		for($i=1; $i <= 255*6; $i+=8)
		{
			if($i > 0 && $i <=255 * 1)
				$incColor='#FF'.toHex($i).'00';
			elseif ($i>255*1 && $i <=255*2)
				$incColor='#'.toHex(255-($i-255)).'FF00';
			elseif ($i>255*2 && $i <=255*3)
				$incColor='#00FF'.toHex($i-(2*255));
			elseif ($i>255*3 && $i <=255*4)
				$incColor='#00'.toHex(255-($i-(3*255))).'FF';
			elseif ($i>255*4 && $i <=255*5)
				$incColor='#'.toHex($i-(4*255)).'00FF';
			elseif ($i>255*5 && $i <255*6)
				$incColor='#FF00' . toHex(255-($i-(5*255)));
			
			echo "<area shape='rect' coords='$x,0,".($x+1).",9' href='javascript:c_pick(\"$incColor\")'>\n"; $x++;
		}
		
		$x = 2;
		
		for($j = 0; $j < 255; $j += 1.34)
		{
			$i = round($j);
			$incColor = '#'.toHex($i).toHex($i).toHex($i);
			echo "<area shape='rect' coords='$x,11,".($x+1).",20' href='javascript:c_pick(\"$incColor\")'>\n"; $x++;
		}
		
		echo "</map>";
	}
}

?>