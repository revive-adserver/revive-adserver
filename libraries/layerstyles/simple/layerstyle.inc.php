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



// Define constant used to place code generator
define('phpAds_adLayerLoaded', true);



/*********************************************************/
/* Return misc capabilities                              */
/*********************************************************/

function phpAds_getLayerLimitations ()
{
	$agent = phpAds_getUserAgent();
	
	$compatible = $agent['agent'] == 'IE' && $agent['version'] < 5.0 ||
				  $agent['agent'] == 'Mozilla' && $agent['version'] < 5.0 ||
				  $agent['agent'] == 'Opera' && $agent['version'] < 5.0 ||
				  $agent['agent'] == 'Konqueror' && $agent['version'] < 5.0 ||
				  $agent['agent'] == 'Safari' && $agent['version'] < 5.0
				  ? false : true;
				  
	$richmedia  = $compatible && !($agent['agent'] == 'IE' && $agent['platform'] == 'Mac');
	
	return array (
		'richmedia'  => $richmedia,
		'compatible' => $compatible
	);
}



/*********************************************************/
/* Output JS code for the layer                          */
/*********************************************************/

function phpAds_putLayerJS ($output, $uniqid)
{
	global $align, $valign, $closetime, $padding;
	global $shifth, $shiftv, $closebutton, $style;
	
	// Register input variables
	phpAds_registerGlobal ('align', 'valign', 'closetime', 'padding',
						   'shifth', 'shiftv', 'closebutton', 'style');
	
	
	if (!isset($padding)) $padding = 0;
	if (!isset($shifth)) $shifth = 0;
	if (!isset($shiftv)) $shiftv = 0;
	if (!isset($closebutton)) $closebutton = 'f';
	
	// Calculate layer size (inc. borders)
	if ($style == 'xp')
	{
		$layer_width = $output['width'] + 8;
		$layer_height = $output['height'] + 4 + 30;
	}
	elseif ($style == 'win')
	{
		$layer_width = $output['width'] + 10;
		$layer_height = $output['height'] + 29;
	}
	else
	{
		$layer_width = $output['width'] + 2 + $padding*2;
		$layer_height = $output['height'] + 2 + ($closebutton == 't' ? 11 : 0) + $padding*2;
	}
	
?>

function phpAds_findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
  d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i>d.layers.length;i++) x=phpAds_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function phpAds_adlayers_place_<?php echo $uniqid; ?>()
{
	var c = phpAds_findObj('phpads_<?php echo $uniqid; ?>');

	if (!c)
		return false;
	
	if (c.style)
		c = c.style;
	
	if (window.innerHeight)
	{
		ih = window.innerHeight;
		iw = window.innerWidth;
		sl = window.pageXOffset;
		st = window.pageYOffset;
		
		if (window.opera)
			of = 0;
		else
			of = 16;
	}
	else if (document.documentElement && document.documentElement.clientHeight)
	{
		ih = document.documentElement.clientHeight;
		iw = document.documentElement.clientWidth;
		sl = document.documentElement.scrollLeft;
		st = document.documentElement.scrollTop;
		of = 0;		
	}
	else if (document.body)
	{
		ih = document.body.clientHeight;
		iw = document.body.clientWidth;
		sl = document.body.scrollLeft;
		st = document.body.scrollTop;
		of = 0;
	}

<?php
	echo "\t\tll = ";
	
	if ($align == 'left')
		echo abs($shifth).' + sl';
	elseif ($align == 'center')
		echo '(iw - '.$layer_width.') / 2 + sl + '.$shifth;
	else
		echo 'iw + sl - '.($layer_width+abs($shifth)).' - of';
	
	echo ";\n\t\tlt = ";
	
	if ($valign == 'middle')
		echo '(ih - '.$layer_height.') / 2 + st + '.$shiftv;
	elseif ($valign == 'bottom')
		echo 'ih + st -'.($layer_height+abs($shiftv)).' - of';
	else
		echo abs($shiftv).' + st';
	
	echo ";\n";
?>

	if (c.pixelLeft)
		c.pixelLeft = ll;
	else if (window.opera)
		c.left = ll;
	else
		c.left = ll + 'px';
		
	if (c.pixelTop)
		c.pixelTop = lt;
	else if (window.opera)
		c.top = lt;
	else
		c.top = lt + 'px';

	c.visibility = phpAds_adlayers_visible_<?php echo $uniqid; ?>;
}


