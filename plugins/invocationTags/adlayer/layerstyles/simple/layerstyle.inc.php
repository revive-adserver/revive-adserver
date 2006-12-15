<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

/*-------------------------------------------------------*/
/* Return misc capabilities                              */
/*-------------------------------------------------------*/

function MAX_layerGetLimitations()
{
	$agent = $GLOBALS['_MAX']['CLIENT'];
	
	$compatible = $agent['browser'] == 'ie' && $agent['maj_ver'] < 5 ||
				  $agent['browser'] == 'mz' && $agent['maj_ver'] < 1 ||
				  $agent['browser'] == 'fx' && $agent['maj_ver'] < 1 ||
				  $agent['browser'] == 'op' && $agent['maj_ver'] < 5 
				  ? false : true;
				  
	//$richmedia  = $agent['platform'] == 'Win' ? true : false;
	$richmedia = true;
	
	return array (
		'richmedia'  => $richmedia,
		'compatible' => $compatible
	);
}



/*-------------------------------------------------------*/
/* Output JS code for the layer                          */
/*-------------------------------------------------------*/

function MAX_layerPutJs($output, $uniqid)
{
	global $align, $valign, $closetime, $padding;
	global $shifth, $shiftv, $closebutton;
	
	// Register input variables
	MAX_commonRegisterGlobals('align', 'valign', 'closetime', 'padding',
						   'shifth', 'shiftv', 'closebutton');
	
	
	if (!isset($padding)) $padding = 0;
	if (!isset($shifth)) $shifth = 0;
	if (!isset($shiftv)) $shiftv = 0;
	if (!isset($closebutton)) $closebutton = 'f';
	
	// Calculate layer size (inc. borders)
	$layer_width = $output['width'] + 2 + $padding*2;
	$layer_height = $output['height'] + 2 + ($closebutton == 't' ? 11 : 0) + $padding*2;
	
?>

function MAX_findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
  d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i>d.layers.length;i++) x=MAX_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MAX_adlayers_place_<?php echo $uniqid; ?>()
{
	var c = MAX_findObj('MAX_<?php echo $uniqid; ?>');

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

	c.visibility = MAX_adlayers_visible_<?php echo $uniqid; ?>;
}


function MAX_simplepop_<?php echo $uniqid; ?>(what)
{
	var c = MAX_findObj('MAX_<?php echo $uniqid; ?>');

	if (!c)
		return false;

	if (c.style)
		c = c.style;

	switch(what)
	{
		case 'close':
			MAX_adlayers_visible_<?php echo $uniqid; ?> = 'hidden';
			MAX_adlayers_place_<?php echo $uniqid; ?>();
			window.clearInterval(MAX_adlayers_timerid_<?php echo $uniqid; ?>);
			break;

		case 'open':
			MAX_adlayers_visible_<?php echo $uniqid; ?> = 'visible';
			MAX_adlayers_place_<?php echo $uniqid; ?>();
			MAX_adlayers_timerid_<?php echo $uniqid; ?> = window.setInterval('MAX_adlayers_place_<?php echo $uniqid; ?>()', 10);

<?php

if (isset($closetime) && $closetime > 0)
	echo "\t\t\treturn window.setTimeout('MAX_simplepop_".$uniqid."(\\'close\\')', ".($closetime * 1000).");";

?>

			break;
	}
}


var MAX_adlayers_timerid_<?php echo $uniqid; ?>;
var MAX_adlayers_visible_<?php echo $uniqid; ?>;


MAX_simplepop_<?php echo $uniqid; ?>('open');
<?php
}



/*-------------------------------------------------------*/
/* Return HTML code for the layer                        */
/*-------------------------------------------------------*/

function MAX_layerGetHtml($output, $uniqid)
{
	global $target;
	global $align, $padding, $closebutton;
	global $backcolor, $bordercolor;
	global $nobg, $noborder;
	
	$conf = $GLOBALS['_MAX']['CONF'];
	
	// Register input variables
	MAX_commonRegisterGlobals('align', 'padding', 'closebutton',
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
	$imagepath = 'http://' . $conf['webpath']['images'] . '/layerstyles/simple/';
	
	// return HTML code
	return '
<div id="MAX_'.$uniqid.'" style="position:absolute; width:'.$layer_width.'px; height:'.$layer_height.'px; z-index:99; left: 0px; top: 0px; visibility: hidden"> 
	<table cellspacing="0" cellpadding="0"'.($noborder == 't' ? '' : ' style="border-style: solid; border-width: 1px; border-color: #'.$bordercolor.'"').'>
'.($closebutton == 't' ?
'		<tr> 
			<td'.($nobg == 't' ? '' : ' bgcolor="#'.$backcolor.'"').' align="right" style="padding: 2px"><a href="javascript:;" onClick="MAX_simplepop_'.$uniqid.'(\'close\'); return false;" style="color:#0000ff"><img src="'.$imagepath.'close.gif" width="7" height="7" alt="Close" border="0"></a></td>
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