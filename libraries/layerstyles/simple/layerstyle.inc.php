<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
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
				  $agent['agent'] == 'Opera' && $agent['version'] < 5.0 
				  ? false : true;
				  
	$richmedia  = $agent['platform'] == 'Win' ? true : false;
	
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
	global $shifth, $shiftv, $closebutton;
	
	// Register input variables
	phpAds_registerGlobal ('align', 'valign', 'closetime', 'padding',
						   'shifth', 'shiftv', 'closebutton');
	
	
	if (!isset($padding)) $padding = 0;
	if (!isset($shifth)) $shifth = 0;
	if (!isset($shiftv)) $shiftv = 0;
	if (!isset($closebutton)) $closebutton = 'f';
	
	// Calculate layer size (inc. borders)
	$layer_width = $output['width'] + 2 + $padding*2;
	$layer_height = $output['height'] + 2 + ($closebutton == 't' ? 11 : 0) + $padding*2;
	
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
		ih = window.innerHeight;
	else
		ih = document.body.clientHeight;
	
	if (window.innerWidth)
		iw = window.innerWidth;
	else
		iw = document.body.clientWidth;
	
	
	if (document.all) { 
		
<?php
	echo "\t\tc.pixelLeft = ";
	
	if ($align == 'left')
		echo abs($shifth).' + document.body.scrollLeft';
	elseif ($align == 'center')
		echo '(iw - '.$layer_width.') / 2 + document.body.scrollLeft + '.$shifth;
	else
		echo 'iw + document.body.scrollLeft - '.($layer_width+abs($shifth));
	
	echo ";\n\t\tc.pixelTop = ";
	
	if ($valign == 'middle')
		echo '(ih - '.$layer_height.') / 2 + document.body.scrollTop + '.$shiftv;
	elseif ($valign == 'bottom')
		echo 'ih + document.body.scrollTop - '.($layer_height+abs($shiftv));
	else
		echo abs($shiftv).' + document.body.scrollTop';
	
	echo ";\n";
?>	
	} else {
<?php
	echo "\t\tc.left = ";
	
	if ($align == 'left')
		echo abs($shifth).' + window.pageXOffset';
	elseif ($align == 'center')
		echo '(iw - '.$layer_width.') / 2 + window.pageXOffset + '.$shifth;
	else
		echo 'iw + window.pageXOffset - '.($layer_width+abs($shifth)).' - 16';
	
	echo ";\n\t\tc.top = ";
	
	if ($valign == 'middle')
		echo '(ih - '.$layer_height.') / 2 + window.pageYOffset + '.$shiftv;
	elseif ($valign == 'bottom')
		echo 'ih + window.pageYOffset -'.($layer_height+abs($shiftv)).' - 16';
	else
		echo abs($shiftv).' + window.pageYOffset';
	
	echo ";\n";
?>	
	}

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
	global $nobg, $noborder;
	
	// Register input variables
	phpAds_registerGlobal ('align', 'padding', 'closebutton',
						   'backcolor', 'bordercolor',
						   'nobg', 'noborder');
	
	
	if (!isset($padding)) $padding = '2';
	if (!isset($closebutton)) $closebutton = 'f';
	if (!isset($backcolor)) $backcolor = 'FFFFFF';
	if (!isset($bordercolor)) $bordercolor = '000000';
	if (!isset($nobg)) $nobg = 'f';
	if (!isset($noborder)) $noborder = 'f';
	
	// Calculate layer size (inc. borders)
	$layer_width = $output['width'] + 2 + $padding*2;
	$layer_height = $output['height'] + 2 + ($closebutton == 't' ? 11 : 0) + $padding*2;
	
	// Create imagepath
	$imagepath = $phpAds_config['url_prefix'].'/libraries/layerstyles/simple/images/';
	
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

?>