function phpAds_simplepop_<?php echo $uniqid; ?>(what)
{
	var c = phpAds_findObj('phpads_<?php echo $uniqid; ?>');

	if (!c)
		return false;

	if (c.style)
		c = c.style;

	switch(what)
	{
		case 'close':
			phpAds_adlayers_visible_<?php echo $uniqid; ?> = 'hidden';
			phpAds_adlayers_place_<?php echo $uniqid; ?>();
			window.clearInterval(phpAds_adlayers_timerid_<?php echo $uniqid; ?>);
			break;

		case 'open':
			phpAds_adlayers_visible_<?php echo $uniqid; ?> = 'visible';
			phpAds_adlayers_place_<?php echo $uniqid; ?>();
			phpAds_adlayers_timerid_<?php echo $uniqid; ?> = window.setInterval('phpAds_adlayers_place_<?php echo $uniqid; ?>()', 10);

<?php

if (isset($closetime) && $closetime > 0)
	echo "\t\t\treturn window.setTimeout('phpAds_simplepop_".$uniqid."(\\'close\\')', ".($closetime * 1000).");";

?>

			break;
	}
}

var phpAds_adlayers_timerid_<?php echo $uniqid; ?>;
var phpAds_adlayers_visible_<?php echo $uniqid; ?>;


phpAds_simplepop_<?php echo $uniqid; ?>('open');
<?php
}



/*********************************************************/
/* Return HTML code for the layer                        */
/*********************************************************/

