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



/*********************************************************/
/* Output JS code for the layer                          */
/*********************************************************/

function phpAds_putLayerJS ($output, $uniqid)
{
	global $ltr, $loop, $speed, $pause, $shiftv;
	global $limited, $lmargin, $rmargin;
		
	if (!isset($ltr)) $ltr = 't';
	if (!isset($loop)) $loop = 'n';
	if (!isset($speed)) $speed = 3;
	if (!isset($pause)) $pause = 10;
	if (!isset($shiftv)) $shiftv = 0;
	
	if ($limited == 't')
	{
		if (!isset($lmargin) || !isset($rmargin))
		{
			$limited = 'f';
			$lmargin = $rmargin = '';
		}
	}
	
?>

function phpAds_findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
  d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i>d.layers.length;i++) x=phpAds_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function phpAds_floater_grow_<?php echo $uniqid; ?>()
{
	var c = phpAds_findObj('phpads_<?php echo $uniqid; ?>');

	if (!c)
		return false;
	
	if (c.style)
		c = c.style;
	
<?php
	if ($limited == 't')
	{
?>
	var iw = <?php echo $rmargin; ?>;
<?php
	}
	else
	{
?>
	if (window.innerWidth)
		var iw = window.innerWidth;
	else
		var iw = document.body.clientWidth;
<?php
	}
?>
	
	var shift = <?php echo 3*($speed-1)+1; ?>;

<?php
	if ($ltr == 't')
	{
?>
	if (document.all) {
		if (c.pixelLeft + shift < iw)
		{
			c.pixelLeft += shift;

			if (iw - c.pixelLeft < <?php echo $output['width']; ?>)
				c.pixelWidth = iw - c.pixelLeft;
		}
		else
		{
			window.clearInterval(phpAds_adlayers_timerid_<?php echo $uniqid; ?>);
			c.visibility = 'hidden';
			c.pixelLeft = 0;
			c.pixelWidth = 0;

			if (<?php echo $loop == 'n' ? 'true' : 'phpAds_adlayers_counter_'.$uniqid.' < '.$loop; ?>)
				window.setTimeout('phpAds_floater_<?php echo $uniqid; ?>()', <?php echo $pause*1000; ?>);
		}
	}
	else
	{
		if (parseInt(c.left) + shift < iw)
		{
			c.left = parseInt(c.left) + shift;

			if (iw - parseInt(c.left) < <?php echo $output['width']; ?>)
				c.width = iw - parseInt(c.left);
		}
		else
		{
			window.clearInterval(phpAds_adlayers_timerid_<?php echo $uniqid; ?>);
			c.visibility = 'hidden';
			c.left = 0;
			c.width = 0;

			if (<?php echo $loop == 'n' ? 'true' : 'phpAds_adlayers_counter_'.$uniqid.' < '.$loop; ?>)
				window.setTimeout('phpAds_floater_<?php echo $uniqid; ?>()', <?php echo $pause*1000; ?>);
		}
	}
<?php
	}
	else
	{
?>
	if (document.all) {
		if (c.pixelLeft > <?php echo $limited == 't' && $lmargin ? $lmargin : -$output['width']; ?>)
		{
			if (c.pixelWidth + shift < <?php echo $output['width']; ?>)
				c.pixelWidth += shift;
			else if (c.pixelWidth < <?php echo $output['width']; ?>)
				c.pixelWidth = <?php echo $output['width']; ?>;

			c.pixelLeft -= shift;
		}
		else
		{
			window.clearInterval(phpAds_adlayers_timerid_<?php echo $uniqid; ?>);
			c.visibility = 'hidden';
			c.pixelLeft = 0;
			c.pixelWidth = 0;

			if (<?php echo $loop == 'n' ? 'true' : 'phpAds_adlayers_counter_'.$uniqid.' < '.$loop; ?>)
				window.setTimeout('phpAds_floater_<?php echo $uniqid; ?>()', <?php echo $pause*1000; ?>);
		}
	}
	else
	{
		if (parseInt(c.left) > <?php echo $limited == 't' && $lmargin ? $lmargin : -$output['width']; ?>)
		{
			if (parseInt(c.width) + shift < <?php echo $output['width']; ?>)
				c.pixelWidth = parseInt(c.width) + shift;
			else if (parseInt(c.width) < <?php echo $output['width']; ?>)
				c.pixelWidth = <?php echo $output['width']; ?>;

			c.left = parseInt(c.left) - shift;
		}
		else
		{
			window.clearInterval(phpAds_adlayers_timerid_<?php echo $uniqid; ?>);
			c.visibility = 'hidden';
			c.left = 0;
			c.width = 0;

			if (<?php echo $loop == 'n' ? 'true' : 'phpAds_adlayers_counter_'.$uniqid.' < '.$loop; ?>)
				window.setTimeout('phpAds_floater_<?php echo $uniqid; ?>()', <?php echo $pause*1000; ?>);
		}
	}
<?php
	}
?>
}


