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
phpAds_registerGlobal ('ltr', 'loop', 'speed', 'pause', 'shiftv', 'transparent', 'backcolor',
					   'limited', 'lmargin', 'rmargin');



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_placeLayerSettings ()
{
	global $ltr, $loop, $speed, $pause, $shiftv, $transparent, $backcolor;
	global $limited, $lmargin, $rmargin;
	
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
	echo "<select name='ltr' style='width:175px;'>";
		echo "<option value='t'".($ltr == 't' ? ' selected' : '').">".$GLOBALS['strLeftToRight']."</option>";
		echo "<option value='f'".($ltr == 'f' ? ' selected' : '').">".$GLOBALS['strRightToLeft'] ."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strLooping']."</td><td width='370'>";
	echo "<select name='loop' style='width:175px;'>";
		echo "<option value='n'".($loop == 'n' ? ' selected' : '').">".$GLOBALS['strAlwaysActive']."</option>";
	for ($i=1;$i<=10;$i++)
		echo "<option value='".$i."'".($loop == $i ? ' selected' : '').">".$i."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strSpeed']."</td><td width='370'>";
	echo "<select name='speed' style='width:60px;'>";
	for ($i=1;$i<=5;$i++)
		echo "<option value='".$i."'".($speed == $i ? ' selected' : '').">".$i."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strPause']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='pause' size='' value='".$pause."' style='width:60px;'> ".$GLOBALS['strSeconds']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strVShift']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='shiftv' size='' value='".$shiftv."' style='width:60px;'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strLimited']."</td><td width='370'>";
	echo "<select name='limited' style='width:60px;' onChange='this.form.lmargin.disabled = this.selectedIndex ? true : false; this.form.rmargin.disabled = this.selectedIndex ? true : false'>";
		echo "<option value='t'".($limited == 't' ? ' selected' : '').">".$GLOBALS['strYes']."</option>";
		echo "<option value='f'".($limited == 'f' ? ' selected' : '').">".$GLOBALS['strNo']."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strLeftMargin']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='lmargin' size='' value='".$lmargin."' style='width:60px;'".($limited == 'f' ? ' disabled' : '')."> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strRightMargin']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='rmargin' size='' value='".$rmargin."' style='width:60px;'".($limited == 'f' ? ' disabled' : '')."> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strTransparentBackground']."</td><td width='370'>";
	echo "<select name='transparent' style='width:60px;' onChange='this.form.backcolor.disabled = this.selectedIndex ? false : true'>";
		echo "<option value='t'".($transparent == 't' ? ' selected' : '').">".$GLOBALS['strYes']."</option>";
		echo "<option value='f'".($transparent == 'f' ? ' selected' : '').">".$GLOBALS['strNo']."</option>";
	echo "</select>";
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
		echo "<input type='text' class='flat' name='backcolor' size='10' maxlength='7' value='".$backcolor."'".($transparent == 't' ? ' disabled' : '')." onFocus='current_cp = this; current_cp_oldval = this.value; current_box = backcolor_box' onChange='c_update()'>";
		echo "</td><td align='right' width='218'>";
		echo "<div onMouseOver='current_cp = backcolor; current_box = backcolor_box' onMouseOut='current_cp = null'><img src='images/colorpicker.png' width='193' height='18' align='absmiddle' usemap='#colorpicker' border='0'><img src='images/spacer.gif' width='22' height='1'></div>";
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
		'clientid' => true,
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