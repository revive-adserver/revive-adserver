<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
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
	global $align, $valign, $closetime, $padding;
	global $shifth, $shiftv;
	
	if (!isset($padding)) $padding = 0;
	if (!isset($shifth)) $shifth = 0;
	if (!isset($shiftv)) $shiftv = 0;
	
	// Calculate layer size (inc. borders)
	$layer_width = $output['width'] + 4 + $padding*2;
	$layer_height = $output['height'] + 14 + $padding*2;
	
?>

function phpAds_findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
  d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i>d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function phpAds_adlayers_place_<?php echo $uniqid; ?>()
{
	var c = phpAds_findObj('phpads_<?php echo $uniqid; ?>');

	if (!c)
		return false;

	c = c.style;

	if (document.all) { 
<?php
	echo "\t\tc.pixelLeft = ";
	
	if ($align == 'left')
		echo abs($shifth);
	elseif ($align == 'center')
		echo '(document.body.clientWidth - '.$layer_width.') / 2 + document.body.scrollLeft + '.$shifth;
	else
		echo 'document.body.clientWidth + document.body.scrollLeft - '.($layer_width+abs($shifth));

	echo ";\n\t\tc.pixelTop = ";

	if ($valign == 'middle')
		echo '(document.body.clientHeight - '.$layer_height.') / 2 + document.body.scrollTop + '.$shiftv;
	elseif ($valign == 'bottom')
		echo 'document.body.clientHeight + document.body.scrollTop - '.($layer_height+abs($shiftv));
	else
		echo abs($shiftv).' + document.body.scrollTop';
	
	echo ";\n";
?>	
	} else {
<?php
	echo "\t\tc.left = ";
	
	if ($align == 'left')
		echo abs($shifth);
	elseif ($align == 'center')
		echo '(window.innerWidth - '.$layer_width.') / 2 + window.pageXOffset + '.$shifth;
	else
		echo 'window.innerWidth + window.pageXOffset - '.($layer_width+abs($shifth));

	echo ";\n\t\tc.top = ";

	if ($valign == 'middle')
		echo '(window.innerHeight - '.$layer_height.') / 2 + window.pageYOffset + '.$shiftv;
	elseif ($valign == 'bottom')
		echo 'window.innerHeight + window.pageYOffset - '.($layer_height+abs($shiftv));
	else
		echo abs($shiftv).' + window.pageYOffset';
	
	echo ";\n";
?>	
	}
}

function phpAds_simplepop(what, ad)
{
	c = phpAds_findObj('phpads_' + ad);

	if (!c)
		return false;

	c = c.style;

	switch(what)
	{
		case 'close':
			c.visibility = 'hidden'; 
		break;

		case 'open':
		
			phpAds_adlayers_place_<?php echo $uniqid; ?>();

			c.visibility = 'visible';

<?php

if (isset($closetime) && $closetime > 0)
	echo "\t\t\treturn window.setTimeout('phpAds_simplepop(\\'close\\', \\'".$uniqid."\\')', ".($closetime * 1000).");";

?>

			break;
	}
}

phpAds_simplepop('open', '<?php echo $uniqid; ?>');
<?php
}



/*********************************************************/
/* Return HTML code for the layer                        */
/*********************************************************/

function phpAds_getLayerHTML ($output, $uniqid)
{
	global $phpAds_config, $target;
	global $align, $padding;

	if (!isset($padding)) $padding = '2';

	// Calculate layer size (inc. borders)
	$layer_width = $output['width'] + 4 + $padding*2;
	$layer_height = $output['height'] + 14 + $padding*2;

	// Create imagepath
	$imagepath = $phpAds_config['url_prefix'].'/misc/layerstyles/simple/images/';

	// return HTML code
	return '
<div id="phpads_'.$uniqid.'" style="position:absolute; width:'.$layer_width.'px; height:'.$layer_height.'px; z-index:99; left: 0px; top: 0px; visibility: hidden"> 
	<table width="100%" cellspacing="0" cellpadding="0" style="border-style: solid; border-width: 1px; border-color: #000000">
		<tr> 
			<td bgcolor="#FFFFFF" align="right" style="padding: 2px"><a href="javascript:;" onClick="phpAds_simplepop(\'close\', \''.$uniqid.'\')" style="color:#0000ff"><img src="'.$imagepath.'close.gif" width="7" height="7" alt="Close" border="0"></a></td>
		</tr>
		<tr> 
			<td bgcolor="#FFFFFF" align="center">
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
	global $shifth, $shiftv;
	
	if (!isset($align)) $align = 'right';
	if (!isset($valign)) $valign = 'top';
	if (!isset($closetime)) $closetime = '-';
	if (!isset($padding)) $padding = '2';
	if (!isset($shifth)) $shifth = 0;
	if (!isset($shiftv)) $shiftv = 0;

	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strHAlignment']."</td><td width='370'>";
	echo "<select name='align' style='width:175px;'>";
		echo "<option value='left'".($align == 'left' ? ' selected' : '').">".$GLOBALS['strLeft']."</option>";
		echo "<option value='center'".($align == 'center' ? ' selected' : '').">".$GLOBALS['strCenter']."</option>";
		echo "<option value='right'".($align == 'right' ? ' selected' : '').">".$GLOBALS['strRight']."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strVAlignment']."</td><td width='370'>";
	echo "<select name='valign' style='width:175px;'>";
		echo "<option value='top'".($valign == 'top' ? ' selected' : '').">".$GLOBALS['strTop']."</option>";
		echo "<option value='middle'".($valign == 'middle' ? ' selected' : '').">".$GLOBALS['strMiddle']."</option>";
		echo "<option value='bottom'".($valign == 'bottom' ? ' selected' : '').">".$GLOBALS['strBottom']."</option>";
	echo "</select>";
	echo "</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strAutoCloseAfter']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='closetime' size='' value='".(isset($closetime) ? $closetime : '-')."' style='width:175px;'> ".$GLOBALS['strAbbrSeconds']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strBannerPadding']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='padding' size='' value='".$padding."' style='width:60px;'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strHShift']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='shifth' size='' value='".$shifth."' style='width:60px;'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$GLOBALS['strVShift']."</td><td width='370'>";
		echo "<input class='flat' type='text' name='shiftv' size='' value='".$shiftv."' style='width:60px;'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
}



/*********************************************************/
/* Place ad-generator settings                           */
/*********************************************************/

function phpAds_generateLayerCode ($parameters)
{
	global $phpAds_config;
	global $align, $valign, $closetime, $padding;
	global $shifth, $shiftv;
	
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
	
	$buffer = "<script language='JavaScript' src='".$phpAds_config['url_prefix']."/adlayer.php";
	if (sizeof($parameters) > 0)
		$buffer .= "?".implode ("&", $parameters);
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

?>