function phpAds_floater_<?php echo $uniqid; ?>()
{
	var c = phpAds_findObj('phpads_<?php echo $uniqid; ?>');

	if (!c)
		return false;

	if (c.style)
		c = c.style;
	
<?php
	if ($limited == 't')
	{
?>
	var iw = <?php echo $rmargin; ?>;
<?php
	}
	else
	{
?>
	if (window.innerWidth)
		var iw = window.innerWidth;
	else
		var iw = document.body.clientWidth;
<?php
	}
?>

<?php
	if ($ltr == 't')
	{
?>
	if (document.all)
	{ 
		c.pixelWidth = <?php echo $output['width']; ?>;
		c.pixelTop = <?php echo $shiftv; ?>;
		c.pixelLeft = <?php echo $limited == 't' && $lmargin ? $lmargin : -$output['width']; ?>;
	}
	else
	{
		c.width = <?php echo $output['width']; ?>;
		c.top = <?php echo $shiftv; ?>;
		c.left = <?php echo $limited == 't' && $lmargin ? $lmargin : -$output['width']; ?>;
	}
<?php
	}
	else
	{
?>
	if (document.all)
	{ 
		c.pixelWidth = 0;
		c.pixelTop = <?php echo $shiftv; ?>;
		c.pixelLeft = iw;
	}
	else
	{
		c.width = 0;
		c.top = <?php echo $shiftv; ?>;
		c.left = iw;
	}
<?php
	}
?>

	c.visibility = 'visible';

	phpAds_adlayers_timerid_<?php echo $uniqid; ?> = window.setInterval('phpAds_floater_grow_<?php echo $uniqid; ?>()', 25);
	phpAds_adlayers_counter_<?php echo $uniqid; ?>++;
}

var phpAds_adlayers_counter_<?php echo $uniqid; ?> = 0;
var phpAds_adlayers_timerid_<?php echo $uniqid; ?> = null;

//window.setTimeout('phpAds_floater_<?php echo $uniqid; ?>()', <?php echo $pause*1000; ?>);
phpAds_floater_<?php echo $uniqid; ?>();

<?php
}



/*********************************************************/
/* Return HTML code for the layer                        */
/*********************************************************/

function phpAds_getLayerHTML ($output, $uniqid)
{
	global $transparent, $backcolor;
	
	if (!isset($transparent)) $transparent = 't';
	if (!isset($backcolor)) $backcolor = '#FFFFFF';

	// return HTML code
	return '<div id="phpads_'.$uniqid.'" style="position:absolute; width:'.$output['width'].'px; height:'.$output['height'].
		'px; z-index:99; left: 0px; top: 0px; visibility: hidden; overflow: hidden'.
		($transparent == 't' ? '' : '; background-color: "'.$backcolor.'; layer-background-color: "'.$backcolor).'">'.
		$output['html'].'</td></tr></table></div>';


}



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
	echo "<td width='200'>". 'Direction' ."</td><td width='370'>";
	echo "<select name='ltr' style='width:175px;'>";
		echo "<option value='t'".($ltr == 't' ? ' selected' : '').">". 'Left to right' ."</option>";
		echo "<option value='f'".($ltr == 'f' ? ' selected' : '').">". 'Right to left' ."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>". 'Looping' ."</td><td width='370'>";
	echo "<select name='loop' style='width:175px;'>";
		echo "<option value='n'".($loop == 'n' ? ' selected' : '').">". 'Always active' ."</option>";
	for ($i=1;$i<=10;$i++)
		echo "<option value='".$i."'".($loop == $i ? ' selected' : '').">".$i."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>". 'Speed' ."</td><td width='370'>";
	echo "<select name='speed' style='width:60px;'>";
	for ($i=1;$i<=5;$i++)
		echo "<option value='".$i."'".($speed == $i ? ' selected' : '').">".$i."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>". 'Pause' ."</td><td width='370'>";
		echo "<input class='flat' type='text' name='pause' size='' value='".$pause."' style='width:60px;'> ".$GLOBALS['strSeconds']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strVShift']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='shiftv' size='' value='".$shiftv."' style='width:60px;'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>". 'Limited' ."</td><td width='370'>";
	echo "<select name='transparent' style='width:60px;' onChange='this.form.backcolor.disabled = this.selectedIndex ? false : true'>";
		echo "<option value='t'".($transparent == 't' ? ' selected' : '').">".$GLOBALS['strYes']."</option>";
		echo "<option value='f'".($transparent == 'f' ? ' selected' : '').">".$GLOBALS['strNo']."</option>";
	echo "</select>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
		
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>". 'Left margin' ."</td><td width='370'>";
		echo "<input class='flat' type='text' name='lmarign' size='' value='".$lmarign."' style='width:60px;'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>". 'Right margin' ."</td><td width='370'>";
		echo "<input class='flat' type='text' name='rmarign' size='' value='".$rmarign."' style='width:60px;'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>". 'Transparent background' ."</td><td width='370'>";
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

	if ($limited == 'f')
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