function phpAds_getLayerHTML ($output, $uniqid)
{
	global $phpAds_config, $target;
	global $align, $padding, $closebutton;
	global $backcolor, $bordercolor;
	global $nobg, $noborder, $style;
	
	// Register input variables
	phpAds_registerGlobal ('align', 'padding', 'closebutton',
						   'backcolor', 'bordercolor',
						   'nobg', 'noborder', 'style');
	
	// Create imagepath
	$imagepath = $phpAds_config['url_prefix'].'/libraries/layerstyles/simple/images/';

	if ($style == 'xp')
	{
		if (!isset($closebutton)) $closebutton = 'f';
		if (!isset($backcolor)) $backcolor = 'FFFFFF';

		// Calculate layer size (inc. borders)
		$layer_width = $output['width'] + 10;
		$layer_height = $output['height'] + 4 + 30;

		// return HTML code
		return '
<div id="phpads_'.$uniqid.'" style="position:absolute; width:'.$layer_width.'px; height:'.$layer_height.'px; z-index:99; left: 0px; top: 0px; visibility: hidden"> 
	<table style="width: '.($layer_width-2).'px;" cellspacing="0"><tr><td style="padding: 0px;width: 26px;"><img src="'.$imagepath.'xp-tb-l.gif"></td>
	<td style="padding: 0px;background-image: url('.$imagepath.'xp-tb-bg.gif);background-repeat: repeat-x;color: white;font-family: Trebuchet MS, Arial, sans-serif;font-size:13px;font-weight: bold;padding-top:2px;"><div style="width:'.($layer_width - 58).'px; overflow: hidden;">'.($output['alt'] ? $output['alt'] : 'Advertisement').'</div></td>
	'.($closebutton == 't' ? '<td style="padding: 0px;width: 30px;"><a href="javascript:;" onClick="phpAds_simplepop_'.$uniqid.'(\'close\'); return false;"><img src="'.$imagepath.'xp-tb-r.gif" style="border:0;"></a></td>' : '<td style="padding: 0px;width: 30px;"><img src="'.$imagepath.'xp-tb-rd.gif" style="border:0;"></td>').'</tr></table>
	<div style="float: left; clear: left; border-left: 1px solid #0019CF; border-bottom: 1px solid #00138C; border-right: 1px solid #00138C;">
	<div style="border-left: 1px solid #0019CF; border-bottom: 1px solid #001EA1; border-right: 1px solid #001DA0;">
	<div style="border-left: 1px solid #166AEE; border-bottom: 1px solid #0441D8; border-right: 1px solid #003DDC;">
	<div style="border-left: 1px solid #0855DD; border-bottom: 1px solid #0048F1; border-right: 1px solid #0048F1; width:'.$output['width'].'px; height:'.$output['height'].'px; background-color: #'.$backcolor.';">'.$output['html'].'</div></div></div></div>
</div>
';
	}
	elseif ($style == 'win')
	{
		if (!isset($closebutton)) $closebutton = 'f';
		if (!isset($backcolor)) $backcolor = 'FFFFFF';

		// Calculate layer size (inc. borders)
		$layer_width = $output['width'] + 8;
		$layer_height = $output['height'] + 29;

		// return HTML code
		return '
<div id="phpads_'.$uniqid.'" style="position:absolute; width:'.$layer_width.'px; height:'.$layer_height.'px; z-index:99; left: 0px; top: 0px; visibility: hidden"> 
	<div style="width: '.$layer_width.'px; border-top: 1px solid #D4D0C8; border-left: 1px solid #D4D0C8; border-bottom: 1px solid #404040; border-right: 1px solid #404040;"><div style="border-top: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF; border-bottom: 1px solid #808080; border-right: 1px solid #808080;">
	<div style="border: 1px solid #D4D0C8;"><table style="width: '.($output['width']+4).'px; background-color: #A6CAF0; background-image: url('.$imagepath.'win-tb-bg.gif); background-repeat: repeat-y;	border-bottom: 1px solid #D4D0C8;" cellspacing="0"><tr><td style="width: 20px;padding: 0px;"><img src="'.$imagepath.'win-tb-l.gif"></td>
	<td style="padding: 0px;color: white; font-family: Tahoma, Arial, sans-serif;	font-size: 11px; font-weight: bold;"><div style="width:'.($layer_width - 44).'px; overflow: hidden;">'.($output['alt'] ? $output['alt'] : 'Advertisement').'</div></td>'.($closebutton == 't' ? '<td style="width: 20px;padding: 0px;"><a href="javascript:;" onClick="phpAds_simplepop_'.$uniqid.'(\'close\'); return false;"><img src="'.$imagepath.'win-tb-r.gif" style="border: 0px;"></a></td>' : '<td style="width: 20px;padding: 0px;"><img src="'.$imagepath.'win-tb-rd.gif" style="border: 0px;"></td>').'
	</tr></table><div style="border-top: 1px solid #808080; border-left: 1px solid #808080; border-bottom: 1px solid #FFFFFF; border-right: 1px solid #FFFFFF;"><div style="border-top: 1px solid #404040; border-left: 1px solid #404040; border-bottom: 1px solid #D4D0C8; border-right: 1px solid #D4D0C8;width:'.$output['width'].'px; height:'.$output['height'].'px; background-color: #'.$backcolor.';">'.$output['html'].'</div>
	</div></div></div></div>
</div>
';
	}
	else
	{
		if (!isset($padding)) $padding = '2';
		if (!isset($closebutton)) $closebutton = 'f';
		if (!isset($backcolor)) $backcolor = 'FFFFFF';
		if (!isset($bordercolor)) $bordercolor = '000000';
		if (!isset($nobg)) $nobg = 'f';
		if (!isset($noborder)) $noborder = 'f';
		
		// Calculate layer size (inc. borders)
		$layer_width = $output['width'] + 2 + $padding*2;
		$layer_height = $output['height'] + 2 + ($closebutton == 't' ? 11 : 0) + $padding*2;
	
		// return HTML code
		return '
<div id="phpads_'.$uniqid.'" style="position:absolute; width:'.$layer_width.'px; height:'.$layer_height.'px; z-index:99; left: 0px; top: 0px; visibility: hidden"> 
	<table cellspacing="0" cellpadding="0"'.($noborder == 't' ? '' : ' style="border-style: solid; border-width: 1px; border-color: #'.$bordercolor.'"').'>
'.($closebutton == 't' ?
'		<tr> 
			<td'.($nobg == 't' ? '' : ' bgcolor="#'.$backcolor.'"').' align="right" style="padding: 2px"><a href="javascript:;" onClick="phpAds_simplepop_'.$uniqid.'(\'close\'); return false;" style="color:#0000ff"><img src="'.$imagepath.'close.gif" width="7" height="7" alt="Close" border="0"></a></td>
		</tr>
' : '').
'		<tr> 
			<td '.($nobg == 't' ? '' : ' bgcolor="#'.$backcolor.'"').' align="center">
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
}

